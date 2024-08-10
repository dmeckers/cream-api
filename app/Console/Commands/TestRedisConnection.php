<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class TestRedisConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:redis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the Redis connection';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            Redis::connection()->ping();
            $this->info('Redis connection is working!');
        } catch (\Exception $e) {
            $this->error('Could not connect to Redis: ' . $e->getMessage());
        }

        return 0;
    }
}
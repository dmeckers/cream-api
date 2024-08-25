<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeDataMigration extends Command
{
    private const DATA_MIGRATION_PATH = 'database/migrations/data';
    private const NAME                = 'name';

    protected $signature = 'make:migration:data {name}';

    protected $description = 'Make a data migration in data folder';

    public function handle(): void
    {
        Artisan::call('make:migration', [
            'name' => $this->argument(self::NAME),
            '--path' => self::DATA_MIGRATION_PATH,
        ]);

        $this->line('Data migration created successfully.', 'info');
    }
}
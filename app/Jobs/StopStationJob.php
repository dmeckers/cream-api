<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\RadioStation;
use App\Repositories\Stations\RadioStationDbRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Process\PendingProcess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StopStationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly RadioStation $radio)
    {
    }

    public function handle(
        PendingProcess $process,
    ): void {
        $mountPoint = $this->radio->getMountPoint();

        $dockerCommand = "docker exec liquidsoap ps aux | grep '{$mountPoint}.liq' | grep -v grep | awk '{print \$2}'";

        $pid = $process->run($dockerCommand)->throw()->output();

        if (empty($pid) || !is_numeric($pid)) {
            throw new \Exception('Could not find the process ID for the station.');
        }

        $dockerCommand = "docker exec liquidsoap kill -9 {$pid}";

        $stopResult = $process->run($dockerCommand)->throw();

        $stopResult->failed() && throw new \Exception('Could not stop the station.');
    }
}
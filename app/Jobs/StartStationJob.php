<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\RadioStation;
use App\Utils\LaravelGlobals;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Process\PendingProcess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class StartStationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const FILESYSTEM_DISK                        = 'radio';
    private const NEW_RADIO_LIQUIDSOAP_SCRIPTS_DIR       = 'liquidsoap/stations/boot/';
    private const INIT_SSH_COMMAND                       = 'ssh -i /app/cream-soap.rsa liquidsoap@cream-soap "nohup liquidsoap /home/liquidsoap/scripts/{script_name}  > /dev/null 2>&1 &"';
    private const INIT_LIQUIDSOAP_DOCKER_COMMAND_TIMEOUT = 60 * 1;  // 1 minutes

    private const JOB_TIMEOUT        = 60 * 2; // 2 minutes
    private const JOB_ATTEMPTS_COUNT = 5;

    public $timeout = self::JOB_TIMEOUT;
    public $tries = self::JOB_ATTEMPTS_COUNT;


    public function __construct(
        private readonly RadioStation $radio,
    ) {
    }

    public function handle(
        LaravelGlobals $laravelGlobals,
        FilesystemManager $fs,
        PendingProcess $process,
    ): void {
        try {
            $icecastPort = $laravelGlobals->config('radio.icecast.port');
            $icecastPassword = $laravelGlobals->config('radio.icecast.password');

            $template = $fs->disk(self::FILESYSTEM_DISK)->get('new_radio_station_template.liq');
            $newRadioStationLiqScript = Str::replace(
                [
                    '%station_id%',
                    '%station_name%',
                    '%icecast_port%',
                    '%icecast_password%',
                    '%station_mount%',
                    '%description%',
                    '%genre%',
                ],
                [
                    $this->radio->getId(),
                    $this->radio->getName(),
                    $icecastPort,
                    $icecastPassword,
                    $this->radio->getMountPoint(),
                    $this->radio->getDescription(),
                    $this->radio->getGenre(),
                ],
                $template
            );

            $scriptName = $this->radio->getMountPoint() . '.liq';

            $fs->disk(name: self::FILESYSTEM_DISK)->put(
                self::NEW_RADIO_LIQUIDSOAP_SCRIPTS_DIR . $scriptName,
                $newRadioStationLiqScript,
            );

            $dockerCommand = Str::replace('{script_name}', $scriptName, self::INIT_SSH_COMMAND);

            $result = $process
                ->timeout(self::INIT_LIQUIDSOAP_DOCKER_COMMAND_TIMEOUT)  // 1 minute
                ->run($dockerCommand);

            if ($result->successful()) {
                \Log::info('Radio station started successfully', [
                    'station_id' => $this->radio->getId(),
                    'station_name' => $this->radio->getName(),
                    'output' => $result->output(),
                ]);
                return;
            }

            $result->throw();
        } catch (\Throwable $th) {
            \Log::error('Exception occurred while starting radio station', [
                'station_id' => $this->radio->getId(),
                'station_name' => $this->radio->getName(),
                'exception_message' => $th->getMessage(),
            ]);
            throw $th;
        }
    }
}

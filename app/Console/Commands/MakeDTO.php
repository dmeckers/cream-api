<?php

declare(strict_types=1);

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeDTO extends Command
{
    private const NAME   = 'name';
    private const PATH   = 'path';
    private const DOMAIN = 'domain';

    private const DEFAULT_DATA_BASE_PATH = 'app/Http/Data';

    protected $signature = 'make:dto {name} {--path=} {--domain=}';

    protected $description = 'Make a data migration in data folder';

    public function handle(): void
    {
        $name = $this->argument(self::NAME);

        $path = $this->option(self::PATH)
            ?? $this->option(self::DOMAIN)
            ? self::DEFAULT_DATA_BASE_PATH . '/' . $this->option(self::DOMAIN)
            : app_path(self::DEFAULT_DATA_BASE_PATH);

        $filePath = $path . '/' . $name . '.php';

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        if (File::exists($filePath)) {
            $this->error('File with such name already exists.');
            return;
        }

        $namespace = ucfirst(str_replace('/', '\\', $path));

        $classContent = $this->generateClassContent(name: $name, namespace: $namespace);

        File::put($filePath, $classContent);

        $this->info("Data transfer object {$name} created successfully at {$filePath}");
    }


    private function generateClassContent(string $name, string $namespace): string
    {
        return <<<PHP
                <?php

                declare(strict_types=1);

                namespace $namespace;

                use Spatie\LaravelData\Data;

                class $name extends Data
                {
                    // Define your properties and methods here
                }

                PHP;
    }
}

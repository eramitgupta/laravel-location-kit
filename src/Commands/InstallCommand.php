<?php

namespace Erag\LocationKit\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'erag:install-location-kit';

    protected $description = 'Publish Location Kit configuration.';

    public function handle(): int
    {
        $this->call('vendor:publish', [
            '--tag' => 'location-kit-config',
            '--force' => false,
        ]);

        $this->components->info('Location Kit installed.');

        return self::SUCCESS;
    }
}

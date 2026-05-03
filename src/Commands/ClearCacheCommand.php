<?php

namespace LaravelLocationKit\Commands;

use Illuminate\Console\Command;
use LaravelLocationKit\Actions\ClearLocationCache;

class ClearCacheCommand extends Command
{
    protected $signature = 'location-kit:clear-cache';

    protected $description = 'Clear Location Kit cached data.';

    public function handle(): int
    {
        try {
            app(ClearLocationCache::class)->handle();
        } catch (\Throwable $exception) {
            $this->components->error('Location Kit cache could not be cleared.');
            $this->line($exception->getMessage());

            return self::FAILURE;
        }

        $this->components->info('Location Kit cache cleared.');

        return self::SUCCESS;
    }
}

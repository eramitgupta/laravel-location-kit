<?php

namespace LaravelLocationKit;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use LaravelLocationKit\Commands\ClearCacheCommand;
use LaravelLocationKit\Commands\InstallCommand;
use LaravelLocationKit\Http\Middleware\ShareLocationKitData;
use LaravelLocationKit\Support\BladeDirectives;

class LocationKitServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/location-kit.php', 'location-kit');

        $this->app->singleton(LocationKit::class, fn () => new LocationKit);
        $this->app->alias(LocationKit::class, 'location-kit');
    }

    public function boot(): void
    {
        $this->registerPublishing();
        $this->registerInertiaSharing();
        BladeDirectives::register();

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                ClearCacheCommand::class,
            ]);
        }
    }

    protected function registerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/location-kit.php' => config_path('location-kit.php'),
        ], 'location-kit-config');
    }

    protected function registerInertiaSharing(): void
    {
        if (! (bool) config('location-kit.inertia.enabled', false)) {
            return;
        }

        if (! class_exists(Inertia::class)) {
            return;
        }

        $this->app->make(Kernel::class)->pushMiddleware(ShareLocationKitData::class);
    }
}

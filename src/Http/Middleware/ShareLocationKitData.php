<?php

namespace LaravelLocationKit\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use LaravelLocationKit\Facades\LocationKit;
use LaravelLocationKit\Support\LocationData;

class ShareLocationKitData
{
    public function handle(Request $request, Closure $next): mixed
    {
        Inertia::share(
            (string) config('location-kit.inertia.prop', 'locationKit'),
            fn () => $this->payload()
        );

        return $next($request);
    }

    protected function payload(): array
    {
        $share = (array) config('location-kit.inertia.share', []);
        $payload = [];

        if ((bool) ($share['countries'] ?? false)) {
            $payload['countries'] = LocationKit::countries()->values()->all();
        }

        if ((bool) ($share['states'] ?? false)) {
            $payload['states'] = app(LocationData::class)->states()->values()->all();
        }

        if ((bool) ($share['cities'] ?? false)) {
            $payload['cities'] = app(LocationData::class)->cities()->values()->all();
        }

        if ((bool) ($share['currencies'] ?? false)) {
            $payload['currencies'] = LocationKit::currencies()->values()->all();
        }

        if ((bool) ($share['timezones'] ?? false)) {
            $payload['timezones'] = LocationKit::timezones()->values()->all();
        }

        if ((bool) ($share['dial_codes'] ?? false)) {
            $payload['dialCodes'] = LocationKit::dialCodes()->values()->all();
        }

        return $payload;
    }
}

<?php

namespace LaravelLocationKit\Actions;

use Illuminate\Support\Collection;
use LaravelLocationKit\Support\LocationCache;
use LaravelLocationKit\Support\LocationData;

class GetStates
{
    public function handle(int|string $countryId): Collection
    {
        return LocationCache::remember('states:'.$countryId, fn () => app(LocationData::class)->states($countryId));
    }
}

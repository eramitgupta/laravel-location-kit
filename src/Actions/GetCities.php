<?php

namespace LaravelLocationKit\Actions;

use Illuminate\Support\Collection;
use LaravelLocationKit\Support\LocationCache;
use LaravelLocationKit\Support\LocationData;

class GetCities
{
    public function handle(int|string $stateId): Collection
    {
        return LocationCache::remember('cities:'.$stateId, fn () => app(LocationData::class)->cities($stateId));
    }
}

<?php

namespace Erag\LocationKit\Actions;

use Erag\LocationKit\Support\LocationCache;
use Erag\LocationKit\Support\LocationData;
use Illuminate\Support\Collection;

class GetCities
{
    public function handle(int|string $stateId): Collection
    {
        return LocationCache::remember('cities:'.$stateId, fn () => app(LocationData::class)->cities($stateId));
    }
}

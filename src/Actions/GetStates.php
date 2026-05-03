<?php

namespace Erag\LocationKit\Actions;

use Erag\LocationKit\Support\LocationCache;
use Erag\LocationKit\Support\LocationData;
use Illuminate\Support\Collection;

class GetStates
{
    public function handle(int|string $countryId): Collection
    {
        return LocationCache::remember('states:'.$countryId, fn () => app(LocationData::class)->states($countryId));
    }
}

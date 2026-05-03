<?php

namespace Erag\LocationKit\Actions;

use Erag\LocationKit\Support\LocationCache;
use Erag\LocationKit\Support\LocationData;
use Illuminate\Support\Collection;

class GetCountries
{
    public function handle(): Collection
    {
        return LocationCache::remember('countries', fn () => app(LocationData::class)->countries());
    }
}

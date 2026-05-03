<?php

namespace LaravelLocationKit\Actions;

use Illuminate\Support\Collection;
use LaravelLocationKit\Support\LocationCache;
use LaravelLocationKit\Support\LocationData;

class GetCountries
{
    public function handle(): Collection
    {
        return LocationCache::remember('countries', fn () => app(LocationData::class)->countries());
    }
}

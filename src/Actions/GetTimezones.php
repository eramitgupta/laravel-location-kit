<?php

namespace LaravelLocationKit\Actions;

use Illuminate\Support\Collection;
use LaravelLocationKit\Support\LocationCache;
use LaravelLocationKit\Support\LocationData;

class GetTimezones
{
    public function handle(): Collection
    {
        return LocationCache::remember('timezones', fn () => app(LocationData::class)->timezones());
    }
}

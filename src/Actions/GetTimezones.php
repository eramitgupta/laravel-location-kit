<?php

namespace Erag\LocationKit\Actions;

use Erag\LocationKit\Support\LocationCache;
use Erag\LocationKit\Support\LocationData;
use Illuminate\Support\Collection;

class GetTimezones
{
    public function handle(): Collection
    {
        return LocationCache::remember('timezones', fn () => app(LocationData::class)->timezones());
    }
}

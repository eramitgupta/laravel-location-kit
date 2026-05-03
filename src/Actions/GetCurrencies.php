<?php

namespace Erag\LocationKit\Actions;

use Erag\LocationKit\Support\LocationCache;
use Erag\LocationKit\Support\LocationData;
use Illuminate\Support\Collection;

class GetCurrencies
{
    public function handle(): Collection
    {
        return LocationCache::remember('currencies', fn () => app(LocationData::class)->currencies());
    }
}

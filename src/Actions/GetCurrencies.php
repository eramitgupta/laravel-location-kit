<?php

namespace LaravelLocationKit\Actions;

use Illuminate\Support\Collection;
use LaravelLocationKit\Support\LocationCache;
use LaravelLocationKit\Support\LocationData;

class GetCurrencies
{
    public function handle(): Collection
    {
        return LocationCache::remember('currencies', fn () => app(LocationData::class)->currencies());
    }
}

<?php

namespace LaravelLocationKit\Actions;

use LaravelLocationKit\Support\LocationCache;

class ClearLocationCache
{
    public function handle(): void
    {
        LocationCache::flush();
    }
}

<?php

namespace Erag\LocationKit\Actions;

use Erag\LocationKit\Support\LocationCache;

class ClearLocationCache
{
    public function handle(): void
    {
        LocationCache::flush();
    }
}

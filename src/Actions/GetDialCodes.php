<?php

namespace Erag\LocationKit\Actions;

use Erag\LocationKit\Options\DialCodeOption;
use Illuminate\Support\Collection;

class GetDialCodes
{
    public function handle(): Collection
    {
        return app(GetCountries::class)->handle()
            ->filter(fn (array $country) => filled($country['countryCodes'] ?? null))
            ->map(fn (array $country) => DialCodeOption::fromArray($country)->toArray())
            ->values();
    }
}

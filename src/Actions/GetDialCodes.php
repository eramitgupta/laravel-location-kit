<?php

namespace LaravelLocationKit\Actions;

use Illuminate\Support\Collection;
use LaravelLocationKit\Options\DialCodeOption;

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

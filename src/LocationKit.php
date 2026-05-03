<?php

namespace LaravelLocationKit;

use Illuminate\Support\Collection;
use LaravelLocationKit\Actions\GetCities;
use LaravelLocationKit\Actions\GetCountries;
use LaravelLocationKit\Actions\GetCurrencies;
use LaravelLocationKit\Actions\GetDialCodes;
use LaravelLocationKit\Actions\GetStates;
use LaravelLocationKit\Actions\GetTimezones;
use LaravelLocationKit\Actions\SearchLocations;
use LaravelLocationKit\Options\CityOption;
use LaravelLocationKit\Options\CountryOption;
use LaravelLocationKit\Options\StateOption;

class LocationKit
{
    public function countries(): Collection
    {
        return app(GetCountries::class)->handle();
    }

    public function states(int|string $countryId): Collection
    {
        return app(GetStates::class)->handle($countryId);
    }

    public function cities(int|string $stateId): Collection
    {
        return app(GetCities::class)->handle($stateId);
    }

    public function currencies(): Collection
    {
        return app(GetCurrencies::class)->handle();
    }

    public function timezones(): Collection
    {
        return app(GetTimezones::class)->handle();
    }

    public function dialCodes(): Collection
    {
        return app(GetDialCodes::class)->handle();
    }

    public function search(string $query, int $limit = 20): array
    {
        return app(SearchLocations::class)->handle($query, $limit);
    }

    public function countryOptions(): array
    {
        return $this->countries()->map(fn (array $country) => CountryOption::fromArray($country)->toArray())->all();
    }

    public function stateOptions(int|string $countryId): array
    {
        return $this->states($countryId)->map(fn (array $state) => StateOption::fromArray($state)->toArray())->all();
    }

    public function cityOptions(int|string $stateId): array
    {
        return $this->cities($stateId)->map(fn (array $city) => CityOption::fromArray($city)->toArray())->all();
    }
}

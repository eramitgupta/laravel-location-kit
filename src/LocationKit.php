<?php

namespace Erag\LocationKit;

use Erag\LocationKit\Actions\GetCities;
use Erag\LocationKit\Actions\GetCountries;
use Erag\LocationKit\Actions\GetCurrencies;
use Erag\LocationKit\Actions\GetDialCodes;
use Erag\LocationKit\Actions\GetStates;
use Erag\LocationKit\Actions\GetTimezones;
use Erag\LocationKit\Actions\SearchLocations;
use Erag\LocationKit\Options\CityOption;
use Erag\LocationKit\Options\CountryOption;
use Erag\LocationKit\Options\StateOption;
use Illuminate\Support\Collection;

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

<?php

namespace LaravelLocationKit\Support;

use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Support\Collection;

class LocationData
{
    public function countries(): Collection
    {
        return $this->collect('countries')
            ->map(fn (array $country) => $this->normalizeCountry($country))
            ->unique('key')
            ->sortBy('name')
            ->values();
    }

    public function states(int|string|null $country = null): Collection
    {
        $countryRecord = $country === null ? null : $this->findCountry($country);

        return $this->collect('states')
            ->map(fn (array $state) => $this->normalizeState($state))
            ->unique(fn (array $state) => ($state['country_key'] ?? '').':'.$state['key'])
            ->when($countryRecord !== null, fn (Collection $states) => $states->where('country_key', $countryRecord['key']))
            ->sortBy('name')
            ->values();
    }

    public function cities(int|string|null $state = null): Collection
    {
        $stateRecord = $state === null ? null : $this->findState($state);

        return $this->collect('cities')
            ->map(fn (array $city) => $this->normalizeCity($city))
            ->unique(fn (array $city) => ($city['state_key'] ?? '').':'.$city['key'])
            ->when($stateRecord !== null, fn (Collection $cities) => $cities->where('state_key', $stateRecord['key']))
            ->sortBy('name')
            ->values();
    }

    public function currencies(): Collection
    {
        return $this->collect('currencies')
            ->map(fn (array $currency) => $this->normalizeCurrency($currency))
            ->unique('code')
            ->sortBy('code')
            ->values();
    }

    public function timezones(): Collection
    {
        return collect(DateTimeZone::listIdentifiers(DateTimeZone::ALL))
            ->map(fn (string $name) => $this->timezoneFromIdentifier($name))
            ->unique('name')
            ->sortBy('name')
            ->values();
    }

    public function findCountry(int|string $country): ?array
    {
        $needle = $this->key($country);

        return $this->countries()
            ->first(fn (array $record) => in_array($needle, array_filter([
                $record['key'] ?? null,
                $this->key($record['name'] ?? null),
                $this->key($record['iso2'] ?? null),
                $this->key($record['iso3'] ?? null),
            ]), true));
    }

    public function findState(int|string $state): ?array
    {
        $needle = $this->key($state);

        return $this->states()
            ->first(fn (array $record) => in_array($needle, array_filter([
                $record['key'] ?? null,
                $this->key($record['name'] ?? null),
                $this->key($record['state_code'] ?? null),
            ]), true));
    }

    protected function collect(string $name): Collection
    {
        return collect($this->read($name));
    }

    protected function read(string $name, bool $withDefaultFallback = true): array
    {
        $custom = $this->readCustom($name);
        $default = $withDefaultFallback ? $this->readDefault($name) : [];

        return [...$custom, ...$default];
    }

    protected function readCustom(string $name): array
    {
        $customPath = $this->configuredDataPath();

        if (! $customPath) {
            return [];
        }

        $customFile = rtrim($customPath, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$name.'.json';

        return is_file($customFile) ? $this->decode($customFile) : [];
    }

    protected function readDefault(string $name): array
    {
        $defaultFile = __DIR__.'/../data/'.$name.'.json';

        return is_file($defaultFile) ? $this->decode($defaultFile) : [];
    }

    protected function configuredDataPath(): ?string
    {
        $path = config('location-kit.data');

        if (is_array($path)) {
            $path = $path['path'] ?? null;
        }

        return filled($path) ? (string) $path : null;
    }

    protected function decode(string $path): array
    {
        return json_decode(file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);
    }

    protected function normalizeCountry(array $country): array
    {
        $country['name'] = $this->name($country['name'] ?? '');
        $country['key'] = $this->key($country['key'] ?? $country['slug'] ?? $country['name']);
        $country['countryCodes'] = collect($country['countryCodes'] ?? [])
            ->map(fn (mixed $code) => trim((string) $code))
            ->filter()
            ->unique()
            ->values()
            ->all();
        $country['flag_url'] = $country['flag_url'] ?? $this->flagUrl($country);

        return $country;
    }

    protected function normalizeState(array $state): array
    {
        $state['name'] = $this->name($state['name'] ?? '');
        $state['key'] = $this->key($state['key'] ?? $state['slug'] ?? $state['name']);
        $state['country_key'] = $this->resolveCountryKey($state);

        return $state;
    }

    protected function normalizeCity(array $city): array
    {
        $city['name'] = $this->name($city['name'] ?? '');
        $city['key'] = $this->key($city['key'] ?? $city['slug'] ?? $city['name']);
        $city['state_key'] = $this->resolveStateKey($city);

        return $city;
    }

    protected function normalizeCurrency(array $currency): array
    {
        $currency['code'] = strtoupper((string) ($currency['code'] ?? ''));
        $currency['countries'] = collect($currency['countries'] ?? [])
            ->map(fn (mixed $country) => $this->key($country))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $countryIdentifier = $currency['country'] ?? $currency['country_name'] ?? null;

        if ($countryIdentifier !== null) {
            $country = $this->findCountry($countryIdentifier);
            $countryKey = $country['key'] ?? null;

            if ($countryKey && ! in_array($countryKey, $currency['countries'], true)) {
                $currency['countries'][] = $countryKey;
            }
        }

        return $currency;
    }

    protected function timezoneFromIdentifier(string $identifier): array
    {
        $timezone = new DateTimeZone($identifier);
        $offset = $timezone->getOffset(new DateTimeImmutable('now', $timezone));

        return [
            'name' => $identifier,
            'key' => $this->key($identifier),
            'offset' => $this->formatOffset($offset),
        ];
    }

    protected function resolveCountryKey(array $state): ?string
    {
        if (isset($state['country_key'])) {
            return $this->key($state['country_key']);
        }

        $country = $state['country'] ?? $state['country_name'] ?? null;

        return $country === null ? null : $this->key($country);
    }

    protected function resolveStateKey(array $city): ?string
    {
        if (isset($city['state_key'])) {
            return $this->key($city['state_key']);
        }

        $state = $city['state'] ?? $city['state_name'] ?? null;

        return $state === null ? null : $this->key($state);
    }

    protected function name(mixed $value): string
    {
        return trim((string) $value);
    }

    protected function key(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $value = mb_strtolower(trim((string) $value));
        $value = preg_replace('/[^a-z0-9]+/i', '-', $value) ?: $value;

        return trim($value, '-');
    }

    protected function formatOffset(int $seconds): string
    {
        $sign = $seconds < 0 ? '-' : '+';
        $seconds = abs($seconds);
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        return sprintf('%s%02d:%02d', $sign, $hours, $minutes);
    }

    protected function flagUrl(array $country): ?string
    {
        $iso2 = strtolower((string) ($country['isoCode2'] ?? $country['iso2'] ?? ''));

        if (! preg_match('/^[a-z]{2}$/', $iso2)) {
            return null;
        }

        return str_replace(
            ['{iso2}', '{ISO2}'],
            [$iso2, strtoupper($iso2)],
            (string) config('location-kit.options.flag_url', 'https://api.iconify.design/flagpack:{iso2}.svg')
        );
    }
}

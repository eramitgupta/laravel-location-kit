<?php

namespace LaravelLocationKit\Actions;

use LaravelLocationKit\Support\LocationData;

class SearchLocations
{
    public function handle(string $query, int $limit = 20): array
    {
        $query = trim($query);

        if ($query === '') {
            return ['countries' => [], 'states' => [], 'cities' => []];
        }

        $data = app(LocationData::class);
        $needle = mb_strtolower($query);

        return [
            'countries' => $data->countries()
                ->filter(fn (array $country) => str_contains(mb_strtolower($country['name'] ?? ''), $needle))
                ->take($limit)
                ->values(),
            'states' => $data->states()
                ->filter(fn (array $state) => str_contains(mb_strtolower($state['name'] ?? ''), $needle))
                ->take($limit)
                ->values(),
            'cities' => $data->cities()
                ->filter(fn (array $city) => str_contains(mb_strtolower($city['name'] ?? ''), $needle))
                ->take($limit)
                ->values(),
        ];
    }
}

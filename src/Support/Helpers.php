<?php

use LaravelLocationKit\Facades\LocationKit;

if (! function_exists('location_countries')) {
    function location_countries(): array
    {
        return LocationKit::countryOptions();
    }
}

if (! function_exists('location_states')) {
    function location_states(int|string $countryId): array
    {
        return LocationKit::stateOptions($countryId);
    }
}

if (! function_exists('location_cities')) {
    function location_cities(int|string $stateId): array
    {
        return LocationKit::cityOptions($stateId);
    }
}

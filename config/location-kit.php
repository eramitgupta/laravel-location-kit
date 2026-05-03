<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Location Data Path
    |--------------------------------------------------------------------------
    |
    | Put your custom JSON files in this directory using the same filenames:
    | countries.json, states.json, cities.json, currencies.json.
    |
    | Files here are merged with bundled defaults. Custom records win when the
    | same stable key exists, so you can override only one country/state/city
    | without copying the full default file.
    |
    | Timezones are always loaded dynamically from PHP DateTimeZone.
    |
    */
    'data' => storage_path('app/location'),

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | Cache normalized location data loaded from JSON. Clear it with:
    | php artisan location-kit:clear-cache
    |
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 86400,
        'prefix' => 'location-kit',
    ],

    /*
    |--------------------------------------------------------------------------
    | Inertia Share
    |--------------------------------------------------------------------------
    |
    | Enable only the datasets your pages need. Cities can be a large payload,
    | so every dataset is opt-in.
    |
    */
    'inertia' => [
        'enabled' => false,
        'prop' => 'locationKit',
        'share' => [
            'countries' => false,
            'states' => false,
            'cities' => false,
            'currencies' => false,
            'timezones' => false,
            'dial_codes' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Option Output
    |--------------------------------------------------------------------------
    |
    | Configure keys used by countryOptions(), stateOptions(), and cityOptions().
    | Option values use stable keys, not numeric IDs.
    |
    */
    'options' => [
        'label_key' => 'label',
        'value_key' => 'value',
        'include_flag' => true,
        'flag_url' => 'https://api.iconify.design/flagpack:{iso2}.svg',
        'include_dial_code' => true,
        'include_currency' => true,
    ],
];

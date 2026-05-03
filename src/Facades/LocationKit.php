<?php

namespace Erag\LocationKit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection countries()
 * @method static \Illuminate\Support\Collection states(int|string $countryId)
 * @method static \Illuminate\Support\Collection cities(int|string $stateId)
 * @method static \Illuminate\Support\Collection currencies()
 * @method static \Illuminate\Support\Collection timezones()
 * @method static \Illuminate\Support\Collection dialCodes()
 * @method static array countryOptions()
 * @method static array stateOptions(int|string $countryId)
 * @method static array cityOptions(int|string $stateId)
 * @method static array search(string $query, int $limit = 20)
 */
class LocationKit extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'location-kit';
    }
}

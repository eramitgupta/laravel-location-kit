# Laravel Location Kit

`erag/laravel-location-kit` provides data-only Laravel helpers and option arrays for countries, states, cities, currencies, timezones, and dial codes.

## Data Coverage

The bundled default data covers:

```txt
Countries: 246
States: 4,120
Cities: 48,313
Currencies: 162
Timezones: 419
```

Countries include stable keys, calling codes, ISO-2 codes, and ISO-3 codes. States and cities are related by stable keys instead of numeric IDs. Currencies are unique by ISO currency code and include related country keys where available. Timezones are loaded dynamically from PHP `DateTimeZone::listIdentifiers(DateTimeZone::ALL)`.

## Installation

```bash
composer require erag/laravel-location-kit
php artisan erag:install-location-kit
```

By default the package reads its bundled JSON files from `src/data`. To override any file, place the same filename in your configured storage path:

```php
'data' => storage_path('app/location'),
```

Enable Inertia sharing only for the datasets your app needs:

```php
'inertia' => [
    'enabled' => true,
    'prop' => 'locationKit',
    'share' => [
        'countries' => true,
        'states' => true,
        'cities' => false,
        'currencies' => true,
        'timezones' => false,
        'dial_codes' => true,
    ],
],
```

The shared prop is lazy and available as `page.props.locationKit`. Cities are disabled by default because the bundled city list is large.

Expected filenames:

```txt
countries.json
states.json
cities.json
currencies.json
```

Files in the configured path are merged with bundled default data. Custom records win when the same stable `key` exists, so you can override only one record without copying the full file.

Example: override India only.

`storage/app/location/countries.json`

```json
[
    {
        "name": "Bharat",
        "key": "india",
        "countryCodes": ["91"],
        "isoCode2": "IN",
        "isoCode3": "IND"
    }
]
```

Add or override states for India.

`storage/app/location/states.json`

```json
[
    {
        "country": "india",
        "name": "Gujarat",
        "key": "gujarat"
    },
    {
        "country": "india",
        "name": "Maharashtra",
        "key": "maharashtra"
    }
]
```

Add or override cities for a state.

`storage/app/location/cities.json`

```json
[
    {
        "state": "gujarat",
        "name": "Ahmedabad",
        "key": "ahmedabad"
    },
    {
        "state": "gujarat",
        "name": "Surat",
        "key": "surat"
    }
]
```

Add or override currencies.

`storage/app/location/currencies.json`

```json
[
    {
        "code": "INR",
        "name": "Indian rupee",
        "symbol": "₹",
        "decimal_digits": 2,
        "countries": ["india"]
    }
]
```

Countries, states, and cities are normalized and loaded uniquely with a stable `key`, so lookups do not depend on numeric IDs. Timezones are generated from PHP:

```php
DateTimeZone::listIdentifiers(DateTimeZone::ALL);
```

## Facade

```php
use Erag\LocationKit\Facades\LocationKit;

LocationKit::countries();
LocationKit::states($countryKey);
LocationKit::cities($stateKey);
LocationKit::currencies();
LocationKit::timezones();
LocationKit::dialCodes();
LocationKit::search($query);

LocationKit::countryOptions();
LocationKit::stateOptions($countryKey);
LocationKit::cityOptions($stateKey);
```

Country option output:

```php
[
    'label' => 'India',
    'value' => 'india',
    'key' => 'india',
]
```

## Commands

```bash
php artisan location-kit:clear-cache
```

## Helpers and Blade

Helpers return option arrays for select/dropdown usage. Pass stable keys, not numeric IDs.

```php
location_countries();
location_states('india');
location_cities('gujarat');
```

Blade directives echo JSON-encoded option arrays.

```blade
@locationCountries
@locationStates('india')
@locationCities('gujarat')
```

Example:

```blade
<select name="country">
    @foreach (location_countries() as $country)
        <option value="{{ $country['value'] }}">
            {{ $country['label'] }}
        </option>
    @endforeach
</select>
```

## Inertia Vue

Install the headless frontend helper from the package:

```bash
npm install @erag/location-kit-vue
```

Use the Vue entry point:

```ts
import { useLocationKit } from '@erag/location-kit-vue'

const {
    countries,
    statesForCountry,
    citiesForState,
    callingCodeForCountry,
    maskPhone,
} = useLocationKit()

const states = statesForCountry('india')
const cities = citiesForState('gujarat')
const dialCode = callingCodeForCountry('india') // +91
const phone = maskPhone('india', '9876543210') // +91 98765 43210
```

The composable reads from Inertia the same way as the lang sync package:

```ts
const page = usePage<PageProps>()
```

## Inertia React

Use the React entry point:

```bash
npm install @erag/location-kit-react
```

```tsx
import { useLocationKit } from '@erag/location-kit-react'

export function AddressForm() {
    const {
        countries,
        statesForCountry,
        citiesForState,
        maskPhone,
    } = useLocationKit()

    const states = statesForCountry('india')
    const cities = citiesForState('gujarat')
    const phone = maskPhone('india', '9876543210')

    return null
}
```

The hook reads from Inertia page props:

```ts
const page = usePage<PageProps>()
```

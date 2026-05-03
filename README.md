# 🌍 Laravel Location Kit

`erag/laravel-location-kit` is a complete Laravel location data package that provides countries, states, cities, currencies, timezones, and dial codes with Laravel helpers, Blade directives, Inertia support, Vue composables, and React hooks.

Built for modern Laravel applications using Laravel + Inertia + Vue / React.

---

## ✨ Features

- 🌎 246 Countries
- 🗺️ 4,120 States / Regions
- 🏙️ 48,313 Cities
- 💱 162 Currencies
- 🕒 419 Timezones
- 📞 Country Dial Codes
- 🛠️ Laravel Facade Support
- 🌐 Global Helper Functions
- 🎨 Blade Directives
- ⚡ Inertia Shared Props
- 💚 Vue Package Included
- ⚛️ React Package Included
- 🔍 Search Support
- 🚀 Cache Support
- 🧩 Override Default JSON Data

---

## 📦 Installation

## Laravel Package

```bash
composer require erag/laravel-location-kit
php artisan erag:install-location-kit
````

---

## 🎯 Frontend Packages (Local Vendor Install)

## 💚 Vue

```bash
npm install ./vendor/erag/laravel-location-kit/vue
```

## ⚛️ React

```bash
npm install ./vendor/erag/laravel-location-kit/react
```

---

## 📊 Data Coverage

```txt
Countries : 246
States    : 4,120
Cities    : 48,313
Currencies: 162
Timezones : 419
```

---

## ⚙️ Configuration

```php
'data' => storage_path('app/location'),

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

---

## 🚀 Why Cities Disabled by Default?

City dataset is large for performance optimization.

Enable only when needed.

```php
'cities' => true
```

---

## 🛠️ Laravel Usage

## Facade

```php
use Erag\LocationKit\Facades\LocationKit;

LocationKit::countries();
LocationKit::states('india');
LocationKit::cities('gujarat');
LocationKit::currencies();
LocationKit::timezones();
LocationKit::dialCodes();
LocationKit::search('india');
```

---

## 📋 Option Arrays

```php
LocationKit::countryOptions();
LocationKit::stateOptions('india');
LocationKit::cityOptions('gujarat');
```

```php
[
    'label' => 'India',
    'value' => 'india',
    'key'   => 'india',
]
```

---

## 🔧 Helper Functions

```php
location_countries();
location_states('india');
location_cities('gujarat');
location_currencies();
location_timezones();
location_dial_codes();
```

---

## 🎨 Blade Directives

```blade
@locationCountries
@locationStates('india')
@locationCities('gujarat')
```

---

## 🧾 Example Select Dropdown

```blade
<select name="country">
    @foreach(location_countries() as $country)
        <option value="{{ $country['value'] }}">
            {{ $country['label'] }}
        </option>
    @endforeach
</select>
```

---

# 💚 Vue Usage

```ts
import { useLocationKit } from './vendor/erag/laravel-location-kit/vue'

const {
    countries,
    statesForCountry,
    citiesForState,
    callingCodeForCountry,
    maskPhone,
} = useLocationKit()
```

---

# ⚛️ React Usage

```tsx
import { useLocationKit } from './vendor/erag/laravel-location-kit/react'

export default function App() {
    const { countries } = useLocationKit()

    return null
}
```

---

## ⚡ Inertia Support

Shared automatically in:

```js
page.props.locationKit
```

---

## 🧩 Override Default Data

```txt
storage/app/location/
```

Files:

```txt
countries.json
states.json
cities.json
currencies.json
```

---

## 🧹 Clear Cache

```bash
php artisan location-kit:clear-cache
```

---

## 🎯 Best For

* 🏢 SaaS Projects
* CRM Systems
* 🛒 Ecommerce Checkout
* 📝 Registration Forms
* 📍 Address Forms
* 📞 Phone Input Forms
* 🌎 Multi-country Apps

---

## 📌 Requirements

* PHP 8.2+
* Laravel 10 / 11 / 12 / 13
* Inertia.js (Optional)
* Vue / React (Optional)

---

## ⭐ Support

If you like this package, give it a GitHub star.

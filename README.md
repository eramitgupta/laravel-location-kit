# 🌍 Laravel Location Kit

`erag/laravel-location-kit` is a complete Laravel location data package for countries, states, cities, currencies, timezones, and dial codes with Laravel helpers, Blade directives, Inertia support, Vue composables, and React hooks.

Built for modern Laravel applications using Laravel + Inertia + Vue / React.

---

## ✨ Features

- 🌎 246 Countries
- 🗺️ 4,120 States / Regions
- 🏙️ 48,313 Cities
- 💱 162 Currencies
- 🕒 419 Timezones
- 📞 Country Dial Codes
- 📱 Phone Mask Support
- 🛠️ Laravel Facade Support
- 🌐 Global Helper Functions
- 🎨 Blade Directives
- ⚡ Inertia Shared Props
- 💚 Vue Package Included
- ⚛️ React Package Included
- 🔍 Search Support
- 🚀 Cache Support
- 🧩 Override Default JSON Data



## 🚧 Coming Soon

- 🧱 Class-based Custom Location Data (Country, State, City, Currency) 
- ➕ Register Custom Data via Classes  
- 🔄 Merge Class Data with JSON Sources  
- ⚙️ Config-driven Class Mapping  
- 🔌 Support for Multiple Data Sources (Class + JSON) 

---

## 📦 Installation

### Laravel Package

```bash
composer require erag/laravel-location-kit
php artisan erag:install-location-kit
````

### 💚 Vue

```bash
npm install ./vendor/erag/laravel-location-kit/vue
```

### ⚛️ React

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

City dataset is large, so it is disabled by default for better performance.

```php
'cities' => true
```

---

## 🛠️ Laravel Usage

### Facade

```php
use LaravelLocationKit\Facades\LocationKit;

LocationKit::countries();
LocationKit::states('india');
LocationKit::cities('gujarat');
LocationKit::currencies();
LocationKit::timezones();
LocationKit::dialCodes();
LocationKit::search('india');
```

---

### Laravel Facade

```php
LocationKit::countries();
LocationKit::states(?string $countryKey = null);
LocationKit::cities(?string $stateKey = null);
LocationKit::currencies();
LocationKit::timezones();
LocationKit::dialCodes();
LocationKit::search(string $query, int $limit = 10);

LocationKit::countryOptions();
LocationKit::stateOptions(string $countryKey);
LocationKit::cityOptions(string $stateKey);
```


---

## ⚡ Inertia Support

```js
page.props.locationKit
```

---

## 🧩 Override Default Data

You can override bundled package data without editing vendor files.

Create your own files inside:

```txt
storage/app/location/
```

Supported files:

```txt
countries.json
states.json
cities.json
currencies.json
```

When the same `key` exists, your custom record replaces the default package record.

### 🌍 Override Country Example

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

### 🗺️ Override States Example

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

### 🏙️ Override Cities Example

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

### 💱 Override Currency Example

```json
[
    {
        "code": "INR",
        "name": "Indian Rupee",
        "symbol": "₹",
        "decimal_digits": 2,
        "countries": ["india"]
    }
]
```

### ⚙️ Change Storage Path

```php
'data' => storage_path('app/location'),
```

### 🧹 Clear Cache After Update

```bash
php artisan location-kit:clear-cache
```

---

### Vue / React Composable API

```ts
countries
statesForCountry(countryKey)
citiesForState(stateKey)
findCountry(countryKey)
callingCodeForCountry(countryKey)
phoneMaxLength(countryKey)
localPhoneDigits(countryKey, value)
maskPhone(countryKey, value)
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

## 📱 Phone Mask Example

### Vue

```vue
<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { useLocationKit } from '@erag/laravel-location-kit/vue'

const selectedCountry = ref('india')
const phone = ref('9876543210')

const locationKit = useLocationKit()

const dialCode = computed(() =>
    locationKit.callingCodeForCountry(selectedCountry.value)
)

const maxLength = computed(() =>
    locationKit.phoneMaxLength(selectedCountry.value)
)

const maskedPhone = computed(() =>
    locationKit.maskPhone(selectedCountry.value, phone.value)
)

watch(phone, (value) => {
    const digits = locationKit.localPhoneDigits(selectedCountry.value, value)

    if (value !== digits) {
        phone.value = digits
    }
})
</script>

<template>
    <div class="space-y-3">
        <input
            v-model="phone"
            inputmode="numeric"
            :maxlength="maxLength ?? undefined"
            class="h-10 w-full rounded border px-3"
            placeholder="Enter phone number"
        />

        <div class="rounded border px-3 py-2">
            <div>Dial Code: {{ dialCode }}</div>
            <div>Masked Phone: {{ maskedPhone }}</div>
        </div>
    </div>
</template>
```

### Output

```txt
Input : 9876543210
Output: +91 98765 43210
```

---

## ⚡ Short Laravel + Inertia Example

### Route

```php
use App\Http\Controllers\LocationKitExampleController;

Route::get('/location-kit-example', [LocationKitExampleController::class, 'index'])
    ->name('location-kit.example');
```

### Controller

```php
<?php

namespace App\Http\Controllers;

use LaravelLocationKit\Facades\LocationKit;
use Inertia\Inertia;
use Inertia\Response;

class LocationKitExampleController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('LocationKitExample', [
            'countries' => LocationKit::countryOptions(),
            'states' => LocationKit::stateOptions('india'),
            'cities' => LocationKit::cityOptions('gujarat'),
        ]);
    }
}
```

### Vue Page

```vue
<script setup lang="ts">
defineProps({
    countries: Array,
    states: Array,
    cities: Array,
})
</script>

<template>
    <div class="space-y-4 p-6">
        <h1 class="text-2xl font-bold">🌍 Location Kit Example</h1>

        <select class="h-10 w-full rounded border px-3">
            <option
                v-for="country in countries"
                :key="country.value"
            >
                {{ country.label }}
            </option>
        </select>

        <select class="h-10 w-full rounded border px-3">
            <option
                v-for="state in states"
                :key="state.value"
            >
                {{ state.label }}
            </option>
        </select>

        <select class="h-10 w-full rounded border px-3">
            <option
                v-for="city in cities"
                :key="city.value"
            >
                {{ city.label }}
            </option>
        </select>
    </div>
</template>
```

---

## 💚 Vue Usage

```ts
import { useLocationKit } from '@erag/laravel-location-kit/vue'

const {
    countries,
    statesForCountry,
    citiesForState,
    callingCodeForCountry,
    phoneMaxLength,
    localPhoneDigits,
    maskPhone,
} = useLocationKit()
```

---

## ⚛️ React Usage

```tsx
import { useLocationKit } from '@erag/laravel-location-kit/vue'

export default function App() {
    const {
        countries,
        statesForCountry,
        citiesForState,
        maskPhone,
    } = useLocationKit()

    return null
}
```

---

## 📌 Requirements

* PHP 8.2+
* Laravel 10 / 11 / 12 / 13
* Inertia.js Optional
* Vue / React Optional

---

## ⭐ Support

If you like this package, give it a GitHub star.


<img width="2940" height="2619" alt="image" src="https://github.com/user-attachments/assets/a6414d64-4d7f-4431-930d-687cea40f688" />


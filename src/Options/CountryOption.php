<?php

namespace Erag\LocationKit\Options;

class CountryOption
{
    public function __construct(protected array $country) {}

    public static function fromArray(array $country): self
    {
        return new self($country);
    }

    public function toArray(): array
    {
        $labelKey = config('location-kit.options.label_key', 'label');
        $valueKey = config('location-kit.options.value_key', 'value');

        return array_filter([
            $labelKey => $this->country['name'] ?? null,
            $valueKey => $this->country['key'] ?? null,
            'isoCode2' => $this->country['isoCode2'] ?? null,
            'isoCode3' => $this->country['isoCode3'] ?? null,
            'flag' => config('location-kit.options.include_flag', true) ? ($this->country['flag_url'] ?? null) : null,
            'dial_code' => config('location-kit.options.include_dial_code', true) ? $this->dialCode() : null,
            'currency_code' => config('location-kit.options.include_currency', true) ? ($this->country['currency_code'] ?? null) : null,
            'key' => $this->country['key'] ?? null,
        ], fn ($value) => $value !== null);
    }

    protected function dialCode(): ?string
    {
        $phoneCode = $this->country['countryCodes'][0] ?? null;

        return $phoneCode ? '+'.ltrim((string) $phoneCode, '+') : null;
    }
}

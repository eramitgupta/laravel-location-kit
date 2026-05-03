<?php

namespace Erag\LocationKit\Options;

class DialCodeOption
{
    public function __construct(protected array $country) {}

    public static function fromArray(array $country): self
    {
        return new self($country);
    }

    public function toArray(): array
    {
        return [
            config('location-kit.options.label_key', 'label') => trim(($this->country['name'] ?? '').' ('.$this->dialCode().')'),
            config('location-kit.options.value_key', 'value') => $this->dialCode(),
            'country_key' => $this->country['key'] ?? null,
            'isoCode2' => $this->country['isoCode2'] ?? null,
            'isoCode3' => $this->country['isoCode3'] ?? null,
            'flag' => $this->country['flag_url'] ?? null,
        ];
    }

    protected function dialCode(): ?string
    {
        $phoneCode = $this->country['countryCodes'][0] ?? null;

        return $phoneCode ? '+'.ltrim((string) $phoneCode, '+') : null;
    }
}

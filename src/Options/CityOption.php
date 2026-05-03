<?php

namespace Erag\LocationKit\Options;

class CityOption
{
    public function __construct(protected array $city) {}

    public static function fromArray(array $city): self
    {
        return new self($city);
    }

    public function toArray(): array
    {
        return [
            config('location-kit.options.label_key', 'label') => $this->city['name'] ?? null,
            config('location-kit.options.value_key', 'value') => $this->city['key'] ?? null,
            'state_key' => $this->city['state_key'] ?? null,
            'key' => $this->city['key'] ?? null,
        ];
    }
}

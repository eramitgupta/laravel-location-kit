<?php

namespace Erag\LocationKit\Options;

class StateOption
{
    public function __construct(protected array $state) {}

    public static function fromArray(array $state): self
    {
        return new self($state);
    }

    public function toArray(): array
    {
        return [
            config('location-kit.options.label_key', 'label') => $this->state['name'] ?? null,
            config('location-kit.options.value_key', 'value') => $this->state['key'] ?? null,
            'country_key' => $this->state['country_key'] ?? null,
            'state_code' => $this->state['state_code'] ?? null,
            'key' => $this->state['key'] ?? null,
        ];
    }
}

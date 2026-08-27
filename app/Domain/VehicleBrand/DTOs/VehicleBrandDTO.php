<?php

namespace App\Domain\VehicleBrand\DTOs;

class VehicleBrandDTO
{
    public function __construct(
        public readonly mixed $name,
        public readonly mixed $logo,
    ) {}
    public static function fromArray(array $data): self { return new self(
            name: $data['name'] ?? null,
            logo: $data['logo'] ?? null,
        ); }
    public function toArray(): array { return [
            'name' => $this->name,
            'logo' => $this->logo,
        ]; }
}
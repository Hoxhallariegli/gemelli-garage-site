<?php

namespace App\Domain\Car\DTOs;

class CarDTO
{
    public function __construct(
        public readonly mixed $client_id,
        public readonly mixed $brand_id,
        public readonly mixed $model_id,
        public readonly mixed $year,
        public readonly mixed $license_plate,
        public readonly mixed $color,
    ) {}
    public static function fromArray(array $data): self { return new self(
            client_id: $data['client_id'] ?? null,
            brand_id: $data['brand_id'] ?? null,
            model_id: $data['model_id'] ?? null,
            year: $data['year'] ?? null,
            license_plate: $data['license_plate'] ?? null,
            color: $data['color'] ?? null,
        ); }
    public function toArray(): array { return [
            'client_id' => $this->client_id,
            'brand_id' => $this->brand_id,
            'model_id' => $this->model_id,
            'year' => $this->year,
            'license_plate' => $this->license_plate,
            'color' => $this->color,
        ]; }
}
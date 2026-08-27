<?php

namespace App\Domain\VehicleModel\DTOs;

class VehicleModelDTO
{
    public function __construct(
        public readonly mixed $brand_id,
        public readonly mixed $body_type_id,
        public readonly mixed $name,
        public readonly mixed $wrap_meters_needed,
        public readonly mixed $model_3d_path = null,
    ) {}
    public static function fromArray(array $data): self { return new self(
            brand_id: $data['brand_id'] ?? null,
            body_type_id: $data['body_type_id'] ?? null,
            name: $data['name'] ?? null,
            wrap_meters_needed: $data['wrap_meters_needed'] ?? null,
            model_3d_path: $data['model_3d_path'] ?? null,
        ); }
    public function toArray(): array { return [
            'brand_id' => $this->brand_id,
            'body_type_id' => $this->body_type_id,
            'name' => $this->name,
            'wrap_meters_needed' => $this->wrap_meters_needed,
            'model_3d_path' => $this->model_3d_path,
        ]; }
}

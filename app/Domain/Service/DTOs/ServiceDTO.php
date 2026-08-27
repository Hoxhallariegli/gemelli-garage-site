<?php

namespace App\Domain\Service\DTOs;

class ServiceDTO
{
    public function __construct(
        public readonly mixed $name,
        public readonly mixed $description,
        public readonly mixed $base_price,
        public readonly mixed $active,
        public readonly mixed $image = null,
    ) {}
    public static function fromArray(array $data): self { return new self(
            name: $data['name'] ?? null,
            description: $data['description'] ?? null,
            base_price: $data['base_price'] ?? null,
            active: $data['active'] ?? null,
            image: $data['image'] ?? null,
        ); }
    public function toArray(): array { return [
            'name' => $this->name,
            'description' => $this->description,
            'base_price' => $this->base_price,
            'active' => $this->active,
            'image' => $this->image,
        ]; }
}

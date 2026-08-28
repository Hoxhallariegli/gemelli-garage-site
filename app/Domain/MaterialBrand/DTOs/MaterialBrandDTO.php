<?php

namespace App\Domain\MaterialBrand\DTOs;

class MaterialBrandDTO
{
    public function __construct(
        public readonly mixed $name,
        public readonly mixed $image,
    ) {}
    public static function fromArray(array $data): self { return new self(
            name: $data['name'] ?? null,
            image: $data['image'] ?? null,
        ); }
    public function toArray(): array { return [
            'name' => $this->name,
            'image' => $this->image,
        ]; }
}
<?php

namespace App\Domain\BodyType\DTOs;

class BodyTypeDTO
{
    public function __construct(
        public readonly mixed $name,
        public readonly mixed $wrap_meters,
        public readonly mixed $image = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            wrap_meters: $data['wrap_meters'] ?? null,
            image: $data['image'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'wrap_meters' => $this->wrap_meters,
            'image' => $this->image,
        ];
    }
}

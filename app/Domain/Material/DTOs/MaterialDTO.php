<?php

namespace App\Domain\Material\DTOs;

class MaterialDTO
{
    public function __construct(
        public readonly mixed $name,
        public readonly mixed $brand,
        public readonly mixed $hex_code,
        public readonly mixed $roughness,
        public readonly mixed $metalness,
        public readonly mixed $purchase_price,
        public readonly mixed $sell_price,
        public readonly mixed $stock_meters,
        public readonly mixed $image = null,
    ) {}
    public static function fromArray(array $data): self { return new self(
            name: $data['name'] ?? null,
            brand: $data['brand'] ?? null,
            hex_code: $data['hex_code'] ?? null,
            roughness: $data['roughness'] ?? null,
            metalness: $data['metalness'] ?? null,
            purchase_price: $data['purchase_price'] ?? null,
            sell_price: $data['sell_price'] ?? null,
            stock_meters: $data['stock_meters'] ?? null,
            image: $data['image'] ?? null,
        ); }
    public function toArray(): array { return [
            'name' => $this->name,
            'brand' => $this->brand,
            'hex_code' => $this->hex_code,
            'roughness' => $this->roughness,
            'metalness' => $this->metalness,
            'purchase_price' => $this->purchase_price,
            'sell_price' => $this->sell_price,
            'stock_meters' => $this->stock_meters,
            'image' => $this->image,
        ]; }
}

<?php

namespace App\Domain\Material\DTOs;

class MaterialDTO
{
    public function __construct(
        public readonly mixed $name,
        public readonly mixed $material_brand_id,
        public readonly mixed $purchase_price,
        public readonly mixed $sell_price,
        public readonly mixed $stock_meters,
        public readonly mixed $image = null,
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            name: $data['name'] ?? null,
            material_brand_id: (!empty($data['material_brand_id'])) ? (int)$data['material_brand_id'] : null,
            purchase_price: ($data['purchase_price'] !== '' && $data['purchase_price'] !== null) ? $data['purchase_price'] : 0,
            sell_price: ($data['sell_price'] !== '' && $data['sell_price'] !== null) ? $data['sell_price'] : 0,
            stock_meters: ($data['stock_meters'] !== '' && $data['stock_meters'] !== null) ? $data['stock_meters'] : 0,
            image: $data['image'] ?? null,
        );
    }

    public function toArray(): array {
        return [
            'name' => $this->name,
            'material_brand_id' => $this->material_brand_id,
            'purchase_price' => $this->purchase_price,
            'sell_price' => $this->sell_price,
            'stock_meters' => $this->stock_meters,
            'image' => $this->image,
        ];
    }
}

<?php

namespace App\Domain\Part\DTOs;

class PartDTO
{
    public function __construct(
        public readonly mixed $name,
        public readonly mixed $purchase_price,
        public readonly mixed $sell_price,
        public readonly mixed $stock_quantity,
        public readonly mixed $image = null,
    ) {}
    public static function fromArray(array $data): self { return new self(
            name: $data['name'] ?? null,
            purchase_price: $data['purchase_price'] ?? null,
            sell_price: $data['sell_price'] ?? null,
            stock_quantity: $data['stock_quantity'] ?? null,
            image: $data['image'] ?? null,
        ); }
    public function toArray(): array { return [
            'name' => $this->name,
            'purchase_price' => $this->purchase_price,
            'sell_price' => $this->sell_price,
            'stock_quantity' => $this->stock_quantity,
            'image' => $this->image,
        ]; }
}

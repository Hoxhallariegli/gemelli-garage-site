<?php

namespace App\Domain\Purchase\DTOs;

class PurchaseDTO
{
    public function __construct(
        public readonly mixed $supplier_id,
        public readonly mixed $purchase_date,
        public readonly mixed $reference_number,
        public readonly mixed $status,
        public readonly mixed $total_amount,
        public readonly array $items = [],
    ) {}
    public static function fromArray(array $data): self { return new self(
            supplier_id: $data['supplier_id'] ?? null,
            purchase_date: $data['purchase_date'] ?? null,
            reference_number: $data['reference_number'] ?? null,
            status: $data['status'] ?? 'pending',
            total_amount: $data['total_amount'] ?? 0,
            items: $data['items'] ?? [],
        ); }
    public function toArray(): array { return [
            'supplier_id' => $this->supplier_id,
            'purchase_date' => $this->purchase_date,
            'reference_number' => $this->reference_number,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
        ]; }
}

<?php

namespace App\Domain\SubscriptionRenewal\DTOs;

class SubscriptionRenewalDTO
{
    public function __construct(
        public readonly ?int $tenant_id,
        public readonly int $plan_id,
        public readonly string $payment_method,
        public readonly ?string $transfer_document,
        public readonly float $amount,
        public readonly ?string $notes,
        public readonly string $status,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            tenant_id: isset($data['tenant_id']) && $data['tenant_id'] !== '' ? (int) $data['tenant_id'] : null,
            plan_id: (int) ($data['plan_id'] ?? 0),
            payment_method: (string) ($data['payment_method'] ?? 'bank_transfer'),
            transfer_document: isset($data['transfer_document']) ? (string) $data['transfer_document'] : null,
            amount: isset($data['amount']) && $data['amount'] !== '' ? (float) $data['amount'] : 0.0,
            notes: isset($data['notes']) ? (string) $data['notes'] : null,
            status: (string) ($data['status'] ?? 'pending'),
        );
    }

    public function toArray(): array
    {
        return [
            'tenant_id' => $this->tenant_id,
            'plan_id' => $this->plan_id,
            'payment_method' => $this->payment_method,
            'transfer_document' => $this->transfer_document,
            'amount' => $this->amount,
            'notes' => $this->notes,
            'status' => $this->status,
        ];
    }
}

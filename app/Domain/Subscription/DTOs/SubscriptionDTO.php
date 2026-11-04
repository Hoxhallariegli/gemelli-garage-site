<?php

namespace App\Domain\Subscription\DTOs;

class SubscriptionDTO
{
    public function __construct(
        public readonly ?int $tenant_id,
        public readonly int $plan_id,
        public readonly string $starts_at,
        public readonly string $ends_at,
        public readonly string $status,
        public readonly bool $auto_renew,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            tenant_id: isset($data['tenant_id']) && $data['tenant_id'] !== '' ? (int) $data['tenant_id'] : null,
            plan_id: (int) ($data['plan_id'] ?? 0),
            starts_at: (string) ($data['starts_at'] ?? now()->toDateTimeString()),
            ends_at: (string) ($data['ends_at'] ?? now()->addMonth()->toDateTimeString()),
            status: (string) ($data['status'] ?? 'active'),
            auto_renew: (bool) ($data['auto_renew'] ?? true),
        );
    }

    public function toArray(): array
    {
        return [
            'tenant_id' => $this->tenant_id,
            'plan_id' => $this->plan_id,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'status' => $this->status,
            'auto_renew' => $this->auto_renew,
        ];
    }
}

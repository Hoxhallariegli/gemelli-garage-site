<?php

namespace App\Domain\Payment\DTOs;

class PaymentDTO
{
    public function __construct(
        public readonly mixed $job_id,
        public readonly mixed $amount,
        public readonly mixed $method,
        public readonly mixed $payment_date,
    ) {}
    public static function fromArray(array $data): self { return new self(
            job_id: $data['job_id'] ?? null,
            amount: $data['amount'] ?? null,
            method: $data['method'] ?? null,
            payment_date: $data['payment_date'] ?? null,
        ); }
    public function toArray(): array { return [
            'job_id' => $this->job_id,
            'amount' => $this->amount,
            'method' => $this->method,
            'payment_date' => $this->payment_date,
        ]; }
}
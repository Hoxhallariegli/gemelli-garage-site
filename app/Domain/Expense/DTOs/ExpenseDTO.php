<?php

namespace App\Domain\Expense\DTOs;

class ExpenseDTO
{
    public function __construct(
        public readonly string $title,
        public readonly float $amount,
        public readonly string $date,
        public readonly string $category,
        public readonly ?int $job_id = null,
        public readonly ?string $notes = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            amount: (float) $data['amount'],
            date: $data['date'],
            category: $data['category'],
            job_id: $data['job_id'] ? (int) $data['job_id'] : null,
            notes: $data['notes'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'amount' => $this->amount,
            'date' => $this->date,
            'category' => $this->category,
            'job_id' => $this->job_id,
            'notes' => $this->notes,
        ];
    }
}

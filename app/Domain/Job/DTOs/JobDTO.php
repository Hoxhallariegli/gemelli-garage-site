<?php

namespace App\Domain\Job\DTOs;

class JobDTO
{
    public function __construct(
        public readonly mixed $car_id,
        public readonly mixed $final_price,
        public readonly mixed $status,
        public readonly mixed $job_date,
        public readonly mixed $notes,
        public readonly array $services = [],
        public readonly array $materials = [],
        public readonly array $parts = [],
    ) {}

    public static function fromArray(array $data): self { return new self(
            car_id: $data['car_id'] ?? null,
            final_price: $data['final_price'] ?? 0,
            status: $data['status'] ?? null,
            job_date: $data['job_date'] ?? null,
            notes: $data['notes'] ?? null,
            services: $data['services'] ?? [],
            materials: $data['materials'] ?? [],
            parts: $data['parts'] ?? [],
        ); }

    public function toArray(): array { return [
            'car_id' => $this->car_id,
            'final_price' => $this->final_price,
            'status' => $this->status,
            'job_date' => $this->job_date,
            'notes' => $this->notes,
        ]; }
}

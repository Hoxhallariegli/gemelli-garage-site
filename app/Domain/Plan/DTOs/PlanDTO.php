<?php

namespace App\Domain\Plan\DTOs;

class PlanDTO
{
    public function __construct(
        public readonly string $name,
        public readonly float $price,
        public readonly ?int $duration_months,
        public readonly ?int $max_users,
        public readonly ?int $max_cars,
        public readonly ?int $max_jobs,
        public readonly bool $active,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: (string) ($data['name'] ?? ''),
            price: isset($data['price']) && $data['price'] !== '' ? (float) $data['price'] : 0.0,
            duration_months: isset($data['duration_months']) && $data['duration_months'] !== '' ? (int) $data['duration_months'] : 1,
            max_users: isset($data['max_users']) && $data['max_users'] !== '' ? (int) $data['max_users'] : 5,
            max_cars: isset($data['max_cars']) && $data['max_cars'] !== '' ? (int) $data['max_cars'] : 100,
            max_jobs: isset($data['max_jobs']) && $data['max_jobs'] !== '' ? (int) $data['max_jobs'] : 500,
            active: (bool) ($data['active'] ?? true),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'duration_months' => $this->duration_months,
            'max_users' => $this->max_users,
            'max_cars' => $this->max_cars,
            'max_jobs' => $this->max_jobs,
            'active' => $this->active,
        ];
    }
}

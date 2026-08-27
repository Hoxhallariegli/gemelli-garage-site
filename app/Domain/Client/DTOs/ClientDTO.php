<?php

namespace App\Domain\Client\DTOs;

class ClientDTO
{
    public function __construct(
        public readonly mixed $name,
        public readonly mixed $phone,
        public readonly mixed $email,
        public readonly mixed $notes,
    ) {}
    public static function fromArray(array $data): self { return new self(
            name: $data['name'] ?? null,
            phone: $data['phone'] ?? null,
            email: $data['email'] ?? null,
            notes: $data['notes'] ?? null,
        ); }
    public function toArray(): array { return [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'notes' => $this->notes,
        ]; }
}
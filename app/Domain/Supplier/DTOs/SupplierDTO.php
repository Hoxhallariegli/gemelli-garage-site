<?php

namespace App\Domain\Supplier\DTOs;

class SupplierDTO
{
    public function __construct(
        public readonly mixed $name,
        public readonly mixed $contact_person,
        public readonly mixed $phone,
        public readonly mixed $email,
    ) {}
    public static function fromArray(array $data): self { return new self(
            name: $data['name'] ?? null,
            contact_person: $data['contact_person'] ?? null,
            phone: $data['phone'] ?? null,
            email: $data['email'] ?? null,
        ); }
    public function toArray(): array { return [
            'name' => $this->name,
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'email' => $this->email,
        ]; }
}

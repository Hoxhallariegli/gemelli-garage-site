<?php

namespace App\Domain\JobRequest\DTOs;

class JobRequestDTO
{
    public function __construct(
        public readonly mixed $name,
        public readonly mixed $email,
        public readonly mixed $phone,
        public readonly mixed $brand,
        public readonly mixed $model,
        public readonly mixed $body_type_id,
        public readonly mixed $service_id,
        public readonly mixed $material_id,
        public readonly mixed $estimated_price,
        public readonly mixed $message,
        public readonly mixed $status,
    ) {}
    public static function fromArray(array $data): self { return new self(
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            brand: $data['brand'] ?? null,
            model: $data['model'] ?? null,
            body_type_id: $data['body_type_id'] ?? null,
            service_id: $data['service_id'] ?? null,
            material_id: $data['material_id'] ?? null,
            estimated_price: $data['estimated_price'] ?? null,
            message: $data['message'] ?? null,
            status: $data['status'] ?? null,
        ); }
    public function toArray(): array { return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'brand' => $this->brand,
            'model' => $this->model,
            'body_type_id' => $this->body_type_id,
            'service_id' => $this->service_id,
            'material_id' => $this->material_id,
            'estimated_price' => $this->estimated_price,
            'message' => $this->message,
            'status' => $this->status,
        ]; }
}
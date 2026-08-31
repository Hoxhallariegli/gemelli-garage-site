<?php

namespace App\Domain\CallLog\DTOs;

class CallLogDTO
{
    public function __construct(
        public readonly mixed $phone_number,
        public readonly mixed $caller_name,
        public readonly mixed $type,
        public readonly mixed $call_time,
        public readonly mixed $is_client,
    ) {}
    public static function fromArray(array $data): self { return new self(
            phone_number: $data['phone_number'] ?? null,
            caller_name: $data['caller_name'] ?? null,
            type: $data['type'] ?? null,
            call_time: $data['call_time'] ?? null,
            is_client: $data['is_client'] ?? null,
        ); }
    public function toArray(): array { return [
            'phone_number' => $this->phone_number,
            'caller_name' => $this->caller_name,
            'type' => $this->type,
            'call_time' => $this->call_time,
            'is_client' => $this->is_client,
        ]; }
}
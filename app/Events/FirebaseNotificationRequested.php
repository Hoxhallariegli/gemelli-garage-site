<?php

namespace App\Events;

use Illuminate\Broadcasting::InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FirebaseNotificationRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $event,
        public string $modelClass,
        public int|string $modelId,
        public string $action = 'created',
        public ?object $item = null
    ) {}
}

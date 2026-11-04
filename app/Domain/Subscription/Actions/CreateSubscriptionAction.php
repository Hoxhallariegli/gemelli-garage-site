<?php

namespace App\Domain\Subscription\Actions;

use App\Models\Subscription;
use App\Domain\Subscription\DTOs\SubscriptionDTO;

class CreateSubscriptionAction
{
    public function execute(SubscriptionDTO $dto): Subscription
    {
        return Subscription::create($dto->toArray());
    }
}

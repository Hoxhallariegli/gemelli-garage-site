<?php

namespace App\Domain\Subscription\Actions;

use App\Models\Subscription;
use App\Models\AuditTrail;
use App\Domain\Subscription\DTOs\SubscriptionDTO;

class CreateSubscriptionAction
{
    public function execute(SubscriptionDTO $dto): Subscription
    {
        $item = Subscription::create($dto->toArray());
        AuditTrail::log($item, 'create', 'Subscriptions');
        return $item;
    }
}

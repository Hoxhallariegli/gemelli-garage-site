<?php

namespace App\Domain\SubscriptionRenewal\Actions;

use App\Models\SubscriptionRenewal;
use App\Domain\SubscriptionRenewal\DTOs\SubscriptionRenewalDTO;

class CreateSubscriptionRenewalAction
{
    public function execute(SubscriptionRenewalDTO $dto): SubscriptionRenewal
    {
        return SubscriptionRenewal::create($dto->toArray());
    }
}

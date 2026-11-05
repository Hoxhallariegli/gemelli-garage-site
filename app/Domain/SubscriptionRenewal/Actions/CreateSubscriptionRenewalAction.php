<?php

namespace App\Domain\SubscriptionRenewal\Actions;

use App\Models\SubscriptionRenewal;
use App\Models\AuditTrail;
use App\Domain\SubscriptionRenewal\DTOs\SubscriptionRenewalDTO;

class CreateSubscriptionRenewalAction
{
    public function execute(SubscriptionRenewalDTO $dto): SubscriptionRenewal
    {
        $item = SubscriptionRenewal::create($dto->toArray());
        AuditTrail::log($item, 'create', 'SubscriptionRenewals');
        return $item;
    }
}

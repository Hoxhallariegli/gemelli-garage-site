<?php

namespace App\Domain\SubscriptionRenewal\Actions;

use App\Models\SubscriptionRenewal;
use App\Models\AuditTrail;

class DeleteSubscriptionRenewalAction
{
    public function execute(SubscriptionRenewal $model): bool
    {
        AuditTrail::log($model, 'delete', 'SubscriptionRenewals');
        return $model->delete();
    }
}

<?php

namespace App\Domain\SubscriptionRenewal\Actions;

use App\Models\SubscriptionRenewal;

class DeleteSubscriptionRenewalAction
{
    public function execute(SubscriptionRenewal $model): bool
    {
        return $model->delete();
    }
}

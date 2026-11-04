<?php

namespace App\Domain\Subscription\Actions;

use App\Models\Subscription;

class DeleteSubscriptionAction
{
    public function execute(Subscription $model): bool
    {
        return $model->delete();
    }
}

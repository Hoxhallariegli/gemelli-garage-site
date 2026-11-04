<?php

namespace App\Domain\Subscription\Actions;

use App\Models\Subscription;
use App\Domain\Subscription\DTOs\SubscriptionDTO;

class UpdateSubscriptionAction
{
    public function execute(Subscription $model, SubscriptionDTO $dto): Subscription
    {
        $model->update($dto->toArray());
        return $model->fresh();
    }
}

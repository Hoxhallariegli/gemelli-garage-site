<?php

namespace App\Domain\SubscriptionRenewal\Actions;

use App\Models\SubscriptionRenewal;
use App\Models\Subscription;
use App\Domain\SubscriptionRenewal\DTOs\SubscriptionRenewalDTO;

class UpdateSubscriptionRenewalAction
{
    public function execute(SubscriptionRenewal $model, SubscriptionRenewalDTO $dto): SubscriptionRenewal
    {
        $oldStatus = $model->status;
        $model->update($dto->toArray());

        // If approved, extend or activate the tenant's subscription
        if ($oldStatus !== 'approved' && $model->status === 'approved') {
            $plan = $model->plan;
            $durationMonths = $plan?->duration_months ?? 1;

            Subscription::updateOrCreate(
                ['tenant_id' => $model->tenant_id],
                [
                    'plan_id' => $model->plan_id,
                    'starts_at' => now(),
                    'ends_at' => now()->addMonths($durationMonths),
                    'status' => 'active',
                    'auto_renew' => true,
                ]
            );
        }

        return $model->fresh();
    }
}

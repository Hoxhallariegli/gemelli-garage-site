<?php

namespace App\Domain\Plan\Actions;

use App\Models\Plan;
use App\Models\AuditTrail;
use App\Domain\Plan\DTOs\PlanDTO;

class UpdatePlanAction
{
    public function execute(Plan $model, PlanDTO $dto): Plan
    {
        $model->update($dto->toArray());
        AuditTrail::log($model, 'update', 'Plans');
        return $model->fresh();
    }
}

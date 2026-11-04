<?php

namespace App\Domain\Plan\Actions;

use App\Models\Plan;
use App\Domain\Plan\DTOs\PlanDTO;

class UpdatePlanAction
{
    public function execute(Plan $model, PlanDTO $dto): Plan
    {
        $model->update($dto->toArray());
        return $model->fresh();
    }
}

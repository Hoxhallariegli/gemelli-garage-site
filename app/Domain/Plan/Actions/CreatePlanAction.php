<?php

namespace App\Domain\Plan\Actions;

use App\Models\Plan;
use App\Domain\Plan\DTOs\PlanDTO;

class CreatePlanAction
{
    public function execute(PlanDTO $dto): Plan
    {
        return Plan::create($dto->toArray());
    }
}

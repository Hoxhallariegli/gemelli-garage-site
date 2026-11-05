<?php

namespace App\Domain\Plan\Actions;

use App\Models\Plan;
use App\Models\AuditTrail;
use App\Domain\Plan\DTOs\PlanDTO;

class CreatePlanAction
{
    public function execute(PlanDTO $dto): Plan
    {
        $item = Plan::create($dto->toArray());
        AuditTrail::log($item, 'create', 'Plans');
        return $item;
    }
}

<?php

namespace App\Domain\Plan\Actions;

use App\Models\Plan;

class DeletePlanAction
{
    public function execute(Plan $model): bool
    {
        return $model->delete();
    }
}

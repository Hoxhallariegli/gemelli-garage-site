<?php

namespace App\Domain\Part\Actions;

use App\Models\Part;
use App\Domain\Part\DTOs\PartDTO;
use App\Models\AuditTrail;

class UpdatePartAction
{
    public function execute(Part $model, PartDTO $dto): Part
    {
        $model->fill($dto->toArray());
        AuditTrail::log($model, 'update', 'Parts');
        $model->save();
        return $model->fresh();
    }
}
<?php

namespace App\Domain\Material\Actions;

use App\Models\Material;
use App\Domain\Material\DTOs\MaterialDTO;
use App\Models\AuditTrail;

class UpdateMaterialAction
{
    public function execute(Material $model, MaterialDTO $dto): Material
    {
        $model->fill($dto->toArray());
        AuditTrail::log($model, 'update', 'Materials');
        $model->save();
        return $model->fresh();
    }
}
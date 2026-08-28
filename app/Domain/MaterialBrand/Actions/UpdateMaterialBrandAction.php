<?php

namespace App\Domain\MaterialBrand\Actions;

use App\Models\MaterialBrand;
use App\Domain\MaterialBrand\DTOs\MaterialBrandDTO;
use App\Models\AuditTrail;

class UpdateMaterialBrandAction
{
    public function execute(MaterialBrand $model, MaterialBrandDTO $dto): MaterialBrand
    {
        $model->fill($dto->toArray());
        AuditTrail::log($model, 'update', 'MaterialBrands');
        $model->save();
        return $model->fresh();
    }
}
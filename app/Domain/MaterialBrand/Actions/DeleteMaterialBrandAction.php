<?php

namespace App\Domain\MaterialBrand\Actions;

use App\Models\MaterialBrand;
use App\Models\AuditTrail;

class DeleteMaterialBrandAction
{
    public function execute(MaterialBrand $model): bool 
    {
        AuditTrail::log($model, 'delete', 'MaterialBrands');
        return $model->delete(); 
    }
}
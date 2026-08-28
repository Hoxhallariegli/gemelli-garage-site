<?php

namespace App\Domain\MaterialBrand\Actions;

use App\Models\MaterialBrand;
use App\Domain\MaterialBrand\DTOs\MaterialBrandDTO;
use App\Models\AuditTrail;

class CreateMaterialBrandAction
{
    public function execute(MaterialBrandDTO $dto): MaterialBrand 
    {
        $item = MaterialBrand::create($dto->toArray());
        AuditTrail::log($item, 'create', 'MaterialBrands');
        return $item;
    }
}
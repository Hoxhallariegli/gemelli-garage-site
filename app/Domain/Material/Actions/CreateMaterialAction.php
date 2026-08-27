<?php

namespace App\Domain\Material\Actions;

use App\Models\Material;
use App\Domain\Material\DTOs\MaterialDTO;
use App\Models\AuditTrail;

class CreateMaterialAction
{
    public function execute(MaterialDTO $dto): Material 
    {
        $item = Material::create($dto->toArray());
        AuditTrail::log($item, 'create', 'Materials');
        return $item;
    }
}
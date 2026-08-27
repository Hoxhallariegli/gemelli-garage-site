<?php

namespace App\Domain\VehicleModel\Actions;

use App\Models\VehicleModel;
use App\Domain\VehicleModel\DTOs\VehicleModelDTO;
use App\Models\AuditTrail;

class CreateVehicleModelAction
{
    public function execute(VehicleModelDTO $dto): VehicleModel 
    {
        $item = VehicleModel::create($dto->toArray());
        AuditTrail::log($item, 'create', 'VehicleModels');
        return $item;
    }
}
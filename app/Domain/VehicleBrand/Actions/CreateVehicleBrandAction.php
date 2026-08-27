<?php

namespace App\Domain\VehicleBrand\Actions;

use App\Models\VehicleBrand;
use App\Domain\VehicleBrand\DTOs\VehicleBrandDTO;
use App\Models\AuditTrail;

class CreateVehicleBrandAction
{
    public function execute(VehicleBrandDTO $dto): VehicleBrand 
    {
        $item = VehicleBrand::create($dto->toArray());
        AuditTrail::log($item, 'create', 'VehicleBrands');
        return $item;
    }
}
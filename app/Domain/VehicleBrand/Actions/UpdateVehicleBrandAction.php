<?php

namespace App\Domain\VehicleBrand\Actions;

use App\Models\VehicleBrand;
use App\Domain\VehicleBrand\DTOs\VehicleBrandDTO;
use App\Models\AuditTrail;

class UpdateVehicleBrandAction
{
    public function execute(VehicleBrand $model, VehicleBrandDTO $dto): VehicleBrand
    {
        $model->fill($dto->toArray());
        AuditTrail::log($model, 'update', 'VehicleBrands');
        $model->save();
        return $model->fresh();
    }
}
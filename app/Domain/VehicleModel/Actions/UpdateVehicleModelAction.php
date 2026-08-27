<?php

namespace App\Domain\VehicleModel\Actions;

use App\Models\VehicleModel;
use App\Domain\VehicleModel\DTOs\VehicleModelDTO;
use App\Models\AuditTrail;

class UpdateVehicleModelAction
{
    public function execute(VehicleModel $model, VehicleModelDTO $dto): VehicleModel
    {
        $model->fill($dto->toArray());
        AuditTrail::log($model, 'update', 'VehicleModels');
        $model->save();
        return $model->fresh();
    }
}
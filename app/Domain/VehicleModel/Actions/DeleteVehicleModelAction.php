<?php

namespace App\Domain\VehicleModel\Actions;

use App\Models\VehicleModel;
use App\Models\AuditTrail;

class DeleteVehicleModelAction
{
    public function execute(VehicleModel $model): bool 
    {
        AuditTrail::log($model, 'delete', 'VehicleModels');
        return $model->delete(); 
    }
}
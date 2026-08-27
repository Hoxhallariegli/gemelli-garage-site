<?php

namespace App\Domain\VehicleBrand\Actions;

use App\Models\VehicleBrand;
use App\Models\AuditTrail;

class DeleteVehicleBrandAction
{
    public function execute(VehicleBrand $model): bool 
    {
        AuditTrail::log($model, 'delete', 'VehicleBrands');
        return $model->delete(); 
    }
}
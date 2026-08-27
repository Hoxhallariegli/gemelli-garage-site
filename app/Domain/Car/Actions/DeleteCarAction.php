<?php

namespace App\Domain\Car\Actions;

use App\Models\Car;
use App\Models\AuditTrail;

class DeleteCarAction
{
    public function execute(Car $model): bool 
    {
        AuditTrail::log($model, 'delete', 'Cars');
        return $model->delete(); 
    }
}
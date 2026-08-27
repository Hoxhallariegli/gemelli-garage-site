<?php

namespace App\Domain\Material\Actions;

use App\Models\Material;
use App\Models\AuditTrail;

class DeleteMaterialAction
{
    public function execute(Material $model): bool 
    {
        AuditTrail::log($model, 'delete', 'Materials');
        return $model->delete(); 
    }
}
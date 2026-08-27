<?php

namespace App\Domain\Part\Actions;

use App\Models\Part;
use App\Models\AuditTrail;

class DeletePartAction
{
    public function execute(Part $model): bool 
    {
        AuditTrail::log($model, 'delete', 'Parts');
        return $model->delete(); 
    }
}
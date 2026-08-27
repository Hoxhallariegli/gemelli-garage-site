<?php

namespace App\Domain\Supplier\Actions;

use App\Models\Supplier;
use App\Models\AuditTrail;

class DeleteSupplierAction
{
    public function execute(Supplier $model): bool
    {
        AuditTrail::log($model, 'delete', 'Suppliers');
        return $model->delete();
    }
}

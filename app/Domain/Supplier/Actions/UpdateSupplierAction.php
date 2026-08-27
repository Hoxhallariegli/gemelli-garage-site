<?php

namespace App\Domain\Supplier\Actions;

use App\Models\Supplier;
use App\Domain\Supplier\DTOs\SupplierDTO;
use App\Models\AuditTrail;

class UpdateSupplierAction
{
    public function execute(Supplier $model, SupplierDTO $dto): Supplier
    {
        $model->fill($dto->toArray());
        AuditTrail::log($model, 'update', 'Suppliers');
        $model->save();
        return $model->fresh();
    }
}

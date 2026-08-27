<?php

namespace App\Domain\Supplier\Actions;

use App\Models\Supplier;
use App\Domain\Supplier\DTOs\SupplierDTO;
use App\Models\AuditTrail;

class CreateSupplierAction
{
    public function execute(SupplierDTO $dto): Supplier
    {
        $item = Supplier::create($dto->toArray());
        AuditTrail::log($item, 'create', 'Suppliers');
        return $item;
    }
}

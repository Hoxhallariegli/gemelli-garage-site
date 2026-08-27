<?php

namespace App\Domain\Car\Actions;

use App\Models\Car;
use App\Domain\Car\DTOs\CarDTO;
use App\Models\AuditTrail;

class CreateCarAction
{
    public function execute(CarDTO $dto): Car 
    {
        $item = Car::create($dto->toArray());
        AuditTrail::log($item, 'create', 'Cars');
        return $item;
    }
}
<?php

namespace App\Domain\Car\Actions;

use App\Models\Car;
use App\Domain\Car\DTOs\CarDTO;
use App\Models\AuditTrail;

class UpdateCarAction
{
    public function execute(Car $model, CarDTO $dto): Car
    {
        $model->fill($dto->toArray());
        AuditTrail::log($model, 'update', 'Cars');
        $model->save();
        return $model->fresh();
    }
}
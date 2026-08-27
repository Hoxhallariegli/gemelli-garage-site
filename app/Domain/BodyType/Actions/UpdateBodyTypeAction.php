<?php

namespace App\Domain\BodyType\Actions;

use App\Models\BodyType;
use App\Domain\BodyType\DTOs\BodyTypeDTO;
use App\Models\AuditTrail;

class UpdateBodyTypeAction
{
    public function execute(BodyType $model, BodyTypeDTO $dto): BodyType
    {
        $model->fill($dto->toArray());
        AuditTrail::log($model, 'update', 'BodyTypes');
        $model->save();
        return $model->fresh();
    }
}

<?php

namespace App\Domain\BodyType\Actions;

use App\Models\BodyType;
use App\Domain\BodyType\DTOs\BodyTypeDTO;
use App\Models\AuditTrail;

class CreateBodyTypeAction
{
    public function execute(BodyTypeDTO $dto): BodyType
    {
        $item = BodyType::create($dto->toArray());
        AuditTrail::log($item, 'create', 'BodyTypes');
        return $item;
    }
}

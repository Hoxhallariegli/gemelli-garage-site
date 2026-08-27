<?php

namespace App\Domain\Part\Actions;

use App\Models\Part;
use App\Domain\Part\DTOs\PartDTO;
use App\Models\AuditTrail;

class CreatePartAction
{
    public function execute(PartDTO $dto): Part 
    {
        $item = Part::create($dto->toArray());
        AuditTrail::log($item, 'create', 'Parts');
        return $item;
    }
}
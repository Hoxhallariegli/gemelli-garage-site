<?php

namespace App\Domain\BodyType\Actions;

use App\Models\BodyType;
use App\Models\AuditTrail;

class DeleteBodyTypeAction
{
    public function execute(BodyType $model): bool
    {
        AuditTrail::log($model, 'delete', 'BodyTypes');
        return $model->delete();
    }
}

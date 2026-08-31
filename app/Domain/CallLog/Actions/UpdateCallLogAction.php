<?php

namespace App\Domain\CallLog\Actions;

use App\Models\CallLog;
use App\Domain\CallLog\DTOs\CallLogDTO;
use App\Models\AuditTrail;

class UpdateCallLogAction
{
    public function execute(CallLog $model, CallLogDTO $dto): CallLog
    {
        $model->fill($dto->toArray());
        AuditTrail::log($model, 'update', 'CallLogs');
        $model->save();
        return $model->fresh();
    }
}
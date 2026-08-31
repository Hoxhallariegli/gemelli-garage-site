<?php

namespace App\Domain\CallLog\Actions;

use App\Models\CallLog;
use App\Domain\CallLog\DTOs\CallLogDTO;
use App\Models\AuditTrail;

class CreateCallLogAction
{
    public function execute(CallLogDTO $dto): CallLog 
    {
        $item = CallLog::create($dto->toArray());
        AuditTrail::log($item, 'create', 'CallLogs');
        return $item;
    }
}
<?php

namespace App\Domain\CallLog\Actions;

use App\Models\CallLog;
use App\Models\AuditTrail;

class DeleteCallLogAction
{
    public function execute(CallLog $model): bool 
    {
        AuditTrail::log($model, 'delete', 'CallLogs');
        return $model->delete(); 
    }
}
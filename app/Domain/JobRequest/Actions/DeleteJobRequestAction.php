<?php

namespace App\Domain\JobRequest\Actions;

use App\Models\JobRequest;
use App\Models\AuditTrail;

class DeleteJobRequestAction
{
    public function execute(JobRequest $model): bool 
    {
        AuditTrail::log($model, 'delete', 'JobRequests');
        return $model->delete(); 
    }
}
<?php

namespace App\Domain\JobRequest\Actions;

use App\Models\JobRequest;
use App\Domain\JobRequest\DTOs\JobRequestDTO;
use App\Models\AuditTrail;

class UpdateJobRequestAction
{
    public function execute(JobRequest $model, JobRequestDTO $dto): JobRequest
    {
        $model->fill($dto->toArray());
        AuditTrail::log($model, 'update', 'JobRequests');
        $model->save();
        return $model->fresh();
    }
}
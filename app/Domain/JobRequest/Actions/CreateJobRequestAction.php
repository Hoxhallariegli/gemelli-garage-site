<?php

namespace App\Domain\JobRequest\Actions;

use App\Models\JobRequest;
use App\Domain\JobRequest\DTOs\JobRequestDTO;
use App\Models\AuditTrail;

class CreateJobRequestAction
{
    public function execute(JobRequestDTO $dto): JobRequest 
    {
        $item = JobRequest::create($dto->toArray());
        AuditTrail::log($item, 'create', 'JobRequests');
        return $item;
    }
}
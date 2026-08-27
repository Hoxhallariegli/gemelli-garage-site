<?php

namespace App\Domain\Client\Actions;

use App\Models\Client;
use App\Domain\Client\DTOs\ClientDTO;
use App\Models\AuditTrail;

class UpdateClientAction
{
    public function execute(Client $model, ClientDTO $dto): Client
    {
        $model->fill($dto->toArray());
        AuditTrail::log($model, 'update', 'Clients');
        $model->save();
        return $model->fresh();
    }
}
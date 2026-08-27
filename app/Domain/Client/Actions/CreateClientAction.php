<?php

namespace App\Domain\Client\Actions;

use App\Models\Client;
use App\Domain\Client\DTOs\ClientDTO;
use App\Models\AuditTrail;

class CreateClientAction
{
    public function execute(ClientDTO $dto): Client 
    {
        $item = Client::create($dto->toArray());
        AuditTrail::log($item, 'create', 'Clients');
        return $item;
    }
}
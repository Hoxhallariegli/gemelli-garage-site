<?php

namespace App\Domain\Client\Actions;

use App\Models\Client;
use App\Models\AuditTrail;

class DeleteClientAction
{
    public function execute(Client $model): bool 
    {
        AuditTrail::log($model, 'delete', 'Clients');
        return $model->delete(); 
    }
}
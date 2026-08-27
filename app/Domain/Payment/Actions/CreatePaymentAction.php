<?php

namespace App\Domain\Payment\Actions;

use App\Models\Payment;
use App\Domain\Payment\DTOs\PaymentDTO;
use App\Models\AuditTrail;

class CreatePaymentAction
{
    public function execute(PaymentDTO $dto): Payment 
    {
        $item = Payment::create($dto->toArray());
        AuditTrail::log($item, 'create', 'Payments');
        return $item;
    }
}
<?php

namespace App\Domain\Expense\Actions;

use App\Models\Expense;
use App\Domain\Expense\DTOs\ExpenseDTO;
use App\Models\AuditTrail;

class CreateExpenseAction
{
    public function execute(ExpenseDTO $dto): Expense
    {
        $item = Expense::create($dto->toArray());
        AuditTrail::log($item, 'create', 'Expenses');
        return $item;
    }
}

<?php

namespace App\Domain\Expense\Actions;

use App\Models\Expense;
use App\Domain\Expense\DTOs\ExpenseDTO;
use App\Models\AuditTrail;

class UpdateExpenseAction
{
    public function execute(Expense $model, ExpenseDTO $dto): Expense
    {
        $model->update($dto->toArray());
        AuditTrail::log($model, 'update', 'Expenses');
        return $model->fresh();
    }
}

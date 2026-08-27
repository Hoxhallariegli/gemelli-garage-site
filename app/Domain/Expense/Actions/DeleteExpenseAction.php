<?php

namespace App\Domain\Expense\Actions;

use App\Models\Expense;
use App\Models\AuditTrail;

class DeleteExpenseAction
{
    public function execute(Expense $model): bool
    {
        AuditTrail::log($model, 'delete', 'Expenses');
        return $model->delete();
    }
}

<?php

namespace App\Livewire\Admin\Expenses;

use App\Models\Expense;
use Livewire\Component;

class Row extends Component
{
    public Expense $item;

    public function render()
    {
        return view('livewire.admin.expenses.row');
    }
}

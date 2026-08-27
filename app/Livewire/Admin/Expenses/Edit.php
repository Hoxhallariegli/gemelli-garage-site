<?php

namespace App\Livewire\Admin\Expenses;

use App\Models\Expense;
use App\Models\Job;
use App\Domain\Expense\DTOs\ExpenseDTO;
use App\Domain\Expense\Actions\UpdateExpenseAction;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Edito Shpenzim')]
class Edit extends Component
{
    public Expense $item;
    public $title, $amount, $date, $category, $job_id, $notes;

    public function mount(Expense $expense)
    {
        $this->item = $expense;
        $this->title = $expense->title;
        $this->amount = $expense->amount;
        $this->date = $expense->date->format('Y-m-d');
        $this->category = $expense->category;
        $this->job_id = $expense->job_id;
        $this->notes = $expense->notes;
    }

    public function render()
    {
        return view('livewire.admin.expenses.edit', [
            'categories' => [
                'rent' => 'Qira',
                'electricity' => 'Energji',
                'water' => 'Ujë',
                'supplies' => 'Materiale',
                'salary' => 'Paga',
                'marketing' => 'Marketing',
                'other' => 'Të tjera',
            ],
            'jobs' => Job::with(['car.client'])->latest()->take(100)->get()->mapWithKeys(function($j) {
                $plate = $j->car?->license_plate ?? 'N/A';
                $client = $j->car?->client?->name ?? 'N/A';
                return [$j->id => "#00{$j->id} - {$plate} ({$client})"];
            })->toArray(),
        ])->layout('components.layouts.app');
    }

    public function update(UpdateExpenseAction $action)
    {
        $this->validate(Expense::rules($this->item->id));

        $dto = ExpenseDTO::fromArray([
            'title' => $this->title,
            'amount' => $this->amount,
            'date' => $this->date,
            'category' => $this->category,
            'job_id' => $this->job_id,
            'notes' => $this->notes,
        ]);

        $action->execute($this->item, $dto);

        session()->flash('success', 'Shpenzimi u përditësua me sukses.');
        return to_route('admin.expenses.index');
    }
}

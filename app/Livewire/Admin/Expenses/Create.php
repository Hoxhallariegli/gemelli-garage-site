<?php

namespace App\Livewire\Admin\Expenses;

use App\Models\Expense;
use App\Models\Job;
use App\Domain\Expense\DTOs\ExpenseDTO;
use App\Domain\Expense\Actions\CreateExpenseAction;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Shto Shpenzim')]
class Create extends Component
{
    public $title, $amount, $date, $category, $job_id, $notes;

    public function mount()
    {
        $this->date = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.admin.expenses.create', [
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

    public function store(CreateExpenseAction $action)
    {
        $this->validate(Expense::rules());

        $dto = ExpenseDTO::fromArray([
            'title' => $this->title,
            'amount' => $this->amount,
            'date' => $this->date,
            'category' => $this->category,
            'job_id' => $this->job_id,
            'notes' => $this->notes,
        ]);

        $action->execute($dto);

        session()->flash('success', 'Shpenzimi u regjistrua me sukses.');
        return to_route('admin.expenses.index');
    }
}

<?php

namespace App\Livewire\Admin\Expenses;

use App\Models\Expense;
use App\Models\Job;
use App\Domain\Expense\Queries\ExpenseListQuery;
use App\Domain\Expense\Actions\DeleteExpenseAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Title('Shpenzimet')]
class Expenses extends Component
{
    use WithPagination;

    public int $paginate = 15;
    #[Url(history: true)] public string $search = '';
    #[Url(history: true)] public $category = '';
    #[Url(history: true)] public $job_id = '';
    public bool $openFilter = false;
    public string $sortField = 'id';
    public bool $sortAsc = false;

    public function resetFilters()
    {
        $this->reset(['search', 'openFilter', 'category', 'job_id']);
        $this->resetPage();
    }

    public function render()
    {
        abort_if_cannot('view_expenses');
        $query = (new ExpenseListQuery())->handle([
            'search' => $this->search,
            'category' => $this->category,
            'job_id' => $this->job_id,
        ], $this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.admin.expenses.index', [
            'items' => $query->paginate($this->paginate),
            'sortableFields' => Expense::sortable(),
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

    public function sortBy($field)
    {
        if (!in_array($field, Expense::sortable(), true)) return;
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        }
        $this->sortField = $field;
    }

    public function deleteExpense($id, DeleteExpenseAction $action)
    {
        $item = Expense::find($id);
        if (!$item) {
            $this->dispatch('toast', message: 'Shpenzimi nuk u gjet', type: 'error');
            return;
        }

        try {
            $action->execute($item);
            $this->dispatch('toast', message: 'Shpenzimi u fshi me sukses', type: 'success');
            $this->resetPage();
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Gabim gjatë fshirjes', type: 'error');
        }
    }
}

<?php

namespace App\Livewire\Admin\Plans;

use App\Models\Plan;
use App\Domain\Plan\Queries\PlanListQuery;
use App\Domain\Plan\Actions\DeletePlanAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Title('Planet e Abonimit')]
class Plans extends Component
{
    use WithPagination;

    public int $paginate = 10;
    #[Url(history: true)] public string $search = '';
    public bool $openFilter = false;
    public string $sortField = 'id';
    public bool $sortAsc = true;

    public function resetFilters()
    {
        $this->reset(['search', 'openFilter']);
        $this->resetPage();
    }

    public function render()
    {
        abort_if_cannot('view_plans');
        $query = (new PlanListQuery())->handle(['search' => $this->search], $this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.admin.plans.index', [
            'items' => $query->paginate($this->paginate),
        ])->layout('components.layouts.app');
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortField = $field;
    }

    public function deletePlan($id, DeletePlanAction $action)
    {
        abort_if_cannot('delete_plans');
        $item = Plan::find($id);
        if (!$item) return;
        $action->execute($item);
        $this->dispatch('toast', message: 'Plani u fshi me sukses.', type: 'success');
        $this->resetPage();
    }
}

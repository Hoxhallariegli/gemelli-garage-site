<?php

namespace App\Livewire\Admin\Parts;

use App\Models\Part;
use App\Domain\Part\Queries\PartListQuery;
use App\Domain\Part\Actions\DeletePartAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('Parts')]
class Parts extends Component
{
        use WithPagination;

    public int $paginate = 10;
    #[Url(history: true)] public string $search = '';
    public bool $openFilter = false;
    public string $sortField = 'id';
    public bool $sortAsc = true;

    public function resetFilters() { $this->reset(['search', 'openFilter', ]); $this->resetPage(); }

    public function render()
    {
        abort_if_cannot('view_parts');
        $query = (new PartListQuery())->handle(['search' => $this->search, ], $this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.admin.parts.index', [
            'items' => $query->paginate($this->paginate),
            'sortableFields' => Part::sortable(),
        ])->layout('components.layouts.app');
    }

    public function sortBy($field) { if (!in_array($field, Part::sortable(), true)) return; if ($this->sortField === $field) { $this->sortAsc = ! $this->sortAsc; } $this->sortField = $field; }

    public function deletePart($id, DeletePartAction $action) 
    {
        abort_if_cannot('delete_parts');
        $item = Part::find($id);
        if (!$item) { $this->dispatch('toast', message: __('parts.not_found'), type: 'error'); return; }
        try { $action->execute($item); $this->dispatch('toast', message: __('parts.deleted'), type: 'success'); $this->resetPage(); } 
        catch (\Illuminate\Database\QueryException $e) { $this->dispatch('toast', message: __('parts.delete_error_referenced'), type: 'error'); }
        catch (\Exception $e) { $this->dispatch('toast', message: __('parts.delete_error'), type: 'error'); }
    }
}
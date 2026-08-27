<?php

namespace App\Livewire\Admin\Materials;

use App\Models\Material;
use App\Domain\Material\Queries\MaterialListQuery;
use App\Domain\Material\Actions\DeleteMaterialAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('Materials')]
class Materials extends Component
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
        abort_if_cannot('view_materials');
        $query = (new MaterialListQuery())->handle(['search' => $this->search, ], $this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.admin.materials.index', [
            'items' => $query->paginate($this->paginate),
            'sortableFields' => Material::sortable(),
        ])->layout('components.layouts.app');
    }

    public function sortBy($field) { if (!in_array($field, Material::sortable(), true)) return; if ($this->sortField === $field) { $this->sortAsc = ! $this->sortAsc; } $this->sortField = $field; }

    public function deleteMaterial($id, DeleteMaterialAction $action) 
    {
        abort_if_cannot('delete_materials');
        $item = Material::find($id);
        if (!$item) { $this->dispatch('toast', message: __('materials.not_found'), type: 'error'); return; }
        try { $action->execute($item); $this->dispatch('toast', message: __('materials.deleted'), type: 'success'); $this->resetPage(); } 
        catch (\Illuminate\Database\QueryException $e) { $this->dispatch('toast', message: __('materials.delete_error_referenced'), type: 'error'); }
        catch (\Exception $e) { $this->dispatch('toast', message: __('materials.delete_error'), type: 'error'); }
    }
}
<?php

namespace App\Livewire\Admin\MaterialBrands;

use App\Models\MaterialBrand;
use App\Domain\MaterialBrand\Queries\MaterialBrandListQuery;
use App\Domain\MaterialBrand\Actions\DeleteMaterialBrandAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

#[Title('MaterialBrands')]
class MaterialBrands extends Component
{
        use WithPagination, WithFileUploads;

    public int $paginate = 10;
    #[Url(history: true)] public string $search = '';
    public bool $openFilter = false;
    public string $sortField = 'id';
    public bool $sortAsc = true;

    public function resetFilters() { $this->reset(['search', 'openFilter', ]); $this->resetPage(); }

    public function render()
    {
        abort_if_cannot('view_material_brands');
        $query = (new MaterialBrandListQuery())->handle(['search' => $this->search, ], $this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.admin.material-brands.index', [
            'items' => $query->paginate($this->paginate),
            'sortableFields' => MaterialBrand::sortable(),
        ])->layout('components.layouts.app');
    }

    public function sortBy($field) { if (!in_array($field, MaterialBrand::sortable(), true)) return; if ($this->sortField === $field) { $this->sortAsc = ! $this->sortAsc; } $this->sortField = $field; }

    public function deleteMaterialBrand($id, DeleteMaterialBrandAction $action) 
    {
        abort_if_cannot('delete_material_brands');
        $item = MaterialBrand::find($id);
        if (!$item) { $this->dispatch('toast', message: __('material-brands.not_found'), type: 'error'); return; }
        try { $action->execute($item); $this->dispatch('toast', message: __('material-brands.deleted'), type: 'success'); $this->resetPage(); } 
        catch (\Illuminate\Database\QueryException $e) { $this->dispatch('toast', message: __('material-brands.delete_error_referenced'), type: 'error'); }
        catch (\Exception $e) { $this->dispatch('toast', message: __('material-brands.delete_error'), type: 'error'); }
    }
}
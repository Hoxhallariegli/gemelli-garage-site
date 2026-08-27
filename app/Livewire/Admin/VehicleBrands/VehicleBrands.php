<?php

namespace App\Livewire\Admin\VehicleBrands;

use App\Models\VehicleBrand;
use App\Domain\VehicleBrand\Queries\VehicleBrandListQuery;
use App\Domain\VehicleBrand\Actions\DeleteVehicleBrandAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('VehicleBrands')]
class VehicleBrands extends Component
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
        abort_if_cannot('view_vehicle_brands');
        $query = (new VehicleBrandListQuery())->handle(['search' => $this->search, ], $this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.admin.vehicle-brands.index', [
            'items' => $query->paginate($this->paginate),
            'sortableFields' => VehicleBrand::sortable(),
        ])->layout('components.layouts.app');
    }

    public function sortBy($field) { if (!in_array($field, VehicleBrand::sortable(), true)) return; if ($this->sortField === $field) { $this->sortAsc = ! $this->sortAsc; } $this->sortField = $field; }

    public function deleteVehicleBrand($id, DeleteVehicleBrandAction $action) 
    {
        abort_if_cannot('delete_vehicle_brands');
        $item = VehicleBrand::find($id);
        if (!$item) { $this->dispatch('toast', message: __('vehicle-brands.not_found'), type: 'error'); return; }
        try { $action->execute($item); $this->dispatch('toast', message: __('vehicle-brands.deleted'), type: 'success'); $this->resetPage(); } 
        catch (\Illuminate\Database\QueryException $e) { $this->dispatch('toast', message: __('vehicle-brands.delete_error_referenced'), type: 'error'); }
        catch (\Exception $e) { $this->dispatch('toast', message: __('vehicle-brands.delete_error'), type: 'error'); }
    }
}
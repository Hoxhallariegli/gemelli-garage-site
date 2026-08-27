<?php

namespace App\Livewire\Admin\VehicleModels;

use App\Models\VehicleModel;
use App\Domain\VehicleModel\Queries\VehicleModelListQuery;
use App\Domain\VehicleModel\Actions\DeleteVehicleModelAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('VehicleModels')]
class VehicleModels extends Component
{
        use WithPagination;

    public int $paginate = 10;
    #[Url(history: true)] public string $search = '';
    #[Url(history: true)] public $brand_id = '';
    public bool $openFilter = false;
    public string $sortField = 'id';
    public bool $sortAsc = true;

    public function resetFilters() { $this->reset(['search', 'openFilter', 'brand_id', ]); $this->resetPage(); }

    public function render()
    {
        abort_if_cannot('view_vehicle_models');
        $query = (new VehicleModelListQuery())->handle(['search' => $this->search,             'brand_id' => $this->brand_id,
], $this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.admin.vehicle-models.index', [
            'items' => $query->paginate($this->paginate),
            'sortableFields' => VehicleModel::sortable(),
            'brands' => \App\Models\VehicleBrand::pluck('name', 'id')->toArray(),
        ])->layout('components.layouts.app');
    }

    public function sortBy($field) { if (!in_array($field, VehicleModel::sortable(), true)) return; if ($this->sortField === $field) { $this->sortAsc = ! $this->sortAsc; } $this->sortField = $field; }

    public function deleteVehicleModel($id, DeleteVehicleModelAction $action) 
    {
        abort_if_cannot('delete_vehicle_models');
        $item = VehicleModel::find($id);
        if (!$item) { $this->dispatch('toast', message: __('vehicle-models.not_found'), type: 'error'); return; }
        try { $action->execute($item); $this->dispatch('toast', message: __('vehicle-models.deleted'), type: 'success'); $this->resetPage(); } 
        catch (\Illuminate\Database\QueryException $e) { $this->dispatch('toast', message: __('vehicle-models.delete_error_referenced'), type: 'error'); }
        catch (\Exception $e) { $this->dispatch('toast', message: __('vehicle-models.delete_error'), type: 'error'); }
    }
}
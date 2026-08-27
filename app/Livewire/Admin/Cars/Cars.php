<?php

namespace App\Livewire\Admin\Cars;

use App\Models\Car;
use App\Domain\Car\Queries\CarListQuery;
use App\Domain\Car\Actions\DeleteCarAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('Cars')]
class Cars extends Component
{
        use WithPagination;

    public int $paginate = 10;
    #[Url(history: true)] public string $search = '';
    #[Url(history: true)] public $client_id = '';
    #[Url(history: true)] public $brand_id = '';
    #[Url(history: true)] public $model_id = '';
    public bool $openFilter = false;
    public string $sortField = 'id';
    public bool $sortAsc = true;

    public function resetFilters() { $this->reset(['search', 'openFilter', 'client_id', 'brand_id', 'model_id', ]); $this->resetPage(); }

    public function render()
    {
        abort_if_cannot('view_cars');
        $query = (new CarListQuery())->handle(['search' => $this->search,             'client_id' => $this->client_id,
            'brand_id' => $this->brand_id,
            'model_id' => $this->model_id,
], $this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.admin.cars.index', [
            'items' => $query->paginate($this->paginate),
            'sortableFields' => Car::sortable(),
            'clients' => \App\Models\Client::pluck('name', 'id')->toArray(),
            'brands' => \App\Models\VehicleBrand::pluck('name', 'id')->toArray(),
            'models' => \App\Models\VehicleModel::pluck('name', 'id')->toArray(),
        ])->layout('components.layouts.app');
    }

    public function sortBy($field) { if (!in_array($field, Car::sortable(), true)) return; if ($this->sortField === $field) { $this->sortAsc = ! $this->sortAsc; } $this->sortField = $field; }

    public function deleteCar($id, DeleteCarAction $action) 
    {
        abort_if_cannot('delete_cars');
        $item = Car::find($id);
        if (!$item) { $this->dispatch('toast', message: __('cars.not_found'), type: 'error'); return; }
        try { $action->execute($item); $this->dispatch('toast', message: __('cars.deleted'), type: 'success'); $this->resetPage(); } 
        catch (\Illuminate\Database\QueryException $e) { $this->dispatch('toast', message: __('cars.delete_error_referenced'), type: 'error'); }
        catch (\Exception $e) { $this->dispatch('toast', message: __('cars.delete_error'), type: 'error'); }
    }
}
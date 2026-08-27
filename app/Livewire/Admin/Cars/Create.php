<?php

namespace App\Livewire\Admin\Cars;

use App\Models\Car;
use App\Models\Client;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Domain\Car\DTOs\CarDTO;
use App\Domain\Car\Actions\CreateCarAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;

#[Title('Add Car')]
class Create extends Component
{
    use WithPagination;

    public $client_id = '';
    public $brand_id = '';
    public $model_id = '';
    public $year = '';
    public $license_plate = '';
    public $color = '';

    #[On('client-created')]
    public function refreshClients($id) { $this->client_id = $id; }

    #[On('vehicle-brand-created')]
    public function refreshBrands($id) { $this->brand_id = $id; $this->model_id = ''; }

    #[On('vehicle-model-created')]
    public function refreshModels($id) { $this->model_id = $id; }

    public function updatedBrandId()
    {
        $this->model_id = '';
    }

    protected function getclientsList() {
        return Client::orderBy('name')->pluck('name', 'id')->toArray();
    }

    protected function getbrandsList() {
        return VehicleBrand::orderBy('name')->pluck('name', 'id')->toArray();
    }

    protected function getmodelsList() {
        if (!$this->brand_id) return [];
        return VehicleModel::where('brand_id', $this->brand_id)->orderBy('name')->pluck('name', 'id')->toArray();
    }

    public function render()
    {
        abort_if_cannot('add_cars');
        return view('livewire.admin.cars.create', [
            'clients' => $this->getclientsList(),
            'brands' => $this->getbrandsList(),
            'models' => $this->getmodelsList(),
        ])->layout('components.layouts.app');
    }

    public function store(CreateCarAction $action)
    {
        $this->validate();
        $dto = CarDTO::fromArray([
            'client_id' => $this->client_id,
            'brand_id' => $this->brand_id,
            'model_id' => $this->model_id,
            'year' => $this->year,
            'license_plate' => $this->license_plate,
            'color' => $this->color,
        ]);
        $action->execute($dto);
        session()->flash('success', __('cars.created'));
        return to_route('admin.cars.index');
    }

    protected function rules(): array { return Car::rules(); }
}

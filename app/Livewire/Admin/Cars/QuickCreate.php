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
use Livewire\Attributes\On;

class QuickCreate extends Component
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

    public bool $created = false;
    public ?int $createdId = null;
    public string $createdLabel = '';

    public function render()
    {
        return view('livewire.admin.cars.quick-create', [
            'clients' => $this->getclientsList(),
            'brands' => $this->getbrandsList(),
            'models' => $this->getmodelsList(),
        ]);
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
        $item = $action->execute($dto);
        $this->dispatch('car-created', id: $item->id);
        $this->dispatch('toast', message: __('cars.created'), type: 'success');
        $this->created = true;
        $this->createdId = $item->id;
        $this->createdLabel = (string) ($item->license_plate ?? $item->id);
        $this->reset(['client_id', 'brand_id', 'model_id', 'year', 'license_plate', 'color']);
    }

    public function addAnother()
    {
        $this->created = false;
        $this->createdId = null;
        $this->createdLabel = '';
    }

    protected function rules(): array { return Car::rules(); }
}

<?php

namespace App\Livewire\Admin\VehicleModels;

use App\Models\VehicleModel;
use App\Models\BodyType;
use App\Models\VehicleBrand;
use App\Domain\VehicleModel\DTOs\VehicleModelDTO;
use App\Domain\VehicleModel\Actions\CreateVehicleModelAction;
use Livewire\Component;
use Livewire\Attributes\On;

class QuickCreate extends Component
{
    public $brand_id = '';
    public $body_type_id = '';
    public $name = '';
    public $wrap_meters_needed = '';

    public bool $created = false;
    public ?int $createdId = null;
    public string $createdLabel = '';

    #[On('vehicle-brand-created')]
    public function refreshBrands($id) { $this->brand_id = $id; }

    #[On('body-type-created')]
    public function refreshBodyTypes($id) { $this->body_type_id = $id; }

    public function updatedBodyTypeId($value)
    {
        if (!$value) return;
        $related = BodyType::find($value);
        if ($related) {
            $this->wrap_meters_needed = $related->wrap_meters;
        }
    }

    protected function getbrandsList() {
        return VehicleBrand::pluck('name', 'id')->toArray();
    }

    protected function getBodyTypesList() {
        return BodyType::pluck('name', 'id')->toArray();
    }

    public function render()
    {
        return view('livewire.admin.vehicle-models.quick-create', [
            'brands' => $this->getbrandsList(),
            'bodyTypes' => $this->getBodyTypesList(),
        ]);
    }

    public function store(CreateVehicleModelAction $action)
    {
        $this->validate();
        $dto = VehicleModelDTO::fromArray([
            'brand_id' => $this->brand_id,
            'body_type_id' => $this->body_type_id,
            'name' => $this->name,
            'wrap_meters_needed' => $this->wrap_meters_needed,
        ]);
        $item = $action->execute($dto);
        $this->dispatch('vehicle-model-created', id: $item->id);
        $this->js("Livewire.dispatch('vehicle-model-created', { id: {$item->id} })");
        $this->dispatch('toast', message: __('vehicle-models.created'), type: 'success');
        $this->created = true;
        $this->createdId = $item->id;
        $this->createdLabel = (string) ($item->name ?? $item->id);
        $this->reset(['brand_id', 'body_type_id', 'name', 'wrap_meters_needed']);
    }

    public function addAnother()
    {
        $this->created = false;
        $this->createdId = null;
        $this->createdLabel = '';
    }

    protected function rules(): array { return VehicleModel::rules(); }
}

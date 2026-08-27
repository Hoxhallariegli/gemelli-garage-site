<?php

namespace App\Livewire\Admin\VehicleModels;

use App\Models\VehicleModel;
use App\Domain\VehicleModel\DTOs\VehicleModelDTO;
use App\Domain\VehicleModel\Actions\CreateVehicleModelAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('Add VehicleModel')]
class Create extends Component
{
    use WithPagination;
    public $brand_id = '';
    public $body_type_id = '';
    public $name = '';
    public $wrap_meters_needed = '';

    #[On('vehicle-brand-created')]
    public function refreshBrands($id) { $this->brand_id = $id; $this->updatedBrandId($id); }

    public function updatedBrandId($value)
    {
        if (!$value) return;
        $related = \App\Models\VehicleBrand::find($value);
        if (!$related) return;
    }

    public function updatedBodyType($value)
    {
        if (isset(VehicleModel::BODY_TYPES[$value])) {
            $this->wrap_meters_needed = VehicleModel::BODY_TYPES[$value];
        }
    }

    public function updatedBodyTypeId($value)
    {
        if (!$value) return;
        $related = \App\Models\BodyType::find($value);
        if ($related) {
            $this->wrap_meters_needed = $related->wrap_meters;
        }
    }

    protected function getbrandsList() {
        return \App\Models\VehicleBrand::pluck('name', 'id')->toArray();
    }

    protected function getBodyTypesList() {
        return \App\Models\BodyType::pluck('name', 'id')->toArray();
    }

    public function render() { abort_if_cannot('add_vehicle_models'); return view('livewire.admin.vehicle-models.create', [
            'brands' => $this->getbrandsList(),
            'bodyTypes' => $this->getBodyTypesList(),
        ])->layout('components.layouts.app'); }

    public function store(CreateVehicleModelAction $action)
    {
        $this->validate();

        $dto = VehicleModelDTO::fromArray([
            'brand_id' => $this->brand_id,
            'body_type_id' => $this->body_type_id,
            'name' => $this->name,
            'wrap_meters_needed' => $this->wrap_meters_needed,
        ]);
        $action->execute($dto);
        session()->flash('success', __('vehicle-models.created'));
        return to_route('admin.vehicle-models.index');
    }
    protected function rules(): array { return VehicleModel::rules(); }
}

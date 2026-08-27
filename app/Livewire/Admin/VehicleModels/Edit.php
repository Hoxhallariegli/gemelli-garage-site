<?php

namespace App\Livewire\Admin\VehicleModels;

use App\Models\VehicleModel;
use App\Domain\VehicleModel\DTOs\VehicleModelDTO;
use App\Domain\VehicleModel\Actions\UpdateVehicleModelAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('Edit VehicleModel')]
class Edit extends Component
{
    use WithPagination;
 public VehicleModel $item;
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

    public function mount(VehicleModel $vehicleModel) { $this->item = $vehicleModel; $this->fill($vehicleModel->toArray());  }
    public function render() { abort_if_cannot('edit_vehicle_models'); return view('livewire.admin.vehicle-models.edit', [
            'brands' => $this->getbrandsList(),
            'bodyTypes' => $this->getBodyTypesList(),
        ])->layout('components.layouts.app'); }

    public function update(UpdateVehicleModelAction $action)
    {
        $this->validate();

        $dto = VehicleModelDTO::fromArray([
            'brand_id' => $this->brand_id,
            'body_type_id' => $this->body_type_id,
            'name' => $this->name,
            'wrap_meters_needed' => $this->wrap_meters_needed,
        ]);
        $action->execute($this->item, $dto);
        session()->flash('success', __('vehicle-models.updated'));
        return to_route('admin.vehicle-models.index');
    }
    protected function rules(): array { return VehicleModel::rules($this->item->id); }
}

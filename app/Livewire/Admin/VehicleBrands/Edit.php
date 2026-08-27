<?php

namespace App\Livewire\Admin\VehicleBrands;

use App\Models\VehicleBrand;
use App\Domain\VehicleBrand\DTOs\VehicleBrandDTO;
use App\Domain\VehicleBrand\Actions\UpdateVehicleBrandAction;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Edit VehicleBrand')]
class Edit extends Component
{
    use WithFileUploads;

    public VehicleBrand $item;
    public $name = '';
    public $logo;

    public function mount(VehicleBrand $vehicleBrand)
    {
        $this->item = $vehicleBrand;
        $this->name = $vehicleBrand->name;
        // We don't fill $this->logo with the string path to avoid validation issues if not changed
    }

    public function render()
    {
        abort_if_cannot('edit_vehicle_brands');
        return view('livewire.admin.vehicle-brands.edit')->layout('components.layouts.app');
    }

    public function update(UpdateVehicleBrandAction $action, \App\Services\ImageUploadService $uploadService)
    {
        $this->validate();

        $logoPath = $this->item->logo;
        if ($this->logo && !is_string($this->logo)) {
            $uploadService->delete($logoPath);
            $logoPath = $uploadService->upload($this->logo, 'brands');
        }

        $dto = VehicleBrandDTO::fromArray([
            'name' => $this->name,
            'logo' => $logoPath,
        ]);

        $action->execute($this->item, $dto);
        session()->flash('success', __('vehicle-brands.updated'));
        return to_route('admin.vehicle-brands.index');
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:15360'],
        ];
    }
}

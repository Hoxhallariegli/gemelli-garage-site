<?php

namespace App\Livewire\Admin\VehicleBrands;

use App\Models\VehicleBrand;
use App\Domain\VehicleBrand\DTOs\VehicleBrandDTO;
use App\Domain\VehicleBrand\Actions\CreateVehicleBrandAction;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Add VehicleBrand')]
class Create extends Component
{
    use WithFileUploads;

    public $name = '';
    public $logo;

    public function render()
    {
        abort_if_cannot('add_vehicle_brands');
        return view('livewire.admin.vehicle-brands.create')->layout('components.layouts.app');
    }

    public function store(CreateVehicleBrandAction $action, \App\Services\ImageUploadService $uploadService)
    {
        $this->validate();

        $logoPath = $uploadService->upload($this->logo, 'brands');

        $dto = VehicleBrandDTO::fromArray([
            'name' => $this->name,
            'logo' => $logoPath,
        ]);

        $action->execute($dto);
        session()->flash('success', __('vehicle-brands.created'));
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

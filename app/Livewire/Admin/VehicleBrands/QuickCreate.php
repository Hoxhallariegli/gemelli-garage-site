<?php

namespace App\Livewire\Admin\VehicleBrands;

use App\Models\VehicleBrand;
use App\Domain\VehicleBrand\DTOs\VehicleBrandDTO;
use App\Domain\VehicleBrand\Actions\CreateVehicleBrandAction;
use Livewire\Component;
use Livewire\WithFileUploads;

class QuickCreate extends Component
{
    use WithFileUploads;

    public $name = '';
    public $logo;

    public bool $created = false;
    public ?int $createdId = null;
    public string $createdLabel = '';

    public function render()
    {
        return view('livewire.admin.vehicle-brands.quick-create');
    }

    public function store(CreateVehicleBrandAction $action, \App\Services\ImageUploadService $uploadService)
    {
        $this->validate();

        $logoPath = $uploadService->upload($this->logo, 'brands');

        $dto = VehicleBrandDTO::fromArray([
            'name' => $this->name,
            'logo' => $logoPath,
        ]);

        $item = $action->execute($dto);
        $this->dispatch('vehicle-brand-created', id: $item->id);
        $this->dispatch('toast', message: __('vehicle-brands.created'), type: 'success');

        $this->created = true;
        $this->createdId = $item->id;
        $this->createdLabel = (string) ($item->name ?? $item->id);
        $this->reset(['name', 'logo']);
    }

    public function addAnother()
    {
        $this->created = false;
        $this->createdId = null;
        $this->createdLabel = '';
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ];
    }
}

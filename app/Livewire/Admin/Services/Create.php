<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use App\Domain\Service\DTOs\ServiceDTO;
use App\Domain\Service\Actions\CreateServiceAction;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Add Service')]
class Create extends Component
{
    use WithFileUploads;

    public $name = '';
    public $description = '';
    public $base_price = '';
    public $active = true;
    public $image;

    public function render() { abort_if_cannot('add_services'); return view('livewire.admin.services.create', [
        ])->layout('components.layouts.app'); }

    public function store(CreateServiceAction $action, \App\Services\ImageUploadService $uploadService)
    {
        $this->validate();

        $imgPath = $uploadService->upload($this->image, 'services');

        $dto = ServiceDTO::fromArray([
            'name' => $this->name,
            'description' => $this->description,
            'base_price' => $this->base_price,
            'active' => $this->active,
            'image' => $imgPath,
        ]);
        $action->execute($dto);
        session()->flash('success', __('services.created'));
        return to_route('admin.services.index');
    }
    protected function rules(): array { return array_merge(Service::rules(), ['image' => 'nullable|image|max:15360']); }
}

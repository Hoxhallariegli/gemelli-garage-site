<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use App\Domain\Service\DTOs\ServiceDTO;
use App\Domain\Service\Actions\UpdateServiceAction;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Edit Service')]
class Edit extends Component
{
    use WithFileUploads;

    public Service $item;
    public $name = '';
    public $description = '';
    public $base_price = '';
    public $active = '';
    public $image;

    public function mount(Service $service) { $this->item = $service; $this->fill($service->toArray()); $this->image = null; }
    public function render() { abort_if_cannot('edit_services'); return view('livewire.admin.services.edit', [
        ])->layout('components.layouts.app'); }

    public function update(UpdateServiceAction $action, \App\Services\ImageUploadService $uploadService)
    {
        $this->validate();

        $imgPath = $this->item->image;
        if ($this->image && !is_string($this->image)) {
            $uploadService->delete($imgPath);
            $imgPath = $uploadService->upload($this->image, 'services');
        }

        $dto = ServiceDTO::fromArray([
            'name' => $this->name,
            'description' => $this->description,
            'base_price' => $this->base_price,
            'active' => $this->active,
            'image' => $imgPath,
        ]);
        $action->execute($this->item, $dto);
        session()->flash('success', __('services.updated'));
        return to_route('admin.services.index');
    }
    protected function rules(): array
    {
        $rules = Service::rules($this->item->id);

        if ($this->image && !is_string($this->image)) {
            $rules['image'] = ['nullable', 'image', 'max:15360'];
        } else {
            $rules['image'] = ['nullable', 'string'];
        }

        return $rules;
    }
}

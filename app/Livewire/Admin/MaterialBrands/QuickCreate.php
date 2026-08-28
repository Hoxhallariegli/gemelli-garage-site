<?php

namespace App\Livewire\Admin\MaterialBrands;

use App\Models\MaterialBrand;
use App\Domain\MaterialBrand\DTOs\MaterialBrandDTO;
use App\Domain\MaterialBrand\Actions\CreateMaterialBrandAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class QuickCreate extends Component
{
        use WithPagination, WithFileUploads;
     public $name = '';
    public $image = '';

    public bool $created = false;
    public ?int $createdId = null;
    public string $createdLabel = '';

    public function render() { return view('livewire.admin.material-brands.quick-create', [
        ]); }

    public function store(CreateMaterialBrandAction $action, \App\Services\ImageUploadService $uploadService)
    {
        $this->validate();

        $imgPath = $uploadService->upload($this->image, 'material-brands');

        $dto = MaterialBrandDTO::fromArray([
            'name' => $this->name,
            'image' => $imgPath,
        ]);
        $item = $action->execute($dto);
        $this->dispatch('material-brand-created', id: $item->id);
        $this->js("Livewire.dispatch('material-brand-created', { id: {$item->id} })");
        $this->dispatch('toast', message: __('material-brands.created'), type: 'success');
        $this->created = true;
        $this->createdId = $item->id;
        $this->createdLabel = (string) ($item->name ?? $item->id);
        $this->reset(['name', 'image']);
    }

    public function addAnother()
    {
        $this->created = false;
        $this->createdId = null;
        $this->createdLabel = '';
    }

    protected function rules(): array
    {
        $rules = MaterialBrand::rules();
        $rules['image'] = ['nullable', 'image', 'max:15360'];
        return $rules;
    }
}

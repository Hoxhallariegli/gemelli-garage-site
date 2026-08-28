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

#[Title('Add MaterialBrand')]
class Create extends Component
{
        use WithPagination, WithFileUploads;
     public $name = '';
    public $image = '';

    public function render() { abort_if_cannot('add_material_brands'); return view('livewire.admin.material-brands.create', [
        ])->layout('components.layouts.app'); }

    public function store(CreateMaterialBrandAction $action, \App\Services\ImageUploadService $uploadService)
    {
        $this->validate();

        $imgPath = $uploadService->upload($this->image, 'material-brands');

        $dto = MaterialBrandDTO::fromArray([
            'name' => $this->name,
            'image' => $imgPath,
        ]);
        $action->execute($dto);
        session()->flash('success', __('material-brands.created'));
        return to_route('admin.material-brands.index');
    }

    protected function rules(): array
    {
        $rules = MaterialBrand::rules();
        $rules['image'] = ['nullable', 'image', 'max:15360'];
        return $rules;
    }
}

<?php

namespace App\Livewire\Admin\MaterialBrands;

use App\Models\MaterialBrand;
use App\Domain\MaterialBrand\DTOs\MaterialBrandDTO;
use App\Domain\MaterialBrand\Actions\UpdateMaterialBrandAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

#[Title('Edit MaterialBrand')]
class Edit extends Component
{
        use WithPagination, WithFileUploads;
 public MaterialBrand $item;
    public $name = '';
    public $image = '';

    public function mount(MaterialBrand $materialBrand) { $this->item = $materialBrand; $this->fill($materialBrand->toArray()); $this->image = null; }
    public function render() { abort_if_cannot('edit_material_brands'); return view('livewire.admin.material-brands.edit', [
        ])->layout('components.layouts.app'); }

    public function update(UpdateMaterialBrandAction $action, \App\Services\ImageUploadService $uploadService)
    {
        $this->validate();

        $imgPath = $this->item->image;
        if ($this->image && !is_string($this->image)) {
            $uploadService->delete($imgPath);
            $imgPath = $uploadService->upload($this->image, 'material-brands');
        }

        $dto = MaterialBrandDTO::fromArray([
            'name' => $this->name,
            'image' => $imgPath,
        ]);
        $action->execute($this->item, $dto);
        session()->flash('success', __('material-brands.updated'));
        return to_route('admin.material-brands.index');
    }

    protected function rules(): array
    {
        $rules = MaterialBrand::rules($this->item->id);

        if ($this->image && !is_string($this->image)) {
            $rules['image'] = ['nullable', 'image', 'max:15360'];
        } else {
            $rules['image'] = ['nullable', 'string'];
        }

        return $rules;
    }
}

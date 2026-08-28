<?php

namespace App\Livewire\Admin\Materials;

use App\Models\Material;
use App\Domain\Material\DTOs\MaterialDTO;
use App\Domain\Material\Actions\UpdateMaterialAction;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Edit Material')]
class Edit extends Component
{
    use WithFileUploads;

    public Material $item;
    public $name = '';
    public $brand = '';
    public $purchase_price = '';
    public $sell_price = '';
    public $stock_meters = '';
    public $image;

    public function mount(Material $material) { $this->item = $material; $this->fill($material->toArray()); $this->image = null; }
    public function render() { abort_if_cannot('edit_materials'); return view('livewire.admin.materials.edit', [
        ])->layout('components.layouts.app'); }

    public function update(UpdateMaterialAction $action, \App\Services\ImageUploadService $uploadService)
    {
        $this->validate();

        $imgPath = $this->item->image;
        if ($this->image && !is_string($this->image)) {
            $uploadService->delete($imgPath);
            $imgPath = $uploadService->upload($this->image, 'materials');
        }

        $dto = MaterialDTO::fromArray([
            'name' => $this->name,
            'brand' => $this->brand,
            'purchase_price' => $this->purchase_price,
            'sell_price' => $this->sell_price,
            'stock_meters' => $this->stock_meters,
            'image' => $imgPath,
        ]);
        $action->execute($this->item, $dto);
        session()->flash('success', __('materials.updated'));
        return to_route('admin.materials.index');
    }

    protected function rules(): array
    {
        $rules = Material::rules($this->item->id);

        // Nëse kemi një upload të ri, e validojmë si imazh.
        // Përndryshe e lëmë si string (path-i ekzistues).
        if ($this->image && !is_string($this->image)) {
            $rules['image'] = ['nullable', 'image', 'max:15360'];
        } else {
            $rules['image'] = ['nullable', 'string'];
        }

        return $rules;
    }
}

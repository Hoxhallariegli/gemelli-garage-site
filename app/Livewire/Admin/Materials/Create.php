<?php

namespace App\Livewire\Admin\Materials;

use App\Models\Material;
use App\Domain\Material\DTOs\MaterialDTO;
use App\Domain\Material\Actions\CreateMaterialAction;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Add Material')]
class Create extends Component
{
    use WithFileUploads;

    public $name = '';
    public $brand = '';
    public $purchase_price = 0;
    public $sell_price = '';
    public $stock_meters = 0;
    public $image;

    public function render() { abort_if_cannot('add_materials'); return view('livewire.admin.materials.create', [
        ])->layout('components.layouts.app'); }

    public function store(CreateMaterialAction $action, \App\Services\ImageUploadService $uploadService)
    {
        $this->validate();

        $imgPath = $uploadService->upload($this->image, 'materials');

        $dto = MaterialDTO::fromArray([
            'name' => $this->name,
            'brand' => $this->brand,
            'purchase_price' => $this->purchase_price,
            'sell_price' => $this->sell_price,
            'stock_meters' => $this->stock_meters,
            'image' => $imgPath,
        ]);
        $action->execute($dto);
        session()->flash('success', __('materials.created'));
        return to_route('admin.materials.index');
    }

    protected function rules(): array
    {
        $rules = Material::rules();
        $rules['image'] = ['nullable', 'image', 'max:15360'];
        return $rules;
    }
}

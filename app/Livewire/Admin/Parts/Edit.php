<?php

namespace App\Livewire\Admin\Parts;

use App\Models\Part;
use App\Domain\Part\DTOs\PartDTO;
use App\Domain\Part\Actions\UpdatePartAction;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Edit Part')]
class Edit extends Component
{
    use WithFileUploads;

    public Part $item;
    public $name = '';
    public $purchase_price = '';
    public $sell_price = '';
    public $stock_quantity = '';
    public $image;

    public function mount(Part $part) { $this->item = $part; $this->fill($part->toArray()); $this->image = null; }
    public function render() { abort_if_cannot('edit_parts'); return view('livewire.admin.parts.edit', [
        ])->layout('components.layouts.app'); }

    public function update(UpdatePartAction $action, \App\Services\ImageUploadService $uploadService)
    {
        $this->validate();

        $imgPath = $this->item->image;
        if ($this->image && !is_string($this->image)) {
            $uploadService->delete($imgPath);
            $imgPath = $uploadService->upload($this->image, 'parts');
        }

        $dto = PartDTO::fromArray([
            'name' => $this->name,
            'purchase_price' => $this->purchase_price,
            'sell_price' => $this->sell_price,
            'stock_quantity' => $this->stock_quantity,
            'image' => $imgPath,
        ]);
        $action->execute($this->item, $dto);
        session()->flash('success', __('parts.updated'));
        return to_route('admin.parts.index');
    }
    protected function rules(): array
    {
        $rules = Part::rules($this->item->id);

        if ($this->image && !is_string($this->image)) {
            $rules['image'] = ['nullable', 'image', 'max:15360'];
        } else {
            $rules['image'] = ['nullable', 'string'];
        }

        return $rules;
    }
}

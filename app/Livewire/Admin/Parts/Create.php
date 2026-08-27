<?php

namespace App\Livewire\Admin\Parts;

use App\Models\Part;
use App\Domain\Part\DTOs\PartDTO;
use App\Domain\Part\Actions\CreatePartAction;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Add Part')]
class Create extends Component
{
    use WithFileUploads;

    public $name = '';
    public $purchase_price = 0;
    public $sell_price = '';
    public $stock_quantity = 0;
    public $image;

    public function render() { abort_if_cannot('add_parts'); return view('livewire.admin.parts.create', [
        ])->layout('components.layouts.app'); }

    public function store(CreatePartAction $action)
    {
        $this->validate();

        $imgPath = null;
        if ($this->image) {
            $imgPath = $this->image->store('parts', 'public');
        }

        $dto = PartDTO::fromArray([
            'name' => $this->name,
            'purchase_price' => $this->purchase_price,
            'sell_price' => $this->sell_price,
            'stock_quantity' => $this->stock_quantity,
            'image' => $imgPath,
        ]);
        $action->execute($dto);
        session()->flash('success', __('parts.created'));
        return to_route('admin.parts.index');
    }
    protected function rules(): array { return array_merge(Part::rules(), ['image' => 'nullable|image|max:1024']); }
}

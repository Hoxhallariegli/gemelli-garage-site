<?php

namespace App\Livewire\Admin\Parts;

use App\Models\Part;
use App\Domain\Part\DTOs\PartDTO;
use App\Domain\Part\Actions\CreatePartAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

class QuickCreate extends Component
{
        use WithPagination;
     public $name = '';
    public $purchase_price = 0;
    public $sell_price = '';
    public $stock_quantity = 0;

    public bool $created = false;
    public ?int $createdId = null;
    public string $createdLabel = '';

    public function render() { return view('livewire.admin.parts.quick-create', [
        ]); }

    public function store(CreatePartAction $action)
    {
        $this->validate();
        $dto = PartDTO::fromArray([
            'name' => $this->name,
            'purchase_price' => $this->purchase_price,
            'sell_price' => $this->sell_price,
            'stock_quantity' => $this->stock_quantity,
        ]);
        $item = $action->execute($dto);
        $this->dispatch('part-created', id: $item->id);
        $this->js("Livewire.dispatch('part-created', { id: {$item->id} })");
        $this->dispatch('toast', message: __('parts.created'), type: 'success');
        $this->created = true;
        $this->createdId = $item->id;
        $this->createdLabel = (string) ($item->name ?? $item->id);
        $this->reset(['name', 'purchase_price', 'sell_price', 'stock_quantity']);
    }

    public function addAnother()
    {
        $this->created = false;
        $this->createdId = null;
        $this->createdLabel = '';
    }

    protected function rules(): array { return Part::rules(); }
}

<?php

namespace App\Livewire\Admin\Materials;

use App\Models\Material;
use App\Domain\Material\DTOs\MaterialDTO;
use App\Domain\Material\Actions\CreateMaterialAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

class QuickCreate extends Component
{
        use WithPagination;
     public $name = '';
    public $brand = '';
    public $purchase_price = 0;
    public $sell_price = '';
    public $stock_meters = 0;

    public bool $created = false;
    public ?int $createdId = null;
    public string $createdLabel = '';

    public function render() { return view('livewire.admin.materials.quick-create', [
        ]); }

    public function store(CreateMaterialAction $action)
    {
        $this->validate();
        $dto = MaterialDTO::fromArray([
            'name' => $this->name,
            'brand' => $this->brand,
            'purchase_price' => $this->purchase_price,
            'sell_price' => $this->sell_price,
            'stock_meters' => $this->stock_meters,
        ]);
        $item = $action->execute($dto);
        $this->dispatch('material-created', id: $item->id);
        $this->js("Livewire.dispatch('material-created', { id: {$item->id} })");
        $this->dispatch('toast', message: __('materials.created'), type: 'success');
        $this->created = true;
        $this->createdId = $item->id;
        $this->createdLabel = (string) ($item->name ?? $item->id);
        $this->reset(['name', 'brand', 'purchase_price', 'sell_price', 'stock_meters']);
    }

    public function addAnother()
    {
        $this->created = false;
        $this->createdId = null;
        $this->createdLabel = '';
    }

    protected function rules(): array { return Material::rules(); }
}

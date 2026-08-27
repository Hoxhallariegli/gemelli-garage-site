<?php

namespace App\Livewire\Admin\Purchases;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Material;
use App\Models\Part;
use App\Domain\Purchase\DTOs\PurchaseDTO;
use App\Domain\Purchase\Actions\UpdatePurchaseAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;

#[Title('Edit Purchase')]
class Edit extends Component
{
    use WithPagination;
    public Purchase $item;
    public $supplier_id = '';
    public $purchase_date = '';
    public $reference_number = '';
    public $status = '';
    public $total_amount = 0;

    public $items = [];
    public $temp_item_type = 'Material';
    public $temp_item_id, $temp_quantity, $temp_unit_cost;

    public function updatedTempItemType()
    {
        $this->temp_item_id = null;
    }

    public function mount(Purchase $purchase)
    {
        $purchase->loadMissing('items.itemable');
        $this->item = $purchase;

        $this->supplier_id = $purchase->supplier_id;
        $this->purchase_date = $purchase->purchase_date?->format('Y-m-d');
        $this->reference_number = $purchase->reference_number;
        $this->status = $purchase->status;
        $this->total_amount = (float)$purchase->total_amount;

        $this->items = [];
        foreach ($purchase->items as $pi) {
            $this->items[] = [
                'type' => $pi->itemable_type === Material::class ? 'Material' : 'Part',
                'id' => $pi->itemable_id,
                'name' => $pi->itemable->name ?? 'N/A',
                'quantity' => (float)$pi->quantity,
                'unit_cost' => (float)$pi->unit_cost,
            ];
        }
    }

    #[On('supplier-created')]
    public function refreshSuppliers($id) { $this->supplier_id = $id; }

    #[On('material-created')]
    public function refreshMaterials($id)
    {
        if ($this->temp_item_type === 'Material') {
            $this->temp_item_id = $id;
        }
    }

    #[On('part-created')]
    public function refreshParts($id)
    {
        if ($this->temp_item_type === 'Part') {
            $this->temp_item_id = $id;
        }
    }

    public function addItem()
    {
        if ($this->item->status === 'received') return;

        $this->validate([
            'temp_item_id' => 'required',
            'temp_quantity' => 'required|numeric|min:0.01',
            'temp_unit_cost' => 'required|numeric|min:0',
        ]);

        $model = $this->temp_item_type === 'Material' ? Material::class : Part::class;
        $product = $model::find($this->temp_item_id);

        if (!$product) return;

        $this->items[] = [
            'type' => $this->temp_item_type,
            'id' => $this->temp_item_id,
            'name' => $product->name,
            'quantity' => (float)$this->temp_quantity,
            'unit_cost' => (float)$this->temp_unit_cost,
        ];

        $this->calculateTotal();
        $this->reset(['temp_item_id', 'temp_quantity', 'temp_unit_cost']);
    }

    public function removeItem($index)
    {
        if ($this->item->status === 'received') return;
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotal();
    }

    protected function calculateTotal()
    {
        $this->total_amount = collect($this->items)->sum(fn($i) => (float)$i['quantity'] * (float)$i['unit_cost']);
    }

    public function render()
    {
        abort_if_cannot('edit_purchases');
        return view('livewire.admin.purchases.edit', [
            'suppliers' => Supplier::orderBy('name')->pluck('name', 'id')->toArray(),
            'availableItems' => $this->temp_item_type === 'Material'
                ? Material::orderBy('name')->pluck('name', 'id')->toArray()
                : Part::orderBy('name')->pluck('name', 'id')->toArray(),
        ])->layout('components.layouts.app');
    }

    public function update(UpdatePurchaseAction $action)
    {
        $this->validate();
        if (empty($this->items)) {
            $this->dispatch('toast', message: __('purchases.add_at_least_one_item'), type: 'error');
            return;
        }

        $dto = PurchaseDTO::fromArray([
            'supplier_id' => $this->supplier_id,
            'purchase_date' => $this->purchase_date,
            'reference_number' => $this->reference_number,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'items' => $this->items,
        ]);
        $action->execute($this->item, $dto);
        session()->flash('success', __('purchases.updated'));
        return to_route('admin.purchases.index');
    }

    protected function rules(): array { return Purchase::rules($this->item->id); }

    protected function validationAttributes(): array
    {
        return [
            'supplier_id' => __('purchases.Supplier'),
            'purchase_date' => __('purchases.Purchase Date'),
            'reference_number' => __('purchases.Reference Number'),
            'temp_item_id' => __('purchases.Select Item'),
            'temp_quantity' => __('purchases.Quantity'),
            'temp_unit_cost' => __('purchases.Unit Cost'),
        ];
    }
}

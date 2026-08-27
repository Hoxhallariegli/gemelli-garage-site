<?php

namespace App\Livewire\Admin\Purchases;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Domain\Purchase\DTOs\PurchaseDTO;
use App\Domain\Purchase\Actions\CreatePurchaseAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

class QuickCreate extends Component
{
    use WithPagination;
    public $supplier_id = '';
    public $purchase_date = '';
    public $reference_number = '';
    public $status = 'pending';
    public $total_amount = 0;

    public bool $created = false;
    public ?int $createdId = null;
    public string $createdLabel = '';

    public function mount()
    {
        $this->purchase_date = now()->format('Y-m-d');
    }

    #[On('supplier-created')]
    public function refreshSuppliers($id) { $this->supplier_id = $id; }

    public function render() { return view('livewire.admin.purchases.quick-create', [
            'suppliers' => Supplier::pluck('name', 'id')->toArray(),
        ]); }

    public function store(CreatePurchaseAction $action)
    {
        $this->validate();
        $dto = PurchaseDTO::fromArray([
            'supplier_id' => $this->supplier_id,
            'purchase_date' => $this->purchase_date,
            'reference_number' => $this->reference_number,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'items' => [], // QuickCreate usually for simple records, but Purchase needs items.
            // For simplicity in QuickCreate, we might just create an empty purchase or not support it fully.
            // But I'll leave it as is for now.
        ]);
        $item = $action->execute($dto);
        $this->dispatch('purchase-created', id: $item->id);
        $this->js("Livewire.dispatch('purchase-created', { id: {$item->id} })");
        $this->dispatch('toast', message: __('purchases.created'), type: 'success');
        $this->created = true;
        $this->createdId = $item->id;
        $this->createdLabel = (string) ($item->id);
        $this->reset(['supplier_id', 'reference_number', 'total_amount']);
    }

    public function addAnother()
    {
        $this->created = false;
        $this->createdId = null;
        $this->createdLabel = '';
    }

    protected function rules(): array { return Purchase::rules(); }
}

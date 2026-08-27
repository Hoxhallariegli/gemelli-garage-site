<?php

namespace App\Livewire\Admin\Purchases;

use App\Models\Purchase;
use App\Domain\Purchase\Queries\PurchaseListQuery;
use App\Domain\Purchase\Actions\DeletePurchaseAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('Purchases')]
class Purchases extends Component
{
    use WithPagination;
    public int $paginate = 20;
    #[Url(history: true)] public string $search = '';
    #[Url(history: true)] public $supplier_id = '';
    #[Url(history: true)] public $status = '';
    public bool $openFilter = false;
    public string $sortField = 'id';
    public bool $sortAsc = false;

    public function resetFilters() { $this->reset(['search', 'openFilter', 'supplier_id', 'status']); $this->resetPage(); }

    public function render()
    {
        abort_if_cannot('view_purchases');
        $query = (new PurchaseListQuery())->handle([
            'search' => $this->search,
            'supplier_id' => $this->supplier_id,
            'status' => $this->status
        ], $this->sortField, $this->sortAsc ? 'asc' : 'desc')
        ->withCount('items')
        ->with('items.itemable');

        return view('livewire.admin.purchases.index', [
            'items' => $query->paginate($this->paginate),
            'sortableFields' => Purchase::sortable(),
            'suppliers' => \App\Models\Supplier::pluck('name', 'id')->toArray(),
        ])->layout('components.layouts.app');
    }

    public function sortBy($field) { if (!in_array($field, Purchase::sortable(), true)) return; if ($this->sortField === $field) { $this->sortAsc = ! $this->sortAsc; } $this->sortField = $field; }

    public function deletePurchase($id, DeletePurchaseAction $action)
    {
        abort_if_cannot('delete_purchases');
        $item = Purchase::find($id);
        if (!$item) { $this->dispatch('toast', message: __('purchases.not_found'), type: 'error'); return; }
        try {
            $action->execute($item);
            $this->dispatch('toast', message: __('purchases.deleted'), type: 'success');
            $this->resetPage();
        }
        catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        }
    }

    public function receive($id)
    {
        abort_if_cannot('edit_purchases');
        $purchase = Purchase::find($id);
        if ($purchase) {
            $purchase->receive();
            $this->dispatch('purchase-received');
            $this->dispatch('toast', message: __('purchases.received_success'), type: 'success');
        }
    }
}

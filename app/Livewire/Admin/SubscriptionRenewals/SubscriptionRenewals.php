<?php

namespace App\Livewire\Admin\SubscriptionRenewals;

use App\Models\SubscriptionRenewal;
use App\Models\Plan;
use App\Domain\SubscriptionRenewal\Queries\SubscriptionRenewalListQuery;
use App\Domain\SubscriptionRenewal\Actions\DeleteSubscriptionRenewalAction;
use App\Domain\SubscriptionRenewal\Actions\UpdateSubscriptionRenewalAction;
use App\Domain\SubscriptionRenewal\DTOs\SubscriptionRenewalDTO;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Title('Rinovimi i Abonimeve')]
class SubscriptionRenewals extends Component
{
    use WithPagination;

    public int $paginate = 10;
    #[Url(history: true)] public string $search = '';
    public string $sortField = 'id';
    public bool $sortAsc = false;

    public function approveRenewal($id, UpdateSubscriptionRenewalAction $action)
    {
        abort_if_cannot('edit_subscription_renewals');
        $item = SubscriptionRenewal::find($id);
        if (!$item) return;

        $dto = SubscriptionRenewalDTO::fromArray([
            'tenant_id' => $item->tenant_id,
            'plan_id' => $item->plan_id,
            'payment_method' => $item->payment_method,
            'transfer_document' => $item->transfer_document,
            'amount' => $item->amount,
            'notes' => $item->notes,
            'status' => 'approved',
        ]);

        $action->execute($item, $dto);
        $this->dispatch('toast', message: 'Kërkesa u miratua dhe abonimi u aktivizua!', type: 'success');
    }

    public function rejectRenewal($id, UpdateSubscriptionRenewalAction $action)
    {
        abort_if_cannot('edit_subscription_renewals');
        $item = SubscriptionRenewal::find($id);
        if (!$item) return;

        $dto = SubscriptionRenewalDTO::fromArray([
            'tenant_id' => $item->tenant_id,
            'plan_id' => $item->plan_id,
            'payment_method' => $item->payment_method,
            'transfer_document' => $item->transfer_document,
            'amount' => $item->amount,
            'notes' => $item->notes,
            'status' => 'rejected',
        ]);

        $action->execute($item, $dto);
        $this->dispatch('toast', message: 'Kërkesa u refuzua.', type: 'warning');
    }

    public function render()
    {
        abort_if_cannot('view_subscription_renewals');
        $query = (new SubscriptionRenewalListQuery())->handle(['search' => $this->search], $this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.admin.subscription-renewals.index', [
            'items' => $query->paginate($this->paginate),
            'plans' => Plan::where('active', true)->get(),
        ])->layout('components.layouts.app');
    }
}

<?php

namespace App\Livewire\Admin\Subscriptions;

use App\Models\Subscription;
use App\Domain\Subscription\Queries\SubscriptionListQuery;
use App\Domain\Subscription\Actions\DeleteSubscriptionAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Title('Abonimet e Kompanive')]
class Subscriptions extends Component
{
    use WithPagination;

    public int $paginate = 10;
    #[Url(history: true)] public string $search = '';
    public string $sortField = 'id';
    public bool $sortAsc = false;

    public function render()
    {
        abort_if_cannot('view_subscriptions');
        $query = (new SubscriptionListQuery())->handle(['search' => $this->search], $this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.admin.subscriptions.index', [
            'items' => $query->paginate($this->paginate),
        ])->layout('components.layouts.app');
    }

    public function deleteSubscription($id, DeleteSubscriptionAction $action)
    {
        abort_if_cannot('delete_subscriptions');
        $item = Subscription::find($id);
        if (!$item) return;
        $action->execute($item);
        $this->dispatch('toast', message: 'Abonimi u fshi.', type: 'success');
        $this->resetPage();
    }
}

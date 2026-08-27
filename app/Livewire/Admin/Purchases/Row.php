<?php

namespace App\Livewire\Admin\Purchases;

use App\Models\Purchase;
use Livewire\Component;
use Livewire\Attributes\On;

class Row extends Component
{
    public Purchase $item;

    #[On('purchase-received')]
    public function refresh()
    {
        $this->item->refresh();
        $this->item->loadCount('items');
        $this->item->load('items.itemable');
    }

    public function render() { return view('livewire.admin.purchases.row'); }
}

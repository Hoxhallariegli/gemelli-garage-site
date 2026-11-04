<?php

namespace App\Livewire\Admin\Garages;

use App\Models\Garage;
use Livewire\Component;

class Row extends Component
{
    public Garage $item;

    public function render()
    {
        return view('livewire.admin.garages.row');
    }
}

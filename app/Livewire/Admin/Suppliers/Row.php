<?php

namespace App\Livewire\Admin\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class Row extends Component { public Supplier $item; public function render() { return view('livewire.admin.suppliers.row'); } }

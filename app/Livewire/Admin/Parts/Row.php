<?php

namespace App\Livewire\Admin\Parts;

use App\Models\Part;
use Livewire\Component;

class Row extends Component { public Part $item; public function render() { return view('livewire.admin.parts.row'); } }
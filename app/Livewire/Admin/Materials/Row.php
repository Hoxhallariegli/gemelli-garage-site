<?php

namespace App\Livewire\Admin\Materials;

use App\Models\Material;
use Livewire\Component;

class Row extends Component { public Material $item; public function render() { return view('livewire.admin.materials.row'); } }
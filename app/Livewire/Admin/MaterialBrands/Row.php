<?php

namespace App\Livewire\Admin\MaterialBrands;

use App\Models\MaterialBrand;
use Livewire\Component;

class Row extends Component { public MaterialBrand $item; public function render() { return view('livewire.admin.material-brands.row'); } }
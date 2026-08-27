<?php

namespace App\Livewire\Admin\VehicleBrands;

use App\Models\VehicleBrand;
use Livewire\Component;

class Row extends Component { public VehicleBrand $item; public function render() { return view('livewire.admin.vehicle-brands.row'); } }
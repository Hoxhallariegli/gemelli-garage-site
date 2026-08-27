<?php

namespace App\Livewire\Admin\VehicleModels;

use App\Models\VehicleModel;
use Livewire\Component;

class Row extends Component { public VehicleModel $item; public function render() { return view('livewire.admin.vehicle-models.row'); } }
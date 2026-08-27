<?php

namespace App\Livewire\Admin\Cars;

use App\Models\Car;
use Livewire\Component;

class Row extends Component { public Car $item; public function render() { return view('livewire.admin.cars.row'); } }
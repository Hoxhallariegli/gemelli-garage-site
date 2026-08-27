<?php

namespace App\Livewire\Admin\BodyTypes;

use App\Models\BodyType;
use Livewire\Component;

class Row extends Component { public BodyType $item; public function render() { return view('livewire.admin.body-types.row'); } }

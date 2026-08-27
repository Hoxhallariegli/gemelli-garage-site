<?php

namespace App\Livewire\Admin\Clients;

use App\Models\Client;
use Livewire\Component;

class Row extends Component { public Client $item; public function render() { return view('livewire.admin.clients.row'); } }
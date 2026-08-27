<?php

namespace App\Livewire\Admin\JobRequests;

use App\Models\JobRequest;
use Livewire\Component;

class Row extends Component { public JobRequest $item; public function render() { return view('livewire.admin.job-requests.row'); } }
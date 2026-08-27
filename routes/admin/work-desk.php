<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\WorkDesk\WorkDesk;

Route::get('/work-desk', WorkDesk::class)->name('admin.work-desk');

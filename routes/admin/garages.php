<?php

use App\Livewire\Admin\Garages\Garages;
use App\Livewire\Admin\Garages\Create as CreateGarage;
use App\Livewire\Admin\Garages\Edit as EditGarage;
use Illuminate\Support\Facades\Route;

Route::prefix('garages')->group(function () {
    Route::get('/', Garages::class)->name('admin.garages.index');
    Route::get('create', CreateGarage::class)->name('admin.garages.create');
    Route::get('{garage}/edit', EditGarage::class)->name('admin.garages.edit');
});

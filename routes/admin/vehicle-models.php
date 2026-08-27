<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\VehicleModels\VehicleModels;
use App\Livewire\Admin\VehicleModels\Create;
use App\Livewire\Admin\VehicleModels\Edit;
Route::prefix('vehicle-models')->group(function () {
    Route::get('/', VehicleModels::class)->name('admin.vehicle-models.index');
    Route::get('create', Create::class)->name('admin.vehicle-models.create');
    Route::get('/{' . 'vehicleModel' . '}/edit', Edit::class)->name('admin.vehicle-models.edit');
});
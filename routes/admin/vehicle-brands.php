<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\VehicleBrands\VehicleBrands;
use App\Livewire\Admin\VehicleBrands\Create;
use App\Livewire\Admin\VehicleBrands\Edit;
Route::prefix('vehicle-brands')->group(function () {
    Route::get('/', VehicleBrands::class)->name('admin.vehicle-brands.index');
    Route::get('create', Create::class)->name('admin.vehicle-brands.create');
    Route::get('/{' . 'vehicleBrand' . '}/edit', Edit::class)->name('admin.vehicle-brands.edit');
});
<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\MaterialBrands\MaterialBrands;
use App\Livewire\Admin\MaterialBrands\Create;
use App\Livewire\Admin\MaterialBrands\Edit;
Route::prefix('material-brands')->group(function () {
    Route::get('/', MaterialBrands::class)->name('admin.material-brands.index');
    Route::get('create', Create::class)->name('admin.material-brands.create');
    Route::get('/{' . 'materialBrand' . '}/edit', Edit::class)->name('admin.material-brands.edit');
});
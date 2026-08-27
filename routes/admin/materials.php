<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Materials\Materials;
use App\Livewire\Admin\Materials\Create;
use App\Livewire\Admin\Materials\Edit;
Route::prefix('materials')->group(function () {
    Route::get('/', Materials::class)->name('admin.materials.index');
    Route::get('create', Create::class)->name('admin.materials.create');
    Route::get('/{' . 'material' . '}/edit', Edit::class)->name('admin.materials.edit');
});
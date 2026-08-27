<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Cars\Cars;
use App\Livewire\Admin\Cars\Create;
use App\Livewire\Admin\Cars\Edit;
Route::prefix('cars')->group(function () {
    Route::get('/', Cars::class)->name('admin.cars.index');
    Route::get('create', Create::class)->name('admin.cars.create');
    Route::get('/{' . 'car' . '}/edit', Edit::class)->name('admin.cars.edit');
});
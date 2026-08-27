<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Suppliers\Suppliers;
use App\Livewire\Admin\Suppliers\Create;
use App\Livewire\Admin\Suppliers\Edit;
Route::prefix('suppliers')->group(function () {
    Route::get('/', Suppliers::class)->name('admin.suppliers.index');
    Route::get('create', Create::class)->name('admin.suppliers.create');
    Route::get('/{supplier}/edit', Edit::class)->name('admin.suppliers.edit');
});

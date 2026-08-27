<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Purchases\Purchases;
use App\Livewire\Admin\Purchases\Create;
use App\Livewire\Admin\Purchases\Edit;
Route::prefix('purchases')->group(function () {
    Route::get('/', Purchases::class)->name('admin.purchases.index');
    Route::get('create', Create::class)->name('admin.purchases.create');
    Route::get('/{purchase}/edit', Edit::class)->name('admin.purchases.edit');
});

<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Parts\Parts;
use App\Livewire\Admin\Parts\Create;
use App\Livewire\Admin\Parts\Edit;
Route::prefix('parts')->group(function () {
    Route::get('/', Parts::class)->name('admin.parts.index');
    Route::get('create', Create::class)->name('admin.parts.create');
    Route::get('/{' . 'part' . '}/edit', Edit::class)->name('admin.parts.edit');
});
<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Expenses\Expenses;
use App\Livewire\Admin\Expenses\Create;
use App\Livewire\Admin\Expenses\Edit;

Route::prefix('expenses')->group(function () {
    Route::get('/', Expenses::class)->name('admin.expenses.index');
    Route::get('create', Create::class)->name('admin.expenses.create');
    Route::get('/{expense}/edit', Edit::class)->name('admin.expenses.edit');
});

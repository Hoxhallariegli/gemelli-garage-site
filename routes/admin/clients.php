<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Clients\Clients;
use App\Livewire\Admin\Clients\Create;
use App\Livewire\Admin\Clients\Edit;
Route::prefix('clients')->group(function () {
    Route::get('/', Clients::class)->name('admin.clients.index');
    Route::get('create', Create::class)->name('admin.clients.create');
    Route::get('/{' . 'client' . '}/edit', Edit::class)->name('admin.clients.edit');
});
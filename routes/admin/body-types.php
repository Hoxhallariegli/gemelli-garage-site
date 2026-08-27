<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\BodyTypes\BodyTypes;
use App\Livewire\Admin\BodyTypes\Create;
use App\Livewire\Admin\BodyTypes\Edit;
Route::prefix('body-types')->group(function () {
    Route::get('/', BodyTypes::class)->name('admin.body-types.index');
    Route::get('create', Create::class)->name('admin.body-types.create');
    Route::get('/{bodyType}/edit', Edit::class)->name('admin.body-types.edit');
});

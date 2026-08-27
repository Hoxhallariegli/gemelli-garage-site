<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Jobs\Jobs;
use App\Livewire\Admin\Jobs\Create;
use App\Livewire\Admin\Jobs\Edit;
Route::prefix('jobs')->group(function () {
    Route::get('/', Jobs::class)->name('admin.jobs.index');
    Route::get('create', Create::class)->name('admin.jobs.create');
    Route::get('/{' . 'job' . '}/edit', Edit::class)->name('admin.jobs.edit');
    Route::get('/{' . 'job' . '}/print', [App\Http\Controllers\Admin\JobPrintController::class, 'show'])->name('admin.jobs.print');
});

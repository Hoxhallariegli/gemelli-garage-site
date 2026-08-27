<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\JobRequests\JobRequests;
use App\Livewire\Admin\JobRequests\Create;
use App\Livewire\Admin\JobRequests\Edit;
Route::prefix('job-requests')->group(function () {
    Route::get('/', JobRequests::class)->name('admin.job-requests.index');
    Route::get('create', Create::class)->name('admin.job-requests.create');
    Route::get('/{' . 'jobRequest' . '}/edit', Edit::class)->name('admin.job-requests.edit');
});
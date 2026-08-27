<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Reports\Index as ReportsIndex;

Route::get('/reports', ReportsIndex::class)->name('admin.reports.index');

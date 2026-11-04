<?php

use App\Livewire\Admin\Plans\Plans;
use App\Livewire\Admin\Plans\Create as CreatePlan;
use App\Livewire\Admin\Plans\Edit as EditPlan;
use App\Livewire\Admin\Subscriptions\Subscriptions;
use App\Livewire\Admin\SubscriptionRenewals\SubscriptionRenewals;
use Illuminate\Support\Facades\Route;

Route::prefix('plans')->group(function () {
    Route::get('/', Plans::class)->name('admin.plans.index');
    Route::get('create', CreatePlan::class)->name('admin.plans.create');
    Route::get('{plan}/edit', EditPlan::class)->name('admin.plans.edit');
});

Route::prefix('subscriptions')->group(function () {
    Route::get('/', Subscriptions::class)->name('admin.subscriptions.index');
    Route::get('renewals', SubscriptionRenewals::class)->name('admin.subscription-renewals.index');
});

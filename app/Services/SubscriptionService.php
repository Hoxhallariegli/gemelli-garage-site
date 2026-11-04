<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\Plan;
use App\Models\Car;
use App\Models\Job;
use App\Models\User;

class SubscriptionService
{
    /**
     * Get active plan for a tenant/company.
     */
    public function getActivePlan(?int $tenantId = null): ?Plan
    {
        if ($tenantId) {
            $subscription = Subscription::where('tenant_id', $tenantId)
                ->whereIn('status', ['active', 'trial'])
                ->where('ends_at', '>', now())
                ->first();

            if ($subscription && $subscription->plan) {
                return $subscription->plan;
            }
        }

        return Plan::where('active', true)->first();
    }

    /**
     * Check if company can add more cars based on subscription.
     */
    public function canAddCar(?int $tenantId = null): bool
    {
        $plan = $this->getActivePlan($tenantId);
        if (!$plan) return true;

        $query = Car::query();
        if ($tenantId && \Illuminate\Support\Facades\Schema::hasColumn('cars', 'tenant_id')) {
            $query->where('tenant_id', $tenantId);
        }

        return $query->count() < $plan->max_cars;
    }

    /**
     * Check if company can add more jobs based on subscription.
     */
    public function canAddJob(?int $tenantId = null): bool
    {
        $plan = $this->getActivePlan($tenantId);
        if (!$plan) return true;

        $query = Job::query();
        if ($tenantId && \Illuminate\Support\Facades\Schema::hasColumn('jobs', 'tenant_id')) {
            $query->where('tenant_id', $tenantId);
        }

        return $query->count() < $plan->max_jobs;
    }

    /**
     * Check if company can add more staff users based on subscription.
     */
    public function canAddUser(?int $tenantId = null): bool
    {
        $plan = $this->getActivePlan($tenantId);
        if (!$plan) return true;

        $query = User::query();
        if ($tenantId && \Illuminate\Support\Facades\Schema::hasColumn('users', 'tenant_id')) {
            $query->where('tenant_id', $tenantId);
        }

        return $query->count() < $plan->max_users;
    }
}

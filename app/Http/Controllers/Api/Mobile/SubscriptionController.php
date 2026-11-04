<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    public function current(Request $request, SubscriptionService $subscriptionService): JsonResponse
    {
        $user = $request->user();
        $tenantId = $user?->tenant_id;
        $plan = $subscriptionService->getActivePlan($tenantId);

        $subscription = null;
        if ($tenantId) {
            $subscription = Subscription::where('tenant_id', $tenantId)->with('plan')->first();
        }

        return response()->json([
            'success' => true,
            'plan' => $plan,
            'subscription' => $subscription,
            'can_add_car' => $subscriptionService->canAddCar($tenantId),
            'can_add_job' => $subscriptionService->canAddJob($tenantId),
            'can_add_user' => $subscriptionService->canAddUser($tenantId),
        ]);
    }
}

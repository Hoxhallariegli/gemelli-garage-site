<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionRenewal;
use App\Domain\SubscriptionRenewal\DTOs\SubscriptionRenewalDTO;
use App\Domain\SubscriptionRenewal\Actions\CreateSubscriptionRenewalAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SubscriptionRenewalController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tenantId = $request->user()?->tenant_id;
        $query = SubscriptionRenewal::query()->with('plan');
        if ($tenantId) {
            $query->where('tenant_id', $tenantId);
        }

        return response()->json([
            'success' => true,
            'data' => $query->orderByDesc('id')->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'payment_method' => 'required|in:bank_transfer,cash,card,online',
            'amount' => 'required|numeric',
        ]);

        $data = $request->all();
        $data['tenant_id'] = $request->user()?->tenant_id;
        $data['status'] = 'pending';

        $dto = SubscriptionRenewalDTO::fromArray($data);
        $renewal = app(CreateSubscriptionRenewalAction::class)->execute($dto);

        return response()->json([
            'success' => true,
            'message' => 'Kërkesa për rinovim u dërgua me sukses dhe është në shqyrtim.',
            'data' => $renewal,
        ], 201);
    }
}

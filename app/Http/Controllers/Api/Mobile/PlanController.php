<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\JsonResponse;

class PlanController extends Controller
{
    public function index(): JsonResponse
    {
        $plans = Plan::where('active', true)->get();
        return response()->json([
            'success' => true,
            'data' => $plans,
        ]);
    }

    public function show($id): JsonResponse
    {
        $plan = Plan::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $plan,
        ]);
    }
}

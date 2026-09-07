<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Job;
use Illuminate\Http\Request;

class MobileDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        $activeJobs = Job::where('status', 'active')->count();
        $totalClients = Client::count();

        return response()->json([
            'success' => true,
            'stats' => [
                'active_jobs' => $activeJobs,
                'total_clients' => $totalClients,
            ],
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    }
}

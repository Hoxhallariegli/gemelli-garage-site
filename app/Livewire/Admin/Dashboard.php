<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Client;
use App\Models\Car;
use App\Models\Job;
use App\Models\Material;
use App\Models\Part;
use App\Models\Expense;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render(): View
    {
        $allJobs = Job::with(['payments', 'services', 'materials', 'parts'])->get();
        $totalRevenue = $allJobs->sum('gross_revenue');
        $totalPaid = $allJobs->sum('paid_amount');
        $totalPending = $allJobs->sum('remaining_balance');
        $totalExpenses = Expense::sum('amount');

        return view('livewire.admin.dashboard', [
            'totalClients' => Client::count(),
            'totalCars' => Car::count(),
            'totalJobs' => Job::count(),
            'totalRevenue' => $totalRevenue,
            'totalPaid' => $totalPaid,
            'totalPending' => $totalPending,
            'totalExpenses' => $totalExpenses,
            'actualCash' => $totalPaid - $totalExpenses,
            'potentialProfit' => $totalRevenue - $totalExpenses,
            'recentJobs' => Job::with(['car.client', 'car.brand', 'car.model', 'services.service', 'materials.material', 'parts.part', 'payments'])
                ->latest()
                ->take(5)
                ->get(),
            'lowStockMaterials' => Material::where('stock_meters', '<', 5)->take(3)->get(),
            'lowStockParts' => Part::where('stock_quantity', '<', 5)->take(3)->get(),
        ]);
    }
}

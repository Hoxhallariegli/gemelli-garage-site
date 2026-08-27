<?php

namespace App\Livewire\Admin\Reports;

use App\Models\{Job, Purchase, Material, Part, Payment, Service, Expense};
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

#[Title('Raporte & Analytics')]
class Index extends Component
{
    #[Url(history: true)] public $date_from;
    #[Url(history: true)] public $date_to;
    #[Url(history: true)] public $activeTab = 'dashboard';
    #[Url(history: true)] public $jobSearch = '';
    #[Url(history: true)] public $jobStatus = 'all';

    public function mount()
    {
        $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->date_to = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        abort_if_cannot('view_reports');
        $jobsQuery = Job::with(['car.client', 'car.brand', 'car.model.bodyType', 'services.service', 'materials.material', 'parts.part', 'payments', 'expenses'])
            ->whereBetween('job_date', [$this->date_from . ' 00:00:00', $this->date_to . ' 23:59:59']);

        if ($this->jobSearch) {
            $jobsQuery->where(function($q) {
                $q->where('id', 'like', '%' . $this->jobSearch . '%')
                  ->orWhereHas('car.client', fn($cq) => $cq->where('name', 'like', '%' . $this->jobSearch . '%'))
                  ->orWhereHas('car', fn($cq) => $cq->where('license_plate', 'like', '%' . $this->jobSearch . '%'));
            });
        }

        if ($this->jobStatus !== 'all') {
            $jobsQuery->where('status', $this->jobStatus);
        }

        $jobs = $jobsQuery->latest('job_date')->get();

        $purchases = Purchase::whereBetween('purchase_date', [$this->date_from, $this->date_to])
            ->where('status', 'received')
            ->get();

        $expenses = Expense::with(['job.car.client'])
            ->whereBetween('date', [$this->date_from, $this->date_to])
            ->get();

        // Comparative Stats (Current vs Previous Month)
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthRevenue = Job::with(['services', 'materials', 'parts'])->get()->filter(fn($j) => $j->job_date >= $currentMonthStart)->sum('gross_revenue');

        $prevMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $prevMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        $prevMonthRevenue = Job::with(['services', 'materials', 'parts'])->get()->filter(fn($j) => $j->job_date >= $prevMonthStart && $j->job_date <= $prevMonthEnd)->sum('gross_revenue');

        $growth = $prevMonthRevenue > 0 ? (($currentMonthRevenue - $prevMonthRevenue) / $prevMonthRevenue) * 100 : 100;

        $stats = [
            'total_revenue' => $jobs->sum('gross_revenue'),
            'total_cost' => $jobs->sum('total_cost'),
            'total_purchases' => $purchases->sum('total_amount'),
            'total_expenses' => $expenses->sum('amount'),
            'total_payments' => $jobs->sum('paid_amount'),
            'pending_balance' => $jobs->sum('remaining_balance'),
            'job_count' => $jobs->count(),
            'current_month_revenue' => $currentMonthRevenue,
            'prev_month_revenue' => $prevMonthRevenue,
            'revenue_growth' => $growth,
        ];

        // Net Profit (Cash Basis) = Total Payments - (Service Material Costs + Direct Expenses)
        $stats['net_profit'] = $stats['total_payments'] - $stats['total_cost'] - $stats['total_expenses'];

        // Full Services List for Tab
        $allServices = DB::table('job_services')
            ->join('services', 'job_services.service_id', '=', 'services.id')
            ->select('services.name', 'services.id', DB::raw('count(*) as total_count'), DB::raw('sum(price) as total_revenue'))
            ->whereBetween('job_services.created_at', [$this->date_from . ' 00:00:00', $this->date_to . ' 23:59:59'])
            ->groupBy('services.id', 'services.name')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Expense Categories Grouped
        $expenseStats = $expenses->groupBy('category')->map(function ($group) {
            return [
                'total' => $group->sum('amount'),
                'count' => $group->count(),
            ];
        });

        // Low Stock Alerts
        $lowStockMaterials = Material::where('stock_meters', '<', 5)->get();
        $lowStockParts = Part::where('stock_quantity', '<', 3)->get();

        // Top Services
        $topServices = DB::table('job_services')
            ->join('services', 'job_services.service_id', '=', 'services.id')
            ->select('services.name', DB::raw('count(*) as count'), DB::raw('sum(price) as revenue'))
            ->groupBy('services.id', 'services.name')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();

        return view('livewire.admin.reports.index', [
            'stats' => $stats,
            'jobs' => $jobs,
            'expenses' => $expenses,
            'expenseStats' => $expenseStats,
            'allServices' => $allServices,
            'lowStockMaterials' => $lowStockMaterials,
            'lowStockParts' => $lowStockParts,
            'topServices' => $topServices,
        ])->layout('components.layouts.app');
    }

    public function setToday() { $this->date_from = Carbon::today()->format('Y-m-d'); $this->date_to = Carbon::today()->format('Y-m-d'); }
    public function setThisMonth() { $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d'); $this->date_to = Carbon::now()->endOfMonth()->format('Y-m-d'); }
    public function setLastMonth() { $this->date_from = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d'); $this->date_to = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d'); }
    public function setTab($tab)
    {
        $this->activeTab = $tab;

        // Pastro filtrat e Job Details kur ndërron tab
        if ($tab !== 'jobs') {
            $this->reset(['jobSearch', 'jobStatus']);
        }
    }
}

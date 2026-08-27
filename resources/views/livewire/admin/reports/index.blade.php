<div class="space-y-6" x-data="{ activeTab: @entangle('activeTab') }">
    {{-- Header & Filters --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 px-1">
        <div>
            <x-h1>{{ __('reports.Analytics Dashboard') }}</x-h1>
            <x-short-description>{{ __('reports.Description') }}</x-short-description>
        </div>

        <div class="flex flex-col sm:flex-row flex-wrap items-start sm:items-center gap-3">
            <div class="flex p-1 bg-gray-100 dark:bg-gray-800 rounded-2xl w-full sm:w-auto overflow-x-auto">
                <button wire:click="setToday" class="flex-1 sm:flex-none whitespace-nowrap px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $date_from == date('Y-m-d') && $date_to == date('Y-m-d') ? 'bg-white dark:bg-gray-700 text-blue-600 shadow-sm' : 'text-gray-400' }}">{{ __('reports.Today') }}</button>
                <button wire:click="setThisMonth" class="flex-1 sm:flex-none whitespace-nowrap px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $date_from == Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') ? 'bg-white dark:bg-gray-700 text-blue-600 shadow-sm' : 'text-gray-400' }}">{{ __('reports.This Month') }}</button>
                <button wire:click="setLastMonth" class="flex-1 sm:flex-none whitespace-nowrap px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $date_from == Carbon\Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d') ? 'bg-white dark:bg-gray-700 text-blue-600 shadow-sm' : 'text-gray-400' }}">{{ __('reports.Last Month') }}</button>
            </div>

            <div class="flex items-center justify-between sm:justify-start gap-2 bg-white dark:bg-gray-800 p-1.5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm w-full sm:w-auto">
                <input type="date" wire:model.live="date_from" class="bg-transparent border-none text-[10px] font-black focus:ring-0 dark:text-white p-1 w-full sm:w-auto">
                <span class="text-gray-300 font-black">→</span>
                <input type="date" wire:model.live="date_to" class="bg-transparent border-none text-[10px] font-black focus:ring-0 dark:text-white p-1 w-full sm:w-auto">
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="flex flex-nowrap p-1 bg-gray-100 dark:bg-gray-900 rounded-2xl w-full sm:w-fit overflow-x-auto custom-scrollbar no-scrollbar-on-mobile">
        <button wire:click="setTab('dashboard')" :class="activeTab == 'dashboard' ? 'bg-white dark:bg-gray-800 text-blue-600 shadow-sm' : 'text-gray-400'" class="whitespace-nowrap px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shrink-0">{{ __('reports.Dashboard') }}</button>
        <button wire:click="setTab('jobs')" :class="activeTab == 'jobs' ? 'bg-white dark:bg-gray-800 text-blue-600 shadow-sm' : 'text-gray-400'" class="whitespace-nowrap px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shrink-0">{{ __('reports.Job Details') }}</button>
        <button wire:click="setTab('services')" :class="activeTab == 'services' ? 'bg-white dark:bg-gray-800 text-blue-600 shadow-sm' : 'text-gray-400'" class="whitespace-nowrap px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shrink-0">{{ __('reports.Services') }}</button>
        <button wire:click="setTab('expenses')" :class="activeTab == 'expenses' ? 'bg-white dark:bg-gray-800 text-blue-600 shadow-sm' : 'text-gray-400'" class="whitespace-nowrap px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shrink-0">{{ __('reports.Expenses') }}</button>
        <button wire:click="setTab('inventory')" :class="activeTab == 'inventory' ? 'bg-white dark:bg-gray-800 text-blue-600 shadow-sm' : 'text-gray-400'" class="whitespace-nowrap px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shrink-0">{{ __('reports.Inventory & Alarms') }}</button>
    </div>

    {{-- Dashboard Tab --}}
    <div x-show="activeTab == 'dashboard'" x-cloak class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="size-10 rounded-2xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
                        <x-heroicon-o-banknotes class="size-5" />
                    </div>
                    <span class="text-[10px] font-black {{ $stats['revenue_growth'] >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                        {{ $stats['revenue_growth'] >= 0 ? '+' : '' }}{{ number_format($stats['revenue_growth'], 1) }}%
                    </span>
                </div>
                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('reports.Total Revenue') }}</span>
                <span class="text-2xl font-black text-gray-900 dark:text-white italic tracking-tighter">€{{ number_format($stats['total_revenue'], 0) }}</span>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between mb-4">
                    <div class="size-10 rounded-2xl bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600">
                        <x-heroicon-o-arrow-trending-down class="size-5" />
                    </div>
                    <span class="text-[10px] font-black text-red-500 uppercase tracking-widest">{{ __('reports.Expenses') }}</span>
                </div>
                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('reports.Expenses & Costs') }}</span>
                <span class="text-2xl font-black text-red-600 italic tracking-tighter">€{{ number_format($stats['total_cost'] + $stats['total_expenses'], 0) }}</span>
                <div class="mt-2 text-[9px] font-bold text-gray-400 uppercase">
                    {{ __('reports.Cost') }}: €{{ number_format($stats['total_cost'], 0) }} + {{ __('reports.Expenses') }}: €{{ number_format($stats['total_expenses'], 0) }}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between mb-4">
                    <div class="size-10 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600">
                        <x-heroicon-o-presentation-chart-line class="size-5" />
                    </div>
                    <span class="text-[10px] font-black text-emerald-500 uppercase">{{ __('reports.Net Profit') }}</span>
                </div>
                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('reports.Fitimi Neto') ?? 'Net Profit' }}</span>
                <span class="text-2xl font-black text-emerald-600 italic tracking-tighter">€{{ number_format($stats['net_profit'], 0) }}</span>
                <div class="mt-2 text-[9px] font-bold text-gray-400 uppercase">
                    {{ __('reports.Margin') }}: {{ $stats['total_revenue'] > 0 ? number_format(($stats['net_profit'] / $stats['total_revenue']) * 100, 1) : 0 }}%
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between mb-4">
                    <div class="size-10 rounded-2xl bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center text-orange-600">
                        <x-heroicon-o-clock class="size-5" />
                    </div>
                </div>
                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('reports.Pending Balance') }}</span>
                <span class="text-2xl font-black text-orange-600 italic tracking-tighter">€{{ number_format($stats['pending_balance'], 0) }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Performance Chart --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-8 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-widest text-gray-900 dark:text-white">{{ __('reports.Performance Comparison') }}</h3>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">{{ __('reports.Revenue: Actual vs Last Month') ?? 'Revenue: Muaji Aktual vs Muaji Kaluar' }}</p>
                    </div>
                </div>

                {{-- Modern Chart using ApexCharts --}}
                <div id="performanceChart" class="w-full h-64"></div>
            </div>

            {{-- Top Services --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-sm">
                <h3 class="text-sm font-black uppercase tracking-widest text-gray-900 dark:text-white mb-6">{{ __('reports.Top Services') }}</h3>
                <div class="space-y-5">
                    @foreach($topServices as $ts)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-xl bg-gray-50 dark:bg-gray-900 flex items-center justify-center text-[10px] font-black text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                    {{ $loop->iteration }}
                                </div>
                                <div class="flex flex-col text-left">
                                    <span class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $ts->name }}</span>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase">{{ $ts->count }} {{ __('jobs.Jobs') }}</span>
                                </div>
                            </div>
                            <span class="text-[11px] font-black text-blue-600">€{{ number_format($ts->revenue, 0) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Jobs Tab --}}
    <div x-show="activeTab == 'jobs'" x-cloak class="space-y-6">
        {{-- Job Filters --}}
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="relative flex-1 w-full md:max-w-md">
                <x-heroicon-o-magnifying-glass class="absolute left-4 top-1/2 -translate-y-1/2 size-4 text-gray-400" />
                <input type="text" wire:model.live.debounce.300ms="jobSearch" placeholder="Search Client, License Plate or ID..." class="w-full pl-12 pr-4 py-3 text-xs font-black uppercase tracking-widest bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-blue-500/20 dark:text-white">
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto overflow-x-auto pb-1 md:pb-0">
                <button wire:click="$set('jobStatus', 'all')" class="whitespace-nowrap px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $jobStatus == 'all' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'bg-gray-50 dark:bg-gray-900 text-gray-400 hover:text-gray-600' }}">All</button>
                <button wire:click="$set('jobStatus', 'pending')" class="whitespace-nowrap px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $jobStatus == 'pending' ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'bg-gray-50 dark:bg-gray-900 text-gray-400 hover:text-orange-500' }}">Pending</button>
                <button wire:click="$set('jobStatus', 'in_progress')" class="whitespace-nowrap px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $jobStatus == 'in_progress' ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/20' : 'bg-gray-50 dark:bg-gray-900 text-gray-400 hover:text-blue-500' }}">Active</button>
                <button wire:click="$set('jobStatus', 'completed')" class="whitespace-nowrap px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $jobStatus == 'completed' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'bg-gray-50 dark:bg-gray-900 text-gray-400 hover:text-emerald-500' }}">Done</button>
            </div>
        </div>

        <div class="space-y-3">
            @forelse($jobs as $job)
                @php
                    $jobMaterialCost = $job->materials->sum(fn($m) => $m->quantity * $m->cost_price);
                    $jobPartCost = $job->parts->sum(fn($p) => $p->quantity * $p->cost_price);
                    $jobExpenses = $job->expenses->sum('amount');
                    $jobTotalOut = $jobMaterialCost + $jobPartCost + $jobExpenses;
                    $jobNet = $job->gross_revenue - $jobTotalOut;

                    $statusClasses = [
                        'pending' => 'bg-orange-500/10 text-orange-500',
                        'in_progress' => 'bg-blue-500/10 text-blue-500',
                        'completed' => 'bg-emerald-500/10 text-emerald-500',
                        'cancelled' => 'bg-red-500/10 text-red-500',
                    ];
                @endphp

                <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:border-blue-500/30 transition-all">
                    <div class="flex flex-col lg:flex-row divide-y lg:divide-y-0 lg:divide-x divide-gray-100 dark:divide-gray-700/50">
                        {{-- Left Info: Client & Vehicle --}}
                        <div class="lg:w-1/4 p-4 bg-gray-50/30 dark:bg-gray-900/10">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="font-black text-gray-900 dark:text-white text-xs">#00{{ $job->id }}</span>
                                    <span class="text-[9px] text-gray-400 font-bold uppercase">{{ $job->job_date?->format('d.m.Y') }}</span>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest {{ $statusClasses[$job->status] ?? 'bg-gray-100 text-gray-400' }}">
                                    {{ $job->status }}
                                </span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 flex items-center justify-center p-1.5 shrink-0">
                                    @if($job->car?->body_type_image)
                                        <img src="{{ asset($job->car->body_type_image) }}" class="w-full h-auto object-contain">
                                    @else
                                        <x-heroicon-o-truck class="size-5 text-gray-200" />
                                    @endif
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="font-black text-gray-900 dark:text-white uppercase text-[11px] truncate">{{ $job->car?->client?->name }}</span>
                                    <span class="text-[9px] text-blue-600 font-black uppercase truncate tracking-tight">{{ $job->car?->license_plate }} • {{ $job->car?->brand?->name }} {{ $job->car?->model?->name }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Middle: Services & Costs --}}
                        <div class="flex-1 p-4 grid grid-cols-2 gap-4">
                            {{-- Services Sub-section --}}
                            <div class="min-w-0">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-[8px] font-black uppercase tracking-[0.2em] text-emerald-600">{{ __('workdesk.Services') }}</h4>
                                    <span class="text-[10px] font-black text-gray-900 dark:text-white">€{{ number_format($job->services->sum('price'), 0) }}</span>
                                </div>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($job->services as $js)
                                        <span class="px-2 py-0.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 text-[8px] font-black uppercase rounded-lg border border-emerald-100 dark:border-emerald-900/30">
                                            {{ $js->service?->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Costs Sub-section --}}
                            <div class="min-w-0 border-l border-gray-100 dark:border-gray-700/50 pl-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-[8px] font-black uppercase tracking-[0.2em] text-red-500">{{ __('reports.Inventory & Expenses') }}</h4>
                                    <span class="text-[10px] font-black text-red-500">€{{ number_format($jobTotalOut, 0) }}</span>
                                </div>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($job->materials as $jm)
                                        <span class="px-2 py-0.5 bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-400 text-[8px] font-bold uppercase rounded-lg border border-gray-100 dark:border-gray-700">
                                            {{ $jm->material?->name }} ({{ $jm->quantity }}m)
                                        </span>
                                    @endforeach
                                    @foreach($job->parts as $jp)
                                        <span class="px-2 py-0.5 bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-400 text-[8px] font-bold uppercase rounded-lg border border-gray-100 dark:border-gray-700">
                                            {{ $jp->part?->name }} ({{ $jp->quantity }}x)
                                        </span>
                                    @endforeach
                                    @foreach($job->expenses as $je)
                                        <span class="px-2 py-0.5 bg-red-50 dark:bg-red-900/20 text-red-600 text-[8px] font-black uppercase rounded-lg border border-red-100 dark:border-red-900/20">
                                            {{ $je->title }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Right: Profit & Balance --}}
                        <div class="lg:w-1/4 p-4 flex flex-col justify-center bg-gray-50/10 dark:bg-gray-900/5 relative group/card">
                            <div class="grid grid-cols-2 gap-4 items-center">
                                <div class="flex flex-col">
                                    <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">{{ __('reports.Potential Profit') }}</span>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-lg font-black text-emerald-600 italic tracking-tighter">€{{ number_format($jobNet, 0) }}</span>
                                        <span class="text-[8px] font-black text-emerald-500 opacity-50">{{ $job->gross_revenue > 0 ? number_format(($jobNet / $job->gross_revenue) * 100, 0) : 0 }}%</span>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">{{ __('jobs.Balance') }}</span>
                                    <span class="text-sm font-black {{ $job->remaining_balance > 0 ? 'text-red-500' : 'text-emerald-500' }}">
                                        €{{ number_format($job->remaining_balance, 0) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Quick Actions --}}
                            <div class="absolute top-2 right-2 flex gap-1">
                                <a href="{{ route('admin.jobs.edit', $job) }}" class="p-1.5 bg-white dark:bg-gray-800 text-gray-400 hover:text-blue-600 rounded-lg border border-gray-100 dark:border-gray-700 shadow-sm transition-all">
                                    <x-heroicon-o-pencil-square class="size-3.5" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-20 text-center bg-white dark:bg-gray-800 rounded-[2rem] border border-dashed border-gray-200 dark:border-gray-700">
                    <x-heroicon-o-magnifying-glass class="size-12 text-gray-200 mx-auto mb-4" />
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">No jobs found matching your criteria.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Services Tab --}}
    <div x-show="activeTab == 'services'" x-cloak>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($allServices as $srv)
                <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-sm group hover:border-blue-600/30 transition-all">
                    <div class="flex justify-between items-start mb-6">
                        <div class="size-10 rounded-2xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
                            <x-heroicon-o-wrench-screwdriver class="size-5" />
                        </div>
                        <span class="px-3 py-1 bg-blue-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest">{{ $srv->total_count }} {{ __('jobs.Jobs') }}</span>
                    </div>
                    <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight mb-1">{{ $srv->name }}</h3>
                    <div class="flex items-end justify-between mt-auto">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ __('reports.Total Revenue') }}</span>
                            <span class="text-xl font-black text-gray-900 dark:text-white italic">€{{ number_format($srv->total_revenue, 0) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Expenses Tab --}}
    <div x-show="activeTab == 'expenses'" x-cloak class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="bg-gray-50 dark:bg-gray-900/50 text-[10px] font-black uppercase text-gray-400 tracking-widest">
                            <tr>
                                <th class="px-6 py-5">{{ __('reports.Date & Description') }}</th>
                                <th class="px-6 py-5">{{ __('reports.Category') }}</th>
                                <th class="px-6 py-5 text-right">{{ __('reports.Amount (€)') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            @foreach($expenses as $exp)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/30 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col">
                                            <span class="font-black text-gray-900 dark:text-white text-xs uppercase">{{ $exp->title }}</span>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-[10px] text-gray-400 font-bold uppercase">{{ $exp->date->format('d.m.Y') }}</span>
                                                @if($exp->job_id)
                                                    <span class="text-[9px] px-1.5 py-0.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 rounded font-black uppercase tracking-tight">Job #00{{ $exp->job_id }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-lg text-[8px] font-black uppercase tracking-widest">{{ __('expenses.categories.' . $exp->category) }}</span>
                                    </td>
                                    <td class="px-6 py-5 text-right font-black text-red-500 italic text-sm">€{{ number_format($exp->amount, 0) }}</td>
                                </tr>
                            @endforeach
                            @if($expenses->isEmpty())
                                <tr><td colspan="3" class="px-6 py-12 text-center text-gray-300 font-black uppercase text-[10px]">{{ __('expenses.No records found.') }}</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-sm">
                <h3 class="text-sm font-black uppercase tracking-widest text-gray-900 dark:text-white mb-8">{{ __('reports.Summary by Category') }}</h3>
                <div class="space-y-6">
                    @foreach($expenseStats as $cat => $data)
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest">
                                <span class="text-gray-400">{{ __('expenses.categories.' . $cat) }}</span>
                                <span class="text-gray-900 dark:text-white">€{{ number_format($data['total'], 0) }}</span>
                            </div>
                            <div class="h-1.5 w-full bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                @php $perc = $stats['total_expenses'] > 0 ? ($data['total'] / $stats['total_expenses']) * 100 : 0; @endphp
                                <div class="h-full bg-red-500 rounded-full" style="width: {{ $perc }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-10 pt-8 border-t border-gray-50 dark:border-gray-700">
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('reports.Total Expenses') }}</p>
                            <p class="text-3xl font-black text-red-600 italic tracking-tighter">€{{ number_format($stats['total_expenses'], 0) }}</p>
                        </div>
                        <x-btn :href="route('admin.expenses.index')" variant="gray" class="!py-2 !px-4 !text-[8px]">{{ __('admin.Edit') }}</x-btn>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Inventory Tab --}}
    <div x-show="activeTab == 'inventory'" x-cloak class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="flex items-center gap-3 mb-8">
                <div class="size-10 rounded-2xl bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-500">
                    <x-heroicon-o-exclamation-triangle class="size-5" />
                </div>
                <h3 class="text-sm font-black uppercase tracking-widest text-gray-900 dark:text-white">{{ __('reports.Stock Alarms') }}</h3>
            </div>
            <div class="space-y-4">
                @forelse($lowStockMaterials as $m)
                    <div class="p-4 bg-red-50/50 dark:bg-red-900/10 rounded-2xl border border-red-100 dark:border-red-900/20 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-xs font-black text-gray-900 dark:text-white uppercase">{{ $m->name }}</span>
                            <span class="text-[9px] text-red-50 font-bold uppercase">{{ $m->brand }}</span>
                        </div>
                        <span class="text-sm font-black text-red-600">{{ number_format($m->stock_meters, 1) }}m</span>
                    </div>
                @empty
                    <p class="py-10 text-center text-gray-400 font-bold uppercase text-[10px]">{{ __('reports.No Alarms') }}</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-10 rounded-[3rem] border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col justify-center">
            <h2 class="text-2xl font-black italic text-gray-900 dark:text-white mb-4">{{ __('reports.Stock Control') }}</h2>
            <p class="text-xs font-bold text-gray-500 mb-8 max-w-xs">{{ __('reports.Monitor materials in real-time to avoid job delays') ?? 'Monitoro materialet në kohë reale për të shmangur vonesat në punë.' }}</p>
            <div class="flex gap-4">
                <x-btn :href="route('admin.purchases.index')" variant="blue" class="!px-8 !py-4">{{ __('reports.Supply') }}</x-btn>
            </div>
        </div>
    </div>

    {{-- ApexCharts Script --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            var options = {
                series: [{
                    name: 'Revenue',
                    data: [{{ $stats['prev_month_revenue'] }}, {{ $stats['current_month_revenue'] }}]
                }],
                chart: {
                    type: 'bar',
                    height: 250,
                    toolbar: { show: false },
                    fontFamily: 'Plus Jakarta Sans, sans-serif'
                },
                plotOptions: {
                    bar: {
                        borderRadius: 12,
                        columnWidth: '40%',
                        distributed: true,
                        dataLabels: { position: 'top' }
                    }
                },
                colors: ['#E5E7EB', '#2563EB'],
                dataLabels: {
                    enabled: true,
                    formatter: function (val) { return "€" + val.toLocaleString(); },
                    offsetY: -20,
                    style: { fontSize: '10px', fontWeight: 900, colors: ["#9CA3AF", "#2563EB"] }
                },
                legend: { show: false },
                xaxis: {
                    categories: ["{{ __('reports.Last Month') }}", "{{ __('reports.This Month') }}"],
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { style: { fontWeight: 900, fontSize: '10px', colors: '#9CA3AF' } }
                },
                yaxis: { show: false },
                grid: { show: false },
                tooltip: { enabled: false }
            };

            var chart = new ApexCharts(document.querySelector("#performanceChart"), options);
            chart.render();

            Livewire.on('refreshCharts', () => {
                chart.updateSeries([{ data: [{{ $stats['prev_month_revenue'] }}, {{ $stats['current_month_revenue'] }}] }]);
            });
        });
    </script>
    @endpush
</div>

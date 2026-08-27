<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <x-h1>{{ __('dashboard.Dashboard') }}</x-h1>
            <x-short-description>{{ __('dashboard.Description') }}</x-short-description>
        </div>
        <div class="flex items-center gap-3">
             <x-btn :href="route('admin.jobs.create')" icon="plus" variant="blue">{{ __('dashboard.Add New Job') }}</x-btn>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
        {{-- Total Clients --}}
        <a href="{{ route('admin.clients.index') }}" class="block bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-xs border border-gray-200/60 dark:border-gray-700/50 group hover:border-blue-500/30 transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">{{ __('dashboard.Clients') }}</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $totalClients }}</p>
                </div>
                <div class="p-2.5 rounded-xl bg-gray-50 dark:bg-gray-900/50 text-gray-400 group-hover:text-blue-600 transition-colors">
                    <x-heroicon-o-users class="size-5" />
                </div>
            </div>
        </a>

        {{-- Vehicles --}}
        <a href="{{ route('admin.cars.index') }}" class="block bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-xs border border-gray-200/60 dark:border-gray-700/50 group hover:border-blue-500/30 transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">{{ __('dashboard.Vehicles') }}</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $totalCars }}</p>
                </div>
                <div class="p-2.5 rounded-xl bg-gray-50 dark:bg-gray-900/50 text-gray-400 group-hover:text-blue-600 transition-colors">
                    <x-heroicon-o-truck class="size-5" />
                </div>
            </div>
        </a>

        {{-- Total Jobs --}}
        <a href="{{ route('admin.jobs.index') }}" class="block bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-xs border border-gray-200/60 dark:border-gray-700/50 group hover:border-blue-500/30 transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">{{ __('dashboard.Total Jobs') }}</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $totalJobs }}</p>
                </div>
                <div class="p-2.5 rounded-xl bg-gray-50 dark:bg-gray-900/50 text-gray-400 group-hover:text-blue-600 transition-colors">
                    <x-heroicon-o-clipboard-document-check class="size-5" />
                </div>
            </div>
        </a>

        {{-- Total Revenue (Billed) --}}
        <a href="{{ route('admin.reports.index') }}" class="block bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-xs border border-gray-200/60 dark:border-gray-700/50 group hover:border-blue-500/30 transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">{{ __('dashboard.Total Revenue') }}</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">€{{ number_format($totalRevenue, 0) }}</p>
                </div>
                <div class="p-2.5 rounded-xl bg-gray-50 dark:bg-gray-900/50 text-gray-400 group-hover:text-blue-600 transition-colors">
                    <x-heroicon-o-document-chart-bar class="size-5" />
                </div>
            </div>
        </a>

        {{-- Total Paid (Collected) --}}
        <a href="{{ route('admin.payments.index') }}" class="block bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-xs border border-gray-200/60 dark:border-gray-700/50 group hover:border-emerald-500/30 transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/70 dark:text-emerald-500 mb-1">{{ __('dashboard.Total Paid') }}</p>
                    <p class="text-3xl font-black text-emerald-600 dark:text-emerald-400 tracking-tighter">€{{ number_format($totalPaid, 0) }}</p>
                </div>
                <div class="p-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400">
                    <x-heroicon-o-banknotes class="size-5" />
                </div>
            </div>
        </a>

        {{-- Total Expenses --}}
        <a href="{{ route('admin.expenses.index') }}" class="block bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-xs border border-gray-200/60 dark:border-gray-700/50 group hover:border-red-500/30 transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-red-600/70 dark:text-red-500 mb-1">{{ __('dashboard.Total Expenses') }}</p>
                    <p class="text-3xl font-black text-red-600 dark:text-red-400 tracking-tighter">€{{ number_format($totalExpenses, 0) }}</p>
                </div>
                <div class="p-2.5 rounded-xl bg-red-50 dark:bg-red-900/50 text-red-600 dark:text-red-400">
                    <x-heroicon-o-arrow-trending-down class="size-5" />
                </div>
            </div>
        </a>

        {{-- Actual Cash --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-xs border border-gray-200/60 dark:border-gray-700/50 group hover:border-indigo-500/30 transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-600/70 dark:text-indigo-400 mb-1">{{ __('dashboard.Actual Cash') }}</p>
                    <p class="text-3xl font-black text-indigo-600 dark:text-indigo-400 tracking-tighter">€{{ number_format($actualCash, 0) }}</p>
                </div>
                <div class="p-2.5 rounded-xl bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400">
                    <x-heroicon-o-wallet class="size-5" />
                </div>
            </div>
        </div>

        {{-- Potential Profit --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-xs border border-gray-200/60 dark:border-gray-700/50 group hover:border-gray-500/30 transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">{{ __('dashboard.Potential Profit') }}</p>
                    <p class="text-3xl font-black text-gray-400 dark:text-gray-500 tracking-tighter">€{{ number_format($potentialProfit, 0) }}</p>
                </div>
                <div class="p-2.5 rounded-xl bg-gray-50 dark:bg-gray-900/50 text-gray-300">
                    <x-heroicon-o-chart-bar-square class="size-5" />
                </div>
            </div>
        </div>

        {{-- Pending Balance --}}
        <a href="{{ route('admin.jobs.index') }}" class="block bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-xs border border-gray-200/60 dark:border-gray-700/50 group hover:border-orange-500/30 transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-orange-600/70 dark:text-orange-500 mb-1">{{ __('dashboard.Pending Balance') }}</p>
                    <p class="text-3xl font-black text-orange-600 dark:text-orange-400 tracking-tighter">€{{ number_format($totalPending, 0) }}</p>
                </div>
                <div class="p-2.5 rounded-xl bg-orange-50 dark:bg-orange-900/50 text-orange-600 dark:text-orange-400">
                    <x-heroicon-o-clock class="size-5" />
                </div>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Main Section: Recent Jobs --}}
        <div class="lg:col-span-8 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-200/60 dark:border-gray-700/50 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="size-8 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                        <x-heroicon-o-queue-list class="size-4" />
                    </div>
                    <h3 class="font-black text-gray-900 dark:text-white uppercase tracking-tight text-xs">{{ __('dashboard.Recent Jobs') }}</h3>
                </div>
                <x-a :href="route('admin.jobs.index')" class="text-[10px] font-bold text-blue-600 uppercase tracking-widest hover:underline">{{ __('dashboard.View all') }}</x-a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/50 dark:bg-gray-900/50 text-[10px] font-black uppercase text-gray-400 tracking-widest">
                        <tr>
                            <th class="px-6 py-4">{{ __('dashboard.Vehicle') }}</th>
                            <th class="px-6 py-4">{{ __('dashboard.Service') }}</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">{{ __('dashboard.Payment') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                        @forelse($recentJobs as $job)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="size-10 rounded-xl bg-gray-50 dark:bg-gray-900 flex items-center justify-center text-gray-400 font-black text-[10px] uppercase border border-gray-100 dark:border-gray-800">
                                            {{ substr($job->car?->brand?->name ?? '?', 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-900 dark:text-white">{{ $job->car?->license_plate ?? '-' }}</span>
                                            <span class="text-[9px] text-gray-400 uppercase font-black tracking-widest">{{ $job->car?->brand?->name }} {{ $job->car?->model?->name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($job->services->take(2) as $js)
                                            <span class="px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[9px] font-bold uppercase tracking-tighter">
                                                {{ $js->service?->name }}
                                            </span>
                                        @endforeach
                                        @if($job->services->count() > 2)
                                            <span class="text-[9px] text-gray-400 font-bold">+{{ $job->services->count() - 2 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $ps = $job->payment_status;
                                        $pStyles = [
                                            'paid' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400',
                                            'partial' => 'bg-orange-50 text-orange-600 dark:bg-orange-900/20 dark:text-orange-400',
                                            'unpaid' => 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400'
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded-lg text-[8px] font-black uppercase {{ $pStyles[$ps] ?? $pStyles['unpaid'] }}">
                                        {{ $ps }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex flex-col items-end">
                                        <span class="font-black text-gray-900 dark:text-white text-base">€{{ number_format($job->gross_revenue, 0) }}</span>
                                        @if($ps !== 'paid')
                                            <span class="text-[8px] text-red-500 font-black uppercase tracking-tighter">-€{{ number_format($job->remaining_balance, 0) }}</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400 text-xs font-bold uppercase tracking-widest italic">Nuk u gjet asnjë punë e fundit.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sidebar Section --}}
        <div class="lg:col-span-4 space-y-6">
            {{-- Quick Actions --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-200/60 dark:border-gray-700/50">
                <h3 class="text-xl font-black uppercase italic leading-none mb-2 text-gray-900 dark:text-white">GEMELLI<span class="text-blue-600">GARAGE</span></h3>
                <p class="text-gray-400 dark:text-gray-500 text-[10px] mb-8 uppercase tracking-[0.2em] font-bold">Premium Studio Management</p>

                <div class="grid grid-cols-1 gap-3 relative z-10">
                    <x-a :href="route('admin.work-desk')" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 hover:bg-blue-50 dark:hover:bg-blue-900/20 text-gray-900 dark:text-white rounded-2xl transition-all group/btn border border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-xl bg-blue-600 text-white flex items-center justify-center">
                                <x-heroicon-o-computer-desktop class="size-4" />
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest">Work Desk</span>
                        </div>
                        <x-heroicon-o-arrow-right class="size-3 group-hover/btn:translate-x-1 transition-transform text-gray-400" />
                    </x-a>

                    <x-a :href="route('admin.jobs.create')" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 text-gray-900 dark:text-white rounded-2xl transition-all group/btn border border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center">
                                <x-heroicon-o-plus-circle class="size-4" />
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest">Regjistrim i Ri</span>
                        </div>
                        <x-heroicon-o-arrow-right class="size-3 group-hover/btn:translate-x-1 transition-transform text-gray-400" />
                    </x-a>
                </div>
            </div>

            {{-- Inventory Alerts --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border border-gray-200/60 dark:border-gray-700/50">
                <div class="flex items-center justify-between mb-6 px-1">
                    <h3 class="font-black text-gray-900 dark:text-white uppercase tracking-tight text-xs">{{ __('Inventory Alerts') }}</h3>
                    <x-heroicon-o-exclamation-triangle class="size-4 text-orange-500 animate-pulse" />
                </div>

                <div class="space-y-3">
                    @foreach($lowStockMaterials->take(3) as $mat)
                        <div class="flex items-center justify-between p-3 bg-red-50/50 dark:bg-red-900/10 rounded-xl border border-red-100 dark:border-red-900/20">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold dark:text-white uppercase truncate max-w-[120px]">{{ $mat->name }}</span>
                                <span class="text-[8px] text-gray-400 font-black uppercase tracking-tighter">Material</span>
                            </div>
                            <span class="text-[10px] font-black text-red-600 dark:text-red-400 uppercase tracking-tighter">{{ number_format($mat->stock_meters, 1) }}m mbetur</span>
                        </div>
                    @endforeach

                    @foreach($lowStockParts->take(2) as $part)
                        <div class="flex items-center justify-between p-3 bg-red-50/50 dark:bg-red-900/10 rounded-xl border border-red-100 dark:border-red-900/20">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold dark:text-white uppercase truncate max-w-[120px]">{{ $part->name }}</span>
                                <span class="text-[8px] text-gray-400 font-black uppercase tracking-tighter">Pjesë</span>
                            </div>
                            <span class="text-[10px] font-black text-red-600 dark:text-red-400 uppercase tracking-tighter">{{ $part->stock_quantity }} copë mbetur</span>
                        </div>
                    @endforeach

                    @if(count($lowStockMaterials) == 0 && count($lowStockParts) == 0)
                        <div class="py-6 text-center">
                            <div class="size-10 rounded-full bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-500 mx-auto mb-2">
                                <x-heroicon-o-check-circle class="size-6" />
                            </div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Stoku është në rregull</p>
                        </div>
                    @endif
                </div>

                @if(count($lowStockMaterials) + count($lowStockParts) > 5)
                    <div class="mt-4 text-center">
                        <x-a :href="route('admin.materials.index')" class="text-[8px] font-black text-gray-400 uppercase hover:text-blue-600 transition-colors tracking-widest italic">+ Shiko të gjitha njoftimet</x-a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


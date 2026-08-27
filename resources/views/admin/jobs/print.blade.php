<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Card #{{ $job->id }} - {{ $job->car?->license_plate }}</title>

    <!-- WhatsApp & Social Media Preview -->
    <meta property="og:site_name" content="Gemelli Garage">
    <meta property="og:title" content="GEMELLI GARAGE - {{ $job->status == 'pending' ? 'Preventivo' : 'Job Card' }} #00{{ $job->id }}">
    <meta property="og:description" content="Detajet për mjetin {{ $job->car?->brand?->name }} {{ $job->car?->model?->name }} ({{ $job->car?->license_plate }}). Klikoni për ta hapur faturën/preventivin.">
    <meta property="og:image" content="{{ route('public.job.preview-image', $job->public_token) }}">
    <meta property="og:image:secure_url" content="{{ route('public.job.preview-image', $job->public_token) }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('public.job.view', $job->public_token) }}">
    <meta name="twitter:card" content="summary_large_image">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');

        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        @page {
            size: A4;
            margin: 0mm;
        }

        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; margin: 0 !important; }
            .print-container {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 0.8cm !important; /* Reduktuar nga 1.5cm */
                width: 100% !important;
                max-width: 100% !important;
                min-height: auto !important; /* Hequr fiks 29.7cm që të mos forcojë faqe të dytë */
            }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 p-0 md:p-4 pb-32 md:pb-4">

    <div class="print-container max-w-4xl mx-auto bg-white p-8 shadow-2xl relative overflow-hidden mb-24 md:mb-4">
        {{-- Background Design Elements --}}
        <div class="absolute top-0 right-0 w-[300px] h-[300px] bg-[#28a745]/[0.02] rounded-full -mr-32 -mt-32"></div>

        {{-- Header --}}
        <div class="flex justify-between items-start relative z-10">
            <div>
                <div class="flex items-center gap-6">
                    <img src="{{ asset('assets/front/gemelli-garage/images/logo-gemelli.png') }}" class="h-32 w-auto grayscale-0 shadow-none print:h-36">
                    <div class="h-24 w-px bg-gray-200 dark:bg-gray-700 hidden sm:block"></div>
                    <div class="hidden sm:block">
                        <p class="text-xs font-black uppercase tracking-[0.4em] text-[#28a745]/60 leading-none">Detailing & Wrap Studio</p>
                    </div>
                </div>

                <div class="mt-8 space-y-1.5 border-l-4 border-[#28a745]/20 pl-4">
                    <p class="text-sm font-black text-gray-800 italic leading-tight uppercase tracking-tight">Viale della repubblica 30, Melegnano 20077</p>
                    <div class="flex gap-6">
                        <p class="text-xs font-black text-gray-900 tracking-tighter flex items-center gap-1.5">
                            <span class="text-[#28a745] font-black">TEL.</span> +39 324 801 9211
                        </p>
                        <p class="text-xs font-black text-gray-900 tracking-tighter flex items-center gap-1.5">
                            <span class="text-[#28a745] font-black">MAIL.</span> gemellicargarage@gmail.com
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <div class="border-2 border-[#28a745]/20 px-4 py-2 rounded-xl inline-block text-right mb-2">
                    <h2 class="text-lg font-black uppercase tracking-tighter italic text-[#28a745]">
                        {{ $job->status == 'pending' ? 'Preventivo' : 'Job Card' }}
                    </h2>
                </div>
                <div class="space-y-0">
                    <p class="text-xs font-black text-gray-900">N°. <span class="text-[#28a745]">#00{{ $job->id }}</span></p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">{{ $job->job_date?->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Client & Vehicle Section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8 relative z-10">
            <div class="bg-emerald-50/30 rounded-[1.5rem] p-5 border border-emerald-100/50 flex flex-col justify-center">
                <span class="text-[8px] font-black uppercase tracking-[0.2em] text-[#28a745] block mb-1">{{ __('reports.Client & Vehicle') }}</span>
                <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight italic">{{ $job->car?->client?->name ?? 'N/A' }}</h3>
                <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1">
                    <p class="text-[10px] font-bold text-gray-500 flex items-center gap-1">
                        <svg class="size-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                        {{ $job->car?->client?->phone }}
                    </p>
                    @if($job->car?->client?->email)
                    <p class="text-[10px] font-bold text-gray-500 flex items-center gap-1">
                        <svg class="size-3 text-[#28a745]" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                        {{ $job->car->client->email }}
                    </p>
                    @endif
                </div>
            </div>

            <div class="bg-gray-50 rounded-[1.5rem] p-5 border border-gray-100 relative overflow-hidden group">
                {{-- Body Type Image Background --}}
                @if($job->car?->model?->bodyType?->image)
                    <div class="absolute -right-4 -bottom-6 opacity-[0.08] pointer-events-none scale-125 rotate-[-10deg] transition-transform group-hover:scale-150 duration-700">
                        <img src="{{ asset($job->car->model->bodyType->image) }}" class="w-48 h-auto object-contain grayscale">
                    </div>
                @endif

                <div class="relative z-10">
                    <span class="text-[8px] font-black uppercase tracking-[0.2em] text-[#28a745] block mb-1">{{ __('workdesk.Vehicle') }}</span>
                    <div class="flex items-center gap-4">
                        <div class="size-12 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-xl font-black text-[#28a745] italic shrink-0 shadow-sm">
                            {{ substr($job->car?->brand?->name ?? '?', 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter leading-none">{{ $job->car?->license_plate }}</h3>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest italic mt-1">{{ $job->car?->brand?->name }} {{ $job->car?->model?->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="mt-8 relative z-10">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-400 border-b border-gray-100">
                        <th class="pb-3 text-[9px] font-black uppercase tracking-[0.2em]">{{ __('jobs.Description') }}</th>
                        <th class="pb-3 text-[9px] font-black uppercase tracking-[0.2em] text-center w-20">{{ __('jobs.Quantity') }}</th>
                        <th class="pb-3 text-[9px] font-black uppercase tracking-[0.2em] text-right w-24">{{ __('jobs.Price') }}</th>
                        <th class="pb-3 text-[9px] font-black uppercase tracking-[0.2em] text-right w-24">{{ __('jobs.Total') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($job->services as $s)
                        <tr class="group">
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    @if($s->service?->image)
                                        <div class="size-10 rounded-lg bg-gray-50 overflow-hidden shrink-0 border border-gray-100">
                                            <img src="{{ asset($s->service->image) }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="size-10 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
                                            <x-heroicon-o-wrench-screwdriver class="size-5 text-emerald-500" />
                                        </div>
                                    @endif
                                    <div>
                                        <span class="block text-xs font-black text-gray-900 uppercase tracking-tight italic">{{ $s->service?->name }}</span>
                                        <span class="text-[7px] font-black text-emerald-500 uppercase tracking-widest">{{ __('workdesk.Service') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 text-center text-[11px] font-black">1</td>
                            <td class="py-4 text-right text-[11px] font-bold text-gray-500">€{{ number_format($s->price, 0) }}</td>
                            <td class="py-4 text-right text-xs font-black italic text-gray-900">€{{ number_format($s->price, 0) }}</td>
                        </tr>
                    @endforeach

                    @foreach($job->materials as $m)
                        <tr class="group">
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    @if($m->material?->image)
                                        <div class="size-10 rounded-lg bg-gray-50 overflow-hidden shrink-0 border border-gray-100">
                                            <img src="{{ asset($m->material->image) }}" class="w-full h-full object-cover">
                                        </div>
                                    @elseif($m->material?->hex_code)
                                        <div class="size-10 rounded-lg shrink-0 border border-gray-100 shadow-inner" style="background-color: {{ $m->material->hex_code }}"></div>
                                    @else
                                        <div class="size-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                            <x-heroicon-o-square-3-stack-3d class="size-5 text-blue-500" />
                                        </div>
                                    @endif
                                    <div>
                                        <span class="block text-xs font-black text-gray-900 uppercase tracking-tight italic">{{ $m->material?->name }}</span>
                                        <span class="text-[7px] font-black text-blue-500 uppercase tracking-widest">{{ __('workdesk.Material') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 text-center text-[11px] font-black">{{ number_format($m->quantity, 1) }}m</td>
                            <td class="py-4 text-right text-[11px] font-bold text-gray-500">€{{ number_format($m->sell_price, 0) }}</td>
                            <td class="py-4 text-right text-xs font-black italic text-gray-900">€{{ number_format($m->quantity * $m->sell_price, 0) }}</td>
                        </tr>
                    @endforeach

                    @foreach($job->parts as $p)
                        <tr class="group">
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    @if($p->part?->image)
                                        <div class="size-10 rounded-lg bg-gray-50 overflow-hidden shrink-0 border border-gray-100">
                                            <img src="{{ asset($p->part->image) }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="size-10 rounded-lg bg-orange-50 flex items-center justify-center shrink-0">
                                            <x-heroicon-o-cog-6-tooth class="size-5 text-orange-500" />
                                        </div>
                                    @endif
                                    <div>
                                        <span class="block text-xs font-black text-gray-900 uppercase tracking-tight italic">{{ $p->part?->name }}</span>
                                        <span class="text-[7px] font-black text-orange-500 uppercase tracking-widest">{{ __('workdesk.Part') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 text-center text-[11px] font-black">{{ number_format($p->quantity, 0) }}</td>
                            <td class="py-4 text-right text-[11px] font-bold text-gray-500">€{{ number_format($p->sell_price, 0) }}</td>
                            <td class="py-4 text-right text-xs font-black italic text-gray-900">€{{ number_format($p->quantity * $p->sell_price, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Financial Summary --}}
        <div class="mt-8 flex justify-end relative z-10">
            <div class="w-64">
                <div class="space-y-3 p-6 bg-emerald-50/30 rounded-[1.5rem] border border-emerald-100 shadow-sm">
                    <div class="flex justify-between items-center text-gray-400">
                        <span class="font-black uppercase tracking-[0.2em] text-[7px]">{{ __('jobs.Subtotal') }}</span>
                        <span class="font-black text-[10px]">€{{ number_format($job->gross_revenue, 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-emerald-500">
                        <span class="font-black uppercase tracking-[0.2em] text-[7px]">{{ __('jobs.Paid') }}</span>
                        <span class="font-black text-[10px]">- €{{ number_format($job->paid_amount, 0) }}</span>
                    </div>
                    <div class="pt-3 border-t border-emerald-100 flex justify-between items-end">
                        <div>
                            <span class="block font-black uppercase tracking-[0.2em] text-[8px] text-[#28a745] mb-0.5">{{ __('jobs.Remaining') }}</span>
                            <span class="text-3xl font-black text-gray-900 italic tracking-tighter">€{{ number_format($job->remaining_balance, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($job->notes)
            <div class="mt-8 p-6 bg-gray-50 rounded-[1.5rem] border border-gray-100 relative z-10">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="size-3 text-[#28a745]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-[8px] font-black uppercase tracking-[0.2em] text-[#28a745]">{{ __('jobs.Notes') }}</span>
                </div>
                <p class="text-[10px] font-bold text-gray-600 leading-tight italic">{{ $job->notes }}</p>
            </div>
        @endif

        {{-- Footer --}}
        <div class="mt-12 pt-8 text-center relative z-10">
            <p class="text-[8px] font-black text-gray-300 uppercase tracking-[0.5em] mb-4 italic">{{ __('jobs.Thanks for choosing us') }}</p>
            <div class="flex justify-center gap-8 text-[9px] font-black text-gray-900 italic">
                <span>@gemelligarage</span>
                <span>www.gemelligarage.com</span>
            </div>
        </div>
    </div>

    @if(!$isPublic)
    <div class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 no-print flex flex-col items-center gap-4">
        {{-- Language Switcher --}}
        <div class="flex gap-2 p-1 bg-white/80 backdrop-blur-sm border border-gray-200 rounded-xl shadow-xl">
            <a href="?lang=sq" class="px-3 py-1 text-[10px] font-black uppercase rounded-lg {{ app()->getLocale() == 'sq' ? 'bg-[#28a745] text-white' : 'text-gray-400 hover:text-gray-600' }}">SQ</a>
            <a href="?lang=en" class="px-3 py-1 text-[10px] font-black uppercase rounded-lg {{ app()->getLocale() == 'en' ? 'bg-[#28a745] text-white' : 'text-gray-400 hover:text-gray-600' }}">EN</a>
        </div>

        <div class="flex gap-4">
            @auth
            <a href="{{ route('admin.jobs.index') }}" class="group flex items-center gap-3 px-8 py-5 bg-white text-gray-900 border border-gray-200 rounded-2xl font-black text-xs uppercase tracking-widest shadow-2xl hover:bg-gray-50 transition-all duration-300 active:scale-95">
                <svg class="size-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                {{ __('admin.Back to List') }}
            </a>
            @endauth

            <button onclick="window.print()" class="group flex items-center gap-3 px-10 py-5 bg-[#28a745] text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-2xl hover:bg-[#218838] hover:scale-105 transition-all duration-300 active:scale-95">
                <svg class="size-5 group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.89l-2.26-2.26a.75.75 0 010-1.06l2.26-2.26a.75.75 0 011.06 1.06l-1.47 1.47h11.41l-1.47-1.47a.75.75 0 111.06-1.06l2.26 2.26a.75.75 0 010 1.06l-2.26 2.26a.75.75 0 11-1.06-1.06l1.47-1.47H5.31l1.47 1.47a.75.75 0 11-1.06 1.06z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 15.75h3a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0018 4.5H6a2.25 2.25 0 00-2.25 2.25v6.75A2.25 2.25 0 006 13.5h3" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.5v-3a2.25 2.25 0 00-2.25-2.25h-1.5A2.25 2.25 0 009 16.5v3" />
                </svg>
                {{ __('jobs.Print') }}
            </button>
        </div>
    </div>
    @endif

</body>
</html>

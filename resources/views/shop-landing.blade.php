<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $garage->name }} | Detailing & Wrap Studio</title>

    <!-- WhatsApp & OpenGraph Preview -->
    <meta property="og:site_name" content="{{ $garage->name }}">
    <meta property="og:title" content="{{ $garage->name }} - Detailing & Wrap Studio">
    <meta property="og:description" content="Detailing, Wrap & Car Care Services at {{ $garage->name }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $garage->logo ? asset(ltrim($garage->logo, '/')) : asset('assets/front/gemelli-garage/images/og-share.png') }}">
    <meta property="og:image:secure_url" content="{{ $garage->logo ? asset(ltrim($garage->logo, '/')) : asset('assets/front/gemelli-garage/images/og-share.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="{{ $garage->logo ? asset(ltrim($garage->logo, '/')) : asset('assets/front/gemelli-garage/images/og-share.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-950 text-white min-h-screen flex flex-col justify-between antialiased">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-gray-950/90 border-b border-gray-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="#" class="flex items-center gap-3">
                @if(!empty($garage->logo))
                    <img src="{{ asset(ltrim($garage->logo, '/')) }}" alt="{{ $garage->name }}" class="w-12 h-12 rounded-2xl object-cover border border-gray-800 shadow-md">
                @else
                    <div class="w-12 h-12 rounded-2xl bg-emerald-600 flex items-center justify-center font-black text-xl text-white shadow-md">
                        {{ mb_substr($garage->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <h1 class="text-lg font-black tracking-tight text-white flex items-center gap-2">
                        {{ $garage->name }}
                    </h1>
                    <p class="text-[11px] font-bold text-emerald-400 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        {{ $garage->city ? ($garage->city . ' - ' . $garage->address) : 'Detailing & Wrap Studio' }}
                    </p>
                </div>
            </a>

            <div class="flex items-center gap-4">
                @if($garage->phone)
                    <a href="tel:{{ $garage->phone }}" class="px-4 py-2 rounded-full text-xs font-bold bg-gray-900 border border-gray-800 text-gray-200 hover:bg-gray-800 transition">
                        <span>{{ $garage->phone }}</span>
                    </a>
                @endif
                <a href="#services" class="px-6 py-2.5 rounded-full text-xs font-black text-white bg-emerald-600 hover:bg-emerald-500 transition shadow-lg shadow-emerald-600/20">
                    Shërbimet
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden py-16 lg:py-24 border-b border-gray-800/60 bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7">
                    <span class="inline-block px-4 py-1.5 rounded-full text-xs font-black text-emerald-400 bg-emerald-950/60 border border-emerald-800/40 mb-6">
                        Servis Zyrtar • {{ $garage->name }}
                    </span>
                    <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-white mb-6 leading-tight">
                        Përkujdesje Premium për Automjetin Tuaj në <span class="text-emerald-500">{{ $garage->name }}</span>
                    </h1>
                    <p class="text-base sm:text-lg text-gray-400 max-w-xl mb-8 font-medium leading-relaxed">
                        Shërbime profesionale detailing, me pellicolë wrapping, mbrojtje me ceramikë dhe pastrim të specializuar.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="#contact" class="px-8 py-4 rounded-full font-black text-sm text-white bg-emerald-600 hover:bg-emerald-500 transition shadow-xl shadow-emerald-600/20">
                            Na Kontaktoni ↗
                        </a>
                        <a href="#services" class="px-8 py-4 rounded-full font-extrabold text-sm text-gray-200 bg-gray-900 border border-gray-800 hover:bg-gray-800 transition">
                            Shiko Shërbimet
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="p-8 rounded-[2.5rem] bg-gray-900 border border-gray-800 shadow-2xl space-y-6">
                        <h3 class="text-xs font-black uppercase tracking-widest text-emerald-400">Rreth Servisit</h3>
                        <div class="space-y-4 text-xs font-bold text-gray-300">
                            <div class="p-4 bg-gray-950 rounded-2xl border border-gray-800/80 flex items-center justify-between">
                                <span class="text-gray-400">Qyteti / Adresa:</span>
                                <span class="text-white font-extrabold">{{ $garage->city ?? 'Tiranë' }} {{ $garage->address ? '('.$garage->address.')' : '' }}</span>
                            </div>
                            <div class="p-4 bg-gray-950 rounded-2xl border border-gray-800/80 flex items-center justify-between">
                                <span class="text-gray-400">Telefoni:</span>
                                <span class="text-white font-extrabold">{{ $garage->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="p-4 bg-gray-950 rounded-2xl border border-gray-800/80 flex items-center justify-between">
                                <span class="text-gray-400">Email:</span>
                                <span class="text-white font-extrabold">{{ $garage->email ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="mb-12">
            <span class="text-xs font-black uppercase tracking-widest text-emerald-400">Shërbimet</span>
            <h2 class="text-3xl font-black text-white tracking-tight mt-1">Shërbimet e Ofruara te {{ $garage->name }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($services as $service)
                <div class="p-6 rounded-[2rem] bg-gray-900 border border-gray-800 flex flex-col justify-between hover:border-emerald-600/50 transition">
                    <div>
                        <h4 class="font-black text-lg text-white mb-2">{{ $service->name }}</h4>
                        <p class="text-xs text-gray-400 leading-relaxed italic">{{ $service->description ?? 'Shërbim profesional detailing' }}</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-gray-800 flex items-center justify-between">
                        <span class="text-xs text-gray-500 font-bold">Çmimi Bazë</span>
                        <span class="text-lg font-black text-emerald-400">€{{ number_format($service->base_price, 2) }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-8 text-center text-gray-500 font-bold text-sm bg-gray-900 rounded-3xl border border-gray-800">
                    Shërbimet po përditësohen.
                </div>
            @endforelse
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-10 bg-gray-950 border-t border-gray-800 text-gray-400 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <span>© {{ date('Y') }} {{ $garage->name }} — Të gjitha të drejtat e rezervuara.</span>
            <a href="{{ route('login') }}" class="hover:text-white transition">Paneli Admin</a>
        </div>
    </footer>

</body>
</html>

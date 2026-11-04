<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-xs leading-5 font-black text-gray-800 hover:border-gray-300 hover:text-gray-900 shadow-2xs dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
        <x-heroicon-o-building-office-2 class="size-4 text-blue-600 dark:text-blue-400" />
        <span class="hidden sm:inline">
            @if($activeGarageId)
                {{ $garages->firstWhere('id', $activeGarageId)?->name ?? 'Zgjidh Garazhin' }}
            @else
                Zgjidh Garazhin
            @endif
        </span>
        <x-heroicon-o-chevron-down class="size-3 text-gray-400" />
    </button>

    <div x-show="open" @click.away="open = false" x-cloak
         class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-700 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-600 z-50 overflow-hidden">
        <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
            <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Garazhet e Tuaja</span>
        </div>
        <div class="max-h-60 overflow-y-auto divide-y divide-gray-50 dark:divide-gray-600">
            @foreach($garages as $garage)
                <button wire:click="switchGarage({{ $garage->id }})"
                        class="w-full text-left px-4 py-3 text-xs flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors {{ $activeGarageId == $garage->id ? 'bg-blue-50 dark:bg-blue-900/30 font-extrabold text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-200' }}">
                    <span>{{ $garage->name }}</span>
                    @if($activeGarageId == $garage->id)
                        <x-heroicon-o-check class="size-4 text-blue-600 dark:text-blue-400" />
                    @endif
                </button>
            @endforeach
        </div>
        @if($garages->isEmpty())
            <div class="px-4 py-3 text-xs text-gray-500 italic">
                Nuk u gjet asnjë garazh.
            </div>
        @endif
    </div>
</div>

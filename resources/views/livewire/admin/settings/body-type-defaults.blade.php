<div class="space-y-10">
    <div class="flex items-center justify-between gap-4 px-1">
        <div>
            <x-h1>Menaxhimi i Modeleve Vizuale</x-h1>
            <x-short-description class="dark:text-gray-400">Ngarkoni Imazhe 2D (.png) për çdo lloj karrocerie për konfiguratorin.</x-short-description>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($items as $item)
            <div class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] shadow-sm border border-gray-50 dark:border-gray-700">
                <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-50 dark:border-gray-700">
                    <span class="text-sm font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest">{{ $item->body_type }}</span>
                </div>

                <div class="space-y-6">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Imazh 2D (.PNG / TRANSPARENT)</label>

                    @if($item->image_2d_path)
                        <div class="relative group aspect-video bg-gray-50 dark:bg-gray-900 rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700">
                            <img src="{{ asset('storage/' . $item->image_2d_path) }}" class="w-full h-full object-contain">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button wire:click="delete({{ $item->id }}, '2d')" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 shadow-lg">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="aspect-video bg-gray-50 dark:bg-gray-900/50 rounded-3xl flex flex-col items-center justify-center border-2 border-dashed border-gray-100 dark:border-gray-700">
                            <x-heroicon-o-photo class="w-8 h-8 text-gray-200 mb-2" />
                            <span class="text-[9px] font-bold text-gray-400 uppercase">Jo Imazh</span>
                        </div>
                    @endif

                    <div class="space-y-3">
                        <input type="file" wire:model.live="uploads2d.{{ $item->id }}" class="text-[10px] text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-gray-700 dark:file:text-gray-300 w-full cursor-pointer">
                        <div wire:loading wire:target="uploads2d.{{ $item->id }}" class="text-[9px] font-black text-blue-600 animate-pulse uppercase">Duke u ngarkuar...</div>
                    </div>
                </div>

                @if(isset($uploads2d[$item->id]))
                    <div class="mt-8">
                        <x-button wire:click="save({{ $item->id }})" variant="blue" class="w-full !py-3 !text-[11px] !font-black uppercase tracking-widest !rounded-2xl shadow-xl shadow-blue-500/20">
                            RUAI IMAZHIN
                        </x-button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

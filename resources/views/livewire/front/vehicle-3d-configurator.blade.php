@php
    $selectedType = $this->selectedType;
    $selectedMaterial = $this->selectedMaterial;
@endphp

<div class="grid grid-cols-1 gap-8 rounded-[3rem] bg-white p-4 dark:bg-gray-900 lg:grid-cols-4 lg:p-8">
    <!-- Visualizer Area -->
    <div class="relative min-h-[550px] overflow-hidden rounded-[2.5rem] border border-gray-100 bg-[#fdfdfd] dark:bg-gray-800 lg:col-span-3 flex items-center justify-center shadow-inner">

        <div class="relative w-full max-w-5xl h-full flex items-center justify-center p-8" style="isolation: isolate;">
            @if($selectedType && $selectedType->image_2d_path)
                <!-- BASE CAR IMAGE (Always there) -->
                @php
                    $imgPath = asset($selectedType->image_2d_path);
                @endphp
                <img src="{{ $imgPath }}"
                     class="relative w-full h-auto max-h-[450px] object-contain pointer-events-none"
                     style="filter: grayscale(1) brightness(1.05); z-index: 1;">

                <!-- COLOR OVERLAY (The Magic Layer) -->
                @if($selectedMaterial)
                    <div class="absolute inset-0 m-auto w-full h-auto max-h-[450px] transition-all duration-700"
                         style="mix-blend-mode: multiply;
                                -webkit-mask-image: url('{{ $imgPath }}');
                                mask-image: url('{{ $imgPath }}');
                                -webkit-mask-size: contain; mask-size: contain;
                                -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat;
                                -webkit-mask-position: center; mask-position: center;
                                z-index: 2;">
                    </div>

                    <!-- HIGHLIGHTS & REFLECTIONS (Makes it look like real wrap) -->
                    <img src="{{ $imgPath }}"
                         class="absolute inset-0 m-auto w-full h-auto max-h-[450px] object-contain pointer-events-none"
                         style="mix-blend-mode: screen; opacity: 0.3; filter: grayscale(1) contrast(1.5) brightness(1.2); z-index: 3;">
                @endif
            @else
                <div class="text-center space-y-4">
                    <div class="w-20 h-20 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <x-heroicon-o-truck class="w-10 h-10 text-gray-200" />
                    </div>
                    <p class="text-[11px] font-black uppercase tracking-[0.3em] text-gray-400">Përzgjidhni karrocerinë</p>
                </div>
            @endif
        </div>

        <!-- Material Label (Apple Style) -->
        @if($selectedMaterial)
            <div class="absolute bottom-10 left-10 flex items-center gap-4 bg-white/80 dark:bg-gray-900/80 backdrop-blur-2xl px-6 py-3.5 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-2xl z-50 animate-in fade-in slide-in-from-bottom-5">
                <div class="flex flex-col">
                    <span class="text-[11px] font-black uppercase tracking-widest dark:text-white">{{ $selectedMaterial->name }}</span>
                    <span class="text-[8px] font-bold text-blue-600 uppercase tracking-tighter">Premium Wrap Vinyl</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Controls Area -->
    <div class="flex flex-col h-full space-y-12 py-4">
        <!-- Body Type -->
        <div>
            <h3 class="text-[10px] font-black uppercase tracking-[0.25em] text-gray-400 mb-8 flex items-center gap-2">
                <span class="w-8 h-[1px] bg-gray-200"></span>
                Karroceria
            </h3>
            <div class="grid grid-cols-2 gap-4">
                @foreach($this->bodyTypes as $type)
                    <button wire:click="selectType({{ $type->id }})"
                            class="group relative p-5 rounded-[2rem] border-2 transition-all duration-500 {{ $selectedBodyTypeId == $type->id ? 'border-blue-600 bg-blue-50/30 dark:bg-blue-900/20 shadow-lg' : 'border-gray-50 bg-gray-50/20 dark:border-gray-800 hover:border-gray-200' }}">
                        <span class="block text-[11px] font-black dark:text-white uppercase tracking-tight transition-colors group-hover:text-blue-600">{{ $type->body_type }}</span>
                        @if($type->image_2d_path)
                            <div class="absolute top-2 right-2 w-1.5 h-1.5 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.6)]"></div>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Materials -->
        <div class="flex-1">
            <h3 class="text-[10px] font-black uppercase tracking-[0.25em] text-gray-400 mb-8 flex items-center gap-2">
                <span class="w-8 h-[1px] bg-gray-200"></span>
                Materiali
            </h3>
            <div class="grid grid-cols-4 gap-4">
                @foreach($this->materials as $material)
                    <button wire:click="selectMaterial({{ $material->id }})"
                            title="{{ $material->name }}"
                            class="group relative aspect-square w-full rounded-full border-2 p-1.5 transition-all duration-500 hover:scale-115 {{ $selectedMaterialId == $material->id ? 'border-blue-600 ring-8 ring-blue-500/5' : 'border-transparent' }}">
                        <div class="w-full h-full rounded-full shadow-xl transition-transform bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden">
                            @if($material->image)
                                <img src="{{ asset($material->image) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-[8px] font-black text-gray-400">{{ substr($material->name, 0, 1) }}</span>
                            @endif
                        </div>
                        @if($selectedMaterialId == $material->id)
                             <div class="absolute -top-1 -right-1 bg-blue-600 text-white rounded-full p-1 shadow-lg border-2 border-white">
                                <x-heroicon-s-check class="w-2.5 h-2.5" />
                             </div>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>

        <x-button variant="blue" class="w-full !rounded-[2rem] !py-6 !text-[12px] !font-black uppercase tracking-[0.2em] shadow-2xl shadow-blue-500/30 hover:scale-[1.03] active:scale-95 transition-all">
            Rezervo Tani
        </x-button>
    </div>
</div>

<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-1">
        <div>
            <x-h1>{{ __('workdesk.Work Desk') }}</x-h1>
            <x-short-description>{{ __('workdesk.Description') }}</x-short-description>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- POS Grid Section --}}
        <div class="xl:col-span-2 space-y-6">
            <x-card>
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div class="flex p-1 bg-gray-100 dark:bg-gray-900 rounded-2xl overflow-x-auto custom-scrollbar max-w-full">
                        <button wire:click="$set('posCategory', 'All')" class="whitespace-nowrap px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all {{ $posCategory == 'All' ? 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm' : 'text-gray-400' }}">{{ __('workdesk.All') }}</button>
                        <button wire:click="$set('posCategory', 'Service')" class="whitespace-nowrap px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all {{ $posCategory == 'Service' ? 'bg-white dark:bg-gray-700 text-emerald-600 shadow-sm' : 'text-gray-400' }}">{{ __('workdesk.Services') }}</button>
                        <button wire:click="$set('posCategory', 'Material')" class="whitespace-nowrap px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all {{ $posCategory == 'Material' ? 'bg-white dark:bg-gray-700 text-blue-600 shadow-sm' : 'text-gray-400' }}">{{ __('workdesk.Materials') }}</button>
                        <button wire:click="$set('posCategory', 'Part')" class="whitespace-nowrap px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all {{ $posCategory == 'Part' ? 'bg-white dark:bg-gray-700 text-orange-600 shadow-sm' : 'text-gray-400' }}">{{ __('workdesk.Parts') }}</button>
                    </div>
                    <div class="relative flex-1 max-w-xs">
                        <x-heroicon-o-magnifying-glass class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-gray-400" />
                        <input type="text" wire:model.live.debounce.300ms="posSearch" placeholder="{{ __('workdesk.Search POS') }}" class="w-full pl-10 pr-4 py-2.5 text-xs font-bold bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-blue-500/20 dark:text-white">
                    </div>
                </div>

                <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 gap-2">
                    @foreach($posItems as $pItem)
                        @php
                            $isOutOfStock = $pItem['stock'] !== null && $pItem['stock'] <= 0;
                        @endphp
                        <button type="button"
                            wire:click="addPosItem('{{ $pItem['type_label'] }}', {{ $pItem['id'] }})"
                            @if($isOutOfStock) disabled @endif
                            class="group flex flex-col items-center p-1.5 bg-gray-50 dark:bg-gray-900/50 border border-transparent {{ $isOutOfStock ? 'opacity-50 cursor-not-allowed grayscale-[0.5]' : 'hover:border-blue-500/30 hover:bg-white dark:hover:bg-gray-800' }} rounded-xl transition-all relative overflow-hidden">
                            <div class="w-full aspect-square rounded-lg bg-white dark:bg-gray-800 shadow-sm overflow-hidden flex items-center justify-center border border-gray-100 dark:border-gray-700 shrink-0 {{ !$isOutOfStock ? 'group-hover:scale-105' : '' }} transition-transform text-gray-400">
                                @if($pItem['image'])
                                    <img src="{{ asset($pItem['image']) }}" class="w-full h-full object-cover">
                                @else
                                    @if($pItem['type_label'] == 'Service') <x-heroicon-o-wrench-screwdriver class="size-5 text-emerald-500/30" />
                                    @elseif($pItem['type_label'] == 'Material') <x-heroicon-o-square-3-stack-3d class="size-5 text-blue-500/30" />
                                    @else <x-heroicon-o-cog-6-tooth class="size-5 text-orange-500/30" /> @endif
                                @endif
                            </div>
                            @if($pItem['stock'] !== null)
                                <div class="absolute top-2 right-2">
                                    <span class="px-1.5 py-0.5 {{ $pItem['stock'] <= 0 ? 'bg-red-500 text-white' : 'bg-white/90 dark:bg-gray-800/90 text-gray-900 dark:text-white border border-gray-100 dark:border-gray-700' }} backdrop-blur-sm rounded-lg shadow-sm text-[9px] font-black tracking-tighter">
                                        {{ number_format($pItem['stock'], 1) }}{{ $pItem['type_label'] == 'Material' ? 'm' : '' }}
                                    </span>
                                </div>
                            @endif
                            <div class="flex flex-col text-center w-full mt-1.5 min-h-[2.5rem] justify-start">
                                <span class="text-[8px] font-black uppercase text-gray-900 dark:text-white leading-tight line-clamp-2 mb-0.5">{{ $pItem['name'] }}</span>
                                <div class="mt-auto flex flex-col items-center">
                                    <x-ui.price :value="$pItem['sell_price']" size="xs" />
                                </div>
                            </div>
                            <div class="absolute top-2 left-2">
                                <div class="size-1.5 rounded-full {{ $pItem['type_label'] == 'Service' ? 'bg-emerald-500' : ($pItem['type_label'] == 'Material' ? 'bg-blue-500' : 'bg-orange-500') }}"></div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </x-card>

            {{-- Selected Items List --}}
            <x-card>
                <div class="flex items-center justify-between mb-6 ml-1">
                    <div class="ui-section-header !text-slate-900 dark:!text-white !mb-0">{{ __('workdesk.Job Content') }}</div>
                    <div class="flex flex-col items-end">
                        <span class="px-3 py-1 bg-slate-900/10 dark:bg-white/10 rounded-xl text-[9px] font-black uppercase tracking-widest text-slate-900 dark:text-white">{{ count($items) }} {{ __('workdesk.Items') }}</span>
                        @error('items') <span class="text-[9px] font-bold text-red-500 dark:text-red-400 uppercase mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse($items as $index => $i)
                        <div class="flex flex-col md:flex-row p-4 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-3xl gap-4">
                            <div class="flex items-center gap-4">
                                <div class="size-10 rounded-xl bg-white dark:bg-gray-800 flex items-center justify-center text-gray-400 shrink-0">
                                    @if($i['type'] == 'Service') <x-heroicon-o-wrench-screwdriver class="size-5 text-emerald-500" />
                                    @elseif($i['type'] == 'Material') <x-heroicon-o-square-3-stack-3d class="size-5 text-blue-500" />
                                    @else <x-heroicon-o-cog-6-tooth class="size-5 text-orange-500" /> @endif
                                </div>
                                <div class="flex flex-col text-left">
                                    <span class="text-xs font-bold dark:text-white">{{ $i['name'] }}</span>
                                    <span class="text-[9px] text-gray-400 uppercase font-black">{{ $i['brand'] }}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 md:flex md:items-center gap-2 md:gap-8 flex-1 w-full md:justify-end">
                                <div class="flex flex-col">
                                    <label class="ui-label mb-1">{{ __('workdesk.Quantity') }}</label>
                                    <div class="flex items-center bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden shrink-0">
                                        <button type="button" wire:click="decrementQuantity({{ $index }})" class="p-1.5 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-gray-400">
                                            <x-heroicon-o-minus class="size-3" />
                                        </button>
                                        <input type="number" step="0.1" wire:model.live.debounce.500ms="items.{{ $index }}.quantity" class="w-10 p-0 text-center text-xs font-black bg-transparent border-none focus:ring-0 dark:text-white [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        <button type="button" wire:click="incrementQuantity({{ $index }})" class="p-1.5 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-gray-400">
                                            <x-heroicon-o-plus class="size-3" />
                                        </button>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <label class="ui-label mb-1">{{ __('workdesk.Price') }}</label>
                                    <input type="number" step="1" wire:model.live.debounce.500ms="items.{{ $index }}.sell_price" class="w-full md:w-16 p-2 text-center text-xs font-bold bg-white dark:bg-gray-800 border-none rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500/20">
                                </div>
                                <div class="flex flex-col items-center md:items-end justify-center">
                                    <label class="ui-label mb-1">{{ __('workdesk.Total') }}</label>
                                    <x-ui.price :value="(float)($i['quantity'] ?: 0) * (float)($i['sell_price'] ?: 0)" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end md:ml-4">
                                <button type="button" wire:click="removeItem({{ $index }})" class="p-2 text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                                    <x-heroicon-o-trash class="size-4 md:size-5" />
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="py-10 text-center border-2 border-dashed border-gray-100 dark:border-gray-700 rounded-2xl">
                            <p class="text-[10px] font-black uppercase text-gray-300 tracking-widest">{{ __('workdesk.Add services or materials from the list above') }}</p>
                        </div>
                    @endforelse
                </div>
            </x-card>
        </div>

        {{-- Sidebar: Intake Info --}}
        <div class="space-y-6">
            <x-card>
                <div class="ui-section-header !text-emerald-600 dark:!text-emerald-400">{{ __('workdesk.Vehicle Registration') }}</div>

                @include('errors.errors')

                <form wire:submit.prevent="saveReception" class="space-y-4">
                    <div class="space-y-1 !mb-4">
                        <div class="flex items-center justify-between mb-1.5 ml-1">
                            <label class="ui-label !mb-0">{{ __('workdesk.Select Client') }}</label>
                            <x-modal :modalTitle="__('workdesk.Add New Client')">
                                <x-slot name="trigger">
                                    <button type="button" class="text-blue-600 text-[9px] font-black uppercase tracking-widest hover:underline">+ {{ __('workdesk.New') }}</button>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="p-6">
                                        <div class="space-y-4">
                                            <x-form.input wire:model="new_client_name" :label="__('workdesk.Name and Surname')" :placeholder="__('workdesk.Client name...')" />
                                            @error('new_client_name') <span class="text-[10px] font-bold text-red-500 uppercase">{{ $message }}</span> @enderror
                                            <x-form.input wire:model="new_client_phone" :label="__('workdesk.Phone Number')" placeholder="06X XXX XXXX" />
                                        </div>
                                        <div class="mt-8 flex justify-end"><x-button wire:click="addClient" variant="blue">{{ __('admin.Save') }}</x-button></div>
                                    </div>
                                </x-slot>
                            </x-modal>
                        </div>
                        <x-form.dropdown-search wire:model.live="client_id" :data="$clients" label="none" placeholder="{{ __('workdesk.Select Client') }}..." class="!mb-0" />
                        @error('client_id') <span class="text-[10px] font-bold text-red-500 uppercase ml-1">{{ $message }}</span> @enderror

                        @if(count($clientCars) > 0)
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach($clientCars as $cCar)
                                    <button type="button"
                                        wire:click="selectCar({{ $cCar['id'] }})"
                                        class="px-3 py-1 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl text-[9px] font-black uppercase tracking-tighter hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 transition-all {{ $license_plate == $cCar['license_plate'] ? 'ring-2 ring-blue-500/20 bg-blue-50 dark:bg-blue-900/20 text-blue-600' : 'text-gray-400' }}">
                                        {{ $cCar['license_plate'] }}
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4 !mb-4">
                        <div class="space-y-1">
                            <div class="flex items-center justify-between mb-1.5 ml-1">
                                <label class="ui-label !mb-0">{{ __('workdesk.Brand') }}</label>
                                <x-modal :modalTitle="__('workdesk.Add New Brand')">
                                    <x-slot name="trigger">
                                        <button type="button" class="text-blue-600 text-[9px] font-black uppercase tracking-widest hover:underline">+ {{ __('workdesk.New') }}</button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <div class="p-6">
                                            <div class="space-y-4">
                                                <x-form.input wire:model="new_brand_name" :label="__('workdesk.Brand Name')" :placeholder="__('workdesk.e.g. BMW, Audi...')" />
                                                @error('new_brand_name') <span class="text-[10px] font-bold text-red-500 uppercase">{{ $message }}</span> @enderror
                                                <x-form.file-upload wire:model="new_brand_logo" :label="__('workdesk.Brand Logo')" id="new-brand-logo">
                                                    @if ($new_brand_logo)
                                                        <div class="mt-4 flex justify-center">
                                                            <img src="{{ $new_brand_logo->temporaryUrl() }}" class="size-20 object-contain rounded-xl border border-gray-100 dark:border-gray-700 p-2 bg-white dark:bg-gray-800 shadow-sm">
                                                        </div>
                                                    @endif
                                                </x-form.file-upload>
                                            </div>
                                            <div class="mt-8 flex justify-end"><x-button wire:click="addBrand" variant="blue">{{ __('admin.Save') }}</x-button></div>
                                        </div>
                                    </x-slot>
                                </x-modal>
                            </div>
                            <x-form.dropdown-search wire:key="brand-dropdown" wire:model.live="brand_id" :data="$brands" label="none" placeholder="{{ __('workdesk.Brand') }}..." class="!mb-0" />
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center justify-between mb-1.5 ml-1">
                                <label class="ui-label !mb-0">{{ __('workdesk.Model') }}</label>
                                @if($brand_id)
                                <x-modal :modalTitle="__('workdesk.Add New Model')">
                                    <x-slot name="trigger">
                                        <button type="button" class="text-blue-600 text-[9px] font-black uppercase tracking-widest hover:underline">+ {{ __('workdesk.New') }}</button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <div class="p-6">
                                            <div class="space-y-4">
                                                <x-form.input wire:model="new_model_name" :label="__('workdesk.Model Name')" :placeholder="__('workdesk.e.g. BMW, Audi...')" />
                                                @error('new_model_name') <span class="text-[10px] font-bold text-red-500 uppercase">{{ $message }}</span> @enderror

                                                <div>
                                                    <div class="flex items-center justify-between mb-1.5 ml-1">
                                                        <label class="text-[10px] font-bold uppercase tracking-widest text-gray-900 dark:text-gray-100">{{ __('vehicle-models.Body Type') }}</label>
                                                        <x-modal>
                                                            <x-slot name="trigger">
                                                                <button type="button" class="text-blue-600 text-[9px] font-black uppercase tracking-widest hover:underline">i Guide</button>
                                                            </x-slot>
                                                            <x-slot name="modalTitle"><div class="px-6 pt-6 dark:text-white">{{ __('vehicle-models.Body Type Guide') }}</div></x-slot>
                                                            <x-slot name="content">
                                                                <div class="p-6">
                                                                    <img src="{{ asset('images/wrap-guide.jpg') }}" class="w-full rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                                                                </div>
                                                            </x-slot>
                                                        </x-modal>
                                                    </div>
                                                    <x-form.dropdown-search wire:model.live="new_model_body_type_id" :data="$bodyTypes" label="none" placeholder="{{ __('vehicle-models.Select Type') }}..." />
                                                </div>

                                                <x-form.input wire:model="new_model_meters" type="number" step="0.1" :label="__('workdesk.Film Meters (for wrapping)')" placeholder="20.0" />
                                            </div>
                                            <div class="mt-8 flex justify-end"><x-button wire:click="addModel" variant="blue">{{ __('admin.Save') }}</x-button></div>
                                        </div>
                                    </x-slot>
                                </x-modal>
                                @endif
                            </div>
                            <x-form.dropdown-search wire:key="model-dropdown-{{ $brand_id }}" wire:model.live="model_id" :data="$models" label="none" placeholder="{{ __('workdesk.Model') }}..." :disabled="!$brand_id" class="!mb-0" />
                        </div>
                    </div>

                    <x-form.input wire:model="license_plate" label="{{ __('workdesk.Plate') }}" placeholder="AB 123 CD" class="dark:bg-gray-900 !mb-0" wrapperClass="!mb-4" />
                    @error('license_plate') <span class="text-[10px] font-bold text-red-500 uppercase ml-1">{{ $message }}</span> @enderror

                    <div class="p-4 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-3xl mt-4">
                        <span class="ui-label !text-gray-400 !mb-0">{{ __('workdesk.Final Total') }}</span>
                        <x-ui.price :value="$total_price" size="xl" variant="slate" class="block" />
                    </div>

                    <x-button type="submit" variant="blue" size="lg" class="w-full shadow-xl shadow-blue-500/10 mt-4">{{ __('workdesk.Register Job') }}</x-button>
                </form>
            </x-card>
        </div>
    </div>

    {{-- Active Jobs Monitor Section --}}
    <div class="mt-2">
        <div class="mb-6 px-2 flex items-center gap-3">
            <div class="h-px bg-gray-100 dark:bg-gray-800 flex-1"></div>
            <div class="text-[9px] font-black uppercase text-gray-400 dark:text-gray-500 tracking-[0.2em] whitespace-nowrap">{{ __('workdesk.Active Jobs Monitoring') }} ({{ count($activeJobs) }})</div>
            <div class="h-px bg-gray-100 dark:bg-gray-800 flex-1"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-6 px-1">
            @forelse($activeJobs as $job)
                @php
                    $statusColor = $job->status == 'pending' ? 'bg-blue-600' : 'bg-orange-500';
                @endphp
                <x-card padding="p-0" class="hover:shadow-xl hover:shadow-blue-500/5 transition-all group overflow-hidden flex flex-col">
                    {{-- Top Section: License Plate & Status --}}
                    <div class="p-6 pb-4 flex items-center justify-between border-b border-gray-50 dark:border-gray-700/50 relative overflow-hidden">
                        @if($job->body_type_image)
                            <div class="absolute -bottom-2 -right-4 opacity-10 dark:opacity-20 pointer-events-none scale-150 rotate-[-15deg]">
                                <img src="{{ asset($job->body_type_image) }}" class="w-40 h-auto object-contain">
                            </div>
                        @endif
                        <div class="flex items-center gap-4 relative z-10">
                            <div class="size-14 rounded-2xl bg-slate-900 dark:bg-slate-700 flex items-center justify-center text-white font-black italic shadow-lg shadow-slate-900/10 text-xl shrink-0">
                                {{ substr($job->car?->brand?->name ?? '?', 0, 1) }}
                            </div>
                            <div class="flex flex-col">
                                <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tighter leading-none mb-1">{{ $job->car?->license_plate ?? 'N/A' }}</h3>
                                <div class="flex items-center gap-2">
                                    <span class="text-[11px] font-black text-slate-900 dark:text-slate-400 uppercase tracking-widest">{{ $job->car?->brand?->name }}</span>
                                    <span class="text-gray-300 dark:text-gray-600">•</span>
                                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-tight">{{ $job->car?->model?->name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-1.5">
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 dark:bg-gray-900/50 rounded-full border border-gray-100 dark:border-gray-700">
                                <div class="size-2 rounded-full {{ $statusColor }} animate-pulse"></div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-600 dark:text-gray-400">{{ __('workdesk.' . $job->status) }}</span>
                            </div>

                            @if($job->payment_status !== 'paid')
                                <div class="px-2 py-0.5 bg-red-500/10 dark:bg-red-500/5 border border-red-200 dark:border-red-900/50 rounded text-[7px] font-black text-red-600 dark:text-red-400 uppercase">
                                    {{ $job->payment_status == 'unpaid' ? __('workdesk.Unpaid') : __('workdesk.Partial Payment') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Middle Section: Client & Services --}}
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6 flex-1">
                        <div class="space-y-4 border-r border-gray-50 dark:border-gray-700/50 pr-6">
                            <x-ui.client-info :name="$job->car?->client?->name" :phone="$job->car?->client?->phone" :label="__('workdesk.Client')" />

                            @if($job->notes)
                            <div class="pt-2">
                                <span class="ui-label !mb-1">{{ __('workdesk.Notes') }}</span>
                                <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 line-clamp-2 italic">"{{ $job->notes }}"</p>
                            </div>
                            @endif
                        </div>

                        <div>
                            <span class="ui-label !mb-3">{{ __('workdesk.Job Content') }}</span>
                            <div class="flex flex-wrap gap-2">
                                {{-- Shërbimet --}}
                                @foreach($job->services as $s)
                                    <span class="px-3 py-1.5 bg-emerald-50/50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-xl text-[10px] font-black uppercase tracking-tighter border border-emerald-100/50 dark:border-emerald-800/30">
                                        <x-heroicon-o-wrench-screwdriver class="size-3 inline mr-1 mb-0.5" />
                                        {{ $s->service?->name }}
                                    </span>
                                @endforeach

                                {{-- Pellicolat --}}
                                @foreach($job->materials as $m)
                                    <span class="px-3 py-1.5 bg-blue-50/50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-xl text-[10px] font-black uppercase tracking-tighter border border-blue-100/50 dark:border-blue-800/30">
                                        <x-heroicon-o-square-3-stack-3d class="size-3 inline mr-1 mb-0.5" />
                                        {{ $m->material?->name }} ({{ number_format($m->quantity, 1) }}m)
                                    </span>
                                @endforeach

                                {{-- Pjesët --}}
                                @foreach($job->parts as $p)
                                    <span class="px-3 py-1.5 bg-orange-50/50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 rounded-xl text-[10px] font-black uppercase tracking-tighter border border-orange-100/50 dark:border-orange-800/30">
                                        <x-heroicon-o-cog-6-tooth class="size-3 inline mr-1 mb-0.5" />
                                        {{ $p->part?->name }}
                                    </span>
                                @endforeach

                                @if($job->services->count() + $job->materials->count() + $job->parts->count() == 0)
                                    <span class="text-[10px] font-black text-slate-300 uppercase italic tracking-widest">{{ __('workdesk.No active elements') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Bottom Section: Financials & Actions --}}
                    <div class="p-6 bg-slate-50/30 dark:bg-slate-900/30 border-t border-slate-50 dark:border-slate-800 space-y-4">
                        {{-- Financial Summary --}}
                        <div class="flex items-center gap-3">
                            <div class="flex-1 bg-white dark:bg-slate-800 px-4 py-2.5 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm text-center sm:text-left">
                                <span class="ui-label !text-[8px] !mb-0.5">{{ __('workdesk.Total') }}</span>
                                <x-ui.price :value="$job->gross_revenue" size="md" variant="slate" />
                            </div>
                            <div class="flex-1 bg-white dark:bg-slate-800 px-4 py-2.5 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm text-center sm:text-left">
                                <span class="ui-label !text-[8px] !mb-0.5">{{ __('workdesk.Remaining') }}</span>
                                <x-ui.price :value="$job->remaining_balance" size="md" :variant="$job->remaining_balance > 0 ? 'orange' : 'slate'" />
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-2">
                            <div class="flex-1 flex items-center justify-between gap-1 p-1 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm">
                                <button wire:click="sendEmail({{ $job->id }})" title="{{ __('workdesk.Send by Email') }}" class="relative p-2 text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-900/20 rounded-xl transition-all">
                                    <x-heroicon-o-envelope class="size-5" />
                                    @if($job->email_sent_at)
                                        <span class="absolute top-1 right-1 flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                        </span>
                                    @endif
                                </button>
                                <a href="{{ $job->whatsapp_url }}" target="_blank" wire:click="markWhatsAppSent({{ $job->id }})" title="{{ __('workdesk.Send via WhatsApp') }}" class="relative p-2 text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-xl transition-all">
                                    <x-heroicon-o-chat-bubble-left-right class="size-5" />
                                    @if($job->whatsapp_sent_at)
                                        <span class="absolute top-1 right-1 flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                        </span>
                                    @endif
                                </a>
                                <a href="{{ route('admin.jobs.print', $job) }}" target="_blank" title="{{ __('workdesk.Print Invoice') }}" class="p-2 text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl transition-all">
                                    <x-heroicon-o-printer class="size-5" />
                                </a>
                                <x-a :href="route('admin.jobs.edit', $job)" title="{{ __('workdesk.Edit Details') }}" class="!p-2 !bg-transparent !text-slate-400 hover:!text-slate-900 dark:hover:!text-white hover:!bg-slate-50 dark:hover:!bg-slate-700 !rounded-xl !border-none transition-all">
                                    <x-heroicon-o-pencil-square class="size-5" />
                                </x-a>
                                <button wire:click="openExpenseModal({{ $job->id }})" title="{{ __('workdesk.Add Quick Expense') }}" class="p-2 text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all">
                                    <x-heroicon-o-minus-circle class="size-5" />
                                </button>
                            </div>

                            <x-button
                                wire:click="openCompletionModal({{ $job->id }})"
                                title="{{ __('workdesk.Close Job & Payment') }}"
                                variant="slate"
                                class="h-[52px] px-6"
                            >
                                <x-heroicon-o-check-circle class="size-5" />
                                <span>{{ __('workdesk.Close') }}</span>
                            </x-button>
                        </div>
                    </div>
                </x-card>
            @empty
                <x-card padding="py-24" rounded="rounded-[3rem]" border="border-2 border-dashed border-gray-100 dark:border-gray-700" class="col-span-full text-center">
                    <div class="size-20 bg-gray-50 dark:bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                        <x-heroicon-o-clipboard-document-list class="size-10" />
                    </div>
                    <p class="text-xs font-black uppercase text-gray-300 tracking-[0.4em]">{{ __('workdesk.No active jobs in process') }}</p>
                </x-card>
            @endforelse
        </div>
    </div>

    {{-- Completion & Payment Modal --}}
    <x-modal>
        <x-slot name="trigger">
            <div x-on:open-modal.window="if($event.detail.id === 'completion-modal') on = true"></div>
        </x-slot>

        <x-slot name="modalTitle">
            <div class="p-6 pb-0 dark:text-white flex items-center gap-3">
                <div class="size-10 rounded-2xl bg-slate-900 flex items-center justify-center text-white shadow-lg shadow-slate-900/20">
                    <x-heroicon-o-banknotes class="size-5" />
                </div>
                <div>
                    <h3 class="text-lg font-black uppercase tracking-tight">{{ __('workdesk.Job Completion & Payment') }}</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ __('workdesk.Financial summary and cash registration') }}</p>
                </div>
            </div>
        </x-slot>

        <x-slot name="content">
            @if($job_to_complete)
            <div class="p-6 space-y-6">
                {{-- Client & Car Info Card --}}
                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-[2rem] p-5 border border-gray-100 dark:border-gray-800">
                    <div class="grid grid-cols-2 gap-4">
                        <x-ui.client-info :name="$job_to_complete->car?->client?->name" :phone="$job_to_complete->car?->client?->phone" :label="__('workdesk.Client')" />
                        <div class="text-right">
                            <span class="ui-label !text-[8px] !mb-1">{{ __('workdesk.Vehicle') }}</span>
                            <p class="text-xs font-black dark:text-white uppercase">{{ $job_to_complete->car?->license_plate }}</p>
                            <p class="text-[9px] text-gray-400 font-bold uppercase">{{ $job_to_complete->car?->brand?->name }} {{ $job_to_complete->car?->model?->name }}</p>
                        </div>
                    </div>
                </div>

                {{-- Financial Summary --}}
                <div class="grid grid-cols-3 gap-3">
                    <x-stat-box :label="__('workdesk.Total')" :value="'€' . number_format($job_to_complete->gross_revenue, 0)" />
                    <x-stat-box :label="__('workdesk.Paid')" :value="'€' . number_format($job_to_complete->paid_amount, 0)" valueColor="text-emerald-500" labelColor="text-emerald-500" />
                    <x-stat-box variant="slate" :label="__('workdesk.Remaining')" :value="'€' . number_format($job_to_complete->remaining_balance, 0)" />
                </div>

                {{-- Payment Form --}}
                <div class="space-y-4 pt-2">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="ui-label !mb-0">{{ __('workdesk.Payment Amount') }}</label>
                            <x-form.input type="number" wire:model="payment_amount" label="none" placeholder="0.00" class="!py-4" />
                        </div>
                        <div class="space-y-1">
                            <label class="ui-label !mb-0">{{ __('workdesk.Method') }}</label>
                            <select wire:model="payment_method" class="w-full bg-gray-50 dark:bg-gray-900 dark:text-gray-200 border border-gray-200 dark:border-gray-700 rounded-2xl py-4 px-4 focus:ring-2 focus:ring-blue-500/20 transition-none text-xs font-bold">
                                <option value="cash">{{ __('workdesk.Cash') }}</option>
                                <option value="card">{{ __('workdesk.Card') }}</option>
                                <option value="transfer">{{ __('workdesk.Transfer') }}</option>
                            </select>
                        </div>
                    </div>

                    <label class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-800 cursor-pointer group">
                        <input type="checkbox" wire:model="should_complete" class="size-5 rounded-lg border-gray-300 text-slate-900 focus:ring-slate-500/20 transition-all">
                        <div class="flex flex-col">
                            <span class="ui-label !mb-0 !text-gray-900 dark:!text-white">{{ __('workdesk.Close Job Status') }}</span>
                            <span class="text-[8px] text-gray-400 font-bold uppercase">{{ __('workdesk.Mark as completed in the system') }}</span>
                        </div>
                    </label>
                </div>
            </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <div class="p-6 pt-0 flex gap-3">
                <x-button variant="gray" @click="on = false" class="flex-1">{{ __('admin.Cancel') }}</x-button>
                <x-button variant="slate" wire:click="savePaymentAndComplete" class="flex-[2] shadow-xl shadow-slate-900/20">{{ __('workdesk.Confirm & Save') }}</x-button>
            </div>
        </x-slot>
    </x-modal>

    {{-- Quick Expense Modal --}}
    <x-modal>
        <x-slot name="trigger">
            <div x-on:open-modal.window="if($event.detail.id === 'quick-expense-modal') on = true"></div>
        </x-slot>

        <x-slot name="modalTitle">
            <div class="p-6 pb-0 dark:text-white flex items-center gap-3">
                <div class="size-10 rounded-2xl bg-red-600 flex items-center justify-center text-white shadow-lg shadow-red-500/20">
                    <x-heroicon-o-minus-circle class="size-5" />
                </div>
                <div>
                    <h3 class="text-lg font-black uppercase tracking-tight">{{ __('workdesk.Add Quick Expense') }}</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ __('workdesk.Register costs directly for this job') }}</p>
                </div>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="p-6 space-y-4">
                <x-form.input wire:model="expense_title" :label="__('admin.Description')" :placeholder="__('workdesk.Transport, Extra parts...')" />

                <div class="grid grid-cols-2 gap-4">
                    <x-form.input type="number" step="0.01" wire:model="expense_amount" :label="__('expenses.Amount') . ' (€)'" placeholder="0.00" />
                    <div class="space-y-1">
                        <label class="ui-label !mb-0">{{ __('expenses.Category') }}</label>
                        <select wire:model="expense_category" class="w-full bg-gray-50 dark:bg-gray-900 dark:text-gray-200 border border-gray-200 dark:border-gray-700 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-blue-500/20 text-xs font-bold">
                            @foreach(__('expenses.categories') as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <x-form.textarea wire:model="expense_notes" :label="__('workdesk.Notes (Optional)')" placeholder="..." />
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="p-6 pt-0 flex gap-3">
                <x-button variant="gray" @click="on = false" class="flex-1">{{ __('admin.Cancel') }}</x-button>
                <x-button variant="red" wire:click="saveQuickExpense" class="flex-[2] shadow-xl shadow-red-500/20">{{ __('workdesk.Save Expense') }}</x-button>
            </div>
        </x-slot>
    </x-modal>
</div>

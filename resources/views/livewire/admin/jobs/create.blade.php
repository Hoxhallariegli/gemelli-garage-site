<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-1">
        <div>
            <x-h1>{{ __('jobs.New Job Card') }}</x-h1>
            <x-short-description>{{ __('jobs.Detailed Description') }}</x-short-description>
        </div>
        <x-back-btn route="admin.jobs.index" />
    </div>

    @include('errors.errors')

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- POS Grid Section --}}
        <div class="xl:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div class="flex p-1 bg-gray-100 dark:bg-gray-900 rounded-2xl overflow-x-auto custom-scrollbar max-w-full">
                        <button wire:click="$set('posCategory', 'All')" class="whitespace-nowrap px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all {{ $posCategory == 'All' ? 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm' : 'text-gray-400' }}">{{ __('jobs.All') }}</button>
                        <button wire:click="$set('posCategory', 'Service')" class="whitespace-nowrap px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all {{ $posCategory == 'Service' ? 'bg-white dark:bg-gray-700 text-emerald-600 shadow-sm' : 'text-gray-400' }}">{{ __('workdesk.Services') }}</button>
                        <button wire:click="$set('posCategory', 'Material')" class="whitespace-nowrap px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all {{ $posCategory == 'Material' ? 'bg-white dark:bg-gray-700 text-blue-600 shadow-sm' : 'text-gray-400' }}">{{ __('workdesk.Materials') }}</button>
                        <button wire:click="$set('posCategory', 'Part')" class="whitespace-nowrap px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all {{ $posCategory == 'Part' ? 'bg-white dark:bg-gray-700 text-orange-600 shadow-sm' : 'text-gray-400' }}">{{ __('workdesk.Parts') }}</button>
                    </div>
                    <div class="relative flex-1 max-w-xs">
                        <x-heroicon-o-magnifying-glass class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-gray-400" />
                        <input type="text" wire:model.live.debounce.300ms="posSearch" placeholder="{{ __('jobs.Search...') }}" class="w-full pl-10 pr-4 py-2.5 text-xs font-bold bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-blue-500/20 dark:text-white">
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
                                    <span class="text-[10px] font-black text-blue-600">€{{ number_format($pItem['sell_price'], 0) }}</span>
                                </div>
                            </div>
                            <div class="absolute top-2 left-2">
                                <div class="size-1.5 rounded-full {{ $pItem['type_label'] == 'Service' ? 'bg-emerald-500' : ($pItem['type_label'] == 'Material' ? 'bg-blue-500' : 'bg-orange-500') }}"></div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Selected Items List --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-6 ml-1">
                    <div class="text-[9px] md:text-[10px] font-black uppercase text-blue-600 tracking-widest md:tracking-[0.2em]">{{ __('workdesk.Job Content') }}</div>
                    <div class="flex flex-col items-end">
                        <span class="px-3 py-1 bg-blue-600/10 rounded-xl text-[9px] font-black uppercase tracking-widest text-blue-600">{{ count($items) }} {{ __('workdesk.Items') }}</span>
                        @error('items') <span class="text-[9px] font-bold text-red-500 uppercase mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse($items as $index => $i)
                        <div class="flex flex-col md:flex-row p-3 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-3xl gap-4">
                            <div class="flex items-center gap-4">
                                <div class="size-9 rounded-xl bg-white dark:bg-gray-800 flex items-center justify-center text-gray-400 shrink-0">
                                    @if($i['type'] == 'Service') <x-heroicon-o-wrench-screwdriver class="size-4 text-emerald-500" />
                                    @elseif($i['type'] == 'Material') <x-heroicon-o-square-3-stack-3d class="size-4 text-blue-500" />
                                    @else <x-heroicon-o-cog-6-tooth class="size-4 text-orange-500" /> @endif
                                </div>
                                <div class="flex flex-col text-left">
                                    <span class="text-[10px] font-bold dark:text-white">{{ $i['name'] }}</span>
                                    <span class="text-[8px] text-gray-400 uppercase font-black">{{ $i['brand'] }}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 md:flex md:items-center gap-2 md:gap-8 flex-1 w-full md:justify-end">
                                <div class="flex flex-col">
                                    <label class="text-[7px] uppercase text-gray-400 font-black mb-1">{{ __('workdesk.Quantity') }}</label>
                                    <div class="flex items-center bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden shrink-0">
                                        <button type="button" wire:click="decrementQuantity({{ $index }})" class="p-1.5 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-gray-400">
                                            <x-heroicon-o-minus class="size-3" />
                                        </button>
                                        <input type="number" step="0.1" wire:model.live.debounce.500ms="items.{{ $index }}.quantity" class="w-10 p-0 text-center text-[10px] font-black bg-transparent border-none focus:ring-0 dark:text-white [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        <button type="button" wire:click="incrementQuantity({{ $index }})" class="p-1.5 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-gray-400">
                                            <x-heroicon-o-plus class="size-3" />
                                        </button>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-[7px] uppercase text-gray-400 font-black mb-1">{{ __('workdesk.Price') }}</label>
                                    <input type="number" step="1" wire:model.live.debounce.500ms="items.{{ $index }}.sell_price" class="w-full md:w-16 p-1.5 text-center text-[10px] font-bold bg-white dark:bg-gray-800 border-none rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500/20">
                                </div>
                                <div class="flex flex-col items-center md:items-end justify-center">
                                    <label class="text-[7px] uppercase text-gray-400 font-black mb-1">{{ __('workdesk.Total') }}</label>
                                    <span class="text-[10px] font-black text-blue-600">€{{ number_format((float)($i['quantity'] ?: 0) * (float)($i['sell_price'] ?: 0), 0) }}</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-end md:ml-4">
                                <button type="button" wire:click="removeItem({{ $index }})" class="p-2 text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                                    <x-heroicon-o-trash class="size-4" />
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center border-2 border-dashed border-gray-100 dark:border-gray-700 rounded-[2rem]">
                            <p class="text-[10px] font-black uppercase text-gray-300 tracking-widest">{{ __('workdesk.Add services or materials from the list above') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar: Summary & Save --}}
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-[9px] md:text-[10px] font-black uppercase text-blue-600 tracking-widest md:tracking-[0.2em] mb-6 ml-1">{{ __('jobs.Register Job') }}</div>

                <form wire:submit.prevent="store" class="space-y-4">
                    <div class="space-y-1 !mb-4">
                        <div class="flex items-center justify-between mb-1.5 ml-1">
                            <label class="text-[10px] font-black uppercase text-gray-900 dark:text-gray-100 tracking-widest">{{ __('jobs.Client & Vehicle') }}</label>
                            <x-modal :modalTitle="__('cars.Add New Car')">
                                <x-slot name="trigger">
                                    <button type="button" class="text-blue-600 text-[9px] font-black uppercase tracking-widest hover:underline">+ {{ __('jobs.New') }}</button>
                                </x-slot>
                                <x-slot name="content"><livewire:admin.cars.quick-create /></x-slot>
                            </x-modal>
                        </div>
                        <x-form.dropdown-search name="car_id" wire:model.live="car_id" label="none" :data="$cars" :placeholder="__('jobs.Select vehicle...')" class="!mb-0" />
                        @error('car_id') <span class="text-[10px] font-bold text-red-500 uppercase ml-1">{{ $message }}</span> @enderror

                        @php $selectedCar = \App\Models\Car::find($car_id); @endphp
                        <div class="mt-2 px-4 py-3 bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-100 dark:border-blue-900/30 flex items-center justify-between overflow-hidden relative group">
                            @if($selectedCar?->body_type_image)
                                <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:opacity-20 transition-opacity scale-150 rotate-[-10deg]">
                                    <img src="{{ asset($selectedCar->body_type_image) }}" class="w-32 h-auto object-contain">
                                </div>
                            @endif
                            <div class="relative z-10 flex flex-col">
                                <span class="text-[8px] font-black text-blue-400 uppercase tracking-[0.2em] block mb-0.5">{{ __('jobs.Actual Client') }}</span>
                                <span class="text-xs font-black text-blue-600 dark:text-blue-400 uppercase tracking-tight">{{ $selectedClientName }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 !mb-4">
                        <x-form.input name="job_date" type="datetime-local" wire:model="job_date" :label="__('jobs.Job Date')" class="dark:bg-gray-900 !mb-0" wrapperClass="!mb-0" />
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase text-gray-900 dark:text-gray-100 tracking-widest ml-1">{{ __('jobs.Status') }}</label>
                            <select wire:model="status" class="w-full bg-gray-50 dark:bg-gray-900 dark:text-gray-200 border border-gray-200 dark:border-gray-700 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-blue-500/20 transition-none text-xs font-bold shadow-none">
                                <option value="pending">{{ __('workdesk.pending') }}</option>
                                <option value="in_progress">{{ __('workdesk.in_progress') }}</option>
                                <option value="completed">{{ __('workdesk.completed') }}</option>
                                <option value="cancelled">{{ __('workdesk.cancelled') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 dark:border-gray-700 space-y-3">
                        <div class="flex justify-between items-center text-[10px]">
                            <span class="font-bold text-gray-400 uppercase tracking-widest">{{ __('jobs.Services') }}</span>
                            <span class="font-black text-gray-900 dark:text-white">€{{ number_format($servicesTotal, 0) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-[10px]">
                            <span class="font-bold text-gray-400 uppercase tracking-widest">{{ __('jobs.Inventory') }}</span>
                            <span class="font-black text-gray-900 dark:text-white">€{{ number_format($inventoryTotal, 0) }}</span>
                        </div>
                        <div class="pt-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-3xl">
                            <span class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('jobs.Final Total (Revenue)') }}</span>
                            <div class="text-4xl font-black text-gray-900 dark:text-white italic tracking-tighter leading-none mb-4">€{{ number_format($totalRevenue, 0) }}</div>

                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-between items-end">
                                <div>
                                    <span class="block text-[8px] font-black text-emerald-500 uppercase tracking-widest">{{ __('jobs.Profit Margin (Est.)') }}</span>
                                    @php $jobNetProfit = $totalRevenue - $totalCost; @endphp
                                    <span class="text-xl font-black text-emerald-600 italic tracking-tighter">€{{ number_format($jobNetProfit, 0) }}</span>
                                </div>
                                <span class="text-[10px] font-black text-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-lg">
                                    {{ $totalRevenue > 0 ? number_format(($jobNetProfit / $totalRevenue) * 100, 1) : 0 }}%
                                </span>
                            </div>
                        </div>
                    </div>

                    <x-button type="submit" variant="blue" wire:loading.attr="disabled" wire:target="store" class="!w-full !py-4 !rounded-2xl !text-xs !font-black !uppercase shadow-xl shadow-blue-500/10 mt-4">
                        <span wire:loading.remove wire:target="store">{{ __('jobs.Save Job Card') }}</span>
                        <span wire:loading wire:target="store" class="flex items-center gap-2 justify-center">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </span>
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

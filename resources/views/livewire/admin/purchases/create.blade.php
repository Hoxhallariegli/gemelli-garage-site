<div class="space-y-6 md:space-y-10">
    <div class="flex items-center justify-between gap-4 px-1">
        <div>
            <x-h1>{{ __('purchases.Add Purchase') }}</x-h1>
            <x-short-description class="dark:text-gray-400">{{ __('purchases.Create Description') }}</x-short-description>
        </div>
        <x-back-btn route="admin.purchases.index" />
    </div>

    @include('errors.errors')

    <form wire:submit.prevent="store" spellcheck="false" autocomplete="off" class="grid grid-cols-1 xl:grid-cols-3 gap-6 md:gap-10 items-start">
        {{-- Main Section: Items --}}
        <div class="xl:col-span-2 space-y-6 md:space-y-8">
            {{-- Header Info Card --}}
            <div class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] shadow-sm border border-gray-50 dark:border-gray-700">
                <div class="text-[9px] md:text-[10px] font-black uppercase text-blue-600 tracking-widest md:tracking-[0.2em] mb-6 md:mb-8 ml-1">{{ __('purchases.Supply Information') }}</div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <div class="flex items-end gap-2">
                            <div class="flex-1"><x-form.dropdown-search name="supplier_id" wire:model.live="supplier_id" :label="__('purchases.Supplier')" :data="$suppliers" /></div>
                            <x-modal>
                                <x-slot name="trigger"><button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-zinc-900/30 text-blue-600 dark:text-blue-400 rounded-2xl hover:scale-105 transition-transform"><x-heroicon-o-plus class="w-5 h-5" /></button></x-slot>
                                <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">{{ __('purchases.Add New Supplier') }}</div></x-slot>
                                <x-slot name="content"><livewire:admin.suppliers.quick-create /></x-slot>
                            </x-modal>
                        </div>
                    </div>
                    <div><x-form.input name="purchase_date" type="date" wire:model="purchase_date" :label="__('purchases.Purchase Date')" class="dark:bg-gray-900" /></div>
                    <div><x-form.input name="reference_number" type="text" wire:model="reference_number" :label="__('purchases.Reference Number')" class="dark:bg-gray-900" /></div>
                </div>
            </div>

            {{-- Items Card --}}
            <div class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-8 ml-1">
                    <div class="text-[9px] md:text-[10px] font-black uppercase text-blue-600 tracking-widest md:tracking-[0.2em]">{{ __('purchases.Invoice Items') }}</div>
                    <span class="px-3 py-1 bg-blue-600/10 rounded-xl text-[9px] font-black uppercase tracking-widest text-blue-600">{{ count($items) }} {{ __('purchases.Items') }}</span>
                </div>

                {{-- Inline Add Entry --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start bg-gray-50 dark:bg-gray-900/50 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700 mb-8">
                    <div class="md:col-span-2 space-y-1">
                        <x-form.label :label="__('purchases.Item Type')" name="temp_item_type" />
                        <select wire:model.live="temp_item_type" class="block w-full bg-white dark:bg-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-none sm:text-sm font-bold shadow-sm">
                            <option value="Material">Material</option>
                            <option value="Part">{{ __('purchases.Part') ?? 'Part' }}</option>
                        </select>
                    </div>
                    <div class="md:col-span-4" wire:key="item-dropdown-container-{{ $temp_item_type }}">
                        <div class="flex items-end gap-2">
                            <div class="flex-1">
                                <x-form.dropdown-search
                                    wire:key="item-dropdown-{{ $temp_item_type }}"
                                    name="temp_item_id"
                                    wire:model.live="temp_item_id"
                                    :label="__('purchases.Select Item')"
                                    :data="$availableItems"
                                />
                            </div>
                            <x-modal wire:key="modal-trigger-{{ $temp_item_type }}">
                                <x-slot name="trigger"><button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-2xl hover:scale-105 transition-transform"><x-heroicon-o-plus class="w-5 h-5" /></button></x-slot>
                                <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">{{ __('purchases.Add New') }}</div></x-slot>
                                <x-slot name="content">
                                    <div wire:key="modal-inner-{{ $temp_item_type }}">
                                        @if($temp_item_type === 'Material')
                                            <livewire:admin.materials.quick-create wire:key="qc-mat-comp" />
                                        @else
                                            <livewire:admin.parts.quick-create wire:key="qc-part-comp" />
                                        @endif
                                    </div>
                                </x-slot>
                            </x-modal>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <x-form.input name="temp_quantity" type="number" step="0.01" wire:model="temp_quantity" :label="__('purchases.Quantity') . ' (' . ($temp_item_type === 'Material' ? __('purchases.Meter') : __('purchases.Piece')) . ')'" />
                    </div>
                    <div class="md:col-span-2"><x-form.input name="temp_unit_cost" type="number" step="0.01" wire:model="temp_unit_cost" :label="__('purchases.Unit Cost')" /></div>
                    <div class="md:col-span-2 flex items-center h-full pt-1.5">
                        <button type="button" wire:click="addItem" wire:loading.attr="disabled" wire:target="addItem" class="w-full bg-blue-600 text-white py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-blue-600/20 hover:scale-[1.02] active:scale-[0.98] transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="addItem">{{ __('purchases.Add') ?? 'Add' }}</span>
                            <span wire:loading wire:target="addItem" class="flex items-center gap-2 justify-center">
                                <svg class="animate-spin h-3 w-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </span>
                        </button>
                    </div>
                </div>

                {{-- Items Table --}}
                <div class="space-y-4">
                    @forelse($items as $index => $i)
                    <div class="flex flex-col md:flex-row md:items-center justify-between p-5 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl hover:border-blue-500/30 transition-all group shadow-sm gap-4">
                        <div class="flex items-center gap-5 mb-4 md:mb-0">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-gray-900 flex items-center justify-center group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20 transition-colors shrink-0">
                                @if($i['type'] == 'Material')
                                    <x-heroicon-o-square-3-stack-3d class="w-6 h-6 text-gray-400 group-hover:text-blue-500" />
                                @else
                                    <x-heroicon-o-cog-6-tooth class="w-6 h-6 text-gray-400 group-hover:text-blue-500" />
                                @endif
                            </div>
                            <div>
                                <span class="block text-sm font-black dark:text-white">{{ $i['name'] }}</span>
                                <span class="block text-[9px] text-gray-400 uppercase font-black tracking-widest">{{ __('purchases.' . $i['type']) }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 md:flex md:items-center gap-4 md:gap-10">
                            <div class="text-left md:text-right">
                                <span class="block text-[8px] text-gray-400 font-black uppercase tracking-widest">{{ __('purchases.Quantity') }}</span>
                                <span class="text-xs font-bold dark:text-white">{{ number_format($i['quantity'], 2) }} {{ $i['type'] == 'Material' ? __('purchases.Meter') : __('purchases.Piece') }}</span>
                            </div>
                            <div class="text-left md:text-right">
                                <span class="block text-[8px] text-gray-400 font-black uppercase tracking-widest">{{ __('purchases.Unit Cost') }}</span>
                                <span class="text-xs font-bold dark:text-white">€{{ number_format($i['unit_cost'], 2) }}</span>
                            </div>
                            <div class="text-left md:text-right md:w-24">
                                <span class="block text-[8px] text-gray-400 font-black uppercase tracking-widest">{{ __('purchases.Subtotal') }}</span>
                                <span class="text-sm font-black text-blue-600 dark:text-blue-400">€{{ number_format($i['quantity'] * $i['unit_cost'], 2) }}</span>
                            </div>
                            <div class="flex justify-end items-center">
                                <button type="button" wire:click="removeItem({{ $index }})" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-16 text-center border-2 border-dashed border-gray-100 dark:border-gray-700 rounded-[2rem]">
                        <div class="w-16 h-16 bg-gray-50 dark:bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-heroicon-o-shopping-cart class="w-8 h-8 text-gray-300" />
                        </div>
                        <p class="text-sm font-bold text-gray-400">{{ __('purchases.No items in purchase') }}</p>
                        <p class="text-[10px] uppercase font-black text-gray-300 tracking-widest mt-1">{{ __('purchases.Add items using form') }}</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar: Summary & Save --}}
        <div class="space-y-6 md:space-y-8 sticky top-10">
            <div class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] shadow-sm border border-gray-50 dark:border-gray-700">
                <div class="text-[9px] md:text-[10px] font-black uppercase text-gray-400 tracking-widest md:tracking-[0.2em] mb-6 md:mb-8 ml-1">{{ __('purchases.Invoice Summary') }}</div>

                <div class="space-y-6">
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-bold text-gray-400 uppercase tracking-widest">{{ __('purchases.Subtotal') }}</span>
                        <span class="font-black dark:text-white">€{{ number_format($total_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-bold text-gray-400 uppercase tracking-widest">{{ __('purchases.Items (Rows)') }}</span>
                        <span class="font-black dark:text-white">{{ count($items) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-bold text-gray-400 uppercase tracking-widest">{{ __('purchases.Total Quantity') }}</span>
                        <span class="font-black dark:text-white">{{ collect($items)->sum('quantity') }}</span>
                    </div>

                    <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                        <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">{{ __('purchases.Total to Pay') }}</span>
                        <div class="text-4xl font-black text-gray-900 dark:text-white">€{{ number_format($total_amount, 2) }}</div>
                    </div>

                    <div class="pt-8">
                        <x-button type="submit" variant="blue" wire:loading.attr="disabled" wire:target="store" class="!w-full !py-5 !rounded-2xl !text-sm shadow-xl shadow-blue-500/10 transition-shadow">
                            <span wire:loading.remove wire:target="store">{{ __('purchases.Save Supply') }}</span>
                            <span wire:loading wire:target="store" class="flex items-center gap-2 justify-center">
                                <svg class="animate-spin h-5 w-5 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                {{ __('purchases.Saving...') }}
                            </span>
                        </x-button>
                        <p class="text-center text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-4">{{ __('purchases.Status pending notice') }}</p>
                    </div>
                </div>
            </div>

            {{-- Helper Card --}}
            <div class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] shadow-sm border border-blue-100 dark:border-blue-900/30 relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                            <x-heroicon-o-information-circle class="w-6 h-6 text-blue-600" />
                        </div>
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-blue-600">{{ __('purchases.Average Cost') }}</h4>
                    </div>
                    <p class="text-[11px] leading-relaxed text-gray-500 dark:text-gray-400 font-bold">{{ __('purchases.Average Cost Description') }}</p>
                </div>
            </div>
        </div>
    </form>
</div>

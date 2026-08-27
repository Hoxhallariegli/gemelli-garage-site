<div class="p-6">
    @if($created)
        <div class="flex flex-col items-center text-center py-10">
            <div class="w-12 h-12 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center mb-4">
                <x-heroicon-o-check class="w-6 h-6 text-green-500" />
            </div>
            <p class="font-bold text-gray-900 dark:text-white">{{ __('purchases.created') }}</p>
            @if($createdLabel)<p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $createdLabel }}</p>@endif
            <button type="button" wire:click="addAnother" class="mt-6 text-xs font-black uppercase tracking-widest text-blue-600 dark:text-blue-400">{{ __('purchases.Add Purchase') }}</button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
            <div>
                <div class="flex items-end gap-2">
                    <div class="flex-1"><x-form.dropdown-search name="supplier_id" wire:model.live="supplier_id" :label="__('purchases.Supplier')" :data="$suppliers" /></div>
                </div>
            </div>
            <div><x-form.input name="purchase_date" type="date" wire:model="purchase_date" :label="__('purchases.Purchase Date')" class="dark:bg-gray-900" /></div>
            <div><x-form.input name="reference_number" type="text" wire:model="reference_number" :label="__('purchases.Reference Number')" class="dark:bg-gray-900" /></div>
        </div>
        <div class="mt-8 flex justify-end"><x-button wire:click="store" variant="blue">{{ __('purchases.Save') }}</x-button></div>
    @endif
</div>

<div class="p-6">
    @include('errors.errors')
    @if($created)
        <div class="flex flex-col items-center text-center py-10">
            <div class="w-12 h-12 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center mb-4">
                <x-heroicon-o-check class="w-6 h-6 text-green-500" />
            </div>
            <p class="font-bold text-gray-900 dark:text-white">{{ __('materials.created') }}</p>
            @if($createdLabel)<p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $createdLabel }}</p>@endif
            <button type="button" wire:click="addAnother" class="mt-6 text-xs font-black uppercase tracking-widest text-blue-600 dark:text-blue-400">{{ __('materials.Add Material') }}</button>
        </div>
    @else
        <div class="space-y-6">
            <x-form.input name="name" type="text" wire:model="name" :label="__('materials.Name')" class="dark:bg-gray-900" />
            <x-form.dropdown-search name="material_brand_id" wire:model.live="material_brand_id" :label="__('materials.Brand')" :data="$brands" />
            <x-form.input name="sell_price" type="text" wire:model="sell_price" :label="__('materials.Sell Price')" class="dark:bg-gray-900" />
        </div>
        <div class="mt-8 flex justify-end"><x-button wire:click="store" variant="blue" class="!rounded-xl px-10">{{ __('materials.Save') }}</x-button></div>
    @endif
</div>

<div class="p-6">
    @include('errors.errors')
    @if($created)
        <div class="flex flex-col items-center text-center py-10">
            <div class="w-12 h-12 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center mb-4">
                <x-heroicon-o-check class="w-6 h-6 text-green-500" />
            </div>
            <p class="font-bold text-gray-900 dark:text-white">{{ __('services.created') }}</p>
            @if($createdLabel)<p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $createdLabel }}</p>@endif
            <button type="button" wire:click="addAnother" class="mt-6 text-xs font-black uppercase tracking-widest text-blue-600 dark:text-blue-400">{{ __('services.Add Service') }}</button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8"><div><x-form.input name="name" type="text" wire:model="name" :label="__('services.Name')" class="dark:bg-gray-900" /></div>
<div class="md:col-span-2"><x-form.textarea name="description" wire:model="description" :label="__('services.Description')" class="dark:bg-gray-900" /></div>
<div><x-form.input name="base_price" type="text" wire:model="base_price" :label="__('services.Base Price')" class="dark:bg-gray-900" /></div>
<div><x-form.checkbox name="active" wire:model="active" :label="__('services.Active')" /></div></div>
        <div class="mt-8 flex justify-end"><x-button wire:click="store" variant="blue">{{ __('services.Save') }}</x-button></div>
    @endif
</div>

<div class="p-6">
    @include('errors.errors')
    @if($created)
        <div class="flex flex-col items-center text-center py-10">
            <div class="w-12 h-12 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center mb-4">
                <x-heroicon-o-check class="w-6 h-6 text-green-500" />
            </div>
            <p class="font-bold text-gray-900 dark:text-white">{{ __('cars.created') }}</p>
            @if($createdLabel)<p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $createdLabel }}</p>@endif
            <button type="button" wire:click="addAnother" class="mt-6 text-xs font-black uppercase tracking-widest text-blue-600 dark:text-blue-400">{{ __('cars.Add Car') }}</button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8"><div>
    <div class="flex items-end gap-2">
        <div class="flex-1"><x-form.dropdown-search name="client_id" wire:model.live="client_id" :label="__('cars.Client Id')" :data="$clients" /></div>
        <x-modal>
            <x-slot name="trigger"><button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-zinc-900/30 text-blue-600 dark:text-blue-400 rounded-2xl hover:scale-105 transition-transform"><x-heroicon-o-plus class="w-5 h-5" /></button></x-slot>
            <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">Add New Client</div></x-slot>
            <x-slot name="content"><livewire:admin.clients.quick-create /></x-slot>
        </x-modal>
    </div>
</div>
<div>
    <div class="flex items-end gap-2">
        <div class="flex-1"><x-form.dropdown-search name="brand_id" wire:model.live="brand_id" :label="__('cars.Brand Id')" :data="$brands" /></div>
        <x-modal>
            <x-slot name="trigger"><button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-zinc-900/30 text-blue-600 dark:text-blue-400 rounded-2xl hover:scale-105 transition-transform"><x-heroicon-o-plus class="w-5 h-5" /></button></x-slot>
            <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">Add New VehicleBrand</div></x-slot>
            <x-slot name="content"><livewire:admin.vehicle-brands.quick-create /></x-slot>
        </x-modal>
    </div>
</div>
<div>
    <div class="flex items-end gap-2">
        <div class="flex-1"><x-form.dropdown-search wire:key="model-dropdown-{{ $brand_id }}" name="model_id" wire:model.live="model_id" :label="__('cars.Model Id')" :data="$models" :disabled="!$brand_id" /></div>
        <x-modal>
            <x-slot name="trigger"><button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-zinc-900/30 text-blue-600 dark:text-blue-400 rounded-2xl hover:scale-105 transition-transform"><x-heroicon-o-plus class="w-5 h-5" /></button></x-slot>
            <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">Add New VehicleModel</div></x-slot>
            <x-slot name="content"><livewire:admin.vehicle-models.quick-create /></x-slot>
        </x-modal>
    </div>
</div>
<div><x-form.input name="year" type="text" wire:model="year" :label="__('cars.Year')" class="dark:bg-gray-900" /></div>
<div><x-form.input name="license_plate" type="text" wire:model="license_plate" :label="__('cars.License Plate')" class="dark:bg-gray-900" /></div>
<div><x-form.input name="color" type="text" wire:model="color" :label="__('cars.Color')" class="dark:bg-gray-900" /></div></div>
        <div class="mt-8 flex justify-end"><x-button wire:click="store" variant="blue">{{ __('cars.Save') }}</x-button></div>
    @endif
</div>

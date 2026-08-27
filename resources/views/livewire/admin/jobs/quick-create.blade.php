<div class="p-6">
    @if($created)
        <div class="flex flex-col items-center text-center py-10">
            <div class="w-12 h-12 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center mb-4">
                <x-heroicon-o-check class="w-6 h-6 text-green-500" />
            </div>
            <p class="font-bold text-gray-900 dark:text-white">{{ __('jobs.created') }}</p>
            @if($createdLabel)<p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $createdLabel }}</p>@endif
            <button type="button" wire:click="addAnother" class="mt-6 text-xs font-black uppercase tracking-widest text-blue-600 dark:text-blue-400">{{ __('jobs.Add Job') }}</button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8"><div>
    <div class="flex items-end gap-2">
        <div class="flex-1"><x-form.dropdown-search name="car_id" wire:model.live="car_id" :label="__('jobs.Client & Vehicle')" :data="$cars" /></div>
        <x-modal>
            <x-slot name="trigger"><button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-zinc-900/30 text-blue-600 dark:text-blue-400 rounded-2xl hover:scale-105 transition-transform"><x-heroicon-o-plus class="w-5 h-5" /></button></x-slot>
            <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">{{ __('cars.Add New Car') }}</div></x-slot>
            <x-slot name="content"><livewire:admin.cars.quick-create /></x-slot>
        </x-modal>
    </div>
</div>
<div>
    <div class="flex items-end gap-2">
        <div class="flex-1"><x-form.dropdown-search name="service_id" wire:model.live="service_id" :label="__('services.Service')" :data="$services" /></div>
        <x-modal>
            <x-slot name="trigger"><button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-zinc-900/30 text-blue-600 dark:text-blue-400 rounded-2xl hover:scale-105 transition-transform"><x-heroicon-o-plus class="w-5 h-5" /></button></x-slot>
            <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">{{ __('services.Add Service') }}</div></x-slot>
            <x-slot name="content"><livewire:admin.services.quick-create /></x-slot>
        </x-modal>
    </div>
</div>
<div>
    <div class="flex items-end gap-2">
        <div class="flex-1"><x-form.dropdown-search name="material_id" wire:model.live="material_id" :label="__('materials.Material')" :data="$materials" /></div>
        <x-modal>
            <x-slot name="trigger"><button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-zinc-900/30 text-blue-600 dark:text-blue-400 rounded-2xl hover:scale-105 transition-transform"><x-heroicon-o-plus class="w-5 h-5" /></button></x-slot>
            <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">{{ __('materials.Add Material') }}</div></x-slot>
            <x-slot name="content"><livewire:admin.materials.quick-create /></x-slot>
        </x-modal>
    </div>
</div>
<div><x-form.input name="meters_used" type="text" wire:model="meters_used" :label="__('jobs.Meters Used')" class="dark:bg-gray-900" /></div>
<div><x-form.input name="final_price" type="text" wire:model="final_price" :label="__('jobs.Final Price')" class="dark:bg-gray-900" /></div>
<div><label class="block mb-1.5 text-[10px] font-bold uppercase tracking-widest">{{ __('jobs.Status') }}</label><select name="status" wire:model="status" class="w-full p-3 text-sm font-bold bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl"><option value="">--</option><option value="pending">{{ __('jobs.pending') }}</option><option value="in_progress">{{ __('jobs.in_progress') }}</option><option value="completed">{{ __('jobs.completed') }}</option><option value="cancelled">{{ __('jobs.cancelled') }}</option></select></div>
<div><x-form.input name="job_date" type="datetime-local" wire:model="job_date" :label="__('jobs.Job Date')" class="dark:bg-gray-900" /></div>
<div class="md:col-span-2"><x-form.textarea name="notes" wire:model="notes" :label="__('jobs.Notes')" class="dark:bg-gray-900" /></div></div>
        <div class="mt-8 flex justify-end"><x-button wire:click="store" variant="blue">{{ __('jobs.Save') }}</x-button></div>
    @endif
</div>

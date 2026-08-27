<div class="p-6">
    @if($created)
        <div class="flex flex-col items-center text-center py-10">
            <div class="w-12 h-12 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center mb-4">
                <x-heroicon-o-check class="w-6 h-6 text-green-500" />
            </div>
            <p class="font-bold text-gray-900 dark:text-white">{{ __('job-requests.created') }}</p>
            @if($createdLabel)<p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $createdLabel }}</p>@endif
            <button type="button" wire:click="addAnother" class="mt-6 text-xs font-black uppercase tracking-widest text-blue-600 dark:text-blue-400">{{ __('job-requests.Add JobRequest') }}</button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8"><div><x-form.input name="name" type="text" wire:model="name" :label="__('job-requests.Name')" class="dark:bg-gray-900" /></div>
<div><x-form.input name="email" type="text" wire:model="email" :label="__('job-requests.Email')" class="dark:bg-gray-900" /></div>
<div><x-form.input name="phone" type="text" wire:model="phone" :label="__('job-requests.Phone')" class="dark:bg-gray-900" /></div>
<div><x-form.input name="brand" type="text" wire:model="brand" :label="__('job-requests.Brand')" class="dark:bg-gray-900" /></div>
<div><x-form.input name="model" type="text" wire:model="model" :label="__('job-requests.Model')" class="dark:bg-gray-900" /></div>
<div>
    <div class="flex items-end gap-2">
        <div class="flex-1"><x-form.dropdown-search name="body_type_id" wire:model.live="body_type_id" :label="__('job-requests.Body Type Id')" :data="$bodyTypes" /></div>
        <x-modal>
            <x-slot name="trigger"><button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-zinc-900/30 text-blue-600 dark:text-blue-400 rounded-2xl hover:scale-105 transition-transform"><x-heroicon-o-plus class="w-5 h-5" /></button></x-slot>
            <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">Add New BodyType</div></x-slot>
            <x-slot name="content"><livewire:admin.body-types.quick-create /></x-slot>
        </x-modal>
    </div>
</div>
<div>
    <div class="flex items-end gap-2">
        <div class="flex-1"><x-form.dropdown-search name="service_id" wire:model.live="service_id" :label="__('job-requests.Service Id')" :data="$services" /></div>
        <x-modal>
            <x-slot name="trigger"><button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-zinc-900/30 text-blue-600 dark:text-blue-400 rounded-2xl hover:scale-105 transition-transform"><x-heroicon-o-plus class="w-5 h-5" /></button></x-slot>
            <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">Add New Service</div></x-slot>
            <x-slot name="content"><livewire:admin.services.quick-create /></x-slot>
        </x-modal>
    </div>
</div>
<div>
    <div class="flex items-end gap-2">
        <div class="flex-1"><x-form.dropdown-search name="material_id" wire:model.live="material_id" :label="__('job-requests.Material Id')" :data="$materials" /></div>
        <x-modal>
            <x-slot name="trigger"><button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-zinc-900/30 text-blue-600 dark:text-blue-400 rounded-2xl hover:scale-105 transition-transform"><x-heroicon-o-plus class="w-5 h-5" /></button></x-slot>
            <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">Add New Material</div></x-slot>
            <x-slot name="content"><livewire:admin.materials.quick-create /></x-slot>
        </x-modal>
    </div>
</div>
<div><x-form.input name="estimated_price" type="text" wire:model="estimated_price" :label="__('job-requests.Estimated Price')" class="dark:bg-gray-900" /></div>
<div class="md:col-span-2"><x-form.textarea name="message" wire:model="message" :label="__('job-requests.Message')" class="dark:bg-gray-900" /></div>
<div><x-form.input name="status" type="text" wire:model="status" :label="__('job-requests.Status')" class="dark:bg-gray-900" /></div></div>
        <div class="mt-8 flex justify-end"><x-button wire:click="store" variant="blue">{{ __('job-requests.Save') }}</x-button></div>
    @endif
</div>
<div class="p-6">
    @include('errors.errors')
    @if($created)
        <div class="flex flex-col items-center text-center py-10">
            <div class="w-12 h-12 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center mb-4">
                <x-heroicon-o-check class="w-6 h-6 text-green-500" />
            </div>
            <p class="font-bold text-gray-900 dark:text-white">{{ __('vehicle-models.created') }}</p>
            @if($createdLabel)<p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $createdLabel }}</p>@endif
            <button type="button" wire:click="addAnother" class="mt-6 text-xs font-black uppercase tracking-widest text-blue-600 dark:text-blue-400">{{ __('vehicle-models.Add VehicleModel') }}</button>
        </div>
    @else
        <div class="space-y-6">
            <div class="flex items-end gap-2">
                <div class="flex-1">
                    <x-form.dropdown-search name="brand_id" wire:model.live="brand_id" :label="__('vehicle-models.Brand Id')" :data="$brands" />
                </div>
                <x-modal>
                    <x-slot name="trigger">
                        <button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-zinc-900/30 text-blue-600 dark:text-blue-400 rounded-2xl hover:scale-105 transition-transform">
                            <x-heroicon-o-plus class="w-5 h-5" />
                        </button>
                    </x-slot>
                    <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">Add New VehicleBrand</div></x-slot>
                    <x-slot name="content"><livewire:admin.vehicle-brands.quick-create /></x-slot>
                </x-modal>
            </div>

            <x-form.input name="name" type="text" wire:model="name" :label="__('vehicle-models.Name')" class="dark:bg-gray-900" />

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
                <x-form.dropdown-search name="body_type_id" wire:model.live="body_type_id" label="none" :data="$bodyTypes" />
            </div>

            <x-form.input name="wrap_meters_needed" type="number" step="0.1" wire:model="wrap_meters_needed" :label="__('vehicle-models.Wrap Meters Needed')" class="dark:bg-gray-900" />
        </div>
        <div class="mt-8 flex justify-end">
            <x-button wire:click="store" variant="blue" class="!rounded-xl px-10">{{ __('vehicle-models.Save') }}</x-button>
        </div>
    @endif
</div>

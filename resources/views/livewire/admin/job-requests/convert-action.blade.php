<div x-data="{ on: false }" x-cloak class="inline-block">
    <x-modal>
        <x-slot name="trigger">
            <button @click="on = true" class="!rounded-xl !bg-green-50 dark:!bg-green-900/30 !text-green-600 dark:!text-green-400 !px-4 !py-1.5 !text-[10px] !font-black !uppercase !border-none">
                Convert
            </button>
        </x-slot>

        <x-slot name="modalTitle">
            <div class="text-left dark:text-white px-6 pt-6">
                Convert Job Request #{{ $jobRequest->id }} to Job
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="p-6 space-y-6 text-left">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Client Info -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-bold uppercase text-gray-400">Client Information</h3>
                        <x-form.input name="client_name" wire:model="client_name" label="Name" />
                        <x-form.input name="client_email" wire:model="client_email" label="Email" />
                        <x-form.input name="client_phone" wire:model="client_phone" label="Phone" />
                    </div>

                    <!-- Car Info -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-bold uppercase text-gray-400">Car Information</h3>
                        <x-form.input name="license_plate" wire:model="license_plate" label="License Plate" />

                        <div class="flex items-end gap-2">
                            <div class="flex-1"><x-form.dropdown-search name="brand_id" wire:model.live="brand_id" label="Brand" :data="$brands" /></div>
                            <x-modal>
                                <x-slot name="trigger"><button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-zinc-900/30 text-blue-600 dark:text-blue-400 rounded-2xl hover:scale-105 transition-transform"><x-heroicon-o-plus class="w-5 h-5" /></button></x-slot>
                                <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">Add New Brand</div></x-slot>
                                <x-slot name="content"><livewire:admin.vehicle-brands.quick-create /></x-slot>
                            </x-modal>
                        </div>

                        <div class="flex items-end gap-2">
                            <div class="flex-1"><x-form.dropdown-search wire:key="model-dropdown-{{ $brand_id }}" name="model_id" wire:model="model_id" label="Model" :data="$models" :disabled="!$brand_id" /></div>
                            <x-modal>
                                <x-slot name="trigger"><button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-zinc-900/30 text-blue-600 dark:text-blue-400 rounded-2xl hover:scale-105 transition-transform"><x-heroicon-o-plus class="w-5 h-5" /></button></x-slot>
                                <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">Add New Model</div></x-slot>
                                <x-slot name="content"><livewire:admin.vehicle-models.quick-create /></x-slot>
                            </x-modal>
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="pt-4 border-t dark:border-gray-700">
                    <h3 class="text-sm font-bold uppercase text-gray-400 mb-4">Pricing & Selection Review</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Main Service</label>
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $jobRequest->service?->name ?? 'None' }}</div>
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Wrapping Material</label>
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $jobRequest->material?->name ?? 'None' }}</div>
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Full Request Message</label>
                                <div class="text-xs text-gray-500 dark:text-gray-400 italic bg-gray-50 dark:bg-gray-900/50 p-3 rounded-xl border border-gray-100 dark:border-gray-700 mt-1">
                                    {!! nl2br(e($jobRequest->message)) !!}
                                </div>
                            </div>
                        </div>
                        <div>
                            <x-form.input name="final_price" wire:model="final_price" label="Final Price" type="number" step="0.01" />
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-3 px-6 pb-6">
                <x-button variant="gray" @click="on = false">Cancel</x-button>
                <x-button variant="green" wire:click="convert" wire:loading.attr="disabled">
                    Confirm Conversion
                </x-button>
            </div>
        </x-slot>
    </x-modal>
</div>

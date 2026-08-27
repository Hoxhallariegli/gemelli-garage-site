<div class="space-y-10">
    <div class="flex items-center justify-between gap-4 px-1"><div><x-h1>{{ __('vehicle-models.Add VehicleModel') }}</x-h1><x-short-description class="dark:text-gray-400">{{ __('vehicle-models.New record') }}</x-short-description></div><x-back-btn route="admin.vehicle-models.index" /></div>
    @include('errors.errors')
    <div class="bg-white dark:bg-gray-800 p-8 sm:p-12 rounded-[2.5rem] shadow-sm border border-gray-50 dark:border-gray-700"><form wire:submit.prevent="store" class="space-y-8"><div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8"><div>
    <div class="flex items-end gap-2">
        <div class="flex-1"><x-form.dropdown-search name="brand_id" wire:model.live="brand_id" :label="__('vehicle-models.Brand Id')" :data="$brands" /></div>
        <x-modal>
            <x-slot name="trigger"><button type="button" @click="on = true" class="mb-6 p-3 bg-blue-50 dark:bg-zinc-900/30 text-blue-600 dark:text-blue-400 rounded-2xl hover:scale-105 transition-transform"><x-heroicon-o-plus class="w-5 h-5" /></button></x-slot>
            <x-slot name="modalTitle"><div class="dark:text-white px-6 pt-6">Add New VehicleBrand</div></x-slot>
            <x-slot name="content"><livewire:admin.vehicle-brands.quick-create /></x-slot>
        </x-modal>
    </div>
</div>
<div><x-form.input name="name" type="text" wire:model="name" :label="__('vehicle-models.Name')" class="dark:bg-gray-900" /></div>
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

    @if($body_type_id)
        @php $selectedBT = \App\Models\BodyType::find($body_type_id); @endphp
        @if($selectedBT && $selectedBT->image)
            <div class="mt-4 p-6 bg-gray-50 dark:bg-gray-900/50 rounded-3xl border border-gray-100 dark:border-gray-700 flex flex-col items-center animate-fadeIn">
                <span class="text-[8px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">{{ __('vehicle-models.Selected Type Preview') }}</span>
                <img src="{{ asset($selectedBT->image) }}" class="h-24 w-auto object-contain">
                <span class="mt-2 text-[10px] font-black text-blue-600 uppercase">{{ $selectedBT->name }}</span>
            </div>
        @endif
    @endif
</div>
<div><x-form.input name="wrap_meters_needed" type="text" wire:model="wrap_meters_needed" :label="__('vehicle-models.Wrap Meters Needed')" class="dark:bg-gray-900" /></div>
                </div>
                <div class="mt-10 flex justify-end">
                    <x-button type="submit" variant="blue" class="w-full sm:w-auto !px-12 !py-4 !rounded-2xl">{{ __('vehicle-models.Save') }}</x-button>
                </div>
            </form>
        </div>
    </div>
</div>

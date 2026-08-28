<div class="space-y-10">
    <div class="flex items-center justify-between gap-4 px-1"><div><x-h1>{{ __('vehicle-brands.Edit VehicleBrand') }}</x-h1><x-short-description class="dark:text-gray-400">{{ __('vehicle-brands.Update info') }}</x-short-description></div><x-back-btn route="admin.vehicle-brands.index" /></div>
    @include('errors.errors')
    <div class="bg-white dark:bg-gray-800 p-8 sm:p-12 rounded-[2.5rem] shadow-sm border border-gray-50 dark:border-gray-700"><form wire:submit.prevent="update" class="space-y-8"><div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8"><div><x-form.input name="name" type="text" wire:model="name" :label="__('vehicle-brands.Name')" class="dark:bg-gray-900" /></div>
<div>
    <x-form.file-upload name="logo" wire:model="logo" :label="__('vehicle-brands.Logo')" id="logo-upload" :isEditing="true" :preview="$item->logo" />
</div>
</div><div class="mt-10 flex justify-end"><x-button type="submit" variant="blue" class="w-full sm:w-auto !px-12 !py-4 !rounded-2xl">{{ __('vehicle-brands.Update') }}</x-button></div></form></div>
</div>

<div class="space-y-10">
    <div class="flex items-center justify-between gap-4 px-1"><div><x-h1>{{ __('parts.Add Part') }}</x-h1><x-short-description class="dark:text-gray-400">{{ __('parts.New record') }}</x-short-description></div><x-back-btn route="admin.parts.index" /></div>
    @include('errors.errors')
    <div class="bg-white dark:bg-gray-800 p-8 sm:p-12 rounded-[2.5rem] shadow-sm border border-gray-50 dark:border-gray-700">
        <form wire:submit.prevent="store" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                <div class="space-y-8">
                    <div><x-form.input name="name" type="text" wire:model="name" :label="__('parts.Name')" class="dark:bg-gray-900" /></div>
                    <div><x-form.input name="sell_price" type="text" wire:model="sell_price" :label="__('parts.Sell Price')" class="dark:bg-gray-900" /></div>
                </div>

                <div>
                    <x-form.file-upload name="image" wire:model="image" :label="'Foto e Pjesës'" id="image" :isEditing="false" />
                </div>
            </div>

            <div class="mt-10 flex justify-end">
                <x-button type="submit" variant="blue" class="w-full sm:w-auto !px-12 !py-4 !rounded-2xl">{{ __('parts.Save') }}</x-button>
            </div>
        </form>
    </div>
</div>

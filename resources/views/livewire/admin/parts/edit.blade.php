<div class="space-y-10">
    <div class="flex items-center justify-between gap-4 px-1"><div><x-h1>{{ __('parts.Edit Part') }}</x-h1><x-short-description class="dark:text-gray-400">{{ __('parts.Update info') }}</x-short-description></div><x-back-btn route="admin.parts.index" /></div>
    @include('errors.errors')
    <div class="bg-white dark:bg-gray-800 p-8 sm:p-12 rounded-[2.5rem] shadow-sm border border-gray-50 dark:border-gray-700">
        <form wire:submit.prevent="update" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                <div class="space-y-8">
                    <div><x-form.input name="name" type="text" wire:model="name" :label="__('parts.name')" class="dark:bg-gray-900" /></div>
                    <div><x-form.input name="sell_price" type="text" wire:model="sell_price" :label="__('parts.sell_price')" class="dark:bg-gray-900" /></div>

                    <div class="p-6 bg-blue-50/50 dark:bg-blue-900/10 rounded-2xl border border-blue-100 dark:border-blue-800/30 flex justify-between items-center">
                        <div class="flex gap-8">
                            <div>
                                <span class="block text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest">{{ __('parts.average_cost') }}</span>
                                <span class="text-lg font-black dark:text-white">€{{ number_format($item->purchase_price, 2) }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest">{{ __('parts.stock_status') }}</span>
                                <span class="text-lg font-black dark:text-white">{{ $item->stock_quantity }} {{ __('parts.pcs') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <x-form.file-upload name="image" wire:model="image" :label="__('parts.part_photo')" id="image" :isEditing="true" />
                </div>
            </div>

            <div class="mt-10 flex justify-end">
                <x-button type="submit" variant="blue" class="w-full sm:w-auto !px-12 !py-4 !rounded-2xl">{{ __('parts.Update') }}</x-button>
            </div>
        </form>
    </div>
</div>

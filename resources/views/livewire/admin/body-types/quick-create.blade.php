<div class="p-6">
    @include('errors.errors')
    @if($created)
        <div class="flex flex-col items-center text-center py-10">
            <div class="w-12 h-12 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center mb-4">
                <x-heroicon-o-check class="w-6 h-6 text-green-500" />
            </div>
            <p class="font-bold text-gray-900 dark:text-white">{{ __('body-types.created') }}</p>
            @if($createdLabel)<p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $createdLabel }}</p>@endif
            <button type="button" wire:click="addAnother" class="mt-6 text-xs font-black uppercase tracking-widest text-blue-600 dark:text-blue-400">{{ __('body-types.Add BodyType') }}</button>
        </div>
    @else
        <div class="space-y-6">
            <x-form.input name="name" type="text" wire:model="name" :label="__('body-types.Name')" class="dark:bg-gray-900" />
            <x-form.input name="wrap_meters" type="number" step="0.1" wire:model="wrap_meters" :label="__('body-types.Wrap Meters')" class="dark:bg-gray-900" />
            <x-form.file-upload name="image" wire:model="image" :label="__('body-types.Image')" id="bt-image-quick" :isEditing="false" />

            <div class="mt-8 flex justify-end">
                <x-button wire:click="store" variant="blue" class="!rounded-xl px-10">{{ __('body-types.Save') }}</x-button>
            </div>
        </div>
    @endif
</div>

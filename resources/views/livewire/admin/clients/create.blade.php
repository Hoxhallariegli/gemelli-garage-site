<div class="space-y-10">
    <div class="flex items-center justify-between gap-4 px-1"><div><x-h1>{{ __('clients.Add Client') }}</x-h1><x-short-description class="dark:text-gray-400">{{ __('clients.New record') }}</x-short-description></div><x-back-btn route="admin.clients.index" /></div>
    @include('errors.errors')
    <x-card>
        <form wire:submit.prevent="store" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                <div><x-form.input name="name" type="text" wire:model="name" :label="__('clients.Name')" class="dark:bg-gray-900" /></div>
                <div><x-form.input name="phone" type="text" wire:model="phone" :label="__('clients.Phone')" class="dark:bg-gray-900" /></div>
                <div><x-form.input name="email" type="text" wire:model="email" :label="__('clients.Email')" class="dark:bg-gray-900" /></div>
                <div class="md:col-span-2"><x-form.textarea name="notes" wire:model="notes" :label="__('clients.Notes')" class="dark:bg-gray-900" /></div>
            </div>
            <div class="mt-10 flex justify-end">
                <x-button type="submit" variant="blue" class="w-full sm:w-auto !px-12 !py-4 !rounded-2xl">{{ __('clients.Save') }}</x-button>
            </div>
        </form>
    </x-card>
</div>

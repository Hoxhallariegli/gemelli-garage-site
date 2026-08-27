<div>
    <x-card>
        <h3 class="mb-4">{{ __('settings.Application Settings') }}</h3>
        <x-form wire:submit="update" method="put">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form.input wire:model="siteName" name="siteName" :label="__('settings.Site Name')" />
                <fieldset>
                    <div class="mt-1 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">
                        <div class="relative p-4 flex">
                            <div class="flex items-center h-5">
                                <input wire:model="isForced2Fa" id="isForced2Fa" type="checkbox" class="size-5 rounded-lg border-gray-300 dark:border-gray-700 text-slate-900 focus:ring-slate-500/20 transition-all cursor-pointer">
                            </div>
                            <label for="isForced2Fa" class="ml-3 flex flex-col cursor-pointer">
                                <span class="ui-label !text-gray-900 dark:!text-white !mb-0">
                                    {{ __('settings.Enforce 2FA') }}
                                </span>
                                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">
                                    {{ __('settings.Force 2 factor authentication for all users on login.') }}
                                </span>
                            </label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="mt-6">
                <x-button variant="slate">{{ __('settings.Update Application Settings') }}</x-button>
            </div>
        </x-form>
        @include('errors.messages')
    </x-card>
</div>

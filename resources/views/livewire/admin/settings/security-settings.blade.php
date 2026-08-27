<div>
    <x-card padding="p-6 md:p-8" rounded="rounded-3xl" border="border border-gray-100 dark:border-gray-700" class="my-6">
        <h3 class="mb-5">{{ __('settings.Office lockdown by IP Address') }}</h3>

        <div class="bg-blue-600 mb-5 p-4 text-white rounded-2xl shadow-sm text-xs font-bold">
            {{ __("settings.When a user is set to office login only the IP's listed below will allow access.") }}
            {{ __("settings.If you are not in the office you will not be able to login.") }}
        </div>

        <p class="text-xs font-bold text-gray-500 mb-4">{{ __('settings.Your current IP address is') }} <span class="text-blue-600">{{ request()->ip() }}</span></p>

        <x-form wire:submit="update" method="put" class="space-y-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="text-left">{{ __('settings.IP Address') }}</th>
                            <th class="text-left">{{ __('settings.Comment') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                        @foreach($ips as $index => $row)
                            <tr wire:key="{{ $index }}">
                                <td class="py-2"><x-form.input wire:model="ips.{{ $index }}.ip" label="none" placeholder="0.0.0.0" /></td>
                                <td class="py-2"><x-form.input wire:model="ips.{{ $index }}.comment" label="none" placeholder="..." /></td>
                                <td class="py-2 text-right">
                                    <button type="button" wire:click="remove({{ $index }})" wire:confirm="{{ __('users.Are you sure?') }}" class="p-2 text-red-400 hover:text-red-600 transition-colors">
                                        <x-heroicon-o-trash class="size-5" />
                                    </button>
                                </td>
                            </tr>
                            @error("ips.$index.ip")
                                <tr><td colspan="3"><span class="text-[10px] font-bold text-red-500 uppercase">{{ $message }}</span></td></tr>
                            @enderror
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-wrap gap-3">
                <x-button type="button" variant="slate" size="sm" wire:click="add" class="!rounded-xl">
                    <x-heroicon-s-plus class="size-4" />
                    {{ __('settings.Add Row') }}
                </x-button>

                <x-button variant="slate" size="sm" class="!rounded-xl">
                    {{ __('settings.Save') }}
                </x-button>
            </div>
        </x-form>

        @include('errors.messages')
    </x-card>
</div>

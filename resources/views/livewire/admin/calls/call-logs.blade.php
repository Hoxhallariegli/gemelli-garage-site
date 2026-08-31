<div class="space-y-6" wire:poll.5s>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <x-h1>{{ __('Call Logs') }}</x-h1>
            <x-short-description>{{ __('View history of incoming calls from your mobile gateway.') }}</x-short-description>
        </div>
    </div>

    <x-card>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <h3 class="font-black text-gray-900 dark:text-white uppercase tracking-tight text-xs">{{ __('Calls History') }}</h3>
            <div class="w-full md:w-72">
                <x-form.input wire:model.live="search" placeholder="{{ __('Search phone or name...') }}" icon="magnifying-glass" />
            </div>
        </div>

        <div class="overflow-x-auto -mx-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Caller') }}</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Phone Number') }}</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Type') }}</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Status') }}</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Date') }}</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-800/50">
                    @forelse($calls as $call)
                        <tr class="group hover:bg-gray-50/50 dark:hover:bg-gray-900/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-900 dark:text-white">{{ $call->caller_name }}</span>
                                    @if($call->is_client)
                                        <span class="text-[9px] text-green-500 uppercase font-black tracking-tighter">{{ __('Registered Client') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ $call->phone_number }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-500">
                                    {{ $call->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <x-badge :variant="$call->is_client ? 'success' : 'blue'">
                                    {{ $call->is_client ? __('Client') : __('New Lead') }}
                                </x-badge>
                            </td>
                            <td class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-tighter">
                                {{ $call->call_time->format('d M, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    wire:click="delete({{ $call->id }})"
                                    wire:confirm="Are you sure you want to delete this log?"
                                    class="p-2 text-gray-400 hover:text-red-600 transition-colors"
                                >
                                    <x-heroicon-o-trash class="size-4" />
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center opacity-20">
                                    <x-heroicon-o-phone-x-mark class="size-12 mb-2" />
                                    <p class="text-sm font-black uppercase tracking-widest">{{ __('No calls logged yet') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $calls->links() }}
        </div>
    </x-card>
</div>

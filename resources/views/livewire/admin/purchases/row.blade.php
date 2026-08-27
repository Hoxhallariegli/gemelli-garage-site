<tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/50 transition-none border-b border-gray-50 dark:border-gray-700/50 last:border-none">
    <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">{{ $item->supplier?->name ?? '-' }}</td>
    <td class="px-4 py-3">
        <div class="flex flex-col gap-1">
            <span class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest">{{ $item->items_count }} {{ __('purchases.Items') }}</span>
            <div class="text-[9px] text-gray-400 font-bold truncate max-w-[200px]">
                {{ $item->items->take(3)->map(fn($i) => $i->itemable?->name)->filter()->implode(', ') }}
                {{ $item->items_count > 3 ? '...' : '' }}
            </div>
        </div>
    </td>
    <td class="px-4 py-3 text-xs font-bold text-gray-600 dark:text-gray-400">
        {{ number_format($item->total_qty ?? 0, 2) }}
    </td>
    <td class="px-4 py-3 font-bold text-gray-900 dark:text-white text-xs">{{ number_format($item->total_amount, 2) }} €</td>
    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $item->purchase_date?->format('d/m/Y') ?? '-' }}</td>
    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $item->reference_number ?? '-' }}</td>
    <td class="px-4 py-3">
        @php
            $statusColors = [
                'received' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
            ];
        @endphp
        <span class="px-3 py-1 text-[9px] font-black uppercase tracking-widest {{ $statusColors[$item->status] ?? 'bg-gray-100 text-gray-700' }} rounded-full">
            {{ __('purchases.' . $item->status) }}
        </span>
    </td>
    <td class="px-4 py-3 text-right !transition-none">
        <div class="flex justify-end gap-3 !transition-none">
            @if($item->status === 'pending')
                @can('edit_purchases')
                    <button wire:click="$parent.receive({{ $item->id }})" class="!rounded-xl !bg-green-50 dark:!bg-green-900/30 !text-green-600 dark:!text-green-400 !px-3 !py-1 !text-[9px] !font-black !uppercase !border-none">{{ __('purchases.Receive') }}</button>
                @endcan
            @endif

            @can('edit_purchases')
                <x-a href="{{ route('admin.purchases.edit', $item) }}" class="!rounded-xl !bg-blue-50 dark:!bg-blue-900/30 !text-blue-600 dark:!text-blue-400 !px-3 !py-1 !text-[9px] !font-black !uppercase !border-none">{{ $item->status === 'received' ? __('purchases.View') : __('purchases.Edit') }}</x-a>
            @endcan

            @can('delete_purchases')
                <div x-data="{ confirmation: '' }" x-cloak class="inline-block">
                    <x-modal>
                        <x-slot name="trigger"><button @click="on = true" class="text-[9px] font-black uppercase text-red-400 hover:text-red-600 dark:hover:text-red-300">{{ __('admin.Delete') }}</button></x-slot>
                        <x-slot name="modalTitle"><div class="text-left dark:text-white">{{ __('purchases.Delete Purchase') }} #{{ $item->id }}?</div></x-slot>
                        <x-slot name="content">
                            <div class="text-left space-y-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('purchases.Irreversible Action') }}</p>
                                @if($item->status === 'received')
                                    <p class="text-[10px] text-orange-500 font-bold uppercase">{{ __('purchases.Stock will be reversed automatically.') }}</p>
                                @endif
                                <input x-model="confirmation" placeholder="{{ __('purchases.Type ID to confirm') }} {{ $item->id }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-red-500 outline-none">
                            </div>
                        </x-slot>
                        <x-slot name="footer"><x-button variant="gray" @click="on = false">{{ __('purchases.Cancel') }}</x-button><x-button variant="red" x-bind:disabled="confirmation !== '{{ $item->id }}'" wire:click="$parent.deletePurchase('{{ $item->id }}')" @click="on = false">{{ __('purchases.Delete') }}</x-button></x-slot>
                    </x-modal>
                </div>
            @endcan
        </div>
    </td>
</tr>

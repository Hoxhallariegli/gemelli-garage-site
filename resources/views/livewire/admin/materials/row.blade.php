<tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/50 transition-none border-b border-gray-50 dark:border-gray-700/50 last:border-none">
    <td class="px-4 py-3">
        <div class="size-10 rounded-xl bg-gray-50 dark:bg-gray-900 flex items-center justify-center overflow-hidden border border-gray-100 dark:border-gray-700">
            @if($item->image)
                <img src="{{ asset($item->image) }}" class="w-full h-full object-cover">
            @else
                <x-heroicon-o-square-3-stack-3d class="size-5 text-gray-300" />
            @endif
        </div>
    </td>
    <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">{{ $item->name }}</td>
    <td class="px-4 py-3 text-gray-600 dark:text-gray-300 text-xs">{{ $item->brand ?? '-' }}</td>
    <td class="px-4 py-3 text-gray-600 dark:text-gray-300 font-medium">€{{ number_format($item->purchase_price, 2) }}</td>
    <td class="px-4 py-3 text-gray-900 dark:text-white font-bold">€{{ number_format($item->sell_price, 2) }}</td>
    <td class="px-4 py-3">
        @php
            $margin = $item->purchase_price > 0 ? (($item->sell_price - $item->purchase_price) / $item->purchase_price) * 100 : 0;
        @endphp
        <span class="text-[10px] font-black {{ $margin > 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ number_format($margin, 1) }}%
        </span>
    </td>
    <td class="px-4 py-3">
        <div class="flex items-center gap-2">
            @if($item->stock_meters <= 0)
                <span class="px-2.5 py-1 text-[9px] font-black uppercase tracking-widest bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-lg">Jashtë Stoku</span>
            @elseif($item->stock_meters < 5)
                <span class="px-2.5 py-1 text-[9px] font-black uppercase tracking-widest bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-lg">{{ $item->stock_meters }} m (Ulët)</span>
            @else
                <span class="px-2.5 py-1 text-[9px] font-black uppercase tracking-widest bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-lg">{{ $item->stock_meters }} m</span>
            @endif
        </div>
    </td>
    <td class="px-4 py-3 text-right !transition-none">
        <div class="flex justify-end gap-3 !transition-none">
            @can('edit_materials')
                <x-a href="{{ route('admin.materials.edit', $item) }}" class="!rounded-xl !bg-blue-50 dark:!bg-blue-900/30 !text-blue-600 dark:!text-blue-400 !px-3 !py-1 !text-[9px] !font-black !uppercase !border-none">Edit</x-a>
            @endcan
            @can('delete_materials')
                <div x-data="{ confirmation: '' }" x-cloak class="inline-block">
                    <x-modal>
                        <x-slot name="trigger"><button @click="on = true" class="text-[9px] font-black uppercase text-red-400 hover:text-red-600 dark:hover:text-red-300">Delete</button></x-slot>
                        <x-slot name="modalTitle"><div class="text-left dark:text-white">Delete {{ $item->name }}?</div></x-slot>
                        <x-slot name="content"><div class="text-left space-y-2"><p class="text-sm text-gray-500 dark:text-gray-400">This action cannot be undone.</p><input x-model="confirmation" placeholder="Type {{ $item->name }} to confirm" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-red-500 outline-none"></div></x-slot>
                        <x-slot name="footer"><x-button variant="gray" @click="on = false">Cancel</x-button><x-button variant="red" x-bind:disabled="confirmation !== '{{ $item->name }}'" wire:click="$parent.deleteMaterial('{{ $item->id }}')" @click="on = false">Delete</x-button></x-slot>
                    </x-modal>
                </div>
            @endcan
        </div>
    </td>
</tr>

<tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/50 transition-none border-b border-gray-50 dark:border-gray-700/50 last:border-none">
    <td class="px-3 py-2 font-bold text-blue-600 dark:text-blue-400">{{ $item->id }}</td>
    <td class="px-3 py-2 font-bold text-gray-900 dark:text-white">{{ $item->name }}</td>
    <td class="px-3 py-2 text-gray-600 dark:text-gray-300 font-black">{{ $item->wrap_meters }} m</td>
    <td class="px-3 py-2">
        @if($item->image)
            <div class="size-16 rounded-2xl bg-gray-50 dark:bg-gray-800 p-1 border border-gray-100 dark:border-gray-700 flex items-center justify-center shrink-0 overflow-hidden shadow-sm">
                <img src="{{ asset($item->image) }}" class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal">
            </div>
        @else
            <div class="size-16 rounded-2xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-gray-300 border border-dashed border-gray-200">
                <x-heroicon-o-photo class="w-6 h-6" />
            </div>
        @endif
    </td>
    <td class="px-3 py-2 text-right !transition-none">
        <div class="flex justify-end gap-3 !transition-none">
            @can('edit_body_types')
                <x-a href="{{ route('admin.body-types.edit', $item) }}" class="!rounded-xl !bg-blue-50 dark:!bg-blue-900/30 !text-blue-600 dark:!text-blue-400 !px-4 !py-1.5 !text-[10px] !font-black !uppercase !border-none">Edit</x-a>
            @endcan
            @can('delete_body_types')
                <div x-data="{ confirmation: '' }" x-cloak class="inline-block">
                    <x-modal>
                        <x-slot name="trigger"><button @click="on = true" class="text-[10px] font-black uppercase text-red-400 hover:text-red-600 dark:hover:text-red-300">Delete</button></x-slot>
                        <x-slot name="modalTitle"><div class="text-left dark:text-white">Delete {{ $item->name }}?</div></x-slot>
                        <x-slot name="content"><div class="text-left space-y-2"><p class="text-sm text-gray-500 dark:text-gray-400">This action cannot be undone.</p><input x-model="confirmation" placeholder="Type {{ $item->name }} to confirm" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-red-500 outline-none"></div></x-slot>
                        <x-slot name="footer"><x-button variant="gray" @click="on = false">Cancel</x-button><x-button variant="red" x-bind:disabled="confirmation !== '{{ $item->name }}'" wire:click="$parent.deleteBodyType('{{ $item->id }}')" @click="on = false">Delete</x-button></x-slot>
                    </x-modal>
                </div>
            @endcan
        </div>
    </td>
</tr>

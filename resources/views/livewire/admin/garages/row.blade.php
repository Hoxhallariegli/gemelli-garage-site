<tr class="hover:bg-gray-50/80 dark:hover:bg-gray-900/60 transition-colors border-b border-gray-200 dark:border-gray-700">
    <td class="px-6 py-5 font-bold text-blue-600 dark:text-blue-400">#{{ $item->id }}</td>
    <td class="px-6 py-5 font-extrabold text-gray-900 dark:text-white">
        {{ $item->name }}
        <span class="block text-[10px] font-medium text-gray-400">slug: /s/{{ $item->slug }}</span>
    </td>
    <td class="px-6 py-5 text-gray-600 dark:text-gray-300 font-bold">
        {{ $item->city ?? 'N/A' }} {{ $item->address ? '- ' . $item->address : '' }}
    </td>
    <td class="px-6 py-5 text-gray-600 dark:text-gray-300 font-mono">{{ $item->phone ?? 'N/A' }}</td>
    <td class="px-6 py-5">
        <div class="flex items-center gap-2">
            <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $item->sms_enabled ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-500' }}">SMS</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $item->whatsapp_enabled ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-500' }}">WA</span>
        </div>
    </td>
    <td class="px-6 py-5 text-right">
        <div class="flex justify-end gap-3">
            @can('edit_garages')
                <x-a href="{{ route('admin.garages.edit', $item) }}" class="!rounded-xl !bg-blue-50 dark:!bg-blue-900/30 !text-blue-600 dark:!text-blue-400 !px-4 !py-1.5 !text-[10px] !font-black !uppercase !border-none">Edit</x-a>
            @endcan
            @can('delete_garages')
                <button wire:click="$parent.deleteGarage({{ $item->id }})" class="text-[10px] font-black uppercase text-red-400 hover:text-red-600">Delete</button>
            @endcan
        </div>
    </td>
</tr>

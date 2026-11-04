<tr class="hover:bg-gray-50/80 dark:hover:bg-gray-900/60 transition-colors border-b border-gray-200 dark:border-gray-700">
    <td class="px-6 py-5 font-bold text-blue-600 dark:text-blue-400">#{{ $item->id }}</td>
    <td class="px-6 py-5 font-extrabold text-gray-900 dark:text-white">{{ $item->name }}</td>
    <td class="px-6 py-5 font-extrabold text-emerald-600 dark:text-emerald-400 font-mono">€{{ number_format($item->price, 2) }}</td>
    <td class="px-6 py-5 text-gray-600 dark:text-gray-300 font-bold">{{ $item->duration_months }} muaj</td>
    <td class="px-6 py-5 text-gray-600 dark:text-gray-300 font-mono">{{ $item->max_users }}</td>
    <td class="px-6 py-5 text-gray-600 dark:text-gray-300 font-mono">{{ $item->max_cars }}</td>
    <td class="px-6 py-5 text-gray-600 dark:text-gray-300 font-mono">{{ $item->max_jobs }}</td>
    <td class="px-6 py-5">
        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase {{ $item->active ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-gray-100 text-gray-600' }}">
            {{ $item->active ? 'Aktiv' : 'Inaktiv' }}
        </span>
    </td>
    <td class="px-6 py-5 text-right">
        <div class="flex justify-end gap-3">
            <x-a href="{{ route('admin.plans.edit', $item) }}" class="!rounded-xl !bg-blue-50 dark:!bg-blue-900/30 !text-blue-600 dark:!text-blue-400 !px-4 !py-1.5 !text-[10px] !font-black !uppercase !border-none">Edit</x-a>
            <button wire:click="$parent.deletePlan({{ $item->id }})" class="text-[10px] font-black uppercase text-red-400 hover:text-red-600">Delete</button>
        </div>
    </td>
</tr>

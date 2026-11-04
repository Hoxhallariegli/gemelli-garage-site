<tr class="hover:bg-gray-50/80 dark:hover:bg-gray-900/60 transition-colors border-b border-gray-200 dark:border-gray-700">
    <td class="px-6 py-5 font-bold text-blue-600 dark:text-blue-400">#{{ $item->id }}</td>
    <td class="px-6 py-5 font-extrabold text-gray-900 dark:text-white">Tenant #{{ $item->tenant_id ?? 1 }}</td>
    <td class="px-6 py-5 font-bold text-indigo-600 dark:text-indigo-400">{{ $item->plan?->name ?? 'Plani Baza' }}</td>
    <td class="px-6 py-5 text-gray-600 dark:text-gray-300">{{ $item->starts_at?->format('d/m/Y') }}</td>
    <td class="px-6 py-5 font-bold text-gray-900 dark:text-white">{{ $item->ends_at?->format('d/m/Y') }}</td>
    <td class="px-6 py-5">
        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase {{ $item->status === 'active' ? 'bg-emerald-100 text-emerald-800' : ($item->status === 'trial' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
            {{ strtoupper($item->status) }}
        </span>
    </td>
    <td class="px-6 py-5 text-right">
        <button wire:click="$parent.deleteSubscription({{ $item->id }})" class="text-[10px] font-black uppercase text-red-400 hover:text-red-600">Fshi</button>
    </td>
</tr>

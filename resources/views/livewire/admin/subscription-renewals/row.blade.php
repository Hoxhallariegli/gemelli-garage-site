<tr class="hover:bg-gray-50/80 dark:hover:bg-gray-900/60 transition-colors border-b border-gray-200 dark:border-gray-700">
    <td class="px-6 py-5 font-bold text-blue-600 dark:text-blue-400">#{{ $item->id }}</td>
    <td class="px-6 py-5 font-extrabold text-gray-900 dark:text-white">Tenant #{{ $item->tenant_id ?? 1 }}</td>
    <td class="px-6 py-5 font-bold text-indigo-600 dark:text-indigo-400">{{ $item->plan?->name ?? 'N/A' }}</td>
    <td class="px-6 py-5 font-extrabold text-emerald-600 dark:text-emerald-400 font-mono">€{{ number_format($item->amount, 2) }}</td>
    <td class="px-6 py-5 uppercase font-bold text-xs text-gray-600 dark:text-gray-300">{{ str_replace('_', ' ', $item->payment_method) }}</td>
    <td class="px-6 py-5">
        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase {{ $item->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : ($item->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
            {{ strtoupper($item->status) }}
        </span>
    </td>
    <td class="px-6 py-5 text-right">
        @if($item->status === 'pending')
            <div class="flex justify-end gap-2">
                <button wire:click="$parent.approveRenewal({{ $item->id }})" class="px-3 py-1 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700">Mirato</button>
                <button wire:click="$parent.rejectRenewal({{ $item->id }})" class="px-3 py-1 bg-red-600 text-white rounded-xl text-xs font-bold hover:bg-red-700">Refuzo</button>
            </div>
        @else
            <span class="text-xs text-gray-400 font-bold">I përpunuar</span>
        @endif
    </td>
</tr>

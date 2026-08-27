<tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/50 transition-none border-b border-gray-50 dark:border-gray-700/50 last:border-none">
    <td class="px-6 py-5 font-bold text-blue-600 dark:text-blue-400">#{{ $item->id }}</td>
    <td class="px-6 py-5">
        <div class="flex flex-col">
            <span class="font-bold text-gray-900 dark:text-white">{{ $item->title }}</span>
            @if($item->job_id)
                <span class="text-[9px] text-blue-600 font-black uppercase tracking-tighter">{{ __('expenses.Job') }}: #00{{ $item->job_id }} • {{ $item->job?->car?->license_plate }}</span>
            @endif
        </div>
    </td>
    <td class="px-6 py-5">
        @php
            $catColors = [
                'rent' => 'bg-purple-100 text-purple-600',
                'electricity' => 'bg-yellow-100 text-yellow-600',
                'water' => 'bg-blue-100 text-blue-600',
                'supplies' => 'bg-orange-100 text-orange-600',
                'salary' => 'bg-emerald-100 text-emerald-600',
                'marketing' => 'bg-pink-100 text-pink-600',
                'other' => 'bg-gray-100 text-gray-600',
            ];
        @endphp
        <span class="px-3 py-1 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $catColors[$item->category] ?? 'bg-gray-100 text-gray-600' }}">
            {{ __('expenses.categories.' . $item->category) }}
        </span>
    </td>
    <td class="px-6 py-5 text-sm font-black text-red-500 italic">€{{ number_format($item->amount, 2) }}</td>
    <td class="px-6 py-5 text-gray-500 dark:text-gray-400 text-xs font-bold whitespace-nowrap">
        {{ $item->date->format('d/m/Y') }}
    </td>
    <td class="px-6 py-5 text-right !transition-none">
        <div class="flex justify-end gap-3 !transition-none">
            <x-a href="{{ route('admin.jobs.edit', $item) }}" class="!rounded-xl !bg-blue-50 dark:!bg-blue-900/30 !text-blue-600 dark:!text-blue-400 !px-4 !py-1.5 !text-[10px] !font-black !uppercase !border-none">{{ __('admin.Edit') }}</x-a>

            <div x-data="{ confirmation: '' }" x-cloak class="inline-block">
                <x-modal>
                    <x-slot name="trigger"><button @click="on = true" class="text-[10px] font-black uppercase text-red-400 hover:text-red-600 dark:hover:text-red-300">{{ __('admin.Delete') }}</button></x-slot>
                    <x-slot name="modalTitle"><div class="text-left dark:text-white">{{ __('expenses.delete_confirm_title') ?? 'Fshi Shpenzimin' }} #{{ $item->id }}?</div></x-slot>
                    <x-slot name="content"><div class="text-left space-y-2"><p class="text-sm text-gray-500 dark:text-gray-400">{{ __('expenses.delete_warning_id') ?? 'Veprim i pakthyeshëm. Shkruaj ID për konfirmim.' }}</p><input x-model="confirmation" placeholder="ID" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-red-500 outline-none"></div></x-slot>
                    <x-slot name="footer"><x-button variant="gray" @click="on = false">{{ __('admin.Cancel') }}</x-button><x-button variant="red" x-bind:disabled="confirmation !== '{{ $item->id }}'" wire:click="$parent.deleteExpense('{{ $item->id }}')" @click="on = false">{{ __('admin.Delete') }}</x-button></x-slot>
                </x-modal>
            </div>
        </div>
    </td>
</tr>

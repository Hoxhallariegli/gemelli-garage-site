<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <x-h1>Rinovimi i Abonimeve</x-h1>
            <x-short-description class="dark:text-gray-400">Menaxhimi i kërkesave për rinovim dhe miratimi i pagesave</x-short-description>
        </div>
    </div>

    @include('errors.messages')

    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm space-y-6">
        <div class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-100/70 dark:bg-gray-700/70 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <x-table.th name="id" label="ID" :$sortField :$sortAsc :sortable="true" />
                        <x-table.th name="tenant_id" label="Kompania" :$sortField :$sortAsc :sortable="true" />
                        <x-table.th name="plan_id" label="Plani i Kërkuar" :$sortField :$sortAsc :sortable="true" />
                        <x-table.th name="amount" label="Shuma (€)" :$sortField :$sortAsc :sortable="true" />
                        <x-table.th name="payment_method" label="Mënyra e Pagesës" :$sortField :$sortAsc :sortable="true" />
                        <x-table.th name="status" label="Statusi" :$sortField :$sortAsc :sortable="true" />
                        <th class="px-6 py-4 text-right text-[10px] font-black uppercase text-gray-400 tracking-widest">Veprimet</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($items as $item)
                        <livewire:admin.subscription-renewals.row :$item :key="$item->id" />
                    @empty
                        <tr><td colspan="100" class="px-6 py-10 text-center text-sm text-gray-400">Nuk u gjet asnjë kërkesë rinovimi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $items->links() }}</div>
    </div>
</div>

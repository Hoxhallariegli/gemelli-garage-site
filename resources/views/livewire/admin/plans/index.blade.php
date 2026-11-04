<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <x-h1>Planet e Abonimit</x-h1>
            <x-short-description class="dark:text-gray-400">Menaxhimi i paketave dhe kufizimeve për kompanitë</x-short-description>
        </div>
        <div class="flex items-center gap-3">
            <x-btn :href="route('admin.plans.create')" icon="plus">Shto Plan të Ri</x-btn>
        </div>
    </div>

    @include('errors.messages')

    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm space-y-6">
        <div class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-100/70 dark:bg-gray-700/70 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <x-table.th name="id" label="ID" :$sortField :$sortAsc :sortable="true" />
                        <x-table.th name="name" label="Emri i Planit" :$sortField :$sortAsc :sortable="true" />
                        <x-table.th name="price" label="Çmimi (€)" :$sortField :$sortAsc :sortable="true" />
                        <x-table.th name="duration_months" label="Kohëzgjatja (Muaj)" :$sortField :$sortAsc :sortable="true" />
                        <x-table.th name="max_users" label="Max Punonjës" :$sortField :$sortAsc :sortable="true" />
                        <x-table.th name="max_cars" label="Max Makina" :$sortField :$sortAsc :sortable="true" />
                        <x-table.th name="max_jobs" label="Max Punë" :$sortField :$sortAsc :sortable="true" />
                        <x-table.th name="active" label="Aktiv" :$sortField :$sortAsc :sortable="true" />
                        <th class="px-6 py-4 text-right text-[10px] font-black uppercase text-gray-400 tracking-widest">Veprimet</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($items as $item)
                        <livewire:admin.plans.row :$item :key="$item->id" />
                    @empty
                        <tr><td colspan="100" class="px-6 py-10 text-center text-sm text-gray-400">Nuk u gjet asnjë plan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $items->links() }}</div>
    </div>
</div>

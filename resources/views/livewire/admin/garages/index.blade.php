<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <x-h1>Garazhet / Serviset</x-h1>
            <x-short-description class="dark:text-gray-400">Menaxhimi i kompanive, serviseve dhe garazhet aktive në sistem</x-short-description>
        </div>
        @can('add_garages')
            <div class="flex items-center gap-3">
                <x-btn :href="route('admin.garages.create')" icon="plus">Shto Garazh të Ri</x-btn>
            </div>
        @endcan
    </div>

    @include('errors.messages')

    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm space-y-6">
        <div class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-100/70 dark:bg-gray-700/70 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-gray-400">ID</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-gray-400">Emri i Garazhit</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-gray-400">Qyteti / Adresa</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-gray-400">Telefoni</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-gray-400">SMS / WhatsApp</th>
                        <th class="px-6 py-4 text-right text-[10px] font-black uppercase text-gray-400">Veprimet</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($items as $item)
                        <livewire:admin.garages.row :$item :key="$item->id" />
                    @empty
                        <tr><td colspan="100" class="px-6 py-10 text-center text-sm text-gray-400">Nuk u gjet asnjë garazh.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $items->links() }}</div>
    </div>
</div>

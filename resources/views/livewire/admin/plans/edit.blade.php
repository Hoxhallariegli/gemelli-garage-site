<div class="space-y-6 max-w-3xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <x-h1>Përditëso Planin: {{ $name }}</x-h1>
            <x-short-description>Modifiko kufizimet dhe çmimin e këtij plani</x-short-description>
        </div>
        <x-btn href="{{ route('admin.plans.index') }}" variant="gray">Kthehu</x-btn>
    </div>

    <form wire:submit="save" class="bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-100 dark:border-gray-700 space-y-6">
        <div>
            <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Emri i Planit</label>
            <input type="text" wire:model="name" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white">
            @error('name') <span class="text-xs text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Çmimi (€)</label>
                <input type="number" step="0.01" wire:model="price" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Kohëzgjatja (Muaj)</label>
                <input type="number" wire:model="duration_months" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Max Punonjës</label>
                <input type="number" wire:model="max_users" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Max Makina</label>
                <input type="number" wire:model="max_cars" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Max Punë</label>
                <input type="number" wire:model="max_jobs" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white">
            </div>
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" wire:model="active" id="active" class="w-5 h-5 rounded text-blue-600">
            <label for="active" class="text-sm font-bold text-gray-700 dark:text-gray-300">Aktiv</label>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end">
            <x-btn type="submit" variant="blue">Përditëso Planin</x-btn>
        </div>
    </form>
</div>

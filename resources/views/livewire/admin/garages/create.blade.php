<div class="space-y-6 max-w-3xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <x-h1>Shto Garazh të Ri</x-h1>
            <x-short-description>Regjistroni një servis apo garazh të ri në sistem</x-short-description>
        </div>
        <x-btn href="{{ route('admin.garages.index') }}" variant="gray">Kthehu</x-btn>
    </div>

    <form wire:submit="save" class="bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-100 dark:border-gray-700 space-y-6">
        <div>
            <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Emri i Garazhit / Servisit</label>
            <input type="text" wire:model.live="name" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white" placeholder="P.sh. Gemelli Auto Garage">
            @error('name') <span class="text-xs text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">URL Slug</label>
            <input type="text" wire:model="slug" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white">
            @error('slug') <span class="text-xs text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Telefoni</label>
                <input type="text" wire:model="phone" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white" placeholder="+35569XXXXXXX">
            </div>
            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" wire:model="email" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white" placeholder="info@gemelligarage.al">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Qyteti</label>
                <input type="text" wire:model="city" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white" placeholder="Tiranë">
            </div>
            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Adresa</label>
                <input type="text" wire:model="address" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white" placeholder="Rruga e Durrësit">
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end">
            <x-btn type="submit" variant="blue">Ruaj Garazhin</x-btn>
        </div>
    </form>
</div>

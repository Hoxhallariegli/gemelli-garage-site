<div class="space-y-6 max-w-3xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <x-h1>Modifiko Garazhin: {{ $name }}</x-h1>
            <x-short-description>Përditëso të dhënat e servisit dhe cilësimet e njoftimeve</x-short-description>
        </div>
        <x-btn href="{{ route('admin.garages.index') }}" variant="gray">Kthehu</x-btn>
    </div>

    <form wire:submit="save" class="bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-100 dark:border-gray-700 space-y-6">
        <div>
            <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Emri i Garazhit / Servisit</label>
            <input type="text" wire:model="name" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white">
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
                <input type="text" wire:model="phone" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" wire:model="email" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Qyteti</label>
                <input type="text" wire:model="city" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Adresa</label>
                <input type="text" wire:model="address" class="w-full p-3 font-bold border border-gray-200 dark:border-gray-700 rounded-2xl dark:bg-gray-900 dark:text-white">
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 space-y-4">
            <div class="flex items-center gap-3">
                <input type="checkbox" wire:model="sms_enabled" id="sms_enabled" class="w-5 h-5 rounded text-blue-600">
                <label for="sms_enabled" class="text-sm font-bold text-gray-700 dark:text-gray-300">Aktivizo SMS Gateway për këtë garazh</label>
            </div>
            <div class="flex items-center justify-between p-4 bg-emerald-50/50 dark:bg-emerald-950/20 rounded-2xl border border-emerald-100 dark:border-emerald-800">
                <div class="flex items-center gap-3">
                    <input type="checkbox" wire:model="whatsapp_enabled" id="whatsapp_enabled" class="w-5 h-5 rounded text-emerald-600">
                    <div>
                        <label for="whatsapp_enabled" class="text-sm font-bold text-gray-800 dark:text-gray-200">Aktivizo WhatsApp Gateway</label>
                        <p class="text-xs text-gray-500">Çiftimi me numrin e telefonit bëhet me seancën <span class="font-mono font-bold text-emerald-600">tenant_{{ $garage->id }}</span></p>
                    </div>
                </div>
                <a href="{{ str_replace('/send', '/qr', config('services.whatsapp.gateway_url', 'http://127.0.0.1:3000/api/whatsapp/send')) }}?session_key=tenant_{{ $garage->id }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl text-xs transition-all shadow-sm">
                    <x-heroicon-o-qr-code class="size-4" /> Skano QR Code
                </a>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end">
            <x-btn type="submit" variant="blue">Përditëso Garazhin</x-btn>
        </div>
    </form>
</div>

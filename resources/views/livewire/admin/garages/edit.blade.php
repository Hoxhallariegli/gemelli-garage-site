<div class="space-y-10">
    <div class="flex items-center justify-between gap-4 px-1">
        <div>
            <x-h1>Modifiko Garazhin: {{ $name }}</x-h1>
            <x-short-description class="dark:text-gray-400">Përditëso të dhënat e servisit dhe cilësimet e njoftimeve</x-short-description>
        </div>
        <x-back-btn route="admin.garages.index" />
    </div>

    @include('errors.messages')

    <div class="bg-white dark:bg-gray-800 p-8 sm:p-12 rounded-[2.5rem] shadow-sm border border-gray-50 dark:border-gray-700">
        <form wire:submit.prevent="save" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                <div>
                    <x-form.input name="name" type="text" wire:model="name" label="Emri i Garazhit / Servisit" class="dark:bg-gray-900" />
                </div>
                <div>
                    <x-form.input name="slug" type="text" wire:model="slug" label="URL Slug" class="dark:bg-gray-900" />
                </div>
                <div>
                    <x-form.input name="phone" type="text" wire:model="phone" label="Telefoni" class="dark:bg-gray-900" />
                </div>
                <div>
                    <x-form.input name="email" type="email" wire:model="email" label="Email" class="dark:bg-gray-900" />
                </div>
                <div>
                    <x-form.input name="city" type="text" wire:model="city" label="Qyteti" class="dark:bg-gray-900" />
                </div>
                <div>
                    <x-form.input name="address" type="text" wire:model="address" label="Adresa" class="dark:bg-gray-900" />
                </div>
            </div>

            <!-- WhatsApp Integration Section -->
            <div class="pt-6 border-t border-gray-100 dark:border-gray-700 space-y-6">
                <div class="p-6 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-2xl border border-emerald-100 dark:border-emerald-800/30 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-emerald-100 dark:bg-emerald-900/40 rounded-xl">
                                <x-heroicon-o-chat-bubble-left-right class="size-6 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <div>
                                <h4 class="font-black text-sm text-gray-900 dark:text-white uppercase tracking-tight">Integrimi WhatsApp QR Code për {{ $name }}</h4>
                                <p class="text-xs text-gray-500 font-bold">Çiftimi me numrin e telefonit bëhet automatikisht për garazhin: <span class="font-bold text-emerald-600">{{ $garage->name }}</span> ({{ $garage->slug }})</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="button" wire:click="checkWhatsAppStatus" class="px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold rounded-xl hover:bg-gray-50 transition">
                                Rifresko Statusin
                            </button>
                            <button type="button" wire:click="generateWhatsAppQr" class="px-5 py-2.5 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition flex items-center gap-2">
                                <x-heroicon-o-qr-code class="size-4" />
                                <span>Gjenero QR Code</span>
                            </button>
                        </div>
                    </div>

                    @if($wa_connected)
                        <div class="p-4 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-200 rounded-xl text-xs font-bold flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>WhatsApp për këtë garazh është 100% i lidhur dhe aktiv! {{ $wa_phone ? '('.$wa_phone.')' : '' }}</span>
                        </div>
                    @elseif($wa_qr)
                        <div class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 text-center space-y-3">
                            <p class="text-xs font-bold text-gray-700 dark:text-gray-300">Skanoni këtë QR Code me aplikacionin WhatsApp në telefonin tuaj:</p>
                            <div class="p-3 bg-white rounded-2xl shadow-md inline-block">
                                <img src="{{ $wa_qr }}" alt="WhatsApp QR Code" class="w-64 h-64 object-contain">
                            </div>
                            <p class="text-[11px] text-gray-400">Settings -> Linked Devices -> Link a Device</p>
                        </div>
                    @else
                        <div class="p-4 bg-gray-100/70 dark:bg-gray-800/60 text-gray-500 dark:text-gray-400 rounded-xl text-xs font-medium">
                            Klikoni "Gjenero QR Code" për të marrë barkodin e lidhjes së WhatsApp.
                        </div>
                    @endif
                </div>

                <!-- Notification Channels Checkboxes -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                    <div class="p-6 bg-gray-50/50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700 flex items-center justify-between">
                        <div>
                            <span class="block font-bold text-sm text-gray-900 dark:text-white">Aktivizo SMS Gateway</span>
                            <span class="text-xs text-gray-500">Dërgimi i SMS për këtë garazh</span>
                        </div>
                        <input type="checkbox" wire:model="sms_enabled" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 size-5">
                    </div>

                    <div class="p-6 bg-gray-50/50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700 flex items-center justify-between">
                        <div>
                            <span class="block font-bold text-sm text-gray-900 dark:text-white">Aktivizo WhatsApp Gateway</span>
                            <span class="text-xs text-gray-500">Dërgimi i mesazheve WhatsApp për këtë garazh</span>
                        </div>
                        <input type="checkbox" wire:model="whatsapp_enabled" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 size-5">
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-end">
                <x-button type="submit" variant="blue" class="w-full sm:w-auto !px-12 !py-4 !rounded-2xl">Përditëso Garazhin</x-button>
            </div>
        </form>
    </div>
</div>

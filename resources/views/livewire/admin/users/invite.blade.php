<x-modal>
    <x-slot name="trigger">
        <x-button @click="on = true">{{ __('users.Add User') }}</x-button>
    </x-slot>

    <x-slot name="modalTitle">{{ __('users.Add User') }}</x-slot>

    <x-slot name="content">

        @include('errors.success')

        <x-form.input tabindex="1" wire:model="name" :label="__('users.Name')" name="name" required />
        <x-form.input tabindex="3" wire:model="email" :label="__('users.Email')" name="email" required />

        <div class="mt-4 space-y-2">
            <label class="block text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">Menaxhimi i Aksesit sipas Garazhit / Servisit</label>
            <div class="overflow-hidden rounded-2xl border border-gray-100 dark:border-gray-700">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Garazhi / Servisi</th>
                            <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Rolet e Atribuara</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($allGarages as $garage)
                            <tr wire:key="invite-garage-{{ $garage->id }}" class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-4 py-3">
                                    <span class="font-bold text-xs text-gray-700 dark:text-gray-300">{{ $garage->name }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($availableRoles as $role)
                                            <label wire:key="invite-role-{{ $garage->id }}-{{ $role->id }}" class="flex items-center gap-1.5 cursor-pointer">
                                                <input type="checkbox"
                                                       wire:model="garageRoles.{{ $garage->id }}"
                                                       value="{{ $role->id }}"
                                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 size-4">
                                                <span class="text-xs font-bold text-gray-500 uppercase tracking-tighter">{{ $role->label ?? $role->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </x-slot>

    <x-slot name="footer">
        <x-button variant="gray" @click="on = false">{{ __('users.Close') }}</x-button>
        <x-button wire:click="store">{{ __('users.Resend Invite') }}</x-button>
    </x-slot>

</x-modal>

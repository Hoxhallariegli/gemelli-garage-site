<tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/50 transition-none border-b border-gray-50 dark:border-gray-700/50 last:border-none">
    <td class="px-4 py-3">
        <div class="flex items-center gap-4">
            @if($item->body_type_image)
                <div class="size-14 rounded-2xl bg-gray-50 dark:bg-gray-800 p-1 border border-gray-100 dark:border-gray-700 flex items-center justify-center shrink-0 overflow-hidden">
                    <img src="{{ asset($item->body_type_image) }}" class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal">
                </div>
            @endif
            <div class="flex flex-col">
                <span class="text-[10px] font-black text-blue-600 uppercase tracking-tight">{{ $item->car?->client?->name ?? 'N/A' }}</span>
                <span class="font-bold text-gray-900 dark:text-white">{{ $item->car?->license_plate ?? '-' }}</span>
                <div class="flex items-center gap-1.5 text-[8px] text-gray-400 font-bold uppercase tracking-widest">
                    <span>{{ $item->car?->brand?->name }}</span>
                    <span>{{ $item->car?->model?->name }}</span>
                </div>
            </div>
        </div>
    </td>
    <td class="px-4 py-3">
        <div class="flex flex-col gap-1.5">
            {{-- Shërbimet --}}
            <div class="flex flex-wrap gap-1">
                @forelse($item->services as $s)
                    <span class="text-[9px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-tight bg-blue-50 dark:bg-blue-900/20 px-1.5 py-0.5 rounded">
                        {{ $s->service?->name }}
                    </span>
                @empty
                    <span class="text-[9px] font-black text-gray-300 uppercase italic">No Service</span>
                @endforelse
            </div>

            {{-- Inventari (Pellicola & Pjesë) --}}
            <div class="flex flex-wrap gap-1">
                @foreach($item->materials as $m)
                    <span class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded text-[8px] font-black uppercase tracking-tighter border border-gray-200 dark:border-gray-600">
                        <x-heroicon-o-square-3-stack-3d class="size-2 inline mr-0.5" />
                        {{ $m->material?->name }} ({{ number_format($m->quantity, 1) }}m)
                    </span>
                @endforeach

                @foreach($item->parts as $p)
                    <span class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded text-[8px] font-black uppercase tracking-tighter border border-gray-200 dark:border-gray-600">
                        <x-heroicon-o-cog-6-tooth class="size-2 inline mr-0.5" />
                        {{ $p->part?->name }}
                    </span>
                @endforeach
            </div>
        </div>
    </td>
    <td class="px-4 py-3 text-right">
        <div class="flex flex-col items-end">
            <span class="font-black text-gray-900 dark:text-white text-sm italic tracking-tighter">€{{ number_format($item->gross_revenue, 0) }}</span>
            @php
                $paymentStatus = $item->payment_status;
                $paymentColors = [
                    'paid' => 'bg-emerald-500/10 text-emerald-600 border-emerald-200',
                    'partial' => 'bg-orange-500/10 text-orange-600 border-orange-200',
                    'unpaid' => 'bg-red-500/10 text-red-600 border-red-200',
                ];
            @endphp
            <span class="mt-1 px-2 py-0.5 rounded border text-[7px] font-black uppercase {{ $paymentColors[$paymentStatus] }}">
                {{ __('jobs.' . $paymentStatus) }}
            </span>
            @if($paymentStatus !== 'paid')
                <span class="text-[8px] font-bold text-gray-400 mt-0.5 italic">{{ __('jobs.Remaining Balance') }}: €{{ number_format($item->remaining_balance, 0) }}</span>
            @endif
        </div>
    </td>
    <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-xs font-bold whitespace-nowrap">
        {{ $item->job_date?->format('d/m/Y') }}
    </td>
    <td class="px-4 py-3">
        @php
            $statusColors = [
                'pending' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                'in_progress' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
            ];
        @endphp
        <span class="px-3 py-1 text-[9px] font-black uppercase tracking-widest rounded-full {{ $statusColors[$item->status] ?? 'bg-gray-100 text-gray-700' }}">
            {{ __('jobs.' . $item->status) ?? str_replace('_', ' ', $item->status) }}
        </span>
    </td>
    <td class="px-4 py-3 text-right !transition-none">
        <div class="flex justify-end gap-3 !transition-none">
            <button wire:click="sendEmail('{{ $item->id }}')" class="relative inline-flex items-center justify-center !rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 px-3 py-1 text-[9px] font-black uppercase border-none hover:bg-blue-100 transition-colors">
                <x-heroicon-o-envelope class="size-3 mr-1" /> {{ __('jobs.Email') ?? 'Email' }}
                @if($item->email_sent_at)
                    <span class="absolute -top-1 -right-1 flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                @endif
            </button>
            <a href="{{ $item->whatsapp_url }}" target="_blank" wire:click="markWhatsAppSent('{{ $item->id }}')" class="relative inline-flex items-center justify-center !rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 px-3 py-1 text-[9px] font-black uppercase border-none hover:bg-emerald-100 transition-colors">
                <x-heroicon-o-chat-bubble-left-right class="size-3 mr-1" /> WhatsApp
                @if($item->whatsapp_sent_at)
                    <span class="absolute -top-1 -right-1 flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                @endif
            </a>
            </a>
            <a href="{{ route('admin.jobs.print', $item) }}" target="_blank" class="inline-flex items-center justify-center !rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-3 py-1 text-[9px] font-black uppercase border-none hover:bg-gray-200 transition-colors">
                <x-heroicon-o-printer class="size-3 mr-1" /> {{ __('jobs.Print') ?? 'Print' }}
            </a>
            @can('edit_jobs')
                <x-a href="{{ route('admin.jobs.edit', $item) }}" class="!rounded-xl !bg-blue-50 dark:!bg-blue-900/30 !text-blue-600 dark:!text-blue-400 !px-3 !py-1 !text-[9px] !font-black !uppercase !border-none">{{ __('jobs.Details') }}</x-a>
            @endcan
            @can('delete_jobs')
                <div x-data="{ confirmation: '' }" x-cloak class="inline-block">
                    <x-modal>
                        <x-slot name="trigger"><button @click="on = true" class="text-[9px] font-black uppercase text-red-400 hover:text-red-600 dark:hover:text-red-300">{{ __('admin.Delete') }}</button></x-slot>
                        <x-slot name="modalTitle"><div class="text-left dark:text-white">{{ __('jobs.Delete Job Card #') }}{{ $item->id }}?</div></x-slot>
                        <x-slot name="content"><div class="text-left space-y-2"><p class="text-sm text-gray-500 dark:text-gray-400">{{ __('jobs.Irreversible action.') }}</p><input x-model="confirmation" placeholder="{{ __('jobs.Type ID to confirm') }} {{ $item->id }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-red-500 outline-none"></div></x-slot>
                        <x-slot name="footer"><x-button variant="gray" @click="on = false">{{ __('admin.Cancel') }}</x-button><x-button variant="red" x-bind:disabled="confirmation !== '{{ $item->id }}'" wire:click="$parent.deleteJob('{{ $item->id }}')" @click="on = false">{{ __('admin.Delete') }}</x-button></x-slot>
                    </x-modal>
                </div>
            @endcan
        </div>
    </td>
</tr>

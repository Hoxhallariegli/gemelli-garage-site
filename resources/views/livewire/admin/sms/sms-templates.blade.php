<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <x-h1>{{ __('SMS Templates') }}</x-h1>
            <x-short-description>{{ __('Manage message templates for reminders, promotions, and automated responses in multiple languages.') }}</x-short-description>
        </div>
        <div>
            <x-btn wire:click="create" variant="blue" icon="plus">
                {{ __('Add New Template') }}
            </x-btn>
        </div>
    </div>

    <x-card padding="p-0 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="size-8 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                    <x-heroicon-o-document-duplicate class="size-4" />
                </div>
                <h3 class="font-black text-gray-900 dark:text-white uppercase tracking-tight text-xs">{{ __('SMS Templates (Multi-Language JSON)') }}</h3>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50/50 dark:bg-gray-900/50 text-[10px] font-black uppercase text-gray-400 tracking-widest">
                    <tr>
                        <th class="px-6 py-4">{{ __('Template Type') }}</th>
                        <th class="px-6 py-4">{{ __('Message Content (JSON / Multi-Lang)') }}</th>
                        <th class="px-6 py-4 text-center">{{ __('Status') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    @forelse($templates as $template)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/30 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[9px] font-bold uppercase tracking-tighter">
                                    {{ $template->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 max-w-xs lg:max-w-md">
                                <div class="space-y-1.5">
                                    @php
                                        $decoded = is_array($template->body) ? $template->body : json_decode((string)$template->body, true);
                                    @endphp
                                    @if(is_array($decoded))
                                        @foreach($locales as $code => $label)
                                            @if(!empty($decoded[$code]))
                                                <div class="text-xs text-gray-600 dark:text-gray-300 flex items-start gap-2">
                                                    <span class="px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-800 text-[9px] font-black uppercase text-gray-400 shrink-0">{{ $code }}</span>
                                                    <span>{{ $decoded[$code] }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <p class="text-gray-600 dark:text-gray-400 text-xs">{{ $template->body }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <x-badge :variant="$template->is_active ? 'success' : 'danger'">
                                    {{ $template->is_active ? __('Active') : __('Inactive') }}
                                </x-badge>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-btn wire:click="edit({{ $template->id }})" variant="blue" size="xs" icon="pencil-square" />
                                    <x-btn wire:click="delete({{ $template->id }})"
                                           wire:confirm="{{ __('Delete this template?') }}"
                                           variant="danger" size="xs" icon="trash" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400 text-xs font-bold uppercase tracking-widest italic">
                                {{ __('No templates found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    {{-- Modal for Create/Edit --}}
    @if($showingModal)
        <div class="fixed z-[9999] inset-0 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl w-full max-w-2xl relative overflow-hidden animate-in fade-in zoom-in duration-200"
                 role="dialog"
                 aria-modal="true">

                <header class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h2 class="text-lg font-black uppercase italic text-gray-900 dark:text-white">
                        {{ $templateId ? __('Edit Template (JSON Multi-Lang)') : __('Create New Template (JSON Multi-Lang)') }}
                    </h2>
                    <button wire:click="$set('showingModal', false)" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <x-heroicon-o-x-mark class="w-6 h-6" />
                    </button>
                </header>

                <main class="p-8 space-y-6">
                    <x-form.group label="Template Type" for="type">
                        <x-form.input wire:model="type" id="type" placeholder="e.g. reminder, promotional, job_view" />
                        <small class="text-gray-400 text-[9px] font-black uppercase tracking-widest italic">{{ __('Used to identify the template in the system.') }}</small>
                    </x-form.group>

                    {{-- Language Tabs --}}
                    <div class="space-y-3">
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">{{ __('Message Body per Language') }}</label>
                        <div class="flex border-b border-gray-200 dark:border-gray-700 gap-2">
                            @foreach($locales as $code => $label)
                                <button type="button"
                                        wire:click="$set('activeTab', '{{ $code }}')"
                                        class="px-4 py-2 text-xs font-bold uppercase tracking-wider border-b-2 transition-all {{ $activeTab === $code ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-400 hover:text-gray-600 dark:hover:text-gray-300' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>

                        {{-- Active Language Textarea --}}
                        @foreach($locales as $code => $label)
                            <div x-show="$wire.activeTab === '{{ $code }}'" class="space-y-2">
                                <x-form.textarea wire:model="body.{{ $code }}" id="body_{{ $code }}" rows="5" placeholder="Përmbajtja e mesazhit në {{ $label }}..." />
                            </div>
                        @endforeach

                        {{-- Tag Pills --}}
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest self-center mr-1">{{ __('Insert Tag:') }}</span>
                            @foreach(['{name}', '{time}', '{link_confirm}', '{link_cancel}'] as $tag)
                                <button type="button"
                                        @click="$wire.body[$wire.activeTab] = ($wire.body[$wire.activeTab] || '') + '{{ $tag }}'"
                                        class="px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 text-[8px] font-black uppercase text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition-colors">
                                    {{ $tag }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </main>

                <footer class="p-6 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3">
                    <x-btn wire:click="$set('showingModal', false)" variant="secondary">
                        {{ __('Cancel') }}
                    </x-btn>
                    <x-btn wire:click="save" variant="blue">
                        {{ __('Save Template (JSON)') }}
                    </x-btn>
                </footer>
            </div>
        </div>
    @endif
</div>

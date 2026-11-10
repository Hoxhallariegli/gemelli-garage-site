<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <x-h1>{{ __('SMS Templates') }}</x-h1>
            <x-short-description>{{ __('Manage message templates for reminders, promotions, and automated responses in multiple languages.') }}</x-short-description>
        </div>
        <div class="shrink-0">
            <x-btn wire:click="create" variant="blue" icon="plus" class="w-full sm:w-auto">
                {{ __('Add New Template') }}
            </x-btn>
        </div>
    </div>

    {{-- Desktop Table View --}}
    <x-card padding="p-0 overflow-hidden" class="hidden md:block">
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
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[10px] font-black uppercase tracking-wider border border-blue-100 dark:border-blue-900/30">
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
                                                    <span class="line-clamp-2">{{ $decoded[$code] }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <p class="text-gray-600 dark:text-gray-400 text-xs line-clamp-2">{{ $template->body }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <x-badge :variant="$template->is_active ? 'success' : 'danger'">
                                    {{ $template->is_active ? __('Active') : __('Inactive') }}
                                </x-badge>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
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

    {{-- Mobile Card List View --}}
    <div class="space-y-4 md:hidden">
        @forelse($templates as $template)
            <div class="p-5 bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-sm space-y-4">
                <div class="flex items-center justify-between gap-2 border-b border-gray-100 dark:border-gray-700/60 pb-3">
                    <span class="px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[10px] font-black uppercase tracking-wider border border-blue-100 dark:border-blue-900/30">
                        {{ $template->type }}
                    </span>
                    <x-badge :variant="$template->is_active ? 'success' : 'danger'">
                        {{ $template->is_active ? __('Active') : __('Inactive') }}
                    </x-badge>
                </div>

                <div class="space-y-2">
                    @php
                        $decoded = is_array($template->body) ? $template->body : json_decode((string)$template->body, true);
                    @endphp
                    @if(is_array($decoded))
                        @foreach($locales as $code => $label)
                            @if(!empty($decoded[$code]))
                                <div class="p-2.5 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700/50 space-y-1">
                                    <span class="px-2 py-0.5 rounded bg-gray-200 dark:bg-gray-800 text-[9px] font-black uppercase text-gray-500 inline-block">{{ $label }}</span>
                                    <p class="text-xs text-gray-700 dark:text-gray-300 font-medium leading-relaxed">{{ $decoded[$code] }}</p>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p class="text-xs text-gray-600 dark:text-gray-400 font-medium">{{ $template->body }}</p>
                    @endif
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100 dark:border-gray-700/60">
                    <x-btn wire:click="edit({{ $template->id }})" variant="blue" size="xs" icon="pencil-square">
                        {{ __('Edit') }}
                    </x-btn>
                    <x-btn wire:click="delete({{ $template->id }})"
                           wire:confirm="{{ __('Delete this template?') }}"
                           variant="danger" size="xs" icon="trash">
                        {{ __('Delete') }}
                    </x-btn>
                </div>
            </div>
        @empty
            <div class="p-8 text-center bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 text-gray-400 text-xs font-bold uppercase tracking-widest italic">
                {{ __('No templates found.') }}
            </div>
        @endforelse
    </div>

    {{-- Responsive Modal for Create/Edit --}}
    @if($showingModal)
        <div class="fixed z-[9999] inset-0 flex items-center justify-center p-2 sm:p-4 bg-gray-900/60 backdrop-blur-sm overflow-y-auto">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-2xl my-auto relative overflow-hidden flex flex-col max-h-[92vh] animate-in fade-in zoom-in duration-200"
                 role="dialog"
                 aria-modal="true">

                <header class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between shrink-0">
                    <h2 class="text-base sm:text-lg font-black uppercase italic text-gray-900 dark:text-white">
                        {{ $templateId ? __('Edit Template') : __('Create New Template') }}
                    </h2>
                    <button wire:click="$set('showingModal', false)" class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                        <x-heroicon-o-x-mark class="w-6 h-6" />
                    </button>
                </header>

                <main class="p-4 sm:p-8 space-y-5 overflow-y-auto custom-scrollbar flex-1">
                    <x-form.group label="Template Type" for="type">
                        <x-form.input wire:model="type" id="type" placeholder="e.g. reminder, promotional, job_view" class="dark:bg-gray-900" />
                        <small class="text-gray-400 text-[9px] font-black uppercase tracking-widest italic block mt-1">{{ __('Used to identify the template in the system.') }}</small>
                    </x-form.group>

                    {{-- Language Tabs --}}
                    <div class="space-y-3">
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">{{ __('Message Body per Language') }}</label>
                        <div class="flex border-b border-gray-200 dark:border-gray-700 gap-1 overflow-x-auto no-scrollbar pb-px">
                            @foreach($locales as $code => $label)
                                <button type="button"
                                        wire:click="$set('activeTab', '{{ $code }}')"
                                        class="px-3 sm:px-4 py-2 text-xs font-bold uppercase tracking-wider border-b-2 whitespace-nowrap transition-all {{ $activeTab === $code ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-400 hover:text-gray-600 dark:hover:text-gray-300' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>

                        {{-- Active Language Textarea --}}
                        @foreach($locales as $code => $label)
                            <div x-show="$wire.activeTab === '{{ $code }}'" class="space-y-2">
                                <x-form.textarea wire:model="body.{{ $code }}" id="body_{{ $code }}" rows="5" placeholder="Përmbajtja e mesazhit në {{ $label }}..." class="dark:bg-gray-900" />
                            </div>
                        @endforeach

                        {{-- Tag Pills --}}
                        <div class="mt-3 flex flex-wrap items-center gap-1.5 p-3 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700/50">
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest w-full sm:w-auto mb-1 sm:mb-0 mr-1">{{ __('Insert Tag:') }}</span>
                            @foreach(['{name}', '{time}', '{link_view}', '{link_confirm}', '{link_cancel}', '{garage}'] as $tag)
                                <button type="button"
                                        @click="$wire.body[$wire.activeTab] = ($wire.body[$wire.activeTab] || '') + '{{ $tag }}'"
                                        class="px-2.5 py-1 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-[9px] font-black uppercase text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-all shadow-sm">
                                    {{ $tag }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </main>

                <footer class="p-4 sm:p-6 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3 shrink-0">
                    <x-btn wire:click="$set('showingModal', false)" variant="secondary">
                        {{ __('Cancel') }}
                    </x-btn>
                    <x-btn wire:click="save" variant="blue">
                        {{ __('Save Template') }}
                    </x-btn>
                </footer>
            </div>
        </div>
    @endif
</div>

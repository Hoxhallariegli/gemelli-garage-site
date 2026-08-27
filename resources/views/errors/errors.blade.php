@if (isset($errors))
    @if (count($errors) > 0)
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-900/30 p-4 rounded-2xl mb-6">
            <div class="flex items-center gap-2 mb-2">
                <x-heroicon-o-exclamation-circle class="w-4 h-4 text-red-600" />
                <span class="text-[10px] font-black uppercase tracking-widest text-red-600">Gabime në Formular</span>
            </div>
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-xs font-bold text-red-500 dark:text-red-400">• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endif

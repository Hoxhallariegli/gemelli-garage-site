<div class="space-y-10">
    <div class="flex items-center justify-between gap-4 px-1">
        <div>
            <x-h1>Shto Shpenzim</x-h1>
            <x-short-description class="dark:text-gray-400">Regjistro një shpenzim të ri në sistem.</x-short-description>
        </div>
        <x-back-btn route="admin.expenses.index" />
    </div>

    @include('errors.errors')

    <div class="bg-white dark:bg-gray-800 p-8 sm:p-12 rounded-[2.5rem] shadow-sm border border-gray-50 dark:border-gray-700">
        <form wire:submit.prevent="store" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                <div class="md:col-span-2">
                    <x-form.input name="title" wire:model="title" label="Titulli / Përshkrimi" placeholder="Psh. Pagesë Qiraje Gusht" class="dark:bg-gray-900" />
                </div>

                <div>
                    <x-form.input name="amount" type="number" step="0.01" wire:model="amount" label="Shuma (€)" placeholder="0.00" class="dark:bg-gray-900" />
                </div>

                <div>
                    <x-form.input name="date" type="date" wire:model="date" label="Data" class="dark:bg-gray-900" />
                </div>

                <div>
                    <label class="block mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-900 dark:text-gray-100 ml-1">Kategoria</label>
                    <select wire:model="category" class="w-full p-3 text-sm font-bold bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-blue-500/20">
                        <option value="">Zgjidh Kategorinë</option>
                        @foreach($categories as $key => $val)
                            <option value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                    @error('category') <span class="text-xs text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-900 dark:text-gray-100 ml-1">Lidhur me Punën (Opsionale)</label>
                    <x-form.dropdown-search wire:model="job_id" :data="$jobs" label="none" placeholder="Zgjidh Job Card" />
                </div>

                <div class="md:col-span-2">
                    <x-form.textarea name="notes" wire:model="notes" label="Shënime Shtesë" placeholder="Detaje të tjera..." class="dark:bg-gray-900" />
                </div>
            </div>

            <div class="mt-10 flex justify-end">
                <x-button type="submit" variant="blue" class="w-full sm:w-auto !px-12 !py-4 !rounded-2xl !text-xs !font-black !uppercase !tracking-widest">Ruaj Shpenzimin</x-button>
            </div>
        </form>
    </div>
</div>

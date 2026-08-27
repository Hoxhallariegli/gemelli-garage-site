<div class="space-y-10">
    <div class="flex items-center justify-between gap-4 px-1">
        <div>
            <x-h1>Suppliers</x-h1>
            <x-short-description>Menaxhimi i furnitorëve të materialeve dhe pjesëve.</x-short-description>
        </div>
        <div class="flex gap-3">
            @if($viewMode == 'list')
                <x-button wire:click="$set('viewMode', 'form')" variant="blue" class="!px-8 !py-3 !rounded-2xl !text-[10px] !font-black !uppercase !tracking-widest">Shto Furnitor</x-button>
            @else
                <x-button wire:click="resetForm" variant="gray" class="!px-8 !py-3 !rounded-2xl !text-[10px] !font-black !uppercase !tracking-widest">Kthehu</x-button>
            @endif
        </div>
    </div>

    @if($viewMode == 'form')
    <div class="bg-white dark:bg-gray-800 p-8 sm:p-12 rounded-[2.5rem] shadow-sm border border-gray-50 dark:border-gray-700 animate-fadeIn">
        <form wire:submit.prevent="save" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <x-form.input wire:model="name" label="Emri i Kompanisë" placeholder="Psh. 3M Albania" />
                <x-form.input wire:model="contact_person" label="Personi Kontaktues" placeholder="Emri..." />
                <x-form.input wire:model="phone" label="Nr. Telefonit" placeholder="06X XXX XXXX" />
                <x-form.input wire:model="email" type="email" label="Email" placeholder="info@supplier.com" />
            </div>
            <div class="flex justify-end pt-6 border-t border-gray-50 dark:border-gray-700">
                <x-button type="submit" variant="blue" class="!px-16 !py-5 !rounded-2xl !text-sm">Ruaj Furnitorin</x-button>
            </div>
        </form>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($suppliers as $supplier)
        <div class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] shadow-sm border border-gray-50 dark:border-gray-700 hover:border-blue-500/30 transition-all group">
            <div class="flex justify-between items-start mb-6">
                <span class="px-3 py-1 bg-blue-500/10 rounded-xl text-[9px] font-black uppercase tracking-widest text-blue-500">Furnitor</span>
            </div>
            <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">{{ $supplier->name }}</h3>
            <p class="text-xs text-gray-400 uppercase font-black tracking-widest mb-2">{{ $supplier->contact_person ?? 'Pa person kontakti' }}</p>
            <div class="space-y-1 text-xs text-gray-500">
                <p>{{ $supplier->phone }}</p>
                <p>{{ $supplier->email }}</p>
            </div>

            <div class="pt-6 mt-6 border-t border-gray-50 dark:border-gray-700 flex gap-3">
                <button wire:click="edit({{ $supplier->id }})" class="flex-1 !bg-gray-50 dark:!bg-gray-900 !text-gray-600 dark:!text-gray-400 !py-3 !rounded-xl !text-[10px] !font-black !uppercase transition-all hover:bg-blue-500 hover:text-white border-none">Edit</button>
                <button wire:click="delete({{ $supplier->id }})" wire:confirm="A jeni i sigurt?" class="flex-1 !bg-red-500/10 !text-red-500 hover:bg-red-500 hover:text-white !py-3 !rounded-xl !text-[10px] !font-black !uppercase transition-all border-none">Fshi</button>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center text-gray-400 font-bold uppercase tracking-widest text-xs">Nuk ka furnitorë të regjistruar.</div>
        @endforelse
    </div>
    @endif
</div>

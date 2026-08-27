<x-layouts.front>
    <main class="mx-auto max-w-screen-xl px-4 sm:mt-12 sm:px-6 md:mt-24 mb-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <h1 class="text-7xl font-black text-gray-900 dark:text-white tracking-tighter italic leading-none">
                    GEMELLI<br><span class="text-blue-600">GARAGE</span>
                </h1>
                <p class="mt-6 text-lg text-gray-500 dark:text-gray-400 font-medium max-w-md">
                    Premium Car Detailing & Professional Wrap Studio. Ne kujdesemi për çdo detaj të mjetit tuaj me pasion dhe profesionalizëm.
                </p>

                <div class="mt-10 flex gap-4">
                    <x-btn :href="route('login')" variant="blue" class="!px-8 !py-4 !rounded-2xl !text-sm !font-black !uppercase !tracking-widest">Dashboard Access</x-btn>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800/50 p-10 rounded-[3rem] border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-40 h-40 bg-blue-600/5 rounded-full -mr-20 -mt-20 group-hover:scale-110 transition-transform duration-700"></div>

                <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tighter mb-8">Contact Us</h2>

                <div class="space-y-8">
                    <div class="flex gap-4">
                        <div class="size-12 rounded-2xl bg-white dark:bg-gray-800 flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                            <x-heroicon-o-map-pin class="size-6" />
                        </div>
                        <div>
                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Sede Legale</span>
                            <p class="text-sm font-bold dark:text-gray-200 uppercase">Viale della repubblica 30,<br>Melegnano 20077</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="size-12 rounded-2xl bg-white dark:bg-gray-800 flex items-center justify-center text-emerald-500 shadow-sm shrink-0">
                            <x-heroicon-o-phone class="size-6" />
                        </div>
                        <div>
                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Call Us</span>
                            <p class="text-sm font-black dark:text-gray-200">+39 324 801 9211</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="size-12 rounded-2xl bg-white dark:bg-gray-800 flex items-center justify-center text-blue-500 shadow-sm shrink-0">
                            <x-heroicon-o-envelope class="size-6" />
                        </div>
                        <div>
                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Email Us</span>
                            <p class="text-sm font-bold dark:text-gray-200">gemellicargarage@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.front>

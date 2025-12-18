<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-slate-700">
                <div class="p-6 text-white">
                    {{ __("Selamat datang kembali! Anda telah login.") }}
                    
                    <div class="mt-4 text-slate-300">
                        Jelajahi menu di atas untuk meminjam barang atau melihat status peminjaman Anda.
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="bg-slate-800 p-6 rounded-lg border border-slate-700 shadow-lg">
                    <h3 class="text-lg font-bold text-white mb-2">Total Barang</h3>
                    <p class="text-3xl text-blue-500 font-bold">120</p>
                </div>
                <div class="bg-slate-800 p-6 rounded-lg border border-slate-700 shadow-lg">
                    <h3 class="text-lg font-bold text-white mb-2">Dipinjam</h3>
                    <p class="text-3xl text-orange-500 font-bold">5</p>
                </div>
                <div class="bg-slate-800 p-6 rounded-lg border border-slate-700 shadow-lg">
                    <h3 class="text-lg font-bold text-white mb-2">Tersedia</h3>
                    <p class="text-3xl text-green-500 font-bold">115</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
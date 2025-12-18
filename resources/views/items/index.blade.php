<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Barang Logistik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-between">
                <a href="{{ route('items.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Tambah Barang Baru
                </a>

                <form action="{{ route('items.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Cari barang..." class="border rounded px-2 py-1">
                    <button type="submit" class="bg-gray-500 text-white px-3 py-1 rounded">Cari</button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($items as $item)
                    <div class="mt-4 flex justify-between items-center">
                        @if($item->status == 'available')
                            <a href="{{ route('loans.create', $item->id) }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Pinjam Barang
                            </a>
                        @else
                            <button disabled
                                class="bg-gray-400 text-white font-bold py-2 px-4 rounded text-sm cursor-not-allowed">
                                Tidak Tersedia
                            </button>
                        @endif

                        <div class="flex space-x-2">
                            <a href="{{ route('items.edit', $item->id) }}"
                                class="text-yellow-600 hover:underline text-sm">Edit</a>

                            <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
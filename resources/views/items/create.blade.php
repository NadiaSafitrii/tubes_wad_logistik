<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Barang Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow-md rounded-lg">
            
            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kode Barang</label>
                    <input type="text" name="code" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Barang</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                    <select name="category" class="w-full border rounded px-3 py-2">
                        <option value="Elektronik">Elektronik</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Alat Musik">Alat Musik</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Stok</label>
                    <input type="number" name="quantity" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi Penyimpanan</label>
                    <input type="text" name="location" class="w-full border rounded px-3 py-2" placeholder="Contoh: Lemari A, Rak 2">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Foto Barang</label>
                    <input type="file" name="photo" class="w-full border rounded px-3 py-2">
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('items.index') }}" class="text-gray-600 mr-4 mt-2">Batal</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Barang</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pengajuan Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow-md rounded-lg">
            
            <div class="mb-6 border-b pb-4">
                <h3 class="text-lg font-bold text-gray-700">Barang yang akan dipinjam:</h3>
                <div class="flex items-center mt-2">
                    @if($item->photo)
                        <img src="{{ asset('storage/' . $item->photo) }}" class="w-16 h-16 object-cover rounded mr-4">
                    @else
                        <div class="w-16 h-16 bg-gray-200 rounded mr-4 flex items-center justify-center text-xs">No Image</div>
                    @endif
                    <div>
                        <p class="text-xl font-bold">{{ $item->name }}</p>
                        <p class="text-sm text-gray-500">Kategori: {{ $item->category }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('loans.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="w-full border rounded px-3 py-2" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tujuan Peminjaman</label>
                    <textarea name="purpose" class="w-full border rounded px-3 py-2" rows="3" placeholder="Contoh: Untuk kegiatan workshop himpunan..." required></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Upload Surat Pengantar (PDF/Gambar)</label>
                    <input type="file" name="letter_file" class="w-full border rounded px-3 py-2" required>
                    <p class="text-xs text-gray-500 mt-1">*Wajib upload surat persetujuan dosen wali/kemahasiswaan.</p>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('items.index') }}" class="text-gray-600 mr-4 mt-2">Batal</a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Ajukan Peminjaman</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
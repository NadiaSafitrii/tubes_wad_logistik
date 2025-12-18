<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola FAQ (Admin)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">Tambah Pertanyaan Baru</h3>
                <form action="{{ route('admin.faqs.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-1">Pertanyaan</label>
                            <input type="text" name="question" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-1">Kategori</label>
                            <select name="category" class="w-full border rounded px-3 py-2">
                                <option value="Umum">Umum</option>
                                <option value="Peminjaman">Peminjaman</option>
                                <option value="Pengembalian">Pengembalian</option>
                                <option value="Sanksi">Sanksi</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-1">Jawaban</label>
                            <textarea name="answer" class="w-full border rounded px-3 py-2" rows="3" required></textarea>
                        </div>
                    </div>
                    <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan FAQ</button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Daftar FAQ Aktif</h3>
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Kategori</th>
                            <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Pertanyaan & Jawaban</th>
                            <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faqs as $faq)
                        <tr>
                            <td class="px-5 py-5 border-b bg-white text-sm">{{ $faq->category }}</td>
                            <td class="px-5 py-5 border-b bg-white text-sm">
                                <div class="font-bold">{{ $faq->question }}</div>
                                <div class="text-gray-500 mt-1">{{ Str::limit($faq->answer, 50) }}</div>
                            </td>
                            <td class="px-5 py-5 border-b bg-white text-sm">
                                <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Hapus FAQ ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
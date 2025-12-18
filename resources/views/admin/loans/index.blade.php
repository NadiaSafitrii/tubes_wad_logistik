<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Approval - Peminjaman Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-900/50 border border-green-500 text-green-200 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-slate-800 overflow-hidden shadow-xl sm:rounded-lg border border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Daftar Permintaan Peminjaman
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-700 bg-slate-900/50">
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Peminjam</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Barang</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700">
                                @forelse($loans ?? [] as $loan)
                                <tr class="hover:bg-slate-700/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-white">{{ $loan->user->name ?? 'User Hapus' }}</div>
                                        <div class="text-xs text-slate-400">{{ $loan->user->email ?? '-' }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-slate-200">{{ $loan->item->name ?? 'Barang Hapus' }}</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-slate-300">
                                            <span class="block text-xs text-slate-500 uppercase">Pinjam:</span>
                                            {{ \Carbon\Carbon::parse($loan->start_date)->format('d M Y') }}
                                        </div>
                                        <div class="text-sm text-slate-300 mt-1">
                                            <span class="block text-xs text-slate-500 uppercase">Kembali:</span>
                                            {{ \Carbon\Carbon::parse($loan->end_date)->format('d M Y') }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($loan->status == 'pending')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-900/50 text-yellow-300 border border-yellow-700">
                                                Menunggu
                                            </span>
                                        @elseif($loan->status == 'approved')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-900/50 text-blue-300 border border-blue-700">
                                                Disetujui (Belum Diambil)
                                            </span>
                                        @elseif($loan->status == 'borrowed')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-900/50 text-indigo-300 border border-indigo-700">
                                                Sedang Dipinjam
                                            </span>
                                        @elseif($loan->status == 'returned')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-900/50 text-green-300 border border-green-700">
                                                Selesai
                                            </span>
                                        @elseif($loan->status == 'rejected')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-900/50 text-red-300 border border-red-700">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            
                                            {{-- Tombol untuk Status: PENDING (Approve / Reject) --}}
                                            @if($loan->status == 'pending')
                                                <form action="{{ route('admin.loans.approve', $loan->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md text-xs transition shadow-sm">
                                                        Setujui
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.loans.reject', $loan->id) }}" method="POST" onsubmit="return confirm('Yakin tolak peminjaman ini?');">
                                                    @csrf
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md text-xs transition shadow-sm">
                                                        Tolak
                                                    </button>
                                                </form>
                                            
                                            {{-- Tombol untuk Status: APPROVED (Barang Diambil) --}}
                                            @elseif($loan->status == 'approved')
                                                <form action="{{ route('admin.loans.pickup', $loan->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-md text-xs transition shadow-sm flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        Barang Diambil
                                                    </button>
                                                </form>

                                            {{-- Tombol untuk Status: BORROWED (Barang Dikembalikan) --}}
                                            @elseif($loan->status == 'borrowed')
                                                <form action="{{ route('admin.loans.return', $loan->id) }}" method="POST" onsubmit="return confirm('Pastikan barang sudah dicek kondisinya. Selesaikan peminjaman?');">
                                                    @csrf
                                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs transition shadow-sm flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                        Selesai (Kembali)
                                                    </button>
                                                </form>

                                            {{-- Status Selesai / Ditolak --}}
                                            @else
                                                <span class="text-slate-500 text-xs italic">Tidak ada aksi</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-10 h-10 mb-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            <p>Tidak ada data peminjaman saat ini.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(isset($loans) && method_exists($loans, 'links'))
                        <div class="mt-6">
                            {{ $loans->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
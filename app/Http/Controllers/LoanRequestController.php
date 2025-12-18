<?php

namespace App\Http\Controllers;

use App\Models\LoanRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanRequestController extends Controller
{
    // Menampilkan daftar peminjaman saya (Status & Riwayat)
    public function index()
    {
        // Ambil data peminjaman milik user yang sedang login, urutkan dari yang terbaru
        $loans = LoanRequest::with('item')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('loans.index', compact('loans'));
    }

    // Menampilkan Form Peminjaman untuk barang tertentu
    public function create(Item $item)
    {
        return view('loans.create', compact('item'));
    }

    // Proses Simpan Pengajuan Peminjaman
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'purpose' => 'required|string|max:255',
            'letter_file' => 'required|file|mimes:pdf,jpg,png|max:2048', // Wajib upload surat (PDF/Gambar)
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id(); // Set peminjam sebagai user yang login
        $data['status'] = 'pending'; // Status awal selalu pending

        // Upload Surat
        if ($request->file('letter_file')) {
            $data['letter_file'] = $request->file('letter_file')->store('loan-letters', 'public');
        }

        LoanRequest::create($data);

        return redirect()->route('loans.index')->with('success', 'Pengajuan peminjaman berhasil dikirim! Menunggu persetujuan.');
    }

    public function adminIndex()
    {
        // Ambil semua data peminjaman, urutkan dari yang statusnya 'pending'
        $loans = LoanRequest::with(['user', 'item'])
                    ->orderByRaw("FIELD(status, 'pending', 'approved', 'picked_up', 'returned', 'rejected')")
                    ->latest()
                    ->get();

        return view('admin.loans.index', compact('loans'));
    }

    // 2. Aksi Menyetujui (Approve)
    public function approve($id)
    {
        $loan = LoanRequest::findOrFail($id);
        
        // Cek stok barang (Opsional: kurangi stok di sini jika mau sistem stok otomatis)
        $item = $loan->item;
        if($item->quantity > 0) {
            $loan->update(['status' => 'approved']);
            
            // Opsional: Kurangi stok
            // $item->decrement('quantity'); 
            
            return redirect()->back()->with('success', 'Peminjaman disetujui!');
        } else {
            return redirect()->back()->with('error', 'Stok barang habis!');
        }
    }

    // 3. Aksi Menolak (Reject)
    public function reject(Request $request, $id)
    {
        $loan = LoanRequest::findOrFail($id);
        $loan->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes // Alasan penolakan
        ]);

        return redirect()->back()->with('success', 'Peminjaman ditolak.');
    }

    // 4. Aksi Barang Diambil (Picked Up)
    public function pickup($id)
    {
        $loan = LoanRequest::findOrFail($id);
        $loan->update(['status' => 'picked_up']);
        return redirect()->back()->with('success', 'Status: Barang telah diambil peminjam.');
    }

    // 5. Aksi Barang Dikembalikan (Return)
    public function returnItem($id)
    {
        $loan = LoanRequest::findOrFail($id);
        $loan->update(['status' => 'returned']);
        
        // Opsional: Jika tadi stok dikurangi, sekarang ditambah lagi
        // $loan->item->increment('quantity');

        return redirect()->back()->with('success', 'Barang telah dikembalikan.');
    }
}
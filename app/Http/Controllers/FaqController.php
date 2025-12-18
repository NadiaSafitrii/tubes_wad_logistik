<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // 1. Halaman untuk Mahasiswa (Hanya Lihat)
    public function index()
    {
        // Mengambil FAQ yang aktif
        $faqs = Faq::where('is_active', true)->latest()->get();
        return view('faqs.index', compact('faqs'));
    }

    // 2. Halaman Admin (Kelola FAQ)
    public function adminIndex()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    // 3. Simpan FAQ Baru (Admin)
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'category' => 'required'
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'category' => $request->category,
            'is_active' => true
        ]);

        return redirect()->back()->with('success', 'FAQ berhasil ditambahkan!');
    }

    // 4. Hapus FAQ (Admin)
    public function destroy($id)
    {
        Faq::destroy($id);
        return redirect()->back()->with('success', 'FAQ dihapus.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // Menampilkan daftar barang (Untuk Admin & Mahasiswa)
    public function index(Request $request)
    {
        // Fitur Search sederhana
        $query = Item::query();
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
        }
        
        $items = $query->latest()->get();
        return view('items.index', compact('items'));
    }

    // Form Tambah Barang (Hanya Admin - nanti kita proteksi di Route)
    public function create()
    {
        return view('items.create');
    }

    // Proses Simpan Barang Baru
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:items',
            'name' => 'required',
            'quantity' => 'required|integer',
            'photo' => 'image|file|max:2048' // Validasi foto maks 2MB
        ]);

        $data = $request->all();

        // Cek jika ada upload foto
        if ($request->file('photo')) {
            $data['photo'] = $request->file('photo')->store('items-photos', 'public');
        }

        Item::create($data);

        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    // Form Edit Barang
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    // Proses Update Barang
    public function update(Request $request, Item $item)
    {
        $data = $request->all();

        if ($request->file('photo')) {
            // Hapus foto lama jika ada
            if ($item->photo) {
                Storage::delete('public/' . $item->photo);
            }
            $data['photo'] = $request->file('photo')->store('items-photos', 'public');
        }

        $item->update($data);

        return redirect()->route('items.index')->with('success', 'Barang berhasil diupdate!');
    }

    // Hapus Barang
    public function destroy(Item $item)
    {
        if ($item->photo) {
            Storage::delete('public/' . $item->photo);
        }
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Barang dihapus!');
    }
}
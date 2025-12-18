<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'start_date',
        'end_date',
        'purpose',
        'letter_file',
        'status',
        'admin_notes',
    ];

    // Relasi: Peminjaman milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Peminjaman adalah untuk satu Barang
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
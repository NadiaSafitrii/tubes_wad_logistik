<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'category',
        'description',
        'specs',
        'photo',
        'quantity',
        'status',
        'location',
    ];

    // Relasi: Satu barang bisa memiliki banyak permintaan peminjaman
    public function loanRequests()
    {
        return $this->hasMany(LoanRequest::class);
    }
}
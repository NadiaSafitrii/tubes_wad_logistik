<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('loan_requests', function (Blueprint $table) {
        $table->id();
        // Relasi ke User (Peminjam)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // Relasi ke Item (Barang)
        $table->foreignId('item_id')->constrained()->onDelete('cascade');
        
        $table->date('start_date');
        $table->date('end_date');
        $table->string('purpose'); // Tujuan peminjaman
        $table->string('letter_file')->nullable(); // File surat pengantar
        
        // Status approval workflow
        $table->enum('status', ['pending', 'approved', 'rejected', 'picked_up', 'returned'])->default('pending');
        
        $table->text('admin_notes')->nullable(); // Catatan admin jika ditolak/lainnya
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_requests');
    }
};

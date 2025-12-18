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
    Schema::create('items', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // Kode barang
        $table->string('name');
        $table->string('category'); // Elektronik, Furniture, dll
        $table->text('description')->nullable();
        $table->text('specs')->nullable(); // Spesifikasi
        $table->string('photo')->nullable();
        $table->integer('quantity'); // Jumlah stok
        $table->enum('status', ['available', 'maintenance', 'lost'])->default('available');
        $table->string('location'); // Lokasi penyimpanan
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};

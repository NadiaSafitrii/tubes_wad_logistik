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
    Schema::table('users', function (Blueprint $table) {
        // Tambahkan kolom role, defaultnya 'student'
        $table->enum('role', ['student', 'admin', 'super_admin'])->default('student')->after('email');
        // Tambahkan nomor induk (NIM/NIP) jika perlu
        $table->string('nomor_induk')->nullable()->after('name');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};

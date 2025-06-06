<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id(); // Sesuai id_buku
            $table->string('judul');
            $table->string('penulis');
            $table->string('isbn')->unique();
            $table->string('penerbit')->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->integer('jumlah_stok')->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('gambar_cover')->nullable(); // Path ke gambar

            $table->foreignId('kategori_id')->nullable()->constrained('kategori')->onDelete('set null');
            $table->foreignId('rak_id')->nullable()->constrained('rak')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_detail', function (Blueprint $table) {
            $table->id(); // Sesuai id_pd
            $table->foreignId('peminjaman_header_id')->constrained('peminjaman_header')->onDelete('cascade'); // Sesuai id_ph
            $table->foreignId('buku_id')->constrained('buku')->onDelete('cascade'); // Sesuai id_buku
            $table->integer('qty')->default(1); // Sesuai qty di ERD
            $table->date('tanggal_pinjam_item'); // Tanggal pinjam spesifik untuk item ini
            $table->date('tanggal_harus_kembali_item'); // Tanggal kembali spesifik untuk item ini
            $table->decimal('denda_item', 8, 2)->nullable()->default(0); // Sesuai denda di ERD
            $table->enum('status_item', ['dipinjam', 'dikembalikan', 'hilang', 'terlambat'])->default('dipinjam');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_detail');
    }
};
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id(); // Sesuai id_pengembalian
            // Foreign key ke peminjaman_detail.id (id_pd)
            // Jika satu item peminjaman hanya bisa dikembalikan sekali, buat unique
            $table->foreignId('peminjaman_detail_id')->unique()->constrained('peminjaman_detail')->onDelete('cascade');
            $table->datetime('tanggal_pengembalian_aktual'); // Sesuai tgl_pengembalian
            $table->decimal('denda_dibayar_aktual', 8, 2)->default(0); // Sesuai denda_dibayar
            $table->string('kondisi_buku_saat_kembali')->nullable(); // Opsional: 'baik', 'rusak ringan', dll.
            $table->text('catatan_pengembalian')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
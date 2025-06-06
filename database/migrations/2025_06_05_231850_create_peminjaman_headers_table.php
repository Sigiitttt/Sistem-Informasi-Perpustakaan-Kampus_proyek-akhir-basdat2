<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_header', function (Blueprint $table) {
            $table->id(); // Sesuai id_ph
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Anggota yang meminjam (id_anggota)
            $table->date('tanggal_transaksi_peminjaman'); // Sesuai tgl_peminjaman di ERD (tanggal keseluruhan transaksi)
            // $table->date('tanggal_harus_kembali_transaksi'); // Jika ada tanggal kembali global untuk transaksi, ERD Anda meletakkannya di header
            $table->decimal('total_denda_transaksi', 8, 2)->nullable()->default(0); // Sesuai total_denda
            $table->string('status_transaksi')->default('pending'); // Contoh: 'pending', 'diproses', 'selesai', 'dibatalkan'
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_header');
    }
};
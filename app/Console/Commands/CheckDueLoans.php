<?php

namespace App\Console\Commands;

use App\Models\PeminjamanDetail;
use App\Notifications\LoanDueSoon;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckDueLoans extends Command
{
    /**
     * Nama dan signature dari command.
     */
    protected $signature = 'app:check-due-loans';

    /**
     * Deskripsi dari command.
     */
    protected $description = 'Periksa peminjaman yang akan jatuh tempo dan kirim notifikasi';

    /**
     * Jalankan logika command.
     */
    public function handle()
    {
        $this->info('Memeriksa peminjaman yang akan jatuh tempo...');

        // Cari semua peminjaman yang statusnya 'dipinjam' dan akan jatuh tempo 3 hari dari sekarang.
        $targetDate = Carbon::today()->addDays(3)->toDateString();

        $dueLoans = PeminjamanDetail::with('peminjamanHeader.user')
            ->where('status_item', 'dipinjam')
            ->whereDate('tanggal_harus_kembali_item', $targetDate)
            ->get();

        if ($dueLoans->isEmpty()) {
            $this->info('Tidak ada peminjaman yang jatuh tempo dalam 3 hari.');
            return;
        }

        foreach ($dueLoans as $loan) {
            // Pastikan user ada sebelum mengirim notifikasi
            if ($loan->peminjamanHeader && $loan->peminjamanHeader->user) {
                $user = $loan->peminjamanHeader->user;
                $user->notify(new LoanDueSoon($loan));
                $this->info("Notifikasi dikirim ke {$user->name} untuk buku '{$loan->buku->judul}'.");
            }
        }

        $this->info('Pemeriksaan selesai.');
    }
}
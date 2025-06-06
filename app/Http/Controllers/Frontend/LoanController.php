<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function history()
    {
        $user = Auth::user();

        // Ambil semua detail peminjaman milik user yang sedang login
        // Diurutkan dari yang terbaru, dan gunakan paginasi
        $loanDetails = $user->peminjamanHeaders()
                            ->with('details.buku') // Eager load relasi
                            ->latest() // Urutkan berdasarkan transaksi terbaru
                            ->get()
                            ->flatMap(fn ($header) => $header->details) // Ambil semua detail
                            ->sortByDesc('created_at'); // Urutkan detailnya

        // Karena flatMap mengembalikan Collection, kita perlu membuat Paginator manual
        // jika datanya sangat banyak. Untuk memulai, kita tampilkan semua dulu.
        // Untuk paginasi yang lebih advanced di collection, kita akan bahas nanti jika diperlukan.

        return view('loans.history', [
            'loanDetails' => $loanDetails,
        ]);
    }
}
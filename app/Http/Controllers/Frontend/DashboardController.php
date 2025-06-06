<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan user tidak null sebelum melanjutkan
        if (!$user) {
            // Arahkan ke login jika tidak ada user yang terautentikasi
            return redirect()->route('login');
        }

        /** @var \App\Models\User $user */ // <--- TAMBAHKAN BARIS INI
        // Baris di bawah ini sekarang seharusnya tidak merah lagi
        $activeLoans = $user->peminjamanHeaders()
            ->with('details.buku')
            ->whereHas('details', function ($query) {
                $query->where('status_item', 'dipinjam');
            })
            ->get()
            ->flatMap(function ($header) {
                return $header->details->where('status_item', 'dipinjam');
            });
        $notifications = $user->unreadNotifications()->take(5)->get();

        return view('dashboard', [
            'activeLoans' => $activeLoans,
            'notifications' => $notifications,
        ]);
    }
}

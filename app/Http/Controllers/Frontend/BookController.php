<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Buku; // Import model Buku
use Illuminate\Http\Request;

use App\Models\PeminjamanHeader;
use App\Models\PeminjamanDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();

        // Logika untuk pencarian sederhana
        if ($request->has('search') && $request->search != '') {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%');
        }
        

        // Ambil data buku dengan paginasi (12 buku per halaman)
        $books = $query->paginate(12);

        return view('buku.index', compact('books'));
    }


    public function show(Buku $buku)
    {
        // Berkat Route Model Binding, Laravel otomatis mengambil data buku
        // berdasarkan ID di URL. Kita tinggal menampilkannya di view.
        return view('buku.show', compact('buku'));
    }

    public function borrow(Request $request, Buku $buku)
    {
        // 1. Cek ketersediaan stok buku
        if ($buku->jumlah_stok <= 0) {
            return back()->with('error', 'Maaf, stok buku ini telah habis.');
        }

        $user = Auth::user();

        // 2. (Opsional) Cek apakah user sudah meminjam buku yang sama dan belum dikembalikan
        $isAlreadyBorrowed = PeminjamanDetail::where('buku_id', $buku->id)
            ->where('status_item', 'dipinjam')
            ->whereHas('peminjamanHeader', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->exists();

        if ($isAlreadyBorrowed) {
            return back()->with('error', 'Anda sudah meminjam buku ini dan belum mengembalikannya.');
        }

        // 3. Gunakan Database Transaction untuk memastikan semua proses berhasil
        try {
            DB::transaction(function () use ($user, $buku) {
                // Buat header peminjaman baru
                $peminjamanHeader = PeminjamanHeader::create([
                    'user_id'                       => $user->id,
                    'tanggal_transaksi_peminjaman'  => now(),
                    'status_transaksi'              => 'diproses',
                ]);

                // Catat detail peminjaman
                PeminjamanDetail::create([
                    'peminjaman_header_id'      => $peminjamanHeader->id,
                    'buku_id'                   => $buku->id,
                    'status_item'               => 'dipinjam',
                    'tanggal_pinjam_item'       => now(),
                    'tanggal_harus_kembali_item'=> now()->addDays(7), // Batas waktu 7 hari
                ]);

                // Kurangi stok buku
                $buku->decrement('jumlah_stok');
            });
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat proses peminjaman. Silakan coba lagi. ' . $e->getMessage());
        }

        // 4. Jika berhasil, kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Buku "' . $buku->judul . '" berhasil dipinjam!');
    }
}
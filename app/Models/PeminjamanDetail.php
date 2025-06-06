<?php
// app/Models/PeminjamanDetail.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PeminjamanDetail extends Model
{
    use HasFactory;
    protected $table = 'peminjaman_detail';
    protected $fillable = [
        'peminjaman_header_id', 
        'buku_id', 
        'qty',
        'tanggal_pinjam_item',
        'tanggal_harus_kembali_item',
        'denda_item',
        'status_item',
    ];

    protected $casts = [
        'tanggal_pinjam_item' => 'date',
        'tanggal_harus_kembali_item' => 'date',
    ];

    public function peminjamanHeader()
    {
        return $this->belongsTo(PeminjamanHeader::class, 'peminjaman_header_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function pengembalian()
    {
        // Jika satu PeminjamanDetail hanya punya satu record Pengembalian
        return $this->hasOne(Pengembalian::class, 'peminjaman_detail_id');
    }
    public function hitungDenda(): int
    {
        // Jika status bukan 'dipinjam', tidak ada denda baru yang dihitung.
        if ($this->status_item !== 'dipinjam') {
            return $this->denda_item ?? 0;
        }

        // Ambil tanggal jatuh tempo
        $dueDate = Carbon::parse($this->tanggal_harus_kembali_item);

        // Ambil tanggal hari ini (hanya tanggal, tanpa jam)
        $today = Carbon::today();

        // Jika hari ini belum melewati tanggal jatuh tempo, tidak ada denda.
        if ($today->lte($dueDate)) {
            return 0;
        }

        // Hitung selisih hari keterlambatan
        $daysLate = $today->diffInDays($dueDate);

        // Tentukan tarif denda per hari (misalnya Rp 1.000)
        $tarifDendaPerHari = 1000;

        // Hitung total denda
        $totalDenda = $daysLate * $tarifDendaPerHari;

        return $totalDenda;
    }
}
<?php

// app/Models/Pengembalian.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;
    protected $table = 'pengembalian';
    protected $fillable = [
        'peminjaman_detail_id', 
        'tanggal_pengembalian_aktual', 
        'denda_dibayar_aktual',
        'kondisi_buku_saat_kembali',
        'catatan_pengembalian',
    ];

    protected $casts = [
        'tanggal_pengembalian_aktual' => 'datetime',
    ];

    public function peminjamanDetail()
    {
        return $this->belongsTo(PeminjamanDetail::class, 'peminjaman_detail_id');
    }
}
<?php

// app/Models/PeminjamanHeader.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanHeader extends Model
{
    use HasFactory;
    protected $table = 'peminjaman_header';
    protected $fillable = [
        'user_id', 
        'tanggal_transaksi_peminjaman', 
        // 'tanggal_harus_kembali_transaksi',
        'total_denda_transaksi',
        'status_transaksi',
        'catatan',
    ];

    protected $casts = [
        'tanggal_transaksi_peminjaman' => 'date',
        // 'tanggal_harus_kembali_transaksi' => 'date',
    ];

    public function user() // Anggota
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details() // PeminjamanDetails
    {
        return $this->hasMany(PeminjamanDetail::class, 'peminjaman_header_id');
    }
}
<?php

// app/Models/Buku.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $table = 'buku';
    protected $fillable = [
        'judul', 
        'penulis', 
        'isbn', 
        'penerbit', 
        'tahun_terbit', 
        'jumlah_stok', 
        'deskripsi', 
        'gambar_cover',
        'kategori_id',
        'rak_id',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }

    public function peminjamanDetails()
    {
        return $this->hasMany(PeminjamanDetail::class, 'buku_id');
    }
}
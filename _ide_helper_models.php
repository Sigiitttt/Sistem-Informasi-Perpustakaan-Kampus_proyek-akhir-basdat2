<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $judul
 * @property string $penulis
 * @property string $isbn
 * @property string|null $penerbit
 * @property string|null $tahun_terbit
 * @property int $jumlah_stok
 * @property string|null $deskripsi
 * @property string|null $gambar_cover
 * @property int|null $kategori_id
 * @property int|null $rak_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kategori|null $kategori
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PeminjamanDetail> $peminjamanDetails
 * @property-read int|null $peminjaman_details_count
 * @property-read \App\Models\Rak|null $rak
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku whereGambarCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku whereJumlahStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku whereKategoriId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku wherePenerbit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku wherePenulis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku whereRakId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku whereTahunTerbit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Buku whereUpdatedAt($value)
 */
	class Buku extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nama_kategori
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Buku> $buku
 * @property-read int|null $buku_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereNamaKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereUpdatedAt($value)
 */
	class Kategori extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $peminjaman_header_id
 * @property int $buku_id
 * @property int $qty
 * @property \Illuminate\Support\Carbon $tanggal_pinjam_item
 * @property \Illuminate\Support\Carbon $tanggal_harus_kembali_item
 * @property string|null $denda_item
 * @property string $status_item
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Buku $buku
 * @property-read \App\Models\PeminjamanHeader $peminjamanHeader
 * @property-read \App\Models\Pengembalian|null $pengembalian
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanDetail whereBukuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanDetail whereDendaItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanDetail wherePeminjamanHeaderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanDetail whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanDetail whereStatusItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanDetail whereTanggalHarusKembaliItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanDetail whereTanggalPinjamItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanDetail whereUpdatedAt($value)
 */
	class PeminjamanDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $tanggal_transaksi_peminjaman
 * @property string|null $total_denda_transaksi
 * @property string $status_transaksi
 * @property string|null $catatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PeminjamanDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanHeader newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanHeader newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanHeader query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanHeader whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanHeader whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanHeader whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanHeader whereStatusTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanHeader whereTanggalTransaksiPeminjaman($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanHeader whereTotalDendaTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanHeader whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeminjamanHeader whereUserId($value)
 */
	class PeminjamanHeader extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $peminjaman_detail_id
 * @property \Illuminate\Support\Carbon $tanggal_pengembalian_aktual
 * @property string $denda_dibayar_aktual
 * @property string|null $kondisi_buku_saat_kembali
 * @property string|null $catatan_pengembalian
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PeminjamanDetail $peminjamanDetail
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengembalian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengembalian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengembalian query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengembalian whereCatatanPengembalian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengembalian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengembalian whereDendaDibayarAktual($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengembalian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengembalian whereKondisiBukuSaatKembali($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengembalian wherePeminjamanDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengembalian whereTanggalPengembalianAktual($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengembalian whereUpdatedAt($value)
 */
	class Pengembalian extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nama_rak
 * @property string|null $lokasi_rak
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Buku> $buku
 * @property-read int|null $buku_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rak newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rak newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rak query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rak whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rak whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rak whereLokasiRak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rak whereNamaRak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rak whereUpdatedAt($value)
 */
	class Rak extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $nim
 * @property string $role
 * @property string|null $nomor_telepon
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PeminjamanHeader> $peminjamanHeaders
 * @property-read int|null $peminjaman_headers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNim($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNomorTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}


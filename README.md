<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Sistem Informasi Perpustakaan Kampus
Sebuah aplikasi web berbasis Laravel untuk manajemen perpustakaan di lingkungan kampus. Proyek ini dibangun sebagai portofolio dan demonstrasi implementasi full-stack menggunakan TALL Stack dengan Filament untuk panel admin dan Laravel Blade untuk antarmuka anggota.

Deskripsi Proyek
Aplikasi ini dirancang untuk memfasilitasi operasional perpustakaan mulai dari manajemen katalog buku, pengelolaan anggota, hingga proses sirkulasi (peminjaman dan pengembalian). Terdapat dua antarmuka utama: panel admin yang komprehensif untuk staf perpustakaan, dan portal anggota yang intuitif untuk mahasiswa dan dosen.

Fitur Utama
1. Panel Admin (Dikelola oleh Filament)
Bagian ini didesain untuk staf perpustakaan atau administrator, memungkinkan mereka untuk mengelola operasional perpustakaan secara efisien.

Dashboard Admin: Ringkasan umum aktivitas perpustakaan.
Manajemen Buku (CRUD): Tambah, lihat, edit, dan hapus data buku beserta detailnya (ISBN, stok, kategori, dll).
Manajemen Kategori & Rak: Mengelompokkan buku berdasarkan kategori dan lokasi fisiknya.
Manajemen Anggota (CRUD): Mengelola data mahasiswa dan dosen yang terdaftar sebagai anggota.
Manajemen Peminjaman: Sistem untuk mencatat peminjaman, melihat daftar buku yang sedang dipinjam, dan melakukan proses pengembalian.
Perhitungan Denda Otomatis: Sistem akan menghitung denda secara otomatis jika terjadi keterlambatan saat proses pengembalian.
Laporan Sederhana: Halaman khusus untuk melihat rekap data peminjaman, buku terpopuler, dan anggota teraktif berdasarkan periode waktu.
2. Antarmuka Anggota (Frontend dengan Laravel Blade)
Bagian ini dirancang untuk mahasiswa dan dosen sebagai pengguna perpustakaan.

Autentikasi Pengguna: Sistem registrasi dan login yang aman untuk anggota.
Dashboard Anggota: Menampilkan ringkasan status peminjaman saat ini dan notifikasi penting (misal: buku akan jatuh tempo).
Katalog Buku: Menampilkan daftar lengkap buku yang tersedia dengan fitur pencarian dan paginasi.
Halaman Detail Buku: Menampilkan informasi lengkap sebuah buku, termasuk sinopsis, detail penerbitan, dan status ketersediaan.
Fungsi Pinjam Mandiri: Anggota dapat melakukan aksi peminjaman buku langsung dari halaman katalog atau detail buku.
Riwayat Peminjaman: Halaman untuk melihat semua buku yang pernah dan sedang dipinjam oleh anggota.
Teknologi yang Digunakan
Backend: PHP 8.3, Laravel 12
Admin Panel: Filament 3.x
Frontend: Laravel Blade, Tailwind CSS, Vite
Autentikasi: Laravel Breeze
Database: MySQL

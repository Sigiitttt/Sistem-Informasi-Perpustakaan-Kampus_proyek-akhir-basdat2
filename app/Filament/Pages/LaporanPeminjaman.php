<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use App\Models\PeminjamanDetail;
use App\Models\User;use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class LaporanPeminjaman extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static string $view = 'filament.pages.laporan-peminjaman';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $title = 'Laporan Peminjaman';
    protected static ?string $navigationLabel = 'Laporan Peminjaman';

    // Properti untuk menampung tanggal filter
    public ?string $startDate = null;
    public ?string $endDate = null;

    // Method `mount` dijalankan saat halaman pertama kali dimuat
    public function mount(): void
    {
        // Atur tanggal default ke awal dan akhir bulan ini
        $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->endOfMonth()->toDateString();

        // Isi form dengan tanggal default
        $this->form->fill([
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }

    // Mendefinisikan form filter tanggal
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('startDate')
                    ->label('Tanggal Mulai')
                    ->default(now()->startOfMonth())
                    ->required(),
                DatePicker::make('endDate')
                    ->label('Tanggal Selesai')
                    ->default(now()->endOfMonth())
                    ->required(),
            ])->columns(2);
    }

    // Method ini akan kita panggil di view untuk mengambil data laporan
    public function getReportData()
    {
        // Ambil data form yang terbaru
        $formData = $this->form->getState();
        $startDate = $formData['startDate'];
        $endDate = $formData['endDate'];

        // 1. Total Peminjaman pada periode tertentu
        $totalLoans = PeminjamanDetail::whereBetween('created_at', [$startDate, $endDate])->count();

        // 2. Buku Paling Populer (Top 5)
        $popularBooks = PeminjamanDetail::select('buku_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('buku_id')
            ->orderByDesc('total')
            ->with('buku') // Ambil relasi buku
            ->take(5)
            ->get();

        // 3. Anggota Paling Aktif (Top 5)
        $activeMembers = PeminjamanDetail::join('peminjaman_header', 'peminjaman_detail.peminjaman_header_id', '=', 'peminjaman_header.id')
            ->join('users', 'peminjaman_header.user_id', '=', 'users.id')
            ->select('users.name', DB::raw('count(peminjaman_detail.id) as total_pinjam'))
            ->whereBetween('peminjaman_detail.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_pinjam')
            ->take(5)
            ->get();

        return [
            'totalLoans' => $totalLoans,
            'popularBooks' => $popularBooks,
            'activeMembers' => $activeMembers,
            'startDate' => Carbon::parse($startDate)->format('d M Y'), // Format tanggal untuk ditampilkan
            'endDate' => Carbon::parse($endDate)->format('d M Y'),
        ];
    }

    // Method untuk men-submit form filter
    public function submit()
    {
        // Method ini sengaja dikosongkan karena data akan diambil secara reaktif di view
    }
}
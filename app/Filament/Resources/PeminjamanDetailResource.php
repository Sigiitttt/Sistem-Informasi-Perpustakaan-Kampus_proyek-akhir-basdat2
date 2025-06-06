<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanDetailResource\Pages;
use App\Filament\Resources\PeminjamanDetailResource\RelationManagers;
use App\Models\PeminjamanDetail;
use Filament\Tables\Actions\Action; // <-- Import Action
use App\Models\Pengembalian;      // <-- Import model
use Illuminate\Support\Facades\DB;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;

class PeminjamanDetailResource extends Resource
{
    protected static ?string $model = PeminjamanDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

     protected static ?string $navigationLabel = 'Peminjaman'; // Nama di menu navigasi
    protected static ?string $modelLabel = 'Peminjaman'; // Nama tunggal (misal: "Buat Peminjaman")
    protected static ?string $pluralModelLabel = 'Peminjaman'; // Nama jamak (misal: judul halaman "Peminjaman")
    protected static ?string $slug = 'peminjaman'; // Nama di URL (akan menjadi /admin/peminjaman)

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            // Field Peminjam (hanya bisa dilihat, tidak bisa diubah)
            Select::make('peminjaman_header_id')
                ->relationship('peminjamanHeader.user', 'name') // Menampilkan nama dari relasi
                ->label('Peminjam')
                ->searchable()
                ->preload()
                ->disabled() // Dibuat disabled agar tidak bisa diubah
                ->required(),

            // Field Buku (hanya bisa dilihat, tidak bisa diubah)
            Select::make('buku_id')
                ->relationship('buku', 'judul')
                ->label('Buku yang Dipinjam')
                ->searchable()
                ->preload()
                ->disabled() // Dibuat disabled agar tidak bisa diubah
                ->required(),

            // Field Tanggal Pinjam (hanya bisa dilihat, tidak bisa diubah)
            DatePicker::make('tanggal_pinjam_item')
                ->label('Tanggal Peminjaman')
                ->disabled()
                ->required(),

            // Field Jatuh Tempo (bisa diubah, misalnya untuk perpanjangan)
            DatePicker::make('tanggal_harus_kembali_item')
                ->label('Tanggal Harus Kembali')
                ->required(),

            // Field Status (bisa diubah, misal dari 'dipinjam' menjadi 'hilang')
            Select::make('status_item')
                ->label('Status')
                ->options([
                    'dipinjam' => 'Dipinjam',
                    'dikembalikan' => 'Dikembalikan',
                    'hilang' => 'Hilang',
                    'terlambat' => 'Terlambat',
                ])
                ->required(),

            // Field Denda (bisa diubah manual oleh admin jika perlu)
            TextInput::make('denda_item')
                ->label('Denda (Rp)')
                ->numeric()
                ->prefix('Rp')
                ->nullable(),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('peminjamanHeader.user.name')->label('Peminjam')->searchable(),
                Tables\Columns\TextColumn::make('buku.judul')->label('Buku')->searchable(),
                Tables\Columns\TextColumn::make('status_item')->badge(),
                Tables\Columns\TextColumn::make('tanggal_harus_kembali_item')->date()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Action::make('kembalikan')
                    ->label('Kembalikan Buku')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation() // Meminta konfirmasi sebelum menjalankan aksi
                    ->modalHeading('Konfirmasi Pengembalian Buku')
                    ->modalDescription('Apakah Anda yakin buku ini sudah dikembalikan? Denda akan dihitung secara otomatis.')
                    ->modalSubmitActionLabel('Ya, Sudah Kembali')
                    // Hanya tampilkan tombol ini jika statusnya masih 'dipinjam'
                    ->visible(fn (PeminjamanDetail $record): bool => $record->status_item === 'dipinjam') 
                    ->action(function (PeminjamanDetail $record) {
                        try {
                            DB::transaction(function () use ($record) {
                                // 1. Hitung dan simpan denda
                                $denda = $record->hitungDenda();
                                $record->denda_item = $denda;

                                // 2. Ubah status peminjaman detail
                                $record->status_item = 'dikembalikan';
                                $record->save();

                                // 3. Buat record baru di tabel pengembalian
                                Pengembalian::create([
                                    'peminjaman_detail_id' => $record->id,
                                    'tanggal_pengembalian_aktual' => now(),
                                    'denda_dibayar_aktual' => $denda, // Asumsi denda langsung dibayar
                                ]);

                                // 4. Tambah kembali stok buku
                                $record->buku->increment('jumlah_stok');
                            });

                            // Kirim notifikasi sukses
                            \Filament\Notifications\Notification::make()
                                ->title('Buku Berhasil Dikembalikan')
                                ->success()
                                ->send();

                        } catch (\Exception $e) {
                            // Kirim notifikasi error jika gagal
                            \Filament\Notifications\Notification::make()
                                ->title('Proses Gagal')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjamanDetails::route('/'),
            'create' => Pages\CreatePeminjamanDetail::route('/create'),
            'edit' => Pages\EditPeminjamanDetail::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengembalianResource\Pages;
use App\Models\Pengembalian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
// Import class yang kita butuhkan
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;

class PengembalianResource extends Resource
{
    protected static ?string $model = Pengembalian::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    // --- Perbaikan untuk Form Edit ---
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Menggunakan Placeholder untuk menampilkan info yang tidak bisa diubah
                Placeholder::make('buku_dipinjam')
                    ->label('Buku')
                    ->content(fn (?Pengembalian $record): string => $record?->peminjamanDetail?->buku?->judul ?? '-'),

                Placeholder::make('peminjam')
                    ->label('Peminjam')
                    ->content(fn (?Pengembalian $record): string => $record?->peminjamanDetail?->peminjamanHeader?->user?->name ?? '-'),

                Placeholder::make('tanggal_pengembalian_aktual')
                    ->label('Tanggal Kembali')
                    ->content(fn (?Pengembalian $record): string => $record ? $record->tanggal_pengembalian_aktual->format('d F Y H:i') : '-'),

                // Field yang mungkin perlu diedit oleh admin
                TextInput::make('denda_dibayar_aktual')
                    ->label('Denda Dibayar (Rp)')
                    ->numeric()
                    ->prefix('Rp'),

                TextInput::make('kondisi_buku_saat_kembali')
                    ->label('Kondisi Buku'),

                Forms\Components\Textarea::make('catatan_pengembalian')
                    ->label('Catatan Tambahan')
                    ->columnSpanFull(),
            ]);
    }

    // --- Perbaikan untuk Tabel Daftar ---
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Menggunakan notasi titik untuk mengambil data dari relasi
                TextColumn::make('peminjamanDetail.buku.judul')
                    ->label('Buku')
                    ->searchable()
                    ->sortable()
                    ->wrap(), // Agar teks panjang bisa turun ke bawah

                TextColumn::make('peminjamanDetail.peminjamanHeader.user.name')
                    ->label('Peminjam')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tanggal_pengembalian_aktual')
                    ->label('Waktu Kembali')
                    ->dateTime('d M Y, H:i') // Format tanggal dan waktu
                    ->sortable(),

                TextColumn::make('denda_dibayar_aktual')
                    ->label('Denda')
                    ->money('IDR') // Format sebagai mata uang Rupiah
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengembalians::route('/'),
            'create' => Pages\CreatePengembalian::route('/create'),
            'edit' => Pages\EditPengembalian::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BukuResource\Pages;
use App\Filament\Resources\BukuResource\RelationManagers;
use App\Models\Buku;
use App\Models\Kategori; // Import Kategori
use App\Models\Rak; // Import Rak
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;


class BukuResource extends Resource
{
    protected static ?string $model = Buku::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Manajemen Katalog';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('penulis')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('isbn')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('penerbit')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahun_terbit')
                    ->numeric()
                    ->minValue(1000)
                    ->maxValue(date('Y')),
                Forms\Components\TextInput::make('jumlah_stok')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0),
                Select::make('kategori_id')
                    ->label('Kategori')
                    ->options(Kategori::all()->pluck('nama_kategori', 'id'))
                    ->searchable()
                    ->preload(),
                    // ->relationship('kategori', 'nama_kategori') // Alternatif jika relasi sudah benar didefinisikan
                Select::make('rak_id')
                    ->label('Rak')
                    ->options(Rak::all()->pluck('nama_rak', 'id'))
                    ->searchable()
                    ->preload(),
                    // ->relationship('rak', 'nama_rak') // Alternatif
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
                FileUpload::make('gambar_cover')
                    ->label('Gambar Cover')
                    ->image()
                    ->disk('public') // Pastikan disk 'public' terkonfigurasi dan `php artisan storage:link` sudah dijalankan
                    ->directory('covers') // Opsional, folder penyimpanan di dalam disk public
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar_cover')
                    ->label('Cover')
                    ->disk('public')
                    ->defaultImageUrl(url('/images/default_cover.png')), // Opsional: gambar default jika null
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(fn (Buku $record): string => $record->judul),
                Tables\Columns\TextColumn::make('penulis')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('isbn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori.nama_kategori') // Menampilkan nama dari relasi
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('rak.nama_rak') // Menampilkan nama dari relasi
                    ->label('Rak')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_stok')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama_kategori')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('rak_id')
                    ->label('Rak')
                    ->relationship('rak', 'nama_rak')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBukus::route('/'),
            'create' => Pages\CreateBuku::route('/create'),
            // 'view' => Pages\ViewBuku::route('/{record}'), // PASTIKAN BARIS INI DIKOMENTARI (diawali //) ATAU DIHAPUS
            'edit' => Pages\EditBuku::route('/{record}/edit'),
        ];
    }
}
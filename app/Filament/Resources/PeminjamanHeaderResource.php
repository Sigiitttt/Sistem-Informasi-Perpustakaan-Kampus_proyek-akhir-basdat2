<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanHeaderResource\Pages;
use App\Filament\Resources\PeminjamanHeaderResource\RelationManagers;
use App\Models\PeminjamanHeader;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeminjamanHeaderResource extends Resource


{

     // --- TAMBAHKAN METHOD DI BAWAH INI UNTUK MENYEMBUNYIKAN MENU ---
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    // ----------------------------------------------------------------


    protected static ?string $model = PeminjamanHeader::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjamanHeaders::route('/'),
            'create' => Pages\CreatePeminjamanHeader::route('/create'),
            'edit' => Pages\EditPeminjamanHeader::route('/{record}/edit'),
        ];
    }
}

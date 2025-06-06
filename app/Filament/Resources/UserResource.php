<?php

namespace App\Filament\Resources;
use Filament\Forms;
use Filament\Forms\Form; // Sudah ada
use Filament\Resources\Resource; // Sudah ada
use Filament\Tables\Table; // Sudah ada
use Illuminate\Support\Facades\Hash; // Tambahkan jika belum ada
use Filament\Forms\Components\Select; // Tambahkan jika belum ada
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;


use App\Filament\Resources\UserResource\Pages; // Pastikan ini ada dan benar

class UserResource extends Resource
{
    // ... (properti static dan method form() Anda yang sudah benar) ...

    public static function form(Form $form): Form // Method form() Anda yang sudah benar
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nama Lengkap')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->label('Alamat Email')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('nim')
                    ->label('Nomor Induk (NIM/NIDN/Pegawai)')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->nullable(),
                Select::make('role')
                    ->label('Level Pengguna')
                    ->options([
                        'admin' => 'Admin',
                        'mahasiswa' => 'Mahasiswa',
                        'dosen' => 'Dosen',
                    ])
                    ->required()
                    ->default('mahasiswa'),
                Forms\Components\TextInput::make('nomor_telepon')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->maxLength(20)
                    ->nullable(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(string $context): bool => $context === 'create')
                    ->maxLength(255)
                    ->helperText('Kosongkan jika tidak ingin mengubah password saat edit.'),
                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->label('Email Terverifikasi Pada')
                    ->disabled()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('nim')
                    ->label('No. Induk')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->label('Level')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'dosen' => 'warning',
                        'mahasiswa' => 'success',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nomor_telepon')
                    ->label('No. Telepon')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true), // Bisa disembunyikan defaultnya
                TextColumn::make('email_verified_at')
                    ->label('Email Terverifikasi')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Bisa disembunyikan defaultnya
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Level Pengguna')
                    ->options([
                        'admin' => 'Admin',
                        'mahasiswa' => 'Mahasiswa',
                        'dosen' => 'Dosen',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Relation managers jika ada
        ];
    }

     public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
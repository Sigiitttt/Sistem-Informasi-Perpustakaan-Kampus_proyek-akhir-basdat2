<?php

namespace App\Filament\Resources\PeminjamanHeaderResource\Pages;

use App\Filament\Resources\PeminjamanHeaderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeminjamanHeaders extends ListRecords
{
    protected static string $resource = PeminjamanHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

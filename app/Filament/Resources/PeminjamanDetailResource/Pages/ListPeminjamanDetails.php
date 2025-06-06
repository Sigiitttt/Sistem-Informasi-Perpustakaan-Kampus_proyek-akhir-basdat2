<?php

namespace App\Filament\Resources\PeminjamanDetailResource\Pages;

use App\Filament\Resources\PeminjamanDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeminjamanDetails extends ListRecords
{
    protected static string $resource = PeminjamanDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

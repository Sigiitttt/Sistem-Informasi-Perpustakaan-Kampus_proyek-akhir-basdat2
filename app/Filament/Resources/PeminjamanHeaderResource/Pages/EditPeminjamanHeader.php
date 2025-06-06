<?php

namespace App\Filament\Resources\PeminjamanHeaderResource\Pages;

use App\Filament\Resources\PeminjamanHeaderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeminjamanHeader extends EditRecord
{
    protected static string $resource = PeminjamanHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

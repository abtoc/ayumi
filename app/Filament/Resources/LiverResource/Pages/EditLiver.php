<?php

namespace App\Filament\Resources\LiverResource\Pages;

use App\Filament\Resources\LiverResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLiver extends EditRecord
{
    protected static string $resource = LiverResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

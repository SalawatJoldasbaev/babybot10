<?php

namespace App\Filament\Resources\GraftResource\Pages;

use App\Filament\Resources\GraftResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGraft extends EditRecord
{
    protected static string $resource = GraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

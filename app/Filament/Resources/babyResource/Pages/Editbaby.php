<?php

namespace App\Filament\Resources\babyResource\Pages;

use App\Filament\Resources\babyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class Editbaby extends EditRecord
{
    protected static string $resource = babyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

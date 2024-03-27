<?php

namespace App\Filament\Resources\GraftResource\Pages;

use App\Filament\Resources\GraftResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGraft extends CreateRecord
{
    protected static string $resource = GraftResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}

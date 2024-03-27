<?php

namespace App\Filament\Resources\babyResource\Pages;

use App\Filament\Resources\babyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class Listbabies extends ListRecords
{
    protected static string $resource = babyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

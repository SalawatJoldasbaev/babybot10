<?php

namespace App\Filament\Resources\GraftResource\Pages;

use App\Filament\Resources\GraftResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGrafts extends ListRecords
{
    protected static string $resource = GraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

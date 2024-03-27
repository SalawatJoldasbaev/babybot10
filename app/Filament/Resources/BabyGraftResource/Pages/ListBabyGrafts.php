<?php

namespace App\Filament\Resources\BabyGraftResource\Pages;

use App\Filament\Resources\BabyGraftResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBabyGrafts extends ListRecords
{
    protected static string $resource = BabyGraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\babyResource\Pages;

use App\Filament\Resources\babyResource;
use Filament\Resources\Pages\CreateRecord;

class Createbaby extends CreateRecord
{
    protected static string $resource = babyResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}

<?php

namespace App\Filament\Resources\BabyGraftResource\Pages;

use App\Filament\Resources\BabyGraftResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBabyGraft extends EditRecord
{
    protected static string $resource = BabyGraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

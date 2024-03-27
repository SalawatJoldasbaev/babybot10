<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ListNotVerifiedPatient extends BaseWidget
{
    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
    protected static ?string $heading = "Список неподтвержденных пациентов";

    public function table(Table $table): Table
    {
        return $table
            ->query(Patient::where('is_verified', false))
            ->columns([
                TextColumn::make('name')
                    ->label('Имя')
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Телефон'),
            ]);
    }
}

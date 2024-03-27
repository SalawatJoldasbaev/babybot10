<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GraftResource\Pages;
use App\Models\Graft;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GraftResource extends Resource
{
    protected static ?string $model = Graft::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $slug = 'grafts';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Прививка';
    protected static ?string $pluralLabel = 'Прививка';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('created_at')
                    ->label('Дата создания')
                    ->content(fn(?Graft $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Дата последнего изменения')
                    ->content(fn(?Graft $record): string => $record?->updated_at?->diffForHumans() ?? '-'),

                TextInput::make('name')
                    ->label('Название')
                    ->required(),

                TextInput::make('description')
                    ->label('Описание')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Описание'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGrafts::route('/'),
            'create' => Pages\CreateGraft::route('/create'),
            'edit' => Pages\EditGraft::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}

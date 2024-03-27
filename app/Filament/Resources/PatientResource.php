<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Models\Patient;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'patients';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Родители';
    protected static ?string $pluralLabel = 'Родители';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('created_at')
                    ->label('Дата создания')
                    ->content(fn(?Patient $record): string => $record?->created_at?->diffForHumans() ?? '-'),
                Placeholder::make('updated_at')
                    ->label('Дата последнего изменения')
                    ->content(fn(?Patient $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                TextInput::make('name')
                    ->label('Имя')
                    ->required(),
                TextInput::make('phone')
                    ->label('Номер телефона')
                    ->required()
                    ->integer(),
                TextInput::make('address')
                    ->label('Адрес'),
                TextInput::make('polyclinic_address')
                    ->label('Адрес поликлиники'),
                TextInput::make('polyclinic_phone')
                    ->label('Телефон поликлиники'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Имя')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Номер телефона')
                    ->searchable(),
                TextColumn::make('address')
                    ->label('Адрес'),
                IconColumn::make('is_verified')
                    ->label('Проверено')
                    ->boolean(),
                TextColumn::make('polyclinic_address')
                    ->label('Адрес поликлиники'),
                TextColumn::make('polyclinic_phone')
                    ->label('Телефон поликлиники'),
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
            ])->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'phone'];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\babyResource\Pages;
use App\Models\Baby;
use App\Models\Patient;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class BabyResource extends Resource
{
    protected static ?string $model = Baby::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $slug = 'babies';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Дети';
    protected static ?string $pluralLabel = 'Дети';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('created_at')
                    ->label('Дата создания')
                    ->content(fn(?baby $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Дата последнего изменения')
                    ->content(fn(?baby $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                Select::make('patient_id')
                    ->label('Родитель')
                    ->relationship('patient', 'name')
                    ->searchable()
                    ->options(function () {
                        return Patient::select(['id', DB::raw("CONCAT(name,'(',phone,')') as name")])->get()->pluck('name', 'id');
                    }),
                TextInput::make('name')
                    ->label('Имя')
                    ->required(),

                DatePicker::make('birthday')->label('День рождения'),
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
                TextColumn::make('patient.name')
                    ->label('Имя родителя'),
                TextColumn::make('birthday')
                    ->label('День рождения')
                    ->date(),
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
            'index' => Pages\Listbabies::route('/'),
            'create' => Pages\Createbaby::route('/create'),
            'edit' => Pages\Editbaby::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}

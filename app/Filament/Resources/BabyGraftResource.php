<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BabyGraftResource\Pages;
use App\Models\Baby;
use App\Models\BabyGraft;
use App\Models\Graft;
use App\Models\Patient;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BabyGraftResource extends Resource
{
    protected static ?string $model = BabyGraft::class;

    protected static ?int $navigationSort = 4;

    protected static ?string $slug = 'baby-grafts';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Прививка ребенка';
    protected static ?string $pluralLabel = 'Прививка ребенка';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('patient')
                    ->label('Родитель')
                    ->live(onBlur: true)
                    ->searchable()
                    ->options(function () {
                        return Patient::select(['id', DB::raw("CONCAT(name,'(',phone,')') as name")])->get()->pluck('name', 'id');
                    })
                    ->searchable(),
                Select::make('baby_id')
                    ->label('Ребенок')
                    ->searchable()
                    ->relationship('baby', 'name')
                    ->options(function (Get $get): Collection {
                        return Baby::when($get('patient'), function ($query, $id) {
                            $query->where('patient_id', $id);
                        })->get()->pluck('name', 'id');
                    })
                    ->searchable(),
                Select::make('graft_id')
                    ->label('Прививка')
                    ->relationship('graft', 'name')
                    ->options(function () {
                        return Graft::select(['id', DB::raw("CONCAT(name,' (',description,')') as name")])->get()->pluck('name', 'id');
                    })
                    ->searchable(),
                DateTimePicker::make('datetime')->label('Время прибытия'),
                TextInput::make('description')->label('Описание'),
                Checkbox::make('message_sent')
                    ->label('Сообщение отправлено')
                    ->disabled(),
                TextInput::make('graft_status')
                    ->label('Статус Прививка')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('datetime')
                    ->label('Время прибытия')
                    ->date(),
                TextColumn::make('description')
                    ->label('Описание'),
                IconColumn::make('message_sent')
                    ->label('Сообщение отправлено')
                    ->boolean(),
                IconColumn::make('graft_status')
                    ->label('Статус Прививка')
                    ->color(fn(string $state): string => match ($state) {
                        'Kelmeydi' => 'warning',
                        'Keledi' => 'success',
                        default => 'gray',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'Keledi' => 'heroicon-o-check-badge',
                        'Kelmeydi' => 'heroicon-o-x-mark',
                        default => 'heroicon-o-clock'
                    })
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
            'index' => Pages\ListBabyGrafts::route('/'),
            'create' => Pages\CreateBabyGraft::route('/create'),
            'edit' => Pages\EditBabyGraft::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->baby) {
            $details['Baby'] = $record->baby->name;
        }

        if ($record->graft) {
            $details['Graft'] = $record->graft->name;
        }

        return $details;
    }
}

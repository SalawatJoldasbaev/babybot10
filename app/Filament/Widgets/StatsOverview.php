<?php

namespace App\Filament\Widgets;

use App\Models\Baby;
use App\Models\BabyGraft;
use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Количество пользователей', Patient::count())
                ->icon('heroicon-m-users')
                ->color('success'),
            Stat::make('Количество детей', Baby::count())
                ->icon('heroicon-m-user-group')
                ->color('success'),
            Stat::make('Количество прививка', BabyGraft::count())
                ->icon('heroicon-m-bolt')
                ->color('success')
        ];
    }
}

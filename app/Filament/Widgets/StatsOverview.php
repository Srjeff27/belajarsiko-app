<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Course;
use App\Models\Transaction;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Mahasiswa', (string) User::role('student')->count()),
            Stat::make('Kelas', (string) Course::count()),
            Stat::make('Transaksi Pending', (string) Transaction::where('status', 'waiting_verification')->count()),
        ];
    }
}


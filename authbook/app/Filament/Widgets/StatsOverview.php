<?php

namespace App\Filament\Widgets;

use App\Models\Author;
use App\Models\Book;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Books', Book::count())
                ->description('Total books registered in system') // Teks kecil di bawah
                ->descriptionIcon('heroicon-m-book-open')        // Ikon di kanan
                ->color('warning'),

            Stat::make('Total Authors', Author::count())
                ->description('Total registered authors')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Available Books', Book::where('status', 'available')->count())
                ->description('Ready for borrowing')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Borrowed Books', Book::where('status', 'borrowed')->count())
                ->description('Currently on loan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
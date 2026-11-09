<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use Filament\Widgets\ChartWidget;

class BooksChart extends ChartWidget
{
    protected static ?string $heading = 'Books Available vs Borrowed';
    protected static ?int $sort = 2;

    // Bikin lebarnya setengah layar (biar ada ruang kosong di kanan)
    protected int|string|array $columnSpan = 1; 
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Buku',
                    'data' => [
                        Book::where('status', 'available')->count(), 
                        Book::where('status', 'borrowed')->count()
                    ],
                    // Warna kuning dan biru muda (sesuai foto)
                    'backgroundColor' => ['#facc15', '#67e8f9'], 
                ],
            ],
            'labels' => ['Available', 'Borrowed'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
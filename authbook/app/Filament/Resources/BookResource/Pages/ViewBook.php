<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewBook extends ViewRecord
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Book Details')
                    ->schema([
                        // KIRI: Cover Image
                        Infolists\Components\ImageEntry::make('cover')
                            ->height(250)
                            ->defaultImageUrl(url('/images/default-book-cover.png'))
                            ->columnSpan(1), // Ambil 1 porsi layar

                        // KANAN: Detail Buku
                        Infolists\Components\Group::make([
                            Infolists\Components\TextEntry::make('title')
                                ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                                ->weight('bold')
                                ->columnSpanFull(),
                                
                            Infolists\Components\TextEntry::make('isbn')
                                ->label('ISBN')
                                ->copyable(),
                                
                            Infolists\Components\TextEntry::make('author.name')
                                ->label('Author'),
                                
                            Infolists\Components\TextEntry::make('publisher'),
                                
                            Infolists\Components\TextEntry::make('year'),
                                
                            Infolists\Components\TextEntry::make('status')
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'available' => 'success',
                                    'borrowed'  => 'warning',
                                    default     => 'gray',
                                }),

                            Infolists\Components\TextEntry::make('categories.name')
                                ->label('Categories')
                                ->badge()
                                ->separator(','),
                        ])->columnSpan(2)->columns(2), // Ambil 2 porsi layar, dibelah 2 kolom

                        // BAWAH: Description (Full width)
                        Infolists\Components\TextEntry::make('description')
                            ->columnSpanFull()
                            ->placeholder('Tidak ada deskripsi'),
                    ])
                    ->columns(3), // Total grid: 1 (kiri) + 2 (kanan)

                Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')->dateTime(),
                        Infolists\Components\TextEntry::make('updated_at')->dateTime(),
                    ])->columns(2)->collapsed(),
            ]);
    }
}
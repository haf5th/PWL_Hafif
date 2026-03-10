<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Tabs::make('Product Tabs')
                    ->tabs([
                        Tab::make('Product Details')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Product Name')
                                    ->weight('bold')
                                    ->color('primary'),
                                TextEntry::make('id')
                                    ->label('Product ID'),
                                TextEntry::make('sku')
                                    ->label('Product SKU')
                                    ->badge()
                                    ->color('danger'),
                                TextEntry::make('description')
                                    ->label('Product Description'),
                                TextEntry::make('created_at')
                                    ->label('Product Creation Date')
                                    ->date('d M Y')
                                    ->color('info'),
                            ]),

                        Tab::make('Product Price and Stock')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                TextEntry::make('price')
                                    ->label('Product Price')
                                    ->weight('bold')
                                    ->color('primary')
                                    ->icon('heroicon-o-currency-dollar')
                                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                                TextEntry::make('stock')
                                    ->label('Product Stock')
                                    ->badge()
                                    ->color(fn ($state) => match(true) {
                                        $state >= 100 => 'success',   // hijau - stok banyak
                                        $state >= 50  => 'warning',   // kuning - stok sedang
                                        $state >= 1   => 'danger',    // merah - stok sedikit
                                        default       => 'gray',      // abu - habis
                                    })
                                    ->formatStateUsing(fn ($state) => match(true) {
                                        $state >= 100 => "Stok Aman ({$state})",
                                        $state >= 50  => "Stok Sedang ({$state})",
                                        $state >= 1   => "Stok Menipis ({$state})",
                                        default       => 'Stok Habis',
                                    }),
                            ]),

                        Tab::make('Image and Status')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Product Image')
                                    ->disk('public'),
                                IconEntry::make('is_active')
                                    ->label('Is Active')
                                    ->boolean(),
                                IconEntry::make('is_featured')
                                    ->label('Is Featured')
                                    ->boolean(),
                            ]),

                    ])
                    ->columnSpanFull()
                    ->vertical(),
            ]);
    }
}

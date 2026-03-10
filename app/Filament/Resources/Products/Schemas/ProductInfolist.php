<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
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
                                Section::make('Product Info')
                    ->description('')
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
                    ->color('gray'),
                TextEntry::make('description')
                    ->label('Product Description'),
                TextEntry::make('created_at')
                    ->label('product Creation Date')
                    ->dateTime('d M Y')
                    ->color('info'),
                ])
                    ->columnSpanFull(),
                Section::make('Product Price and Stock')
                    ->description('')
                    ->schema([
                TextEntry::make('price')
                    ->label('Product Price')
                    ->weight('bold')
                    ->color('primary')
                    ->icon('heroicon-o-currency-dollar')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextEntry::make('stock')
                    ->label('Product Stock')
                    ->icon('heroicon-o-currency-dollar'),
                ])
                    ->columnSpanFull(),
                Section::make('Image and Status')
                    ->description('')
                    ->schema([
                ImageEntry::make('image')
                    ->label('Product Image')
                    ->disk('public'),
                TextEntry::make('price')
                    ->label('Product Price')
                    ->weight('bold')
                    ->color('primary')
                    ->icon('heroicon-s-currency-dollar'),
                TextEntry::make('stock')
                    ->label('Product Stock')
                    ->weight('bold')
                    ->color('primary'),
                IconEntry::make('is_active')   
                            ->label('Is Active')
                            ->boolean(),             
                        IconEntry::make('is_featured')
                            ->label('Is Featured')
                            ->boolean(),
                    ])->columnSpanFull(),
            ]);
    }
}

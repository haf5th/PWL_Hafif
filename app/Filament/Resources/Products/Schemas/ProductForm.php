<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Checkbox;
use Filament\Actions\Action;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Wizard::make([
                Step::make('Product Info')
                    ->description('Isi informasi dasar produk')
                    ->schema([
                        Group::make([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('sku')
                                ->required(),
                        ])->columns(2),
                        MarkdownEditor::make('description'),
                    ]),

                Step::make('Product Price and Stock')
                    ->description('Isi harga produk')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        Group::make([
                            TextInput::make('price')
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->validationMessages([
                                    'required' => 'Harga produk wajib diisi.',
                                    'min_value' => 'Harga produk harus lebih besar dari 0.',
                                ]),          
                            TextInput::make('stock')
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->validationMessages([
                                    'required' => 'Stok produk wajib diisi.',
                                    'min_value' => 'Stok produk harus lebih besar dari 0.',
                                ]),          
                        ])->columns(2),     
                    ]),                      

                Step::make('Media & Status')
                    ->description('Isi Gambar Produk')
                    ->schema([
                        FileUpload::make('image')
                            ->disk('public')
                            ->directory('products'),
                        Checkbox::make('is_active'),
                        Checkbox::make('is_featured'),
                    ]),                      
            ])                               
            ->columnSpanFull()
            ->submitAction(
                Action::make('save')
                    ->label('Save Product')
                    ->button()
                    ->color('primary')
                    ->submit('save')
            ),                              
        ]);
    }
}
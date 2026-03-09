<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;


class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                // SECTION KIRI - Content (2/3 width)
                Section::make('Content')
                    ->description('Write your post content here')
                    ->icon('heroicon-o-pencil-square')
                    ->schema([
                        Group::make([
                            TextInput::make('title')
                                ->label('Title')
                                ->required()
                                ->placeholder('Post title'),
                            TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->placeholder('post-slug'),
                        ])->columns(2),

                        Group::make([
                            Select::make('category_id')
                                ->label('Category')
                                ->relationship('category', 'name')
                                ->preload()
                                ->searchable()
                                ->required(),
                            ColorPicker::make('color')
                                ->label('Accent Color')
                                ->nullable(),
                        ])->columns(2),

                        MarkdownEditor::make('body')
                            ->label('Body Content')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2),

                // SECTION KANAN - Meta Information (1/3 width)
                Group::make([
                    Section::make('Media')
                        ->description('Upload featured image')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make('image')
                                ->label('Featured Image')
                                ->disk('public')
                                ->directory('posts')
                                ->image()
                                ->nullable()
                                ->columnSpanFull(),
                        ]),

                    Section::make('Publishing')
                        ->description('Manage publication settings')
                        ->icon('heroicon-o-megaphone')
                        ->schema([
                            TagsInput::make('tags')
                                ->label('Tags')
                                ->nullable()
                                ->columnSpanFull(),

                            Checkbox::make('published')
                                ->label('Publish this post')
                                ->default(false)
                                ->columnSpanFull(),

                            DateTimePicker::make('published_at')
                                ->label('Publish Date & Time')
                                ->nullable()
                                ->columnSpanFull(),
                        ]),
                ])
                ->columnSpan(1),
            ]);
    }
}

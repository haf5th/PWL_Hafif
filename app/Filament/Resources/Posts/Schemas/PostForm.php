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
use Illuminate\Validation\Rules\Unique;

use App\Models\Category;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Post Details")
                    ->description("Fill in the details of the post.")
                    ->icon("heroicon-o-document-text")
                    ->schema([
                        Group::make([
                            TextInput::make("title")
                                ->rules("required | min:3 | max:10")
                                ->maxLength(255),
                            TextInput::make("slug")
                                ->rules("required ")
                                ->unique()
                                ->validationMessages([
                                    "unique" =>
                                        "Slug harus unik dan tidak boleh sama.",
                                ]),
                            Select::make("category_id")
                                ->label("Category")
                                ->relationship("category", "name")
                                ->options(Category::all()->pluck("name", "id"))
                                ->required()
                                // ->preload()
                                ->searchable(),
                            ColorPicker::make("color"),
                        ])->columns(2),
                        MarkdownEditor::make("body")->label("Body")->required(),
                    ])
                    ->columnSpan(2),

                Group::make([
                    Section::make("Image Upload")->schema([
                        FileUpload::make("image")
                            ->required()
                            ->disk("public")
                            ->directory("posts"),
                    ]),

                    Section::make("Meta Information")
                        ->schema([
                            // RichEditor::make('content'),
                            TagsInput::make("tags"),
                            Checkbox::make("published"),
                        ])
                        ->columns(1),

                    DateTimePicker::make("published_at"),
                ]),
            ])
            ->columns(3);
    }
}

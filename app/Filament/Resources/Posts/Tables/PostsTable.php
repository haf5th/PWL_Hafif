<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Models\Category;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\Action;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ReplicateAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Checkbox;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("id")
                    ->Label("ID")
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make("title")
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make("slug")
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make("category.name")
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                ColorColumn::make("color")->toggleable(),
                ImageColumn::make("image")->disk("public")->toggleable(),
                TextColumn::make("created_at")
                    ->Label("Created At")
                    ->sortable()
                    ->dateTime()
                    ->toggleable(),
                TextColumn::make("tags")
                    ->Label("Tags")
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make("published")
                    ->Label("Published")
                    ->boolean()
                    ->trueIcon("heroicon-o-check-circle")
                    ->falseIcon("heroicon-o-x-circle")
                    ->color(
                        fn(bool $state): string => $state
                            ? "success"
                            : "danger",
                    )
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort("created_at", "desc")

            ->filters([
                Filter::make("created_at")
                    ->Label("Creation Date")
                    ->schema([
                        DatePicker::make("created_at")->Label("Select Date"),
                    ])
                    ->query(function ($query, $data) {
                        return $query->when(
                            $data["created_at"],
                            fn($query, $date) => $query->whereDate(
                                "created_at",
                                $date,
                            ),
                        );
                    }),
                SelectFilter::make("category_id")
                    ->relationship("category", "name")
                    ->options(Category::all()->pluck("name", "id"))
                    ->Label("Category"),
                // ->preload(),
            ])
            ->recordActions([
                ReplicateAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make("status")
                    ->Label("Status Change")
                    ->icon("heroicon-o-check-circle")
                    ->schema([
                        Checkbox::make("published")->default(
                            fn($record) => $record->published,
                        ),
                    ])
                    ->action(function ($record, $data) {
                        $record->update(["published" => $data["published"]]);
                    })
                    ->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}

<?php

namespace App\Filament\Resources\AttributeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class OptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'options';

    protected static ?string $title = 'Attribute Options';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        // VALUE (EN)
                        Forms\Components\TextInput::make('value.en')
                            ->label('Value (EN)')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                if (empty($get('slug'))) {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->placeholder('e.g., Red, Large'),

                        // VALUE (BG)
                        Forms\Components\TextInput::make('value.bg')
                            ->label('Value (BG)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('напр. Червен, Голям'),

                        // SLUG
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('URL-friendly identifier'),

                        // HEX COLOR (Only for swatch type)
                        Forms\Components\ColorPicker::make('hex_color')
                            ->label('Color')
                            ->placeholder('#FF0000')
                            ->helperText('Only for color swatches (e.g., #FF0000 for red)')
                            ->visible(fn ($get, $livewire) =>
                                $livewire->ownerRecord->type === 'swatch'
                            ),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        // POSITION
                        Forms\Components\TextInput::make('position')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Lower numbers appear first'),

                        // ACTIVE
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('value')
            ->columns([
                // VALUE
                Tables\Columns\TextColumn::make('value')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                // SLUG
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->copyable()
                    ->color('gray')
                    ->size('sm'),

                // COLOR SWATCH (if applicable)
                Tables\Columns\ColorColumn::make('hex_color')
                    ->label('Color')
                    ->placeholder('—')
                    ->visible(fn ($livewire) => $livewire->ownerRecord->type === 'swatch'),

                // POSITION
                Tables\Columns\TextColumn::make('position')
                    ->sortable()
                    ->alignCenter(),

                // ACTIVE
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->placeholder('All')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('position')
            ->defaultSort('position');
    }
}

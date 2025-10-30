<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CollectionResource\Pages;
use App\Filament\Resources\CollectionResource\RelationManagers;
use App\Models\Collection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CollectionResource extends Resource
{
    protected static ?string $model = Collection::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Collection Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // NAME (EN)
                                Forms\Components\TextInput::make('name.en')
                                    ->label('Name (EN)')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, $get) {
                                        if (empty($get('slug'))) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),

                                // NAME (BG)
                                Forms\Components\TextInput::make('name.bg')
                                    ->label('Name (BG)')
                                    ->required()
                                    ->maxLength(255),

                                // SLUG
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->helperText('URL-friendly version'),

                                // TYPE
                                Forms\Components\Select::make('type')
                                    ->options([
                                        'manual' => 'Manual',
                                        'auto' => 'Automatic',
                                    ])
                                    ->required()
                                    ->default('manual')
                                    ->native(false)
                                    ->helperText('Manual: Select products manually. Auto: Products added automatically based on rules.'),
                            ]),

                        // DESCRIPTION
                        Forms\Components\Textarea::make('description.en')
                            ->label('Description (EN)')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description.bg')
                            ->label('Description (BG)')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull(),

                        // IMAGE URL
                        Forms\Components\TextInput::make('image')
                            ->label('Image URL')
                            ->url()
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->helperText('Enter image URL'),

                        // POSITION
                        Forms\Components\TextInput::make('position')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Lower numbers appear first'),
                    ])->columns(2),

                // AUTO COLLECTION RULES
                Forms\Components\Section::make('Automatic Collection Rules')
                    ->schema([
                        Forms\Components\KeyValue::make('conditions')
                            ->label('Conditions (JSON)')
                            ->helperText('Define rules for automatic product inclusion (e.g., category_id, is_featured, price_range)')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($get) => $get('type') === 'auto')
                    ->collapsible(),

                // SEO
                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title.en')
                            ->label('Meta Title (EN)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('meta_title.bg')
                            ->label('Meta Title (BG)')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('meta_description.en')
                            ->label('Meta Description (EN)')
                            ->rows(2)
                            ->maxLength(500),

                        Forms\Components\Textarea::make('meta_description.bg')
                            ->label('Meta Description (BG)')
                            ->rows(2)
                            ->maxLength(500),
                    ])->columns(2)->collapsible()->collapsed(),

                // STATUS
                Forms\Components\Section::make('Visibility')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Collection is visible on storefront'),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured')
                            ->default(false)
                            ->helperText('Show in featured sections'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Collection Name')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('medium')
                    ->limit(40),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->copyable()
                    ->color('gray')
                    ->size('sm'),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'manual' => 'info',
                        'auto' => 'success',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Products')
                    ->alignCenter()
                    ->badge()
                    ->color('success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('position')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),

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
                    ->placeholder('All collections')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),

                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'manual' => 'Manual',
                        'auto' => 'Automatic',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollections::route('/'),
            'create' => Pages\CreateCollection::route('/create'),
            'edit' => Pages\EditCollection::route('/{record}/edit'),
        ];
    }
}

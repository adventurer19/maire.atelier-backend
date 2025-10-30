<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product Information')
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
                                        // Auto-generate slug only if it's empty
                                        if (empty($get('slug'))) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),

                                // NAME (BG)
                                Forms\Components\TextInput::make('name.bg')
                                    ->label('Name (BG)')
                                    ->required()
                                    ->maxLength(255),

                                // SKU (КРИТИЧНО - ЗАДЪЛЖИТЕЛНО!)
                                Forms\Components\TextInput::make('sku')
                                    ->label('SKU')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(100)
                                    ->default(fn () => 'SKU-' . strtoupper(Str::random(8)))
                                    ->helperText('Unique product identifier'),

                                // SLUG
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->helperText('URL-friendly version'),
                            ]),

                        // SHORT DESCRIPTION
                        Forms\Components\Textarea::make('short_description.en')
                            ->label('Short Description (EN)')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('short_description.bg')
                            ->label('Short Description (BG)')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        // DESCRIPTION
                        Forms\Components\RichEditor::make('description.en')
                            ->label('Description (EN)')
                            ->columnSpanFull()
                            ->maxLength(65535),

                        Forms\Components\RichEditor::make('description.bg')
                            ->label('Description (BG)')
                            ->columnSpanFull()
                            ->maxLength(65535),
                    ])->columns(2),

                // PRICING & STOCK
                Forms\Components\Section::make('Pricing & Inventory')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->label('Price (BGN)')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->prefix('BGN')
                                    ->default(0),

                                Forms\Components\TextInput::make('compare_at_price')
                                    ->label('Compare at Price')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->prefix('BGN')
                                    ->helperText('Original price for discounts'),

                                Forms\Components\TextInput::make('cost_price')
                                    ->label('Cost Price')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->prefix('BGN')
                                    ->helperText('Your cost (hidden from customers)'),
                            ]),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('stock_quantity')
                                    ->label('Stock Quantity')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0)
                                    ->default(0),

                                Forms\Components\TextInput::make('low_stock_threshold')
                                    ->label('Low Stock Alert')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(5)
                                    ->helperText('Alert when stock is below this'),

                                Forms\Components\Select::make('stock_status')
                                    ->label('Stock Status')
                                    ->options([
                                        'in_stock' => 'In Stock',
                                        'out_of_stock' => 'Out of Stock',
                                        'preorder' => 'Pre-order',
                                    ])
                                    ->required()
                                    ->default('in_stock')
                                    ->native(false),
                            ]),
                    ])->columns(1),

                // CATEGORIES & COLLECTIONS
                Forms\Components\Section::make('Organization')
                    ->schema([
                        Forms\Components\Select::make('categories')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->helperText('Select one or more categories'),

                        Forms\Components\Select::make('collections')
                            ->relationship('collections', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->helperText('Add to collections (optional)'),
                    ])->columns(2),

                // MATERIAL & CARE
                Forms\Components\Section::make('Product Details')
                    ->schema([
                        Forms\Components\Textarea::make('material.en')
                            ->label('Material (EN)')
                            ->rows(2)
                            ->maxLength(500),

                        Forms\Components\Textarea::make('material.bg')
                            ->label('Material (BG)')
                            ->rows(2)
                            ->maxLength(500),

                        Forms\Components\Textarea::make('care_instructions.en')
                            ->label('Care Instructions (EN)')
                            ->rows(2)
                            ->maxLength(1000),

                        Forms\Components\Textarea::make('care_instructions.bg')
                            ->label('Care Instructions (BG)')
                            ->rows(2)
                            ->maxLength(1000),
                    ])->columns(2)->collapsible(),

                // SHIPPING & DIMENSIONS
                Forms\Components\Section::make('Shipping & Dimensions')
                    ->schema([
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\TextInput::make('weight')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->suffix('kg'),

                                Forms\Components\TextInput::make('width')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->suffix('cm'),

                                Forms\Components\TextInput::make('height')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->suffix('cm'),

                                Forms\Components\TextInput::make('depth')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->suffix('cm'),
                            ]),

                        Forms\Components\Toggle::make('requires_shipping')
                            ->label('Requires Shipping')
                            ->default(true)
                            ->helperText('Disable for digital products'),

                        Forms\Components\Toggle::make('is_taxable')
                            ->label('Taxable')
                            ->default(true)
                            ->helperText('Apply tax to this product'),
                    ])->columns(1)->collapsible(),

                // IMAGES
                Forms\Components\Section::make('Product Images')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('images')
                            ->collection('images')
                            ->multiple()
                            ->reorderable()
                            ->maxFiles(10)
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                                '16:9',
                            ])
                            ->nullable()
                            ->helperText('Upload up to 10 images. First image is the main product image.')
                            ->columnSpanFull(),
                    ]),

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
                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Product is visible on storefront'),

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
                // IMAGE
                SpatieMediaLibraryImageColumn::make('images')
                    ->label('Image')
                    ->collection('images')
                    ->conversion('thumb')
                    ->circular()
                    ->defaultImageUrl(asset('images/placeholder-product.jpg')),

                // NAME
                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('medium')
                    ->limit(50),

                // SKU
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->color('gray'),

                // PRICE
                Tables\Columns\TextColumn::make('price')
                    ->money('BGN')
                    ->sortable(),

                // STOCK
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state === 0 => 'danger',
                        $state < 10 => 'warning',
                        default => 'success',
                    }),

                // STATUS
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // DATES
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->placeholder('All products')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->placeholder('All products')
                    ->trueLabel('Featured only')
                    ->falseLabel('Not featured'),

                Tables\Filters\SelectFilter::make('stock_status')
                    ->options([
                        'in_stock' => 'In Stock',
                        'out_of_stock' => 'Out of Stock',
                        'preorder' => 'Pre-order',
                    ]),

                Tables\Filters\SelectFilter::make('categories')
                    ->relationship('categories', 'name')
                    ->preload()
                    ->multiple(),
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
            RelationManagers\VariantsRelationManager::class,
            RelationManagers\ReviewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'view' => Pages\ViewProduct::route('/{record}'),
        ];
    }
}

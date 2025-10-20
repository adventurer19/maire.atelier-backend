<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;


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
                                Forms\Components\TextInput::make('name.en')
                                    ->label('Name (EN)')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) =>
                                    $set('slug', Str::slug($state))
                                    ),

                                Forms\Components\TextInput::make('name.bg')
                                    ->label('Name (BG)')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->unique(Product::class, 'slug', ignoreRecord: true),
                            ]),

                        Forms\Components\RichEditor::make('description.en')
                            ->label('Description (EN)')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description.bg')
                            ->label('Description (BG)')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('sku')
                            ->label('SKU')
                            ->unique(Product::class, 'sku', ignoreRecord: true)
                            ->helperText('Unique product identifier'),
                    ]),

                Forms\Components\Section::make('Pricing')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->prefix('BGN')
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->required(),

                                Forms\Components\TextInput::make('compare_at_price')
                                    ->label('Compare at Price')
                                    ->numeric()
                                    ->prefix('BGN')
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->helperText('Original price for showing discounts'),
                            ]),

                        Forms\Components\Toggle::make('is_taxable')
                            ->label('Charge Tax')
                            ->default(true),
                    ]),

                Forms\Components\Section::make('Inventory')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('stock_quantity')
                                    ->label('Stock Quantity')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0)
                                    ->required(),

                                Forms\Components\TextInput::make('low_stock_threshold')
                                    ->numeric()
                                    ->minValue(0)
                                    ->helperText('Alert when stock is below this number'),

                                Forms\Components\Select::make('stock_status')
                                    ->options([
                                        'in_stock' => 'In Stock',
                                        'out_of_stock' => 'Out of Stock',
                                        'preorder' => 'Pre-order',
                                    ])
                                    ->required()
                                    ->default('in_stock'),
                            ]),
                    ]),

                Forms\Components\Section::make('Categories & Collections')
                    ->description('Select at least one category (required)')
                    ->schema([
                        Forms\Components\Select::make('categories')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('categories', $state))
                            ->helperText('Select one or more categories'),

                        Forms\Components\Select::make('collections')
                            ->relationship('collections', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->helperText('Add to collections (optional)'),
                    ]),

                // ✅ АКТИВИРАНА СЕКЦИЯ ЗА СНИМКИ
                Forms\Components\Section::make('Product Images')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('images')
                            ->collection('images')
                            ->multiple()
                            ->image()
                            ->imageEditor()
                            ->maxFiles(10)
                            ->reorderable()
                            ->helperText('Upload up to 10 images. First image will be the main product image.')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Shipping & Dimensions')
                    ->schema([
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\TextInput::make('weight')
                                    ->numeric()
                                    ->suffix('kg')
                                    ->minValue(0)
                                    ->step(0.01),

                                Forms\Components\TextInput::make('width')
                                    ->numeric()
                                    ->suffix('cm')
                                    ->minValue(0)
                                    ->step(0.1),

                                Forms\Components\TextInput::make('height')
                                    ->numeric()
                                    ->suffix('cm')
                                    ->minValue(0)
                                    ->step(0.1),

                                Forms\Components\TextInput::make('depth')
                                    ->numeric()
                                    ->suffix('cm')
                                    ->minValue(0)
                                    ->step(0.1),
                            ]),

                        Forms\Components\Toggle::make('requires_shipping')
                            ->default(true)
                            ->helperText('Does this product need to be shipped?'),
                    ]),

                Forms\Components\Section::make('Status & Visibility')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Product will be visible in the store'),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Product')
                            ->helperText('Show in featured products section'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // СНИМКА (ПЪРВА КОЛОНА)
                Tables\Columns\SpatieMediaLibraryImageColumn::make('images')
                    ->collection('images')
                    ->label('Image')
                    ->size(50)
                    ->circular(),

                // ИМЕ НА ПРОДУКТА
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(40),

                // SKU (БЕЗ ДУБЛИРАНЕ!)
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                // ЦЕНА
                Tables\Columns\TextColumn::make('price')
                    ->money('BGN')
                    ->sortable(),

                // НАЛИЧНОСТ
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('Stock quantity')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state === 0 => 'danger',
                        $state < 10 => 'warning',
                        default => 'success',
                    }),

                // АКТИВЕН
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),

                // ДАТА НА СЪЗДАВАНЕ (СКРИТА ПО ПОДРАЗБИРАНЕ)
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueLabel('Active products')
                    ->falseLabel('Inactive products')
                    ->native(false),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueLabel('Featured products')
                    ->falseLabel('Not featured')
                    ->native(false),

                Tables\Filters\SelectFilter::make('stock_status')
                    ->options([
                        'in_stock' => 'In Stock',
                        'out_of_stock' => 'Out of Stock',
                        'preorder' => 'Pre-order',
                    ]),
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

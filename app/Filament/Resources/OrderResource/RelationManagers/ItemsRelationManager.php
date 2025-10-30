<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Product;
use App\Models\ProductVariant;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Order Items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $product = Product::find($state);
                            $set('name', $product->name);
                            $set('sku', $product->sku);
                            $set('price', $product->price);
                        }
                    }),

                Forms\Components\Select::make('variant_id')
                    ->label('Variant')
                    ->options(function (callable $get) {
                        $productId = $get('product_id');
                        if (!$productId) {
                            return [];
                        }

                        return ProductVariant::where('product_id', $productId)
                            ->get()
                            ->mapWithKeys(function ($variant) {
                                return [$variant->id => $variant->getVariantName() . ' (SKU: ' . $variant->sku . ')'];
                            });
                    })
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $variant = ProductVariant::find($state);
                            $set('sku', $variant->sku);
                            $set('price', $variant->price ?? $variant->product->price);
                        }
                    })
                    ->helperText('Optional: Select a specific variant (size, color, etc.)'),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Product Name'),

                        Forms\Components\TextInput::make('sku')
                            ->required()
                            ->label('SKU')
                            ->maxLength(100),
                    ]),

                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->default(1)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $price = $get('price');
                                if ($price && $state) {
                                    $set('subtotal', $price * $state);
                                }
                            }),

                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->prefix('€')
                            ->minValue(0)
                            ->step(0.01)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $quantity = $get('quantity');
                                if ($quantity && $state) {
                                    $set('subtotal', $state * $quantity);
                                }
                            }),

                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->required()
                            ->prefix('€')
                            ->disabled()
                            ->dehydrated(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->wrap(),

                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('variant')
                    ->label('Variant')
                    ->getStateUsing(fn ($record) => $record->variant?->getVariantName())
                    ->placeholder('N/A')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('quantity')
                    ->alignCenter()
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('price')
                    ->money('EUR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('EUR')
                    ->getStateUsing(fn ($record) => $record->price * $record->quantity),
        ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Recalculate subtotal before saving
                        $data['subtotal'] = $data['price'] * $data['quantity'];
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Recalculate subtotal before saving
                        $data['subtotal'] = $data['price'] * $data['quantity'];
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Product Details')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Product Name'),

                                Infolists\Components\TextEntry::make('sku')
                                    ->label('SKU')
                                    ->copyable(),

                                Infolists\Components\TextEntry::make('slug')
                                    ->copyable(),
                            ]),

                        Infolists\Components\TextEntry::make('description')
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Pricing & Stock')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('price')
                            ->money('EUR')
                            ->size('lg')
                            ->weight('bold'),

                        Infolists\Components\TextEntry::make('compare_at_price')
                            ->money('EUR')
                            ->placeholder('No compare price'),

                        Infolists\Components\TextEntry::make('stock_quantity')
                            ->badge()
                            ->color(fn ($state) => match (true) {
                                $state === 0 => 'danger',
                                $state < 10 => 'warning',
                                default => 'success',
                            }),

                        Infolists\Components\TextEntry::make('stock_status')
                            ->badge(),
                    ]),

                Infolists\Components\Section::make('Categories & Collections')
                    ->schema([
                        Infolists\Components\TextEntry::make('categories.name')
                            ->badge()
                            ->separator(','),

                        Infolists\Components\TextEntry::make('collections.name')
                            ->badge()
                            ->separator(',')
                            ->placeholder('Not in any collection'),
                    ]),

                Infolists\Components\Section::make('Status')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Active')
                            ->boolean(),

                        Infolists\Components\IconEntry::make('is_featured')
                            ->label('Featured')
                            ->boolean(),

                        Infolists\Components\IconEntry::make('has_variants')
                            ->label('Has Variants')
                            ->boolean(),
                    ]),

                Infolists\Components\Section::make('Dimensions & Shipping')
                    ->columns(4)
                    ->schema([
                        Infolists\Components\TextEntry::make('weight')
                            ->suffix(' kg')
                            ->placeholder('Not set'),

                        Infolists\Components\TextEntry::make('width')
                            ->suffix(' cm')
                            ->placeholder('Not set'),

                        Infolists\Components\TextEntry::make('height')
                            ->suffix(' cm')
                            ->placeholder('Not set'),

                        Infolists\Components\TextEntry::make('depth')
                            ->suffix(' cm')
                            ->placeholder('Not set'),
                    ]),

                Infolists\Components\Section::make('Timestamps')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime(),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->dateTime(),
                    ]),
            ]);
    }
}

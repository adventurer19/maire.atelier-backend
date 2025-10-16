<?php

namespace App\Filament\Resources\CollectionResource\Pages;

use App\Filament\Resources\CollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewCollection extends ViewRecord
{
    protected static string $resource = CollectionResource::class;

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
                Infolists\Components\Section::make('Collection Details')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Collection Name'),

                                Infolists\Components\TextEntry::make('slug')
                                    ->copyable(),

                                Infolists\Components\TextEntry::make('type')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'manual' => 'info',
                                        'auto' => 'success',
                                    })
                                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                            ]),

                        Infolists\Components\TextEntry::make('description')
                            ->columnSpanFull()
                            ->placeholder('No description'),
                    ]),

                Infolists\Components\Section::make('Statistics')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('products_count')
                            ->label('Total Products')
                            ->getStateUsing(fn ($record) => $record->products()->count())
                            ->badge()
                            ->color('success')
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('position')
                            ->label('Display Position'),
                    ]),

                Infolists\Components\Section::make('Status')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Active')
                            ->boolean(),
                    ]),

                Infolists\Components\Section::make('SEO Information')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Infolists\Components\TextEntry::make('meta_title')
                            ->placeholder('Not set'),

                        Infolists\Components\TextEntry::make('meta_description')
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

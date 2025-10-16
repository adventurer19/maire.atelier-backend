<?php

namespace App\Filament\Resources\ReviewResource\Pages;

use App\Filament\Resources\ReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewReview extends ViewRecord
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            Actions\Action::make('approve')
                ->label('Approve Review')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn ($record) => !$record->is_approved)
                ->action(fn ($record) => $record->update(['is_approved' => true]))
                ->requiresConfirmation(),

            Actions\Action::make('reject')
                ->label('Reject Review')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn ($record) => $record->is_approved)
                ->action(fn ($record) => $record->update(['is_approved' => false]))
                ->requiresConfirmation(),

            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Review Details')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('product.name')
                                    ->label('Product')
                                    ->size('lg')
                                    ->weight('bold'),

                                Infolists\Components\TextEntry::make('user.name')
                                    ->label('Customer')
                                    ->size('lg'),
                            ]),

                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('user.email')
                                    ->label('Customer Email')
                                    ->copyable(),

                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Review Date')
                                    ->dateTime(),
                            ]),
                    ]),

                Infolists\Components\Section::make('Rating & Review')
                    ->schema([
                        Infolists\Components\TextEntry::make('rating')
                            ->formatStateUsing(fn ($state) => str_repeat('⭐', $state))
                            ->size('xl')
                            ->color(fn ($state) => match (true) {
                                $state >= 4 => 'success',
                                $state === 3 => 'warning',
                                default => 'danger',
                            }),

                        Infolists\Components\TextEntry::make('title')
                            ->label('Review Title')
                            ->placeholder('No title provided')
                            ->size('lg')
                            ->weight('bold'),

                        Infolists\Components\TextEntry::make('comment')
                            ->label('Review Comment')
                            ->placeholder('No comment provided')
                            ->columnSpanFull()
                            ->prose(),
                    ]),

                Infolists\Components\Section::make('Review Status')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\IconEntry::make('is_approved')
                            ->label('Approved')
                            ->boolean()
                            ->size('lg'),

                        Infolists\Components\IconEntry::make('is_verified_purchase')
                            ->label('Verified Purchase')
                            ->boolean()
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('helpful_count')
                            ->label('Helpful Count')
                            ->badge()
                            ->color('info')
                            ->size('lg'),
                    ]),

                Infolists\Components\Section::make('Product Information')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('product.sku')
                                    ->label('Product SKU')
                                    ->copyable(),

                                Infolists\Components\TextEntry::make('product.price')
                                    ->label('Product Price')
                                    ->money('EUR'),
                            ]),

                        Infolists\Components\TextEntry::make('product.categories.name')
                            ->label('Product Categories')
                            ->badge()
                            ->separator(','),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Infolists\Components\Section::make('Timestamps')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime(),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->dateTime(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}

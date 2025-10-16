<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            Actions\Action::make('mark_as_paid')
                ->label('Mark as Paid')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn ($record) => $record->payment_status !== 'paid')
                ->action(fn ($record) => $record->markAsPaid())
                ->requiresConfirmation(),

            Actions\Action::make('mark_as_shipped')
                ->label('Mark as Shipped')
                ->icon('heroicon-o-truck')
                ->color('info')
                ->visible(fn ($record) => !in_array($record->status, ['shipped', 'delivered', 'cancelled']))
                ->action(fn ($record) => $record->markAsShipped())
                ->requiresConfirmation(),

            Actions\Action::make('mark_as_delivered')
                ->label('Mark as Delivered')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->visible(fn ($record) => $record->status === 'shipped')
                ->action(fn ($record) => $record->markAsDelivered())
                ->requiresConfirmation(),

            Actions\Action::make('cancel_order')
                ->label('Cancel Order')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn ($record) => $record->canBeCancelled())
                ->action(fn ($record) => $record->cancel())
                ->requiresConfirmation()
                ->modalHeading('Cancel Order')
                ->modalDescription('Are you sure you want to cancel this order? Stock will be restored.'),

            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Order Information')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('order_number')
                                    ->label('Order Number')
                                    ->copyable()
                                    ->size('lg')
                                    ->weight('bold'),

                                Infolists\Components\TextEntry::make('status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'processing' => 'info',
                                        'shipped' => 'primary',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                        'refunded' => 'gray',
                                    }),

                                Infolists\Components\TextEntry::make('payment_status')
                                    ->label('Payment Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'paid' => 'success',
                                        'failed' => 'danger',
                                        'refunded' => 'gray',
                                    }),
                            ]),
                    ]),

                Infolists\Components\Section::make('Customer Details')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('user.name')
                                    ->label('Customer Name'),

                                Infolists\Components\TextEntry::make('user.email')
                                    ->label('Customer Email')
                                    ->copyable(),
                            ]),
                    ]),

                Infolists\Components\Section::make('Order Summary')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('subtotal')
                                    ->money('EUR')
                                    ->size('lg'),

                                Infolists\Components\TextEntry::make('shipping_cost')
                                    ->label('Shipping')
                                    ->money('EUR'),

                                Infolists\Components\TextEntry::make('tax')
                                    ->money('EUR'),

                                Infolists\Components\TextEntry::make('discount')
                                    ->money('EUR')
                                    ->visible(fn ($record) => $record->discount > 0),

                                Infolists\Components\TextEntry::make('total')
                                    ->money('EUR')
                                    ->size('xl')
                                    ->weight('bold')
                                    ->color('success')
                                    ->columnSpanFull(),
                            ]),

                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('payment_method')
                                    ->label('Payment Method')
                                    ->formatStateUsing(fn ($state) => match($state) {
                                        'credit_card' => 'Credit Card',
                                        'paypal' => 'PayPal',
                                        'bank_transfer' => 'Bank Transfer',
                                        'cash_on_delivery' => 'Cash on Delivery',
                                        default => 'N/A',
                                    })
                                    ->placeholder('N/A'),

                                Infolists\Components\TextEntry::make('currency'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Order Items')
                    ->schema([
                        Infolists\Components\TextEntry::make('items_count')
                            ->label('Total Items')
                            ->getStateUsing(fn ($record) => $record->items()->sum('quantity'))
                            ->badge()
                            ->color('info')
                            ->size('lg'),
                    ])
                    ->description('View items in the "Items" tab above'),

                Infolists\Components\Section::make('Notes')
                    ->schema([
                        Infolists\Components\TextEntry::make('notes')
                            ->placeholder('No notes')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => !empty($record->notes))
                    ->collapsible(),

                Infolists\Components\Section::make('Additional Information')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('customer_ip')
                                    ->label('Customer IP')
                                    ->placeholder('N/A'),

                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Order Date')
                                    ->dateTime(),
                            ]),

                        Infolists\Components\TextEntry::make('user_agent')
                            ->label('User Agent')
                            ->placeholder('N/A')
                            ->columnSpanFull()
                            ->limit(100),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->dateTime(),

                                Infolists\Components\TextEntry::make('updated_at')
                                    ->dateTime(),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}

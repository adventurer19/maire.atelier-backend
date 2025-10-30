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
                Infolists\Components\Section::make('Order Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('order_number')->label('Номер на поръчка'),
                        Infolists\Components\TextEntry::make('user.name')->label('Клиент'),
                        Infolists\Components\TextEntry::make('status')->label('Статус')->badge(),
                        Infolists\Components\TextEntry::make('payment_status')->label('Плащане')->badge(),
                        Infolists\Components\TextEntry::make('total')->label('Обща сума')->money('EUR'),
                        Infolists\Components\TextEntry::make('created_at')->label('Дата на създаване')->dateTime(),
                    ]),
            ]);
    }
}

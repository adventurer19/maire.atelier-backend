<?php

namespace App\Filament\Resources\CouponResource\Pages;

use App\Filament\Resources\CouponResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewCoupon extends ViewRecord
{
    protected static string $resource = CouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            Actions\Action::make('activate')
                ->label('Activate')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn ($record) => !$record->is_active)
                ->action(fn ($record) => $record->update(['is_active' => true])),

            Actions\Action::make('deactivate')
                ->label('Deactivate')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn ($record) => $record->is_active)
                ->action(fn ($record) => $record->update(['is_active' => false]))
                ->requiresConfirmation(),

            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Coupon Details')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('code')
                                    ->label('Coupon Code')
                                    ->size('xl')
                                    ->weight('bold')
                                    ->copyable(),

                                Infolists\Components\TextEntry::make('type')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'percentage' => 'success',
                                        'fixed' => 'info',
                                    })
                                    ->formatStateUsing(fn (string $state): string => match ($state) {
                                        'percentage' => 'Percentage Discount',
                                        'fixed' => 'Fixed Amount',
                                    })
                                    ->size('lg'),
                            ]),

                        Infolists\Components\TextEntry::make('value')
                            ->label('Discount Value')
                            ->formatStateUsing(fn ($state, $record) =>
                            $record->type === 'percentage'
                                ? $state . '%'
                                : '€' . number_format($state, 2)
                            )
                            ->size('xl')
                            ->weight('bold')
                            ->color('success'),
                    ]),

                Infolists\Components\Section::make('Conditions & Limits')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('min_purchase_amount')
                                    ->label('Minimum Purchase Amount')
                                    ->money('EUR')
                                    ->placeholder('No minimum requirement'),

                                Infolists\Components\TextEntry::make('max_discount_amount')
                                    ->label('Maximum Discount Amount')
                                    ->money('EUR')
                                    ->placeholder('No cap')
                                    ->visible(fn ($record) => $record->type === 'percentage'),
                            ]),

                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('usage_limit')
                                    ->label('Usage Limit')
                                    ->placeholder('Unlimited')
                                    ->badge()
                                    ->color('info'),

                                Infolists\Components\TextEntry::make('usage_count')
                                    ->label('Times Used')
                                    ->badge()
                                    ->color('success'),

                                Infolists\Components\TextEntry::make('remaining')
                                    ->label('Remaining Uses')
                                    ->getStateUsing(function ($record) {
                                        if (!$record->usage_limit) return '∞';
                                        $remaining = $record->usage_limit - $record->usage_count;
                                        return max(0, $remaining);
                                    })
                                    ->badge()
                                    ->color(fn ($state) => match(true) {
                                        $state === '∞' => 'success',
                                        $state == 0 => 'danger',
                                        $state < 10 => 'warning',
                                        default => 'success',
                                    }),
                            ]),
                    ]),

                Infolists\Components\Section::make('Validity Period')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('starts_at')
                                    ->label('Valid From')
                                    ->dateTime()
                                    ->placeholder('Active immediately'),

                                Infolists\Components\TextEntry::make('expires_at')
                                    ->label('Valid Until')
                                    ->dateTime()
                                    ->placeholder('Never expires')
                                    ->color(fn ($state) => $state && now()->gt($state) ? 'danger' : null),
                            ]),

                        Infolists\Components\TextEntry::make('status')
                            ->label('Current Status')
                            ->getStateUsing(function ($record) {
                                if (!$record->is_active) return 'Inactive';
                                if ($record->starts_at && now()->lt($record->starts_at)) return 'Not Started';
                                if ($record->expires_at && now()->gt($record->expires_at)) return 'Expired';
                                if ($record->usage_limit && $record->usage_count >= $record->usage_limit) return 'Exhausted';
                                return 'Active';
                            })
                            ->badge()
                            ->color(fn ($state) => match($state) {
                                'Active' => 'success',
                                'Not Started' => 'info',
                                'Inactive' => 'warning',
                                'Expired', 'Exhausted' => 'danger',
                            })
                            ->size('lg'),
                    ]),

                Infolists\Components\Section::make('Status')
                    ->columns(1)
                    ->schema([
                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Active Status')
                            ->boolean()
                            ->size('lg'),
                    ]),

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

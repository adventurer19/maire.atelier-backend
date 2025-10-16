<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Coupon Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('code')
                                    ->label('Coupon Code')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50)
                                    ->alphaDash()
                                    ->uppercase()
                                    ->placeholder('SUMMER2024')
                                    ->helperText('Unique code customers will enter at checkout'),

                                Forms\Components\Select::make('type')
                                    ->options([
                                        'percentage' => 'Percentage Discount',
                                        'fixed' => 'Fixed Amount',
                                    ])
                                    ->required()
                                    ->default('percentage')
                                    ->native(false)
                                    ->live()
                                    ->helperText('Type of discount'),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('value')
                                    ->label(fn ($get) => $get('type') === 'percentage' ? 'Discount Percentage' : 'Discount Amount')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->suffix(fn ($get) => $get('type') === 'percentage' ? '%' : '€')
                                    ->live()
                                    ->rules([
                                        fn ($get) => function ($attribute, $value, $fail) use ($get) {
                                            if ($get('type') === 'percentage' && $value > 100) {
                                                $fail('Percentage cannot exceed 100%');
                                            }
                                        },
                                    ]),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->helperText('Enable or disable this coupon'),
                            ]),
                    ]),

                Forms\Components\Section::make('Conditions & Limits')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('min_purchase_amount')
                                    ->label('Minimum Purchase Amount')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->prefix('€')
                                    ->helperText('Minimum order amount required (optional)'),

                                Forms\Components\TextInput::make('max_discount_amount')
                                    ->label('Maximum Discount Amount')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->prefix('€')
                                    ->helperText('Cap the maximum discount (optional)')
                                    ->visible(fn ($get) => $get('type') === 'percentage'),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('usage_limit')
                                    ->label('Usage Limit')
                                    ->numeric()
                                    ->minValue(1)
                                    ->helperText('Maximum number of times this coupon can be used (leave empty for unlimited)'),

                                Forms\Components\TextInput::make('usage_count')
                                    ->label('Times Used')
                                    ->numeric()
                                    ->default(0)
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->helperText('Current usage count'),
                            ]),
                    ]),

                Forms\Components\Section::make('Validity Period')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('starts_at')
                                    ->label('Valid From')
                                    ->native(false)
                                    ->helperText('When this coupon becomes active (optional)'),

                                Forms\Components\DateTimePicker::make('expires_at')
                                    ->label('Valid Until')
                                    ->native(false)
                                    ->helperText('When this coupon expires (optional)')
                                    ->after('starts_at'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->tooltip('Click to copy'),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'percentage' => 'success',
                        'fixed' => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'percentage' => 'Percentage',
                        'fixed' => 'Fixed Amount',
                    }),

                Tables\Columns\TextColumn::make('value')
                    ->label('Discount')
                    ->sortable()
                    ->formatStateUsing(fn ($state, $record) =>
                    $record->type === 'percentage'
                        ? $state . '%'
                        : '€' . number_format($state, 2)
                    )
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('min_purchase_amount')
                    ->label('Min. Purchase')
                    ->money('EUR')
                    ->placeholder('No minimum')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('usage_count')
                    ->label('Usage')
                    ->alignCenter()
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($state, $record) =>
                    $record->usage_limit
                        ? $state . ' / ' . $record->usage_limit
                        : $state . ' / ∞'
                    ),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Valid From')
                    ->dateTime()
                    ->placeholder('Immediately')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime()
                    ->placeholder('Never')
                    ->sortable()
                    ->color(fn ($state) => $state && now()->gt($state) ? 'danger' : null),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'percentage' => 'Percentage',
                        'fixed' => 'Fixed Amount',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->placeholder('All coupons')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),

                Tables\Filters\Filter::make('expired')
                    ->label('Expired')
                    ->query(fn ($query) => $query->where('expires_at', '<', now())),

                Tables\Filters\Filter::make('exhausted')
                    ->label('Exhausted')
                    ->query(fn ($query) => $query->whereNotNull('usage_limit')
                        ->whereRaw('usage_count >= usage_limit')),

                Tables\Filters\Filter::make('valid_now')
                    ->label('Valid Now')
                    ->query(function ($query) {
                        return $query->where('is_active', true)
                            ->where(function($q) {
                                $q->whereNull('starts_at')
                                    ->orWhere('starts_at', '<=', now());
                            })
                            ->where(function($q) {
                                $q->whereNull('expires_at')
                                    ->orWhere('expires_at', '>=', now());
                            })
                            ->where(function($q) {
                                $q->whereNull('usage_limit')
                                    ->orWhereRaw('usage_count < usage_limit');
                            });
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                Tables\Actions\Action::make('activate')
                    ->label('Activate')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => !$record->is_active)
                    ->action(fn ($record) => $record->update(['is_active' => true])),

                Tables\Actions\Action::make('deactivate')
                    ->label('Deactivate')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->is_active)
                    ->action(fn ($record) => $record->update(['is_active' => false])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->deselectRecordsAfterCompletion()
                        ->color('success'),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->deselectRecordsAfterCompletion()
                        ->color('danger'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
            'view' => Pages\ViewCoupon::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $activeCount = static::getModel()::where('is_active', true)->count();
        return $activeCount > 0 ? (string) $activeCount : null;
    }
}

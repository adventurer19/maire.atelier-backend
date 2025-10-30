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
                                    ->suffix(fn ($get) => $get('type') === 'percentage' ? '%' : 'BGN')
                                    ->helperText(fn ($get) => $get('type') === 'percentage'
                                        ? 'Enter percentage (e.g., 20 for 20% off)'
                                        : 'Enter fixed amount in BGN'),

                                Forms\Components\TextInput::make('min_purchase')
                                    ->label('Minimum Purchase Amount')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->prefix('BGN')
                                    ->helperText('Leave empty for no minimum'),

                                Forms\Components\TextInput::make('max_discount')
                                    ->label('Maximum Discount Amount')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->prefix('BGN')
                                    ->visible(fn ($get) => $get('type') === 'percentage')
                                    ->helperText('Maximum discount cap for percentage coupons'),

                                Forms\Components\TextInput::make('usage_limit')
                                    ->label('Usage Limit')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0)
                                    ->helperText('0 = unlimited uses'),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('valid_from')
                                    ->label('Valid From')
                                    ->displayFormat('d/m/Y H:i')
                                    ->helperText('Leave empty to activate immediately'),

                                Forms\Components\DateTimePicker::make('valid_until')
                                    ->label('Valid Until')
                                    ->displayFormat('d/m/Y H:i')
                                    ->after('valid_from')
                                    ->helperText('Leave empty for no expiration'),
                            ]),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Deactivate to temporarily disable the coupon'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->color('primary'),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'percentage' => 'success',
                        'fixed' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('value')
                    ->label('Discount')
                    ->formatStateUsing(fn ($record): string =>
                    $record->type === 'percentage'
                        ? "{$record->value}%"
                        : "{$record->value} BGN"
                    )
                    ->sortable(),

                Tables\Columns\TextColumn::make('min_purchase')
                    ->label('Min. Purchase')
                    ->money('BGN')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('usage_limit')
                    ->label('Limit')
                    ->formatStateUsing(fn ($state): string => $state > 0 ? (string) $state : 'Unlimited')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('used_count')
                    ->label('Used')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color(fn ($record) =>
                    $record->usage_limit > 0 && $record->used_count >= $record->usage_limit
                        ? 'danger'
                        : 'success'
                    ),

                Tables\Columns\TextColumn::make('valid_from')
                    ->label('Valid From')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('valid_until')
                    ->label('Valid Until')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->placeholder('—'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->alignCenter()
                    ->sortable(),

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
                    ->placeholder('All')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),

                Tables\Filters\Filter::make('valid')
                    ->label('Currently Valid')
                    ->query(fn ($query) => $query
                        ->where('is_active', true)
                        ->where(fn ($q) => $q
                            ->whereNull('valid_from')
                            ->orWhere('valid_from', '<=', now())
                        )
                        ->where(fn ($q) => $q
                            ->whereNull('valid_until')
                            ->orWhere('valid_until', '>=', now())
                        )
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Review Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('Product'),

                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('Customer'),
                            ]),

                        Forms\Components\Select::make('rating')
                            ->options([
                                5 => '⭐⭐⭐⭐⭐ (5 stars - Excellent)',
                                4 => '⭐⭐⭐⭐ (4 stars - Good)',
                                3 => '⭐⭐⭐ (3 stars - Average)',
                                2 => '⭐⭐ (2 stars - Poor)',
                                1 => '⭐ (1 star - Very Poor)',
                            ])
                            ->required()
                            ->default(5)
                            ->native(false),

                        Forms\Components\TextInput::make('title')
                            ->maxLength(255)
                            ->placeholder('Review title (optional)'),

                        Forms\Components\Textarea::make('comment')
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Review Status')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Toggle::make('is_approved')
                                    ->label('Approved')
                                    ->default(false)
                                    ->helperText('Only approved reviews will be visible on storefront'),

                                Forms\Components\Toggle::make('is_verified_purchase')
                                    ->label('Verified Purchase')
                                    ->default(false)
                                    ->helperText('Customer actually purchased this product'),

                                Forms\Components\TextInput::make('helpful_count')
                                    ->label('Helpful Count')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->helperText('Number of users who found this helpful'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->wrap()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('rating')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state))
                    ->color(fn ($state) => match (true) {
                        $state >= 4 => 'success',
                        $state === 3 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('title')
                    ->limit(30)
                    ->wrap()
                    ->toggleable()
                    ->placeholder('No title'),

                Tables\Columns\TextColumn::make('comment')
                    ->limit(50)
                    ->wrap()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_verified_purchase')
                    ->label('Verified')
                    ->boolean()
                    ->alignCenter()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_approved')
                    ->label('Approved')
                    ->boolean()
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('helpful_count')
                    ->label('Helpful')
                    ->alignCenter()
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rating')
                    ->options([
                        5 => '⭐⭐⭐⭐⭐ (5 stars)',
                        4 => '⭐⭐⭐⭐ (4 stars)',
                        3 => '⭐⭐⭐ (3 stars)',
                        2 => '⭐⭐ (2 stars)',
                        1 => '⭐ (1 star)',
                    ])
                    ->multiple(),

                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Approval Status')
                    ->placeholder('All reviews')
                    ->trueLabel('Approved only')
                    ->falseLabel('Pending approval'),

                Tables\Filters\TernaryFilter::make('is_verified_purchase')
                    ->label('Verified Purchase')
                    ->placeholder('All reviews')
                    ->trueLabel('Verified only')
                    ->falseLabel('Not verified'),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),

                Tables\Filters\SelectFilter::make('product')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn ($record) => $record->update(['is_approved' => true]))
                    ->visible(fn ($record) => !$record->is_approved)
                    ->requiresConfirmation(),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(fn ($record) => $record->update(['is_approved' => false]))
                    ->visible(fn ($record) => $record->is_approved)
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['is_approved' => true]))
                        ->deselectRecordsAfterCompletion()
                        ->color('success')
                        ->requiresConfirmation(),

                    Tables\Actions\BulkAction::make('reject')
                        ->label('Reject Selected')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn ($records) => $records->each->update(['is_approved' => false]))
                        ->deselectRecordsAfterCompletion()
                        ->color('danger')
                        ->requiresConfirmation(),

                    Tables\Actions\BulkAction::make('mark_verified')
                        ->label('Mark as Verified Purchase')
                        ->icon('heroicon-o-shield-check')
                        ->action(fn ($records) => $records->each->update(['is_verified_purchase' => true]))
                        ->deselectRecordsAfterCompletion()
                        ->color('info'),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
            'view' => Pages\ViewReview::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $pendingCount = static::getModel()::where('is_approved', false)->count();
        return $pendingCount > 0 ? (string) $pendingCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('is_approved', false)->count() > 0 ? 'warning' : null;
    }
}

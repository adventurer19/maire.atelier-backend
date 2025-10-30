<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributeResource\Pages;
use App\Filament\Resources\AttributeResource\RelationManagers;
use App\Models\Attribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AttributeResource extends Resource
{
    protected static ?string $model = Attribute::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Attribute Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // NAME (EN)
                                Forms\Components\TextInput::make('name.en')
                                    ->label('Name (EN)')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, $get) {
                                        if (empty($get('slug'))) {
                                            $set('slug', Str::slug($state));
                                        }
                                    })
                                    ->placeholder('e.g., Color, Size, Material'),

                                // NAME (BG)
                                Forms\Components\TextInput::make('name.bg')
                                    ->label('Name (BG)')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('напр. Цвят, Размер, Материал'),

                                // SLUG
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->helperText('URL-friendly identifier'),

                                // TYPE
                                Forms\Components\Select::make('type')
                                    ->label('Type')
                                    ->options([
                                        'select' => 'Select (Dropdown)',
                                        'swatch' => 'Swatch (Color Picker)',
                                    ])
                                    ->required()
                                    ->default('select')
                                    ->native(false)
                                    ->helperText('Select for sizes, Swatch for colors'),
                            ]),

                        // POSITION
                        Forms\Components\TextInput::make('position')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Lower numbers appear first'),
                    ])->columns(2),

                // BEHAVIOR
                Forms\Components\Section::make('Behavior')
                    ->schema([
                        Forms\Components\Toggle::make('is_filterable')
                            ->label('Filterable')
                            ->default(false)
                            ->helperText('Allow filtering products by this attribute'),

                        Forms\Components\Toggle::make('is_visible')
                            ->label('Visible on Product Page')
                            ->default(true)
                            ->helperText('Show attribute on product detail page'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Attribute Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->copyable()
                    ->color('gray')
                    ->size('sm'),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'select' => 'info',
                        'swatch' => 'purple',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('options_count')
                    ->counts('options')
                    ->label('Options')
                    ->alignCenter()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('position')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_filterable')
                    ->label('Filterable')
                    ->boolean()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_visible')
                    ->label('Visible')
                    ->boolean()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'select' => 'Select',
                        'swatch' => 'Swatch',
                    ]),

                Tables\Filters\TernaryFilter::make('is_filterable')
                    ->label('Filterable'),

                Tables\Filters\TernaryFilter::make('is_visible')
                    ->label('Visible'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OptionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttributes::route('/'),
            'create' => Pages\CreateAttribute::route('/create'),
            'edit' => Pages\EditAttribute::route('/{record}/edit'),
        ];
    }
}

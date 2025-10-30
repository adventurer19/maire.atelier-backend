<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Category Information')
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
                                    }),

                                // NAME (BG)
                                Forms\Components\TextInput::make('name.bg')
                                    ->label('Name (BG)')
                                    ->required()
                                    ->maxLength(255),

                                // SLUG
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->helperText('URL-friendly version'),

                                // PARENT CATEGORY
                                Forms\Components\Select::make('parent_id')
                                    ->label('Parent Category')
                                    ->relationship('parent', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('None (Root Category)')
                                    ->helperText('Leave empty for root category'),
                            ]),

                        // DESCRIPTION
                        Forms\Components\Textarea::make('description.en')
                            ->label('Description (EN)')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description.bg')
                            ->label('Description (BG)')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull(),

                        // IMAGE URL
                        Forms\Components\TextInput::make('image')
                            ->label('Image URL')
                            ->url()
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->helperText('Enter image URL or upload to storage'),

                        // POSITION
                        Forms\Components\TextInput::make('position')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Lower numbers appear first'),
                    ])->columns(2),

                // SEO
                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title.en')
                            ->label('Meta Title (EN)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('meta_title.bg')
                            ->label('Meta Title (BG)')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('meta_description.en')
                            ->label('Meta Description (EN)')
                            ->rows(2)
                            ->maxLength(500),

                        Forms\Components\Textarea::make('meta_description.bg')
                            ->label('Meta Description (BG)')
                            ->rows(2)
                            ->maxLength(500),
                    ])->columns(2)->collapsible()->collapsed(),

                // STATUS
                Forms\Components\Section::make('Visibility')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Category is visible on storefront'),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured')
                            ->default(false)
                            ->helperText('Show in featured sections'),

                        Forms\Components\Toggle::make('show_in_menu')
                            ->label('Show in Menu')
                            ->default(true)
                            ->helperText('Display in navigation menu'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Category Name')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->copyable()
                    ->color('gray')
                    ->size('sm'),

                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent')
                    ->badge()
                    ->color('info')
                    ->placeholder('Root Category'),

                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Products')
                    ->alignCenter()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('position')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\IconColumn::make('show_in_menu')
                    ->label('In Menu')
                    ->boolean()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->placeholder('All categories')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),

                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Parent Category')
                    ->relationship('parent', 'name')
                    ->placeholder('All categories'),

                Tables\Filters\TernaryFilter::make('show_in_menu')
                    ->label('In Menu')
                    ->placeholder('All')
                    ->trueLabel('Show in menu')
                    ->falseLabel('Hidden from menu'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

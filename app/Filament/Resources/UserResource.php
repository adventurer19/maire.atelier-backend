<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Enums\UserRole;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Users';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([

            // User info section
            Forms\Components\Section::make('User Information')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Full Name')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->label('Email Address')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\Select::make('role')
                        ->label('Role')
                        ->options([
                            UserRole::Admin->value => 'Admin',
                            UserRole::Editor->value => 'Editor',
                            UserRole::Customer->value => 'Customer',
                        ])
                        ->default(UserRole::Customer->value)
                        ->required()
                        ->native(false)
                        ->helperText('Admin: Full access. Editor: Limited access. Customer: Storefront only.'),

                    Forms\Components\DateTimePicker::make('email_verified_at')
                        ->label('Email Verified At')
                        ->format('Y-m-d H:i:s')
                        ->displayFormat('d.m.Y H:i')
                        ->helperText('Leave empty if email is not verified'),
                ]),

            // Password section
            Forms\Components\Section::make('Password')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->required(fn (string $context): bool => $context === 'create')
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                        ->dehydrated(fn ($state) => filled($state))
                        ->minLength(8)
                        ->helperText('Minimum 8 characters. Leave empty to keep current password.'),

                    Forms\Components\TextInput::make('password_confirmation')
                        ->label('Confirm Password')
                        ->password()
                        ->same('password')
                        ->required(fn (string $context): bool => $context === 'create')
                        ->dehydrated(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => ucfirst($state->value))
                    ->color(fn ($state): string => match ($state->value) {
                        'admin' => 'danger',
                        'editor' => 'warning',
                        'customer' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('email_verified_at')->label('Verified')->boolean(),
                Tables\Columns\TextColumn::make('orders_count')
                    ->counts('orders')
                    ->badge()
                    ->color('info')
                    ->label('Orders'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'editor' => 'Editor',
                        'customer' => 'Customer',
                    ]),
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Verified')
                    ->trueLabel('Verified')
                    ->falseLabel('Unverified'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

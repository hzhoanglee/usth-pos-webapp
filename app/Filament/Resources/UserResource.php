<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Role;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        $role_lists = Role::all()->pluck('role_name', 'role_code')->toArray();
        foreach ($role_lists as $key => $value) {
            $role_lists[$key] = __('manager.'.$value);
        }
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->name(__('manager.Name'))
                    ->autofocus()
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('manager.Name')),
                Forms\Components\TextInput::make('email')
                    ->name(__('manager.Email'))
                    ->email()
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('manager.Email')),
                Forms\Components\TextInput::make('password')
                    ->name(__('manager.Password'))
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->autocomplete(false)
                    ->placeholder(__('manager.Password')),
                Forms\Components\TextInput::make('national_id')
                    ->label(__('manager.National ID'))
                    ->required()
                    ->autocomplete(false)
                    ->numeric()->nullable()
                    ->placeholder(__('manager.National ID')),
                Forms\Components\Select::make('role_id')
                    ->name(__('manager.Role'))
                    ->required()
                    ->options($role_lists)
                    ->placeholder(__('manager.Role')),
                Forms\Components\TextInput::make('employee_id')
                    ->name(__('manager.Employee ID'))
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('manager.Employee ID')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('manager.Name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('role.role_name')
                    ->label(__('manager.Role'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('national_id')
                    ->label(__('manager.National ID'))
                    ->sortable()
                    ->searchable()
                    ->default(__('No ID')),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role_name')
                    ->options([
                        'admin' => __('manager.Admin'),
                        'manager' => __('manager.Manager'),
                        'cashier' => __('manager.Cashier')
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getPluralLabel(): ?string
    {
        return __('manager.User');
    }
    public static function getModelLabel(): String{
        return __('order.User');
    }

}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankAccountResource\Pages;
use App\Filament\Resources\BankAccountResource\RelationManagers;
use App\Models\BankAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BankAccountResource extends Resource
{
    protected static ?string $model = BankAccount::class;

    protected static ?string $navigationIcon = 'heroicon-m-building-library';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->label(__('bankaccount.Bank account information'))
                ->schema([
                    Forms\Components\TextInput::make('bank_number')
                        ->name(__('bankaccount.Bank number'))
                        ->autofocus()
                        ->required()
                        ->autocomplete(false)
                        ->placeholder(__('bankaccount.Bank number')),
                    Forms\Components\TextInput::make('owner_name')
                        ->name(__('bankaccount.Owner name'))
                        ->autofocus()
                        ->required()
                        ->autocomplete(false)
                        ->placeholder(__('bankaccount.Owner name')),
                    Forms\Components\Select::make('bank')
                    ->label(__('bankaccount.Bank'))
                    ->options(['VPB' => 'VPB'])

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bank_number')
                    ->label(__('bankaccount.Bank number'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('owner_name')
                    ->label(__('bankaccount.Owner name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bank')
                    ->label(__('bankaccount.Bank'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListBankAccounts::route('/'),
            'create' => Pages\CreateBankAccount::route('/create'),
            'edit' => Pages\EditBankAccount::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): String{
        return __('bankaccount.Bank Account');
    }
    public static function getPluralLabel(): ?string
    {
        return __('bankaccount.Bank Account');
    }
}

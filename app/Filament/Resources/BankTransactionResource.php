<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankTransactionResource\Pages;
use App\Filament\Resources\BankTransactionResource\RelationManagers;
use App\Models\BankTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BankTransactionResource extends Resource
{
    protected static ?string $model = BankTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Business Managements';

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->where('type', 1);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->label(__('bankaccount.Bank transaction information'))
                ->schema([
                    Forms\Components\TextInput::make('amount')
                        ->name(__('bankaccount.Amount'))->numeric()
                        ->autofocus()
                        ->required()
                        ->autocomplete(false)
                        ->placeholder(__('bankaccount.Amount')),
                    Forms\Components\RichEditor::make('content')
                        ->name(__('bankaccount.Content'))
                        ->required()
                        ->placeholder(__('bankaccount.Content')),
                    Forms\Components\DateTimePicker::make('created_at')
                        ->name(__('bankaccount.Time'))
                        ->required()
                        ->placeholder(__('bankaccount.Time')),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('amount')
                    ->label(__('bankaccount.Amount'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('checked')->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('bankaccount.Time'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBankTransactions::route('/'),
        ];
    }
}

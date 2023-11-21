<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderDetailsResource\Pages;
use App\Filament\Resources\OrderDetailsResource\RelationManagers;
use App\Models\OrderDetails;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderDetailsResource extends Resource
{
    protected static ?string $model = OrderDetails::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('OrderID')
                    ->label(__('orderdetails.Order ID'))
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('orderdetails.Order ID')),

                Forms\Components\TextInput::make('ProductID')
                    ->name(__('orderdetails.Product ID'))
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('orderdetails.Product ID')),

                Forms\Components\TextInput::make('Unit Price')
                    ->label(__('orderdetails.Unit Price'))
                    ->required()
                    ->numeric()
                    ->autocomplete(false)
                    ->placeholder(__('orderdetails.Unit Price')),


                Forms\Components\TextInput::make('Quantity')
                    ->name(__('orderdetails.Quantity'))
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('orderdetails.Quantity')),


                Forms\Components\TextInput::make('Subtotal')
                    ->name(__('orderdetails.Subtotal'))
                    ->required()
                    ->numeric()
                    ->autocomplete(false)
                    ->placeholder(__('orderdetails.Subtotal')),


                Forms\Components\Select::make('status')
                    ->name(__('orderdetails.Status'))
                    ->required()
                    ->options([
                        'OK' => __('orderdetails.OK'),
                        'Refund' => __('orderdetails.Refund'),
                    ])
                    ->placeholder(__('orderdetails.Status')),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('OrderID')
                    ->label(__('orderdetails.Order ID'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ProductID')
                    ->label(__('orderdetails.Product ID'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Unit Price')
                    ->label(__('orderdetails.Unit Price'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Quantity')
                    ->label(__('orderdetails.Quantity'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Subtotal')
                    ->label(__('orderdetails.Subtotal'))
                    ->searchable()
                    ->sortable(),



                Tables\Columns\SelectColumn::make('status')
                    ->label(__('orderdetails.Status'))
                    ->options([
                        'OK' => __('orderdetails.OK'),
                        'Refund' => __('orderdetails.Refund'),
                    ])
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
            'index' => Pages\ListOrderDetails::route('/'),
            'create' => Pages\CreateOrderDetails::route('/create'),
            'edit' => Pages\EditOrderDetails::route('/{record}/edit'),
        ];
    }

    public static function getPluralLabel(): ?string
    {
        return __('orderdetails.Order Details');
    }
    public static function getModelLabel(): String{
        return __('orderdetails.Order Details');
    }

}

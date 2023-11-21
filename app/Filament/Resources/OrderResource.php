<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_id')
                    ->label(__('order.Order ID'))
                    ->autofocus()
                    ->required()
                    ->unique()
                    ->autocomplete(false)
                    ->placeholder(__('order.Order ID')),



                Forms\Components\Select::make('client')
                    ->name(__('order.Client'))
                    ->required()
                    ->options([
                        'Walk-in Customer' => __('order.Walk-in Customer'),
                        'Registered Customer' => __('order.Registered Customer'),
                    ])
                    ->placeholder(__('order.Client')),



                Forms\Components\TextInput::make('price_before_discount')
                    ->name(__('order.Price before discount'))
                    ->numeric()
                    ->inputMode('decimal')
                    ->required()
                    ->placeholder(__('order.Price before discount')),

                Forms\Components\TextInput::make('apply_coupons')
                    ->name(__('order.Apply coupons'))
                    ->autocomplete(false)
                    ->placeholder(__('order.Apply coupons')),

                Forms\Components\TextInput::make('price_after_discount')
                    ->name(__('order.Price after discount'))
                    ->numeric()
                    ->inputMode('decimal')
                    ->required()
                    ->placeholder(__('order.Price after discount')),
                Forms\Components\Select::make('status')
                    ->label(__('order.Status'))
                    ->required()
                    ->options([
                        'OK' => __('order.OK'),
                        'Refund' => __('order.Refund'),
                        'Partly refund' => __('order.Partly refund'),
                    ])
                    ->placeholder(__('order.Status')),

                Forms\Components\Select::make('cashier_name')
                    ->name(__('order.Cashier name'))
                    ->required()
                    ->options(
                        \App\Models\User::all()->pluck('name', 'id')->toArray()
                    )
                    ->placeholder(__('order.Cashier name')),

                Forms\Components\DatePicker::make('order_date')
                    ->name(__('order.Order date'))
                    ->required()
                    ->default(now())
                    ->placeholder(__('order.Order date')),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('order_id')
                    ->label(__('order.Order ID'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('client')
                    ->label(__('order.Client'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price_before_discount')
                    ->label(__('order.Price before discount'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('apply_coupons')
                    ->label(__('order.Apply coupons'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_after_discount')
                    ->label(__('order.Price after discount'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('order.Status'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('order.User'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('order_date')
                    ->label(__('order.Oder date'))
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getPluralLabel(): ?string
    {
        return __('order.Order');
    }

    public static function getModelLabel(): String{
        return __('order.Order');
    }

}

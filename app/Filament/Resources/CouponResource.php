<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

    protected static ?string $navigationGroup = 'Business Managements';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('coupon_code')
                    ->label(__('coupon.Coupon Code'))
                    ->autofocus()
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('coupon.Coupon Code')),
                Forms\Components\DatePicker::make('started_date')
                    ->label(__('coupon.Started Date'))
                    ->required()
                    ->placeholder(__('coupon.Started Date'))
                    ->format('d-m-Y')
                    ->minDate(now()->format('d-m-Y'))
                    ->maxDate(now()->addYear()->format('d-m-Y')),
                Forms\Components\DatePicker::make('expired_date')
                    ->label(__('coupon.Expired Date'))
                    ->required()
                    ->placeholder(__('coupon.Expired Date'))
                    ->format('d-m-Y')
                    ->minDate(now()->format('d-m-Y'))
                    ->maxDate(now()->addYear()->format('d-m-Y')),
                Forms\Components\Select::make('coupon_type')
                    ->label(__('coupon.Coupon Type'))
                    ->placeholder(__('coupon.Coupon Type'))
                    ->required()
                    ->options([
                        'percentage' => __('coupon.Percentage'),
                        'amount' => __('coupon.Amount'),
                        ]),
                Forms\Components\CheckboxList::make('coupon_condition')
                    ->label(__('coupon.Condition'))
                    ->required()
                    ->options([
                        'applied with other' => __('coupon.Applied with other'),
                    ]),
                Forms\Components\TextInput::make('minimum_value')
                    ->label(__('coupon.Minimum bill value'))
                    ->autocomplete(false)
                    ->placeholder(__('coupon.Minimum bill value')),
                Forms\Components\Select::make('on_product')
                    ->label(__('coupon.On product'))
                    ->options(
                        \App\Models\Product::all()->pluck('product_name','id')->toArray()
                    )
                    ->placeholder(__('coupon.On product')),
                Forms\Components\TextInput::make('coupon_value')
                    ->label(__('coupon.Coupon Value'))
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('coupon.Coupon Value')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('coupon_code')
                    ->label(__('coupon.Coupon Code'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('coupon_type')
                    ->label(__('coupon.Coupon Type'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('coupon_condition')
                    ->label(__('coupon.Condition'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('started_date')
                    ->label(__('coupon.Started Date'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expired_date')
                    ->label(__('coupon.Expired Date'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('on_product')
                    ->label(__('coupon.On product'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('minimum_value')
                    ->label(__('coupon.Minimum bill value'))
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
    public static function getPluralLabel(): ?string
    {
        return __('coupon.Coupon');
    }

    public static function getModelLabel(): String{
        return __('coupon.Coupon');
    }

}

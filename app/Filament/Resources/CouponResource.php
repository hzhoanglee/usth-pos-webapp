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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('coupon_code')
                    ->name(__('coupon.Coupon code'))
                    ->autofocus()
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('coupon.Coupon code')),
                Forms\Components\DatePicker::make('started_date')
                    ->name(__('coupon.Started date'))
                    ->required()
                    ->placeholder(__('coupon.Started date'))
                    ->format('d-m-Y')
                    ->minDate(now()->format('d-m-Y'))
                    ->maxDate(now()->addYear()->format('d-m-Y')),
                Forms\Components\DatePicker::make('expired_date')
                    ->name(__('coupon.Expired date'))
                    ->required()
                    ->placeholder(__('coupon.Expired date'))
                    ->format('d-m-Y')
                    ->minDate(now()->format('d-m-Y'))
                    ->maxDate(now()->addYear()->format('d-m-Y')),
                Forms\Components\Select::make('coupon_type')
                    ->name(__('coupon.Coupon type'))
                    ->placeholder(__('coupon.Coupon type'))
                    ->required()
                    ->options([
                        'percentage' => 'Percentage',
                        'amount' => 'Amount',
                        ]),
                Forms\Components\CheckboxList::make('coupon_condition')
                    ->name(__('coupon.Coupon condition'))
                    ->options([
                        'on products' => 'On product',
                        'applied with other' => 'Applied with other',
                    ]),
                Forms\Components\TextInput::make('coupon_minimum_condition')
                    ->name(__('coupon.Coupon minimum condition'))
                    ->autofocus()
                    ->autocomplete(false)
                    ->placeholder(__('coupon.Coupon minimum condition')),
                Forms\Components\TextInput::make('coupon_value')
                    ->name(__('coupon.Coupon value'))
                    ->autofocus()
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('coupon.Coupon value')),
                    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('coupon_code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('coupon_type')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('coupon_condition')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('started_date')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expired_date')
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

}

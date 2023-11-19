<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LotResource\Pages;
use App\Filament\Resources\LotResource\RelationManagers;
use App\Models\Lot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LotResource extends Resource
{
    protected static ?string $model = Lot::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('lot_name')
                    ->name(__('lot.Lot name'))
                    ->autofocus()
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('lot.Lot name')),
                Forms\Components\TextInput::make('lot_code')
                    ->name(__('lot.Lot code'))
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('lot.Lot code')),
                Forms\Components\TextInput::make('lot_price')
                    ->name(__('lot.Import price'))
                    ->required()
                    ->numeric()
                    ->autocomplete(false)
                    ->placeholder(__('lot.Import price')),
                Forms\Components\TextInput::make('sku_code')
                    ->name(__('lot.SKU'))
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('lot.SKU')),
                Forms\Components\DatePicker::make('expired_date')
                    ->name(__('lot.Expired date'))
                    ->required()
                    ->placeholder(__('lot.Expired date'))
                    ->format('d-m-Y')
                    ->maxDate(now()->addYear()->format('d-m-Y'))
                    ->minDate(now()->format('d-m-Y')),
                Forms\Components\Select::make('imported_by')
                    ->name(__('lot.Imported by'))
                    ->required()
                    ->options(
                        \App\Models\User::all()->pluck('name', 'id')->toArray()
                    )
                    ->placeholder(__('lot.Imported by')),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lot_name')
                    ->label(__('lot.Lot name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lot_code')
                    ->label(__('lot.Lot code'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lot_price')
                    ->label(__('lot.Import price'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sku_code')
                    ->label(__('lot.SKU'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expired_date')
                    ->label(__('lot.Expired date'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('lot.Imported by'))
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
            'index' => Pages\ListLots::route('/'),
            'create' => Pages\CreateLot::route('/create'),
            'edit' => Pages\EditLot::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): String{
        return __('lot.Lot');
    }
    public static function getPluralLabel(): ?string
    {
        return __('lot.Lot');
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('supplier_name')
                    ->name(__('supplier.Supplier Name'))
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('supplier.Supplier Name')),

                Forms\Components\TextInput::make('supplier_phone')
                    ->label(__('supplier.Supplier Phone'))
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('supplier.Supplier Phone')),

                Forms\Components\TextInput::make('reference_no')
                    ->name(__('supplier.Reference No'))
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('supplier.Reference No')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier_name')
                    ->label(__('supplier.Supplier Name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier_phone')
                    ->label(__('supplier.Supplier Phone'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reference_no')
                    ->label(__('supplier.Reference No'))
                    ->searchable()
                    ->sortable()
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }

    public static function getPluralLabel(): ?string
    {
        return __('supplier.Supplier');
    }
    public static function getModelLabel(): String{
        return __('supplier.Supplier');
    }
}

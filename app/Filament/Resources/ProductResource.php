<?php

namespace App\Filament\Resources;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->label(__('product.Product Information'))
                    ->schema([
                        Forms\Components\TextInput::make('product_name')->columnSpan(1)
                            ->name(__('product.Product name'))
                            ->autofocus()
                            ->required()
                            ->autocomplete(false)
                            ->placeholder(__('product.Product name')),
                        Forms\Components\TextInput::make('product_description')->columnSpan(1)
                            ->name(__('product.Product description'))
                            ->autofocus()
                            #->required()
                            ->autocomplete(false)
                            ->placeholder(__('product.Product description')),
                        Forms\Components\TextInput::make('product_image')->columnSpan(1)
                            ->name(__('product.Product image'))
                            ->autofocus()
                            #->required()
                            ->autocomplete(false)
                            ->placeholder(__('product.Product image')),
                        Forms\Components\TextInput::make('quantity')
                            ->name(__('product.Quantity'))
                            ->autofocus()
                            ->required()
                            ->autocomplete(false)
                            ->placeholder(__('product.Quantity')),
                        Forms\Components\TextInput::make('tax')
                            ->name(__('product.Tax'))
                            ->autofocus()
                            #->required()
                            ->autocomplete(false)
                            ->placeholder(__('product.Tax')),
                        Forms\Components\TextInput::make('price_box_listing')
                            ->name(__('product.Price box listing'))
                            ->autofocus()
                            #->required()
                            ->autocomplete(false)
                            ->placeholder(__('product.Price box listing')),
                        Forms\Components\TextInput::make('price_box_discounted')
                            ->name(__('product.Price box discounted'))
                            ->autofocus()
                            ->required()
                            ->autocomplete(false)
                            ->placeholder(__('product.Price box discounted')),
                        Forms\Components\TextInput::make('limit_by_age')
                            ->label(__('product.Limit by age'))
                            ->autofocus()
                            #->required()
                            ->autocomplete(false)
                            ->placeholder(__('product.Limit by age')),
                        Forms\Components\TextInput::make('limit_per_order')
                            ->label(__('product.Limit per order'))
                            ->autofocus()
                            #->required()
                            ->autocomplete(false)
                            ->placeholder(__('product.Limit per order')),
                        Forms\Components\TextInput::make('SKU')
                            ->label(__('product.SKU'))
                            ->autofocus()
                            #->required()
                            ->autocomplete(false)
                            ->placeholder(__('product.SKU')),
                        Forms\Components\TextInput::make('barcode')
                            ->name(__('product.Barcode'))
                            ->autofocus()
                            #->required()
                            ->autocomplete(false)
                            ->placeholder(__('product.Barcode'))
                    ])
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_name')
                    ->label(__('product.Product name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product_description')
                    ->label(__('product.Product description'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('product.Quantity'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('SKU')
                    ->label(__('product.SKU'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_box_listing')
                    ->label(__('product.Price box listing'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_box_discounted')
                    ->label(__('product.Price box discounted'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_item_listing')
                    ->label(__('product.Price item listing'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_item_discounted')
                    ->label(__('product.Price item discounted'))
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): String{
        return __('product.Product');
    }
    public static function getPluralLabel(): ?string
    {
        return __('product.Product');
    }
}

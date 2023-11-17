<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->name(__('customer.Customer name'))
                    ->autofocus()
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('customer.Customer name')),
                Forms\Components\TextInput::make('mobile')
                    ->name(__('customer.Phone number'))
                    ->autofocus()
                    #->required()
                    ->autocomplete(false)
                    ->placeholder(__('customer.Phone number')),
                Forms\Components\TextInput::make('email')
                    ->name(__('customer.Customer email'))
                    ->autofocus()
                    #->required()
                    ->autocomplete(false)
                    ->placeholder(__('customer.Customer email')),
                Forms\Components\TextInput::make('face')
                    ->name(__('customer.Customer Face'))
                    ->autofocus()
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('customer.Customer Face')),
                Forms\Components\TextInput::make('caddress')
                    ->name(__('customer.Customer address'))
                    ->autofocus()
                    #->required()
                    ->autocomplete(false)
                    ->placeholder(__('customer.Customer address')),
                Forms\Components\TextInput::make('zalo_number')
                    ->name(__('customer.Customer Zalo'))
                    ->autofocus()
                    #->required()
                    ->autocomplete(false)
                    ->placeholder(__('customer.Customer Zalo')),
                Forms\Components\TextInput::make('credit')
                    ->name(__('customer.Customer credit'))
                    ->autofocus()
                    ->required()
                    ->autocomplete(false)
                    ->placeholder(__('customer.Customer credit')),
                Forms\Components\TextInput::make('age')
                    ->name(__('customer.Customer age'))
                    ->autofocus()
                    #->required()
                    ->autocomplete(false)
                    ->placeholder(__('customer.Customer age')),
                Forms\Components\TextInput::make('image')
                    ->name(__('customer.Customer image'))
                    ->autofocus()
                    #->required()
                    ->autocomplete(false)
                    ->placeholder(__('customer.Customer image')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('zalo_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('credit')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('age')
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}

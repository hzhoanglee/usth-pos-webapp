<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Business Managements';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->label(__('customer.Customer Information'))
                    ->schema([
                    Forms\Components\TextInput::make('name')->columnSpan(1)
                        ->name(__('customer.Customer name'))
                        ->autofocus()
                        ->required()
                        ->autocomplete(false)
                        ->placeholder(__('customer.Customer name')),
                    Forms\Components\TextInput::make('mobile')->columnSpan(1)
                        ->label(__('customer.Phone number'))
                        ->autofocus()
                        #->required()
                        ->autocomplete(false)
                        ->placeholder(__('customer.Phone number')),
                    Forms\Components\TextInput::make('email')->columnSpan(1)
                        ->label(__('customer.Customer email'))
                        ->autofocus()
                        #->required()
                        ->autocomplete(false)
                        ->placeholder(__('customer.Customer email')),
                    Forms\Components\FileUpload::make('face')->maxWidth(200)
                        ->name(__('customer.Customer Face'))
                        ->disk('r2')
                        ->directory(env('APP_ENV').'/customer')
                        ->visibility('public')
                        ->placeholder(__('customer.Customer Face')),
                    Forms\Components\TextInput::make('address')
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
//                        ->required()
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
                ]),
                Section::make()->schema([
                    Forms\Components\Repeater::make('details')->columnSpan(3)
                        ->label(__('customer.Additional Information'))
                        ->schema([
                            Forms\Components\Select::make('type')
                                ->label(__('customer.Type'))
                                ->options([
                                'Blood type' => __('customer.Blood type'),
                                'Allergy' => __('customer.Allergy'),
                                'Symptoms' => __('customer.Specific symptoms')
                            ]),
                            Forms\Components\TextInput::make('Value')
                                ->name(__('customer.Customer Field'))
                                ->autofocus()
                                #->required()
                                ->autocomplete(false)
                                ->placeholder(__('customer.Customer Field'))->columnSpan(3),
                        ])
                ])
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('customer.Customer name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->label(__('customer.Phone number'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('customer.Customer email'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('customer.Customer address'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('zalo_number')
                    ->label(__('customer.Customer Zalo'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('credit')
                    ->label(__('customer.Customer credit'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('age')
                    ->label(__('customer.Customer age'))
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

    public static function getModelLabel(): String{
        return __('customer.Customer');
    }
    public static function getPluralLabel(): ?string
    {
        return __('customer.Customer');
    }
}

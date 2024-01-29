<?php

namespace App\Filament\Widgets;

use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Order;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan ='full';

    protected static ?int $sort =4;

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Order::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('user.name')
                ->label(__('manager.Cashier'))
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('client.name')
                ->label(__('order.Client'))
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('value.total_due')
                ->label(__('order.Paid'))
                ->money('vnd')
                ->searchable()
                ->sortable(),

        ];
    }

    protected function getTableFilters(): array
    {
       return [
        Filter::make('created_at')
            ->form([
                DatePicker::make('created_from'),
                DatePicker::make('created_until'),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['created_from'],
                        fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                    )
                    ->when(
                        $data['created_until'],
                        fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                    );
            })
    ];
    }
}

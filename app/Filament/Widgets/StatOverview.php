<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;

class StatOverview extends BaseWidget
{

    protected static ?int $sort =2;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Customer', Customer::count())
                ->description('Increase in customers')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([1,2,3,3,4,5,7,9]),

            Stat::make('Total Product', Product::count())
            ->description('Product variety')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success')
            ->chart([1,4,7,8]),

            Stat::make('Daily Income', number_format(Order::whereDate('created_at', '=', now()->toDateString())->sum('value.total_due')). ' Vnd')
            ->description('Income trend')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success')
            ->chart([1,2,0,3]),


        ];

    }
}

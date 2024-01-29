<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;

class Customer extends ChartWidget
{
    protected static ?string $heading = 'Customer Type Allocation';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $orders = Order::all();

        if ($orders->isEmpty()) {
            return [];
        }

        $paymentMethods = $orders->groupBy(function ($order) {
            // Check if client relationship is null
            if ($order->client) {
                return $order->client->name ? 'Signed-in Customer' : 'Walk-in Customer';
            } else {
                return 'Walk-in Customer';
            }
        })
        ->mapWithKeys(function ($group, $key) {
            return [$key => $group->count()];
        })
        ->toArray();

        // Extract labels from the keys
        $labels = array_keys($paymentMethods);

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Customer with most Order',
                    'data' => array_values($paymentMethods),
                    'backgroundColor' => ['#28a745', '#e74c3c'],
                ],
            ],
            'options' => [
                'legend' => [
                    'display' => false, // Hide legend
                ],
                'scales' => [
                    'yAxes' => [
                        [
                            'display' => false, // Hide y-axis
                        ],
                    ],
                ],
                'maintainAspectRatio' => false, // Set to false to allow resizing
                'responsive' => true, // Allow the chart to be responsive
                'width' => 50, // Set the width of the chart
                'height' => 50, // Set the height of the chart
            ],
        ];
    }

    protected function getType(): string
    {
        // return 'pie';
        return 'doughnut';
    }
}

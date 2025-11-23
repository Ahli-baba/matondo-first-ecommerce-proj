<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        // Fetch statistics
        $newOrders = Order::query()->where('status', 'new')->count();
        $processingOrders = Order::query()->where('status', 'processing')->count();
        $shippedOrders = Order::query()->where('status', 'shipped')->count();
        $averagePrice = Order::query()->avg('grand_total') ?? 0;

        return [
            Stat::make('New Orders', $newOrders),
            Stat::make('Processing Orders', $processingOrders),
            Stat::make('Shipped Orders', $shippedOrders),
            Stat::make('Average Price', '₹ ' . number_format($averagePrice, 2)),
        ];
    }
}

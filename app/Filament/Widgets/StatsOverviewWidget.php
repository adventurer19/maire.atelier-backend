<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Calculate revenue (this month)
        $thisMonthRevenue = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // Calculate revenue (last month)
        $lastMonthRevenue = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total');

        // Calculate revenue change percentage
        $revenueChange = $lastMonthRevenue > 0
            ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : 0;

        // Orders count (this month vs last month)
        $thisMonthOrders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $ordersChange = $lastMonthOrders > 0
            ? (($thisMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100
            : 0;

        // New customers (this month)
        $newCustomers = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Average order value
        $avgOrderValue = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->avg('total');

        return [
            Stat::make('Total Revenue (This Month)', '€' . number_format($thisMonthRevenue, 2))
                ->description($revenueChange >= 0 ? "↑ {$revenueChange}% increase" : "↓ " . abs($revenueChange) . "% decrease")
                ->descriptionIcon($revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange >= 0 ? 'success' : 'danger')
                ->chart([7, 12, 8, 15, 18, 20, 22]), // Sample data

            Stat::make('Orders (This Month)', number_format($thisMonthOrders))
                ->description($ordersChange >= 0 ? "↑ {$ordersChange}% from last month" : "↓ " . abs($ordersChange) . "% from last month")
                ->descriptionIcon($ordersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ordersChange >= 0 ? 'success' : 'danger')
                ->chart([5, 8, 6, 10, 12, 15, 14]),

            Stat::make('New Customers', number_format($newCustomers))
                ->description('This month')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->chart([2, 3, 5, 4, 6, 8, 7]),

            Stat::make('Average Order Value', '€' . number_format($avgOrderValue ?? 0, 2))
                ->description('This month')
                ->descriptionIcon('heroicon-m-calculator')
                ->color('warning'),

            Stat::make('Total Products', Product::count())
                ->description(Product::where('is_active', true)->count() . ' active')
                ->descriptionIcon('heroicon-m-cube')
                ->color('success'),

            Stat::make('Low Stock Products', Product::where('stock_quantity', '<=', 10)->count())
                ->description('Requires attention')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }
}

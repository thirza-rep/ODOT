<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $branchId = auth()->user()->branch_id;

        // Base query for orders based on branch
        $ordersQuery = Order::completed()->when($branchId, fn($q) => $q->inBranch($branchId));

        // Period filter (default: this_month)
        $period = $request->get('period', 'this_month');
        $startDate = match ($period) {
            'today' => Carbon::today(),
            'this_week' => Carbon::now()->startOfWeek(),
            'this_month' => Carbon::now()->startOfMonth(),
            'this_year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfMonth(),
        };

        $ordersQuery->where('created_at', '>=', $startDate);

        // Stats
        $totalRevenue = (clone $ordersQuery)->sum('total') * 1000;
        
        // Menghitung Profit (Gross Profit) dari order items yang match
        $totalProfit = 0;
        $orderIds = (clone $ordersQuery)->pluck('id');
        if ($orderIds->isNotEmpty()) {
            $totalProfit = OrderItem::whereIn('order_id', $orderIds)
                ->get()
                ->sum(function ($item) {
                    return ($item->sell_price - $item->cost_price) * $item->quantity * 1000;
                });
        }

        $totalOrders = (clone $ordersQuery)->count();

        // Top Selling Products
        $topProducts = OrderItem::whereIn('order_id', $orderIds)
            ->select('product_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Recent Orders
        $recentOrders = (clone $ordersQuery)->with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('reports.index', compact(
            'totalRevenue',
            'totalProfit',
            'totalOrders',
            'topProducts',
            'recentOrders',
            'period'
        ));
    }
}

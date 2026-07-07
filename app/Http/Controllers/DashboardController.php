<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $branchId = $user->branch_id;

        // ── Summary Cards ──
        $totalProducts = Product::when($branchId, fn($q) => $q->inBranch($branchId))->active()->count();
        $lowStockCount = Product::when($branchId, fn($q) => $q->inBranch($branchId))->active()->lowStock()->count();

        $todayOrders = Order::when($branchId, fn($q) => $q->inBranch($branchId))->completed()->today();
        $todaySalesCount = $todayOrders->count();
        $todayRevenue    = $todayOrders->sum('total');

        // ── Sales Chart (last 7 days) ──
        $salesChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dayTotal = Order::when($branchId, fn($q) => $q->inBranch($branchId))
                ->completed()
                ->whereDate('created_at', $date)
                ->sum('total');

            $salesChart[] = [
                'label' => $date->translatedFormat('D, d M'),
                'total' => round($dayTotal, 2),
            ];
        }

        // ── Top 5 Best-Selling Products (this month) ──
        $bestSelling = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->whereHas('order', function ($q) use ($branchId) {
                $q->completed()->thisMonth();
                if ($branchId) $q->inBranch($branchId);
            })
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // ── Market Research (Mock Data) ──
        $trendingProducts = [
            ['name' => 'Smartphone Case Premium',   'platform' => 'Shopee',     'trend' => 'hot',    'sold' => '12.5rb+'],
            ['name' => 'Serum Vitamin C',            'platform' => 'Tokopedia',  'trend' => 'rising', 'sold' => '8.2rb+'],
            ['name' => 'Tumbler Stainless 750ml',    'platform' => 'Shopee',     'trend' => 'hot',    'sold' => '15.1rb+'],
            ['name' => 'Kabel Data Fast Charging',   'platform' => 'Tokopedia',  'trend' => 'rising', 'sold' => '22.3rb+'],
            ['name' => 'Masker KN95 Premium',        'platform' => 'Shopee',     'trend' => 'stable', 'sold' => '5.7rb+'],
            ['name' => 'Mouse Wireless Ergonomic',   'platform' => 'Tokopedia',  'trend' => 'hot',    'sold' => '9.8rb+'],
        ];

        return view('dashboard', compact(
            'totalProducts',
            'lowStockCount',
            'todaySalesCount',
            'todayRevenue',
            'salesChart',
            'bestSelling',
            'trendingProducts'
        ));
    }
}

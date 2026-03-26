<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        // 1. Revenue Over Time (Last 30 Days) - Line Chart
        $revenueData = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as daily_revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 2. Orders by Payment Method - Pie Chart
        $paymentMethods = Payment::where('status', 'success')
            ->select('method', DB::raw('count(*) as count'))
            ->groupBy('method')
            ->get();

        // 3. Top Selling Products (Top 5) - Bar Chart
        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // 4. Quick Stats
        $stats = [
            'total_revenue' => Order::whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])->sum('total'),
            'monthly_revenue' => Order::whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])
                ->whereMonth('created_at', now()->month)
                ->sum('total'),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        return view('admin.analytics.index', compact('revenueData', 'paymentMethods', 'topProducts', 'stats'));
    }
}

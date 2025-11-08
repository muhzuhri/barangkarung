<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class RevenueController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        $totalRevenue = Order::where('status', 'selesai')->sum('total');
        $totalOrders = Order::where('status', 'selesai')->count();

        // Start from October 2025
        $startDate = \Carbon\Carbon::create(2025, 10, 1)->startOfMonth();
        $now = \Carbon\Carbon::now();

        // Generate months from October 2025 to current month
        $months = [];
        $current = $startDate->copy();
        while ($current->lte($now)) {
            $months[] = $current->format('Y-m');
            $current->addMonth();
        }

        // Get revenue data starting from October 2025
        $revenueRows = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('SUM(total) as revenue'),
            DB::raw('COUNT(*) as orders_count')
        )
            ->where('status', 'selesai')
            ->where('created_at', '>=', $startDate)
            ->groupBy('month')
            ->pluck('revenue', 'month');

        $orderRows = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('COUNT(*) as orders_count')
        )
            ->where('status', 'selesai')
            ->where('created_at', '>=', $startDate)
            ->groupBy('month')
            ->pluck('orders_count', 'month');

        // Map to ensure all months are present (bulan terlama di kiri, terbaru di kanan)
        $monthly = collect($months)->map(function ($m) use ($revenueRows, $orderRows) {
            return (object) [
                'month' => $m,
                'revenue' => (float) ($revenueRows[$m] ?? 0),
                'orders_count' => (int) ($orderRows[$m] ?? 0)
            ];
        })->values();

        $completedOrders = Order::with(['items.product'])
            ->where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Additional data for charts
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = \Carbon\Carbon::now()->subMonths($i)->format('Y-m');
        }

        $userRows = \App\Models\User::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', \Carbon\Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->pluck('count', 'month');

        $productRows = \App\Models\Product::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', \Carbon\Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->pluck('count', 'month');

        $monthlyUsers = collect($months)->map(function ($m) use ($userRows) {
            return (object) ['month' => $m, 'count' => (int) ($userRows[$m] ?? 0)];
        });
        $monthlyProducts = collect($months)->map(function ($m) use ($productRows) {
            return (object) ['month' => $m, 'count' => (int) ($productRows[$m] ?? 0)];
        });

        return view('admin.revenue.index', compact(
            'admin',
            'totalRevenue',
            'totalOrders',
            'monthly',
            'completedOrders',
            'monthlyUsers',
            'monthlyProducts'
        ));
    }
}

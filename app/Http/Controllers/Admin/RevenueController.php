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

        $totalRevenue = Order::where('order_status', 'selesai')->sum('total');
        $totalOrders = Order::where('order_status', 'selesai')->count();

        // Generate last 12 months (dari bulan terlama ke terbaru - Januari ke kanan)
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $months[] = \Carbon\Carbon::now()->subMonths($i)->format('Y-m');
        }

        // Get revenue data for last 12 months
        $revenueRows = Order::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as orders_count')
            )
            ->where('order_status', 'selesai')
            ->where('created_at', '>=', \Carbon\Carbon::now()->subMonths(12)->startOfMonth())
            ->groupBy('month')
            ->pluck('revenue', 'month');

        $orderRows = Order::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as orders_count')
            )
            ->where('order_status', 'selesai')
            ->where('created_at', '>=', \Carbon\Carbon::now()->subMonths(12)->startOfMonth())
            ->groupBy('month')
            ->pluck('orders_count', 'month');

        // Map to ensure all months are present (bulan terlama di kiri, terbaru di kanan - Januari ke kanan)
        $monthly = collect($months)->map(function ($m) use ($revenueRows, $orderRows) {
            return (object) [
                'month' => $m,
                'revenue' => (float) ($revenueRows[$m] ?? 0),
                'orders_count' => (int) ($orderRows[$m] ?? 0)
            ];
        })->values();

        $completedOrders = Order::with(['items.product'])
            ->where('order_status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.revenue.index', compact(
            'admin', 'totalRevenue', 'totalOrders', 'monthly', 'completedOrders'
        ));
    }
}



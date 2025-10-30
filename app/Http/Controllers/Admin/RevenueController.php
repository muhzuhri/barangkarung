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

        $monthly = Order::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as orders_count')
            )
            ->where('order_status', 'selesai')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        $completedOrders = Order::with(['items.product'])
            ->where('order_status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.revenue.index', compact(
            'admin', 'totalRevenue', 'totalOrders', 'monthly', 'completedOrders'
        ));
    }
}



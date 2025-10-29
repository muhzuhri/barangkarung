<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminAuthController extends Controller
{
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        
        // Aggregate statistics
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'selesai')->sum('total');

        // Recent orders
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Monthly datasets: ensure last 6 months always present
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = Carbon::now()->subMonths($i)->format('Y-%m');
        }

        $revenueRows = Order::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(total) as revenue')
            )
            ->where('status', 'selesai')
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->pluck('revenue', 'month');

        $orderRows = Order::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->pluck('count', 'month');

        $userRows = User::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->pluck('count', 'month');

        $productRows = Product::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->pluck('count', 'month');

        $monthlyRevenue = collect($months)->map(function ($m) use ($revenueRows) {
            return (object) ['month' => $m, 'revenue' => (float) ($revenueRows[$m] ?? 0)];
        });
        $monthlyOrders = collect($months)->map(function ($m) use ($orderRows) {
            return (object) ['month' => $m, 'count' => (int) ($orderRows[$m] ?? 0)];
        });
        $monthlyUsers = collect($months)->map(function ($m) use ($userRows) {
            return (object) ['month' => $m, 'count' => (int) ($userRows[$m] ?? 0)];
        });
        $monthlyProducts = collect($months)->map(function ($m) use ($productRows) {
            return (object) ['month' => $m, 'count' => (int) ($productRows[$m] ?? 0)];
        });

        return view('admin.dashboard', compact(
            'admin',
            'totalUsers',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'recentOrders',
            'monthlyRevenue',
            'monthlyOrders',
            'monthlyUsers',
            'monthlyProducts',
        ));
    }

    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.setting.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'current_password' => 'required_with:password',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
            }
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}

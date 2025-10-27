<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;
use App\Models\Product;

class AdminAuthController extends Controller
{
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        
        // Calculate statistics
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = 0; // Orders removed
        $totalRevenue = 0; // Revenue removed
        
        // Recent orders removed
        $recentOrders = collect();
        
        // Monthly revenue removed
        $monthlyRevenue = collect();
        
        return view('admin.dashboard', compact(
            'admin', 
            'totalUsers', 
            'totalProducts', 
            'totalOrders', 
            'totalRevenue',
            'recentOrders',
            'monthlyRevenue'
        ));
    }

    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('admin'));
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    /**
     * Menampilkan halaman "Pesanan Saya"
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil semua pesanan milik user, termasuk item di dalamnya
        $orders = Order::with(['items.product'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pesanan', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan
     */
    public function show($id)
    {
        $user = Auth::user();

        $order = Order::with(['items.product'])
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('pesanan-detail', compact('order'));
    }
}
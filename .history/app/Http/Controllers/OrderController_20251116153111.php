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

        // Ambil pesanan aktif (belum selesai) milik user, termasuk item di dalamnya
        $orders = Order::with(['items.product'])
            ->where('user_id', $user->id)
            ->where('status', '!=', 'selesai')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.order.pesanan', compact('orders'));
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

        return view('user.order.pesanan-detail', compact('order'));
    }

    /**
     * Menandai pesanan sebagai selesai oleh user
     */
    public function complete(Request $request, $id)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();
        if ($order->status !== 'dikirim') {
            return back()->with('error', 'Pesanan tidak bisa diselesaikan pada status saat ini.');
        }
        $order->status = 'selesai';
        $order->save();
        return redirect()->route('pesanan.history')->with('success', 'Terima kasih! Pesanan dipindahkan ke riwayat.');
    }

    /**
     * Menampilkan riwayat pesanan (selesai) milik user
     */
    public function history()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $orders = Order::with(['items.product'])
            ->where('user_id', $user->id)
            ->where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.order.pesanan-history', compact('orders'));
    }
}

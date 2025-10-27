<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil item keranjang beserta produk (tampilkan semua agar user dapat memilih)
        $cartItems = Cart::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang')->with('error', 'Keranjang Anda kosong.');
        }

        // Hitung total (untuk tampilan bisa tetap total semua, atau kosongkan - di sini tampilkan total semua)
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingCost = 12000;
        $serviceFee = 2000;
        $discount = 0;
        $total = $subtotal + $shippingCost + $serviceFee - $discount;

        return view('checkout', compact('cartItems', 'subtotal', 'shippingCost', 'serviceFee', 'discount', 'total', 'user'));
    }

    /**
     * Proses checkout dan buat pesanan
     */
    public function process(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi input termasuk selected_items
        $request->validate([
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'integer',
            'shipping_address' => 'nullable|string|max:500',
            'phone' => 'required|string|max:20',
            'shipping_method' => 'required|string',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string|max:500',
        ]);

        $selectedIds = array_map('intval', $request->input('selected_items', []));

        // Ambil hanya cart items yang dipilih dan memang milik user
        $cartItems = Cart::with('product')
            ->where('user_id', $user->id)
            ->whereIn('id', $selectedIds)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang')->with('error', 'Produk yang dipilih tidak ditemukan di keranjang.');
        }

        // Hitung total berdasarkan item yang dipilih
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingCost = 12000;
        $serviceFee = 2000;
        $discount = 0;
        $total = $subtotal + $shippingCost + $serviceFee - $discount;

        // Buat pesanan baru
        $order = Order::create([
            'user_id' => $user->id,
            'shipping_address' => $request->shipping_address ?? $user->address ?? '',
            'phone' => $request->phone,
            'shipping_method' => $request->shipping_method,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'service_fee' => $serviceFee,
            'discount' => $discount,
            'total' => $total,
            'status' => 'pending',
        ]);

        // Simpan item pesanan hanya untuk item yang dipilih
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'size' => $item->size ?? null,
                'price' => $item->product->price,
            ]);
        }

        // Hapus hanya item yang diproses dari keranjang
        Cart::where('user_id', $user->id)
            ->whereIn('id', $selectedIds)
            ->delete();

        Log::info("Checkout sukses oleh user {$user->id}, order_id: {$order->id}, total: {$total}");

        return redirect()->route('pesanan')->with('success', 'Pesanan berhasil dibuat! Terima kasih atas pembelian Anda.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product'])
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,Sedang Diproses,dikirim,selesai,dibatalkan'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan diperbarui.');
    }
}




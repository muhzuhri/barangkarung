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
            'status' => 'required|string|in:pending,Sedang Diproses,dikirim,selesai,dibatalkan',
            'tracking_number' => 'nullable|string|max:255'
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $order->status = $request->input('status');

        // Jika status diubah menjadi "dikirim", simpan nomor resi
        if ($request->input('status') === 'dikirim') {
            $order->tracking_number = $request->input('tracking_number');
        }

        $order->save();

        // Jika status baru adalah "dikirim" dan sebelumnya bukan, kirim notifikasi ke user
        if ($request->input('status') === 'dikirim' && $oldStatus !== 'dikirim' && $order->tracking_number) {
            // Kirim notifikasi ke user (bisa menggunakan email, SMS, atau notifikasi in-app)
            // Untuk sementara, kita simpan sebagai flash message untuk demo
            session()->flash('user_notification', [
                'order_code' => $order->order_code,
                'tracking_number' => $order->tracking_number,
                'message' => "Pesanan Anda dengan kode {$order->order_code} telah dikirim dengan nomor resi: {$order->tracking_number}"
            ]);
        }

        return redirect()->back()->with('success', 'Status pesanan diperbarui.');
    }

    public function updatePayment(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $action = $request->input('action');
        if ($action === 'verified') {
            $order->payment_status = 'verified';
        } elseif ($action === 'rejected') {
            $order->payment_status = 'rejected';
        }
        $order->save();
        return redirect()->back()->with('success', 'Status pembayaran diperbarui.');
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan'
        ]);
        $order = Order::findOrFail($id);
        $order->order_status = $request->order_status;
        $order->save();
        return redirect()->back()->with('success', 'Status pesanan diperbarui.');
    }
}

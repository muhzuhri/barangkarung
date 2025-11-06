<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentSettingController extends Controller
{
    public function index()
    {
        $admin = auth('admin')->user();
        $payments = PaymentSetting::all();
        return view('admin.setting.payment', compact('admin', 'payments'));
    }

    public function update(Request $request, $id)
    {
        $payment = PaymentSetting::findOrFail($id);
        
        $request->validate([
            'label' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'qris_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['qris_image', 'icon_image']);

        // Handle icon image upload
        if ($request->hasFile('icon_image')) {
            // Delete old image if exists
            if ($payment->icon_image && Storage::disk('public')->exists($payment->icon_image)) {
                Storage::disk('public')->delete($payment->icon_image);
            }

            $image = $request->file('icon_image');
            $path = $image->store('payment-icons', 'public');
            $data['icon_image'] = $path;
        }

        // Handle QRIS image upload
        if ($request->hasFile('qris_image')) {
            // Delete old image if exists
            if ($payment->qris_image && Storage::disk('public')->exists($payment->qris_image)) {
                Storage::disk('public')->delete($payment->qris_image);
            }

            $image = $request->file('qris_image');
            $path = $image->store('qris', 'public');
            $data['qris_image'] = $path;
        }

        $payment->update($data);

        return redirect()->route('admin.setting.payment')
            ->with('success', 'Pengaturan pembayaran berhasil diperbarui!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|max:255|unique:payment_settings,payment_method',
            'label' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'qris_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['qris_image', 'icon_image']);

        // Handle icon image upload
        if ($request->hasFile('icon_image')) {
            $image = $request->file('icon_image');
            $path = $image->store('payment-icons', 'public');
            $data['icon_image'] = $path;
        }

        // Handle QRIS image upload
        if ($request->hasFile('qris_image')) {
            $image = $request->file('qris_image');
            $path = $image->store('qris', 'public');
            $data['qris_image'] = $path;
        }

        PaymentSetting::create($data);

        return redirect()->route('admin.setting.payment')
            ->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }
}

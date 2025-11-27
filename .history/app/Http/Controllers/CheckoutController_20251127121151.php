<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
// Midtrans classes will be referenced via FQN and guarded by class_exists


class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $selectedIds = $request->query('selected_items', '');
        $selectedIds = $selectedIds ? explode(',', $selectedIds) : [];

        if (empty($selectedIds)) {
            return redirect()->route('keranjang')->with('error', 'Pilih minimal satu item untuk checkout.');
        }

        $cartItems = Cart::with('product')
            ->where('user_id', $user->id)
            ->whereIn('id', $selectedIds)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang')->with('error', 'Item yang dipilih tidak ditemukan.');
        }

        // Hitung total
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        // Sesuaikan biaya pengiriman berdasarkan opsi
        $shippingCost = $request->shipping_method === 'kargo' ? 12000 : 25000;
        $serviceFee = 2000;
        $discount = 0;
        $total = $subtotal + $shippingCost + $serviceFee - $discount;

        // Ambil payment settings yang aktif
        $paymentSettings = PaymentSetting::where('is_active', true)->get()->keyBy('payment_method');

        // Prepare payment settings data untuk JavaScript dengan key payment_method
        $paymentSettingsJs = [];
        $isVercel = env('VERCEL') === '1' || env('APP_ENV') === 'production';
        
        foreach ($paymentSettings as $payment) {
            // Cek apakah qris_image dari Cloudinary atau local storage
            $qrisImageUrl = null;
            if ($payment->qris_image) {
                $isCloudinary = str_contains($payment->qris_image, 'cloudinary.com') || str_contains($payment->qris_image, 'res.cloudinary.com');
                
                if ($isCloudinary) {
                    // URL Cloudinary - langsung pakai
                    $qrisImageUrl = $payment->qris_image;
                } elseif ($isVercel) {
                    // Di Vercel, local storage path tidak bisa diakses
                    // Set null agar tidak error, tapi user perlu re-upload
                    $qrisImageUrl = null;
                    Log::warning("QRIS image for payment method '{$payment->payment_method}' is using local storage path in Vercel. Please re-upload to Cloudinary.");
                } else {
                    // Local development - bisa pakai local storage
                    $qrisImageUrl = asset('storage/' . $payment->qris_image);
                }
            }
            
            $paymentSettingsJs[$payment->payment_method] = [
                'label' => $payment->label ?? ucfirst($payment->payment_method),
                'account_number' => $payment->account_number ?? '',
                'account_name' => $payment->account_name ?? '',
                'qris_image' => $qrisImageUrl,
                'instructions' => $payment->instructions ?? ''
            ];
        }

        // Tentukan metode pembayaran yang memerlukan bukti transfer
        // Metode yang memerlukan bukti: semua metode transfer (bukan COD)
        $transferMethods = $paymentSettings->keys()->toArray();
        // Tambahkan COD sebagai opsi default jika belum ada
        $allPaymentMethods = array_merge(['cod'], $transferMethods);

        return view('user.checkout', compact('cartItems', 'subtotal', 'shippingCost', 'serviceFee', 'discount', 'total', 'user', 'paymentSettings', 'paymentSettingsJs', 'allPaymentMethods', 'transferMethods'));
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
        $rules = [
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'integer',
            'shipping_address' => 'nullable|string|max:500',
            'phone' => 'required|string|max:20',
            'shipping_method' => 'required|string',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string|max:500',
        ];
        // Ambil metode pembayaran yang memerlukan bukti transfer dari payment_settings
        $transferMethods = PaymentSetting::where('is_active', true)->pluck('payment_method')->toArray();
        // Payment proof dibuat optional - user bisa upload nanti
        if (in_array($request->payment_method, $transferMethods)) {
            $rules['payment_proof'] = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
        }
        $validated = $request->validate($rules);

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
        // Sesuaikan biaya pengiriman berdasarkan opsi yang dipilih user
        $shippingMethod = $request->shipping_method;
        $shippingCost = $shippingMethod === 'kargo' ? 12000 : 25000;
        $serviceFee = 2000;
        $discount = 0;
        $total = $subtotal + $shippingCost + $serviceFee - $discount;

        // Buat pesanan baru
        $orderData = [
            'user_id' => $user->id,
            'order_code' => 'ORD-' . strtoupper(uniqid()),
            'shipping_address' => $request->shipping_address ?? $user->address ?? '',
            'phone' => $request->phone,
            'shipping_method' => $shippingMethod,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'service_fee' => $serviceFee,
            'discount' => $discount,
            'total' => $total,
        ];

        // Ambil metode pembayaran yang memerlukan bukti transfer dari payment_settings
        $transferMethods = PaymentSetting::where('is_active', true)->pluck('payment_method')->toArray();
        
        if (in_array($request->payment_method, $transferMethods)) {
            // Payment proof sekarang optional - user bisa upload nanti
            if ($request->hasFile('payment_proof')) {
                // Cek apakah di Vercel atau Cloudinary tersedia
                $isVercel = env('VERCEL') === '1' || env('APP_ENV') === 'production';
                $cloudinaryUrl = env('CLOUDINARY_URL') ?: config('cloudinary.cloud_url');
                
                // Log untuk debug
                Log::info("Is Vercel: " . ($isVercel ? 'yes' : 'no'));
                Log::info("Cloudinary URL configured: " . (!empty($cloudinaryUrl) ? 'yes' : 'no'));
                
                // Di Vercel atau jika Cloudinary tersedia, gunakan Cloudinary
                if ($isVercel || ($cloudinaryUrl && !empty($cloudinaryUrl))) {
                    try {
                        $file = $request->file('payment_proof');
                        $secureUrl = null;
                        
                        // Method 1: Coba menggunakan UploadApi langsung (lebih reliable)
                        try {
                            $uploadApi = new UploadApi();
                            $result = $uploadApi->upload($file->getRealPath(), [
                                'folder' => 'barangkarung/payments',
                                'resource_type' => 'image',
                            ]);
                            
                            if (isset($result['secure_url']) && !empty($result['secure_url'])) {
                                $secureUrl = $result['secure_url'];
                                Log::info("Payment proof uploaded via UploadApi: " . $secureUrl);
                            } else {
                                Log::warning("UploadApi returned no secure_url. Result: " . print_r($result, true));
                            }
                        } catch (\Exception $e) {
                            Log::error("UploadApi failed: " . $e->getMessage());
                        }
                        
                        // Method 2: Fallback ke Cloudinary facade
                        if (!$secureUrl) {
                            try {
                                $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                                    'folder' => 'barangkarung/payments',
                                    'resource_type' => 'image',
                                ]);
                                
                                // Coba berbagai cara untuk mendapatkan URL
                                if (is_array($uploadedFile) && isset($uploadedFile['secure_url'])) {
                                    $secureUrl = $uploadedFile['secure_url'];
                                } elseif (is_object($uploadedFile)) {
                                    // Coba method getSecurePath()
                                    if (method_exists($uploadedFile, 'getSecurePath')) {
                                        try {
                                            $secureUrl = $uploadedFile->getSecurePath();
                                        } catch (\Exception $e) {}
                                    }
                                    
                                    // Coba convert ke array
                                    if (!$secureUrl) {
                                        try {
                                            $json = json_encode($uploadedFile);
                                            $array = json_decode($json, true);
                                            $secureUrl = $array['secure_url'] ?? null;
                                        } catch (\Exception $e) {}
                                    }
                                    
                                    // Coba property
                                    if (!$secureUrl && property_exists($uploadedFile, 'secure_url')) {
                                        try {
                                            $secureUrl = $uploadedFile->secure_url;
                                        } catch (\Exception $e) {}
                                    }
                                    
                                    // Coba helper function
                                    if (!$secureUrl) {
                                        $secureUrl = getCloudinarySecureUrl($uploadedFile);
                                    }
                                }
                                
                                if ($secureUrl) {
                                    Log::info("Payment proof uploaded via Cloudinary facade: " . $secureUrl);
                                }
                            } catch (\Exception $e) {
                                Log::error("Cloudinary facade failed: " . $e->getMessage());
                            }
                        }
                        
                        // Jika semua method gagal, simpan file sebagai base64 sementara (fallback)
                        if (!$secureUrl) {
                            Log::warning("All Cloudinary methods failed. Using base64 fallback.");
                            try {
                                $fileContent = file_get_contents($file->getRealPath());
                                $base64 = base64_encode($fileContent);
                                // Simpan dengan prefix khusus untuk identifikasi
                                $orderData['payment_proof'] = 'base64:' . $base64;
                                Log::info("Payment proof saved as base64 (temporary)");
                            } catch (\Exception $e) {
                                Log::error("Base64 fallback failed: " . $e->getMessage());
                                // Jika semua gagal, biarkan null - user bisa upload nanti
                                Log::warning("Payment proof upload completely failed. User can upload later.");
                            }
                        } else {
                            $orderData['payment_proof'] = $secureUrl;
                        }
                    } catch (\Exception $e) {
                        Log::error("Payment proof upload error: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString());
                        // Jangan block checkout - user bisa upload nanti
                        Log::warning("Payment proof upload failed but continuing checkout. User can upload later.");
                    }
                } else {
                    // Hanya untuk local development, gunakan local storage
                    try {
                        $path = $request->file('payment_proof')->store('payments', 'public');
                        $orderData['payment_proof'] = $path;
                        Log::info("Payment proof saved to local storage: {$path}");
                    } catch (\Exception $e) {
                        Log::error("Local storage error: " . $e->getMessage());
                        // Jangan block checkout - user bisa upload nanti
                        Log::warning("Local storage failed but continuing checkout. User can upload later.");
                    }
                }
            }
            // Payment proof optional - tidak block checkout jika tidak ada
            $orderData['payment_status'] = 'pending';
            $orderData['status'] = 'pending';
        } else {
            // Metode lain, misal COD
            $orderData['status'] = 'pending';
        }
        $order = Order::create($orderData);


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

        // Jika metode pembayaran Midtrans DANA, buat transaksi Snap
        if ($request->payment_method === 'midtrans_dana') {
            if (!class_exists(\Midtrans\Snap::class)) {
                Log::error('Midtrans error: Snap class not available. Did you install midtrans/midtrans-php?');
                return redirect()->route('pesanan')
                    ->with('error', 'Layanan pembayaran sementara tidak tersedia. Coba lagi nanti.');
            }
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_code,
                    'gross_amount' => (int) $total,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $request->phone,
                    'shipping_address' => [
                        'address' => $request->shipping_address ?? '',
                    ],
                ],
                'enabled_payments' => ['dana'],
                'callbacks' => [
                    'finish' => route('pesanan'),
                ],
                'item_details' => $cartItems->map(function ($item) {
                    return [
                        'id' => (string) $item->product_id,
                        'price' => (int) $item->product->price,
                        'quantity' => (int) $item->quantity,
                        'name' => substr($item->product->name, 0, 50),
                    ];
                })->values()->toArray(),
            ];

            try {
                $snapTransaction = \Midtrans\Snap::createTransaction($params);
                $order->update([
                    'payment_gateway' => 'midtrans',
                    'payment_token' => $snapTransaction->token ?? null,
                    'payment_redirect_url' => $snapTransaction->redirect_url ?? null,
                    'payment_status' => 'pending',
                ]);

                Log::info("Midtrans Snap created for order {$order->order_code}");

                return redirect()->away($order->payment_redirect_url);
            } catch (\Throwable $e) {
                Log::error('Midtrans error: ' . $e->getMessage());
                return redirect()->route('pesanan')
                    ->with('error', 'Gagal memproses pembayaran DANA. Silakan coba lagi atau pilih metode lain.');
            }
        }

        Log::info("Checkout sukses oleh user {$user->id}, order_id: {$order->id}, total: {$total}");

        return redirect()->route('pesanan')->with('success', 'Pesanan berhasil dibuat! Terima kasih atas pembelian Anda.');
    }

    /**
     * Midtrans Payment Notification Callback
     */
    public function midtransNotification(Request $request)
    {
        $notif = new \Midtrans\Notification();
        $orderCode = $notif->order_id ?? null;
        $transactionStatus = $notif->transaction_status ?? null;
        $fraudStatus = $notif->fraud_status ?? null;
        $transactionId = $notif->transaction_id ?? null;

        if (!$orderCode) {
            return response()->json(['message' => 'invalid payload'], 400);
        }

        $order = Order::where('order_code', $orderCode)->first();
        if (!$order) {
            return response()->json(['message' => 'order not found'], 404);
        }

        $newStatus = $order->status;
        $paymentStatus = $order->payment_status;

        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'challenge') {
                $paymentStatus = 'challenge';
                $newStatus = 'pending';
            } else if ($fraudStatus === 'accept') {
                $paymentStatus = 'paid';
                $newStatus = 'paid';
            }
        } else if ($transactionStatus === 'settlement') {
            $paymentStatus = 'paid';
            $newStatus = 'paid';
        } else if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $paymentStatus = $transactionStatus;
            $newStatus = 'cancelled';
        } else if ($transactionStatus === 'pending') {
            $paymentStatus = 'pending';
            $newStatus = 'pending';
        }

        $order->update([
            'payment_transaction_id' => $transactionId,
            'payment_status' => $paymentStatus,
            'status' => $newStatus,
            'paid_at' => $paymentStatus === 'paid' ? now() : $order->paid_at,
        ]);

        return response()->json(['message' => 'ok']);
    }
}
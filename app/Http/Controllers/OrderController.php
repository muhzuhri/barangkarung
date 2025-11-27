<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;

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

    /**
     * Upload bukti pembayaran oleh user
     */
    public function uploadProof(Request $request, Order $order)
    {
        // Authorize: hanya owner order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        // Ambil metode pembayaran transfer dari payment_settings
        $transferMethods = \App\Models\PaymentSetting::where('is_active', true)->pluck('payment_method')->toArray();
        if (!in_array($order->payment_method, $transferMethods)) {
            return back()->with('error', 'Upload bukti hanya untuk pembayaran transfer.');
        }

        // Sudah ada proof atau sudah verified
        if ($order->payment_proof || in_array($order->payment_status ?? '', ['verified', 'rejected'])) {
            return back()->with('error', 'Bukti pembayaran sudah diupload atau diproses.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB
        ]);

        $file = $request->file('payment_proof');

        // Cek apakah di Vercel atau Cloudinary tersedia
        $isVercel = env('VERCEL') === '1' || env('APP_ENV') === 'production';
        $cloudinaryUrl = env('CLOUDINARY_URL') ?: config('cloudinary.cloud_url');
        
        // Di Vercel atau jika Cloudinary tersedia, gunakan Cloudinary
        if ($isVercel || ($cloudinaryUrl && !empty($cloudinaryUrl))) {
            try {
                // Upload ke Cloudinary - coba berbagai cara
                $proofPath = null;
                
                // Method 1: Cloudinary facade
                try {
                    $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                        'folder' => 'barangkarung/payments',
                        'resource_type' => 'image',
                    ]);
                    
                    // Coba berbagai cara untuk mendapatkan URL
                    if (is_object($uploadedFile)) {
                        if (method_exists($uploadedFile, 'getSecurePath')) {
                            try {
                                $proofPath = $uploadedFile->getSecurePath();
                            } catch (\Exception $e) {}
                        }
                        
                        if (!$proofPath) {
                            try {
                                $json = json_encode($uploadedFile);
                                $array = json_decode($json, true);
                                $proofPath = $array['secure_url'] ?? null;
                            } catch (\Exception $e) {}
                        }
                        
                        if (!$proofPath && property_exists($uploadedFile, 'secure_url')) {
                            try {
                                $proofPath = $uploadedFile->secure_url;
                            } catch (\Exception $e) {}
                        }
                    } elseif (is_array($uploadedFile)) {
                        $proofPath = $uploadedFile['secure_url'] ?? null;
                    }
                    
                    if (!$proofPath) {
                        $proofPath = getCloudinarySecureUrl($uploadedFile);
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Cloudinary facade failed: " . $e->getMessage());
                }
                
                // Method 2: UploadApi langsung
                if (!$proofPath) {
                    try {
                        $uploadApi = new UploadApi();
                        $result = $uploadApi->upload($file->getRealPath(), [
                            'folder' => 'barangkarung/payments',
                            'resource_type' => 'image',
                        ]);
                        $proofPath = $result['secure_url'] ?? null;
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("UploadApi failed: " . $e->getMessage());
                    }
                }
                
                if (!$proofPath) {
                    throw new \Exception('Gagal mendapatkan URL dari Cloudinary response');
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal mengupload bukti pembayaran ke Cloudinary: ' . $e->getMessage());
            }
        } else {
            // Hanya untuk local development, gunakan local storage
            try {
                $proofPath = $file->store('payments', 'public');
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal menyimpan bukti pembayaran: ' . $e->getMessage());
            }
        }
        
        $order->update([
            'payment_proof' => $proofPath,
            'payment_status' => 'pending'
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload! Menunggu konfirmasi admin.');
    }
}
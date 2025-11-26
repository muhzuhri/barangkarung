<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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

        // Cek apakah di Vercel atau Cloudinary tersedia
        $isVercel = env('VERCEL') === '1' || env('APP_ENV') === 'production';
        $cloudinaryUrl = env('CLOUDINARY_URL') ?: config('cloudinary.cloud_url');

        // Handle icon image upload
        if ($request->hasFile('icon_image')) {
            if ($isVercel || ($cloudinaryUrl && !empty($cloudinaryUrl))) {
                // Upload ke Cloudinary
                try {
                    // Hapus old image dari Cloudinary jika ada
                    if ($payment->icon_image && str_contains($payment->icon_image, 'cloudinary.com')) {
                        // Extract public_id dari URL Cloudinary
                        $publicId = basename(parse_url($payment->icon_image, PHP_URL_PATH), '.jpg');
                        $publicId = basename($publicId, '.png');
                        try {
                            Cloudinary::destroy('barangkarung/payment-icons/' . $publicId);
                        } catch (\Exception $e) {
                            // Ignore jika file tidak ditemukan
                        }
                    }
                    
                    // Upload ke Cloudinary menggunakan Cloudinary facade
                    $uploadedFile = Cloudinary::upload($request->file('icon_image')->getRealPath(), [
                        'folder' => 'barangkarung/payment-icons',
                        'resource_type' => 'image',
                    ]);
                    
                    // Gunakan helper function untuk mendapatkan URL
                    $secureUrl = getCloudinarySecureUrl($uploadedFile);
                    
                    if (!$secureUrl) {
                        throw new \Exception('Gagal mendapatkan URL icon dari Cloudinary');
                    }
                    
                    $data['icon_image'] = $secureUrl;
                } catch (\Exception $e) {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupload icon: ' . $e->getMessage());
                }
            } else {
                // Local storage untuk development
                if ($payment->icon_image && Storage::disk('public')->exists($payment->icon_image)) {
                    Storage::disk('public')->delete($payment->icon_image);
                }
                $image = $request->file('icon_image');
                $path = $image->store('payment-icons', 'public');
                $data['icon_image'] = $path;
            }
        }

        // Handle QRIS image upload
        if ($request->hasFile('qris_image')) {
            if ($isVercel || ($cloudinaryUrl && !empty($cloudinaryUrl))) {
                // Upload ke Cloudinary
                try {
                    // Hapus old image dari Cloudinary jika ada
                    if ($payment->qris_image && str_contains($payment->qris_image, 'cloudinary.com')) {
                        $publicId = basename(parse_url($payment->qris_image, PHP_URL_PATH), '.jpg');
                        $publicId = basename($publicId, '.png');
                        try {
                            Cloudinary::destroy('barangkarung/qris/' . $publicId);
                        } catch (\Exception $e) {
                            // Ignore jika file tidak ditemukan
                        }
                    }
                    
                    // Upload ke Cloudinary menggunakan Cloudinary facade
                    $uploadedFile = Cloudinary::upload($request->file('qris_image')->getRealPath(), [
                        'folder' => 'barangkarung/qris',
                        'resource_type' => 'image',
                    ]);
                    
                    // Gunakan helper function untuk mendapatkan URL
                    $secureUrl = getCloudinarySecureUrl($uploadedFile);
                    
                    if (!$secureUrl) {
                        throw new \Exception('Gagal mendapatkan URL QRIS dari Cloudinary');
                    }
                    
                    $data['qris_image'] = $secureUrl;
                } catch (\Exception $e) {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupload QRIS: ' . $e->getMessage());
                }
            } else {
                // Local storage untuk development
                if ($payment->qris_image && Storage::disk('public')->exists($payment->qris_image)) {
                    Storage::disk('public')->delete($payment->qris_image);
                }
                $image = $request->file('qris_image');
                $path = $image->store('qris', 'public');
                $data['qris_image'] = $path;
            }
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

        // Cek apakah di Vercel atau Cloudinary tersedia
        $isVercel = env('VERCEL') === '1' || env('APP_ENV') === 'production';
        $cloudinaryUrl = env('CLOUDINARY_URL') ?: config('cloudinary.cloud_url');

        // Handle icon image upload
        if ($request->hasFile('icon_image')) {
            if ($isVercel || ($cloudinaryUrl && !empty($cloudinaryUrl))) {
                // Upload ke Cloudinary
                try {
                    // Upload ke Cloudinary menggunakan Cloudinary facade
                    $uploadedFile = Cloudinary::upload($request->file('icon_image')->getRealPath(), [
                        'folder' => 'barangkarung/payment-icons',
                        'resource_type' => 'image',
                    ]);
                    
                    // Gunakan helper function untuk mendapatkan URL
                    $secureUrl = getCloudinarySecureUrl($uploadedFile);
                    
                    if (!$secureUrl) {
                        throw new \Exception('Gagal mendapatkan URL icon dari Cloudinary');
                    }
                    
                    $data['icon_image'] = $secureUrl;
                } catch (\Exception $e) {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupload icon: ' . $e->getMessage());
                }
            } else {
                // Local storage untuk development
                $image = $request->file('icon_image');
                $path = $image->store('payment-icons', 'public');
                $data['icon_image'] = $path;
            }
        }

        // Handle QRIS image upload
        if ($request->hasFile('qris_image')) {
            if ($isVercel || ($cloudinaryUrl && !empty($cloudinaryUrl))) {
                // Upload ke Cloudinary
                try {
                    // Upload ke Cloudinary menggunakan Cloudinary facade
                    $uploadedFile = Cloudinary::upload($request->file('qris_image')->getRealPath(), [
                        'folder' => 'barangkarung/qris',
                        'resource_type' => 'image',
                    ]);
                    
                    // Gunakan helper function untuk mendapatkan URL
                    $secureUrl = getCloudinarySecureUrl($uploadedFile);
                    
                    if (!$secureUrl) {
                        throw new \Exception('Gagal mendapatkan URL QRIS dari Cloudinary');
                    }
                    
                    $data['qris_image'] = $secureUrl;
                } catch (\Exception $e) {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupload QRIS: ' . $e->getMessage());
                }
            } else {
                // Local storage untuk development
                $image = $request->file('qris_image');
                $path = $image->store('qris', 'public');
                $data['qris_image'] = $path;
            }
        }

        PaymentSetting::create($data);

        return redirect()->route('admin.setting.payment')
            ->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $payment = PaymentSetting::findOrFail($id);
        
        // Hapus file gambar jika ada
        if ($payment->icon_image) {
            if (str_contains($payment->icon_image, 'cloudinary.com')) {
                // Hapus dari Cloudinary
                try {
                    $publicId = basename(parse_url($payment->icon_image, PHP_URL_PATH), '.jpg');
                    $publicId = basename($publicId, '.png');
                    Cloudinary::destroy('barangkarung/payment-icons/' . $publicId);
                } catch (\Exception $e) {
                    // Ignore jika file tidak ditemukan
                }
            } elseif (Storage::disk('public')->exists($payment->icon_image)) {
                Storage::disk('public')->delete($payment->icon_image);
            }
        }
        
        if ($payment->qris_image) {
            if (str_contains($payment->qris_image, 'cloudinary.com')) {
                // Hapus dari Cloudinary
                try {
                    $publicId = basename(parse_url($payment->qris_image, PHP_URL_PATH), '.jpg');
                    $publicId = basename($publicId, '.png');
                    Cloudinary::destroy('barangkarung/qris/' . $publicId);
                } catch (\Exception $e) {
                    // Ignore jika file tidak ditemukan
                }
            } elseif (Storage::disk('public')->exists($payment->qris_image)) {
                Storage::disk('public')->delete($payment->qris_image);
            }
        }
        
        $payment->delete();

        return redirect()->route('admin.setting.payment')
            ->with('success', 'Metode pembayaran berhasil dihapus!');
    }
}

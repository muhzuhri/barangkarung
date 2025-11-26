# Cara Debug Cloudinary Upload

## 1. Cek Log di Vercel

### Via Vercel Dashboard:
1. Buka https://vercel.com
2. Login ke akun Anda
3. Pilih project `barangkarung`
4. Klik tab **"Deployments"**
5. Pilih deployment terbaru
6. Klik **"Functions"** atau **"Logs"**
7. Cari log yang mengandung:
   - `Cloudinary upload response`
   - `CloudinaryHelper`
   - `Payment proof uploaded`
   - Error messages

### Via Vercel CLI (jika terinstall):
```bash
vercel logs
```

## 2. Cek Log di Local Development

### Jalankan server dengan logging:
```bash
php artisan serve
```

### Test upload di browser:
1. Buka `http://localhost:8000/checkout`
2. Upload bukti pembayaran
3. Cek terminal/console untuk melihat log

### Atau cek log file:
```bash
# Windows
type storage\logs\laravel.log

# Linux/Mac
tail -f storage/logs/laravel.log
```

## 3. Test Upload Langsung

### Buat file test sederhana:
Buka browser console (F12) dan jalankan:
```javascript
// Test apakah payment settings data ter-load
console.log('Payment Settings:', paymentSettingsData);
```

### Atau buat route test:
Tambahkan di `routes/web.php`:
```php
Route::get('/test-cloudinary', function() {
    try {
        $cloudinaryUrl = env('CLOUDINARY_URL') ?: config('cloudinary.cloud_url');
        return response()->json([
            'cloudinary_configured' => !empty($cloudinaryUrl),
            'cloudinary_url' => $cloudinaryUrl ? 'Set' : 'Not Set',
            'is_vercel' => env('VERCEL') === '1',
            'app_env' => env('APP_ENV'),
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
```

Lalu buka: `http://localhost:8000/test-cloudinary` atau `https://barangkarung.vercel.app/test-cloudinary`

## 4. Cek Error di Browser

1. Buka browser console (F12)
2. Pilih tab **"Console"**
3. Upload bukti pembayaran
4. Lihat error yang muncul

## 5. Cek Network Request

1. Buka browser console (F12)
2. Pilih tab **"Network"**
3. Upload bukti pembayaran
4. Cari request ke `/checkout/process`
5. Klik request tersebut
6. Lihat tab **"Response"** untuk melihat error message

## 6. Test Cloudinary Connection

Jalankan di terminal:
```bash
php artisan tinker
```

Lalu di tinker:
```php
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

// Test config
config('cloudinary.cloud_url');

// Test upload (gunakan file test)
$testFile = storage_path('app/test.jpg'); // Buat file test dulu
Cloudinary::upload($testFile, ['folder' => 'test']);
```

## Yang Perlu Dicek:

1. **Cloudinary URL di Vercel:**
   - Pastikan `CLOUDINARY_URL` sudah di-set di Vercel Environment Variables
   - Buka Vercel Dashboard → Project Settings → Environment Variables

2. **Response Structure:**
   - Cek log `Cloudinary upload response type:` dan `class:`
   - Ini akan menunjukkan format response yang sebenarnya

3. **Error Message:**
   - Copy error message lengkap dari log
   - Termasuk stack trace jika ada

## Jika Masih Error:

Kirimkan informasi berikut:
1. Error message lengkap dari log Vercel
2. Output dari `/test-cloudinary` route
3. Screenshot browser console jika ada error JavaScript
4. Log dari `Cloudinary upload response type:` dan `class:`


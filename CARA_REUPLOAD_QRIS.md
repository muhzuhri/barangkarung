# Cara Re-upload QRIS ke Cloudinary

## Masalah
QRIS image yang sudah ada masih menggunakan path local storage (`qris/OQiaggl1N6uPYDkkYdFWVckjtqoFucTFc5xTuPCB.jpg`) yang tidak bisa diakses di Vercel.

## Solusi: Re-upload QRIS

### Langkah-langkah:

1. **Buka Admin Panel:**
   - Login sebagai admin
   - Buka: `https://barangkarung.vercel.app/admin/payment-settings`
   - Atau local: `http://localhost:8000/admin/payment-settings`

2. **Edit Metode Pembayaran:**
   - Cari metode pembayaran yang punya QRIS (misalnya DANA)
   - Klik form edit metode tersebut

3. **Re-upload QRIS Image:**
   - Scroll ke bagian "Gambar QRIS"
   - Klik "Choose File" atau area upload
   - Pilih file QRIS image yang sama (atau file baru)
   - **Pastikan file terpilih** (bukan hanya klik, tapi benar-benar pilih file)

4. **Simpan:**
   - Klik tombol "Simpan Perubahan"
   - Tunggu sampai muncul pesan sukses

5. **Verifikasi:**
   - Setelah simpan, cek apakah gambar QRIS muncul
   - Jika muncul, berarti sudah tersimpan di Cloudinary
   - URL akan berubah menjadi: `https://res.cloudinary.com/dk1fcgwuy/image/upload/...`

## Troubleshooting

### Jika upload gagal dengan error "Trying to access array offset on null":

1. **Cek Log Vercel:**
   - Buka Vercel Dashboard → Deployments → Logs
   - Cari log yang mengandung: `QRIS upload - Response type:`
   - Copy log lengkap dan kirimkan untuk debugging

2. **Cek Konfigurasi:**
   - Buka: `https://barangkarung.vercel.app/test-cloudinary`
   - Pastikan `cloudinary_configured: true`

3. **Coba Upload Lagi:**
   - Pastikan file image valid (JPG, PNG, max 2MB)
   - Coba dengan file yang berbeda
   - Pastikan koneksi internet stabil

### Jika QRIS tidak muncul di checkout:

1. **Cek Browser Console (F12):**
   - Buka tab "Console"
   - Pilih metode pembayaran DANA
   - Lihat log: `QRIS image URL:`
   - Pastikan URL adalah Cloudinary URL (bukan `/storage/...`)

2. **Cek Database:**
   - Pastikan di database, kolom `qris_image` berisi URL Cloudinary
   - Bukan path local storage

## Catatan Penting

- **Setelah re-upload, URL akan berubah** dari `qris/...` menjadi `https://res.cloudinary.com/...`
- **File lama di local storage tidak akan terhapus** (tidak masalah, karena tidak digunakan lagi)
- **Di Vercel, hanya Cloudinary URL yang bisa diakses**
- **Di local development, bisa pakai local storage atau Cloudinary**


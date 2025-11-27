# TODO: Fix Upload Bukti Pembayaran User Tidak Muncul di Admin

## Information Gathered (Ringkasan Pemahaman):
- Model Order mendukung field `payment_proof` dan `payment_status`.
- View admin (`admin/orders/show.blade.php`): Sudah benar menampilkan gambar dari `storage/` jika ada, dengan debug jika hilang.
- View user detail (`pesanan-detail.blade.php`): Menampilkan link bukti jika ada, tapi **TIDAK ADA FORM UPLOAD** → penyebab utama masalah.
- View list pesanan (`pesanan.blade.php`): Tidak ada form upload.
- Flow: User upload → simpan ke `storage/app/public/orders/` → update DB `payment_proof` & `payment_status=pending`.

## Plan (Rencana Lengkap):
- **resources/views/pesanan-detail.blade.php**: Tambah form upload di section status pembayaran jika `payment_method` transfer (dana/mandiri/qris) DAN `payment_status` pending DAN belum ada proof.
- **routes/web.php**: Tambah route POST `/pesanan/{order}/upload-bukti`.
- **app/Http/Controllers/OrderController.php**: Method `uploadProof` untuk validasi, simpan file unik, update order.
- Pastikan symlink `storage:link`.

## Langkah-langkah (Steps):
- [ ] 1. Tambah route di `routes/web.php`.
- [ ] 2. Tambah method `uploadProof` di `app/Http/Controllers/OrderController.php`.
- [ ] 3. Tambah form upload di `resources/views/pesanan-detail.blade.php`.
- [ ] 4. Jalankan `php artisan storage:link` (jika belum ada symlink public/storage).
- [ ] 5. Test: Buat order pending transfer, upload dari user detail, cek muncul di admin detail dengan gambar.
- [ ] 6. Update TODO.md selesai.

## Dependent Files:
- routes/web.php
- app/Http/Controllers/OrderController.php
- resources/views/pesanan-detail.blade.php

## Followup:
- Test end-to-end.
- Handle error (file terlalu besar, format salah).

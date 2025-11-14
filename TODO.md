# TODO: Tambahkan Tombol Fullscreen di Chatbot

## Tugas Utama

-   [ ] Tambahkan tombol fullscreen (ikon expand) di header chatbot di `navbar.blade.php`
-   [ ] Update JavaScript untuk toggle mode fullscreen (memperbesar ukuran chatbot ke hampir layar penuh)
-   [ ] Update CSS di `chatbot-style.css` untuk styling mode fullscreen jika diperlukan

## Langkah-langkah Detail

1. [ ] Edit `resources/views/components/navbar.blade.php`:
    - Tambahkan tombol fullscreen di header chatbot
    - Tambahkan event listener di JavaScript untuk toggle fullscreen
2. [ ] Update JavaScript di navbar.blade.php:
    - Tambahkan variabel untuk track mode fullscreen
    - Tambahkan fungsi toggleFullscreen()
    - Ubah ukuran window saat fullscreen
3. [ ] Test fungsionalitas:
    - Klik tombol fullscreen memperbesar chatbot
    - Klik lagi mengembalikan ke ukuran normal
    - Pastikan responsive dan tidak overlap dengan konten lain

## Status

-   [x] Analisis file chatbot selesai
-   [x] Rencana disetujui user
-   [ ] Implementasi dimulai

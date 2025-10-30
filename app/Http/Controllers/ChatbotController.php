<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $text = Str::of(mb_strtolower($request->input('message')));

        $reply = $this->generateReply($text);

        return response()->json([
            'reply' => $reply,
        ]);
    }

    private function generateReply($text)
    {
        // Rules-based intents with broad keyword coverage
        $rules = [
            [
                'k' => ['halo', 'hai', 'hi', 'assalam', 'pagi', 'siang', 'sore', 'malam', 'selamat'],
                'r' => 'Halo! Saya asisten BarangKarung. Tanyakan soal produk pakaian, ukuran, bahan, pengiriman, pembayaran, atau bantuan belanja.'
            ],
            [
                'k' => ['cara beli', 'cara belanja', 'order gimana', 'pesan gimana', 'bagaimana cara'],
                'r' => 'Cara belanja: buka katalog, pilih produk dan ukuran, masukkan ke keranjang, lanjut checkout, isi alamat, pilih pengiriman dan pembayaran, lalu konfirmasi.'
            ],
            [
                'k' => ['size', 'ukuran', 'fit', 'muat', 'besar', 'kecil', 'slim fit', 'oversize'],
                'r' => 'Ukuran tersedia mengikuti produk. Lihat size chart/opsi ukuran di halaman produk. Jika ragu, sebutkan tinggi/berat Anda, kami bantu rekomendasi.'
            ],
            [
                'k' => ['size chart', 'tabel ukuran', 'panduan ukuran', 'chart size', 'measurement', 'lingkar dada', 'panjang baju'],
                'r' => 'Panduan ukuran (size chart) tercantum di deskripsi produk. Jika tidak terlihat, beri tahu produk yang dimaksud agar kami bantu.'
            ],
            [
                'k' => ['bahan', 'material', 'kain', 'fabric', 'cotton', 'katun', 'jeans', 'denim', 'poly', 'polyester', 'fleece', 'corduroy', 'linen', 'rayon'],
                'r' => 'Bahan berbeda tiap produk (mis. katun, polyester, denim, fleece). Cek deskripsi produk untuk bahan dan panduan perawatan.'
            ],
            [
                'k' => ['warna', 'color', 'pilihan warna', 'varian warna'],
                'r' => 'Pilihan warna mengikuti stok produk. Lihat varian di halaman produk. Jika warna tertentu tidak muncul, kemungkinan sedang habis.'
            ],
            [
                'k' => ['model', 'desain', 'style', 'motif'],
                'r' => 'Detail model/desain dapat dilihat pada foto dan deskripsi produk. Tanyakan model tertentu, kami bantu carikan.'
            ],
            [
                'k' => ['harga', 'price', 'berapa', 'murah', 'diskon harga'],
                'r' => 'Harga tercantum di halaman produk dan bisa berubah saat promo. Tambahkan ke keranjang untuk melihat total dengan ongkir.'
            ],
            [
                'k' => ['stok', 'tersedia', 'habis', 'available', 'restock', 'kapan restock'],
                'r' => 'Ketersediaan stok ditampilkan di halaman produk. Jika habis, pantau secara berkala—restock dilakukan sesuai ketersediaan supplier.'
            ],
            [
                'k' => ['pengiriman', 'ongkir', 'kirim', 'kurir', 'estimasi tiba', 'lama pengiriman', 'packing', 'kemasan'],
                'r' => 'Opsi: Reguler atau Kargo. Ongkir dan estimasi tiba tampil saat checkout. Barang dipacking rapi dan aman sebelum dikirim.'
            ],
            [
                'k' => ['alamat', 'ubah alamat', 'ganti alamat', 'alamat kirim', 'alamat salah'],
                'r' => 'Ubah alamat di halaman Checkout atau dari Profile sebelum bayar. Jika sudah bayar, segera hubungi admin agar kami bantu.'
            ],
            [
                'k' => ['lacak', 'tracking', 'resi', 'status pesanan', 'order saya', 'pesanan saya', 'cek pesanan'],
                'r' => 'Cek status di menu Pesanan/Riwayat. Jika tersedia resi, akan tampil setelah paket dikirim.'
            ],
            [
                'k' => ['bayar', 'pembayaran', 'payment', 'dana', 'midtrans', 'cod', 'cara bayar', 'snap'],
                'r' => 'Metode pembayaran: COD dan DANA (via Midtrans). Pilih saat checkout. Setelah bayar DANA berhasil, status pesanan otomatis menjadi paid.'
            ],
            [
                'k' => ['langkah dana', 'cara dana', 'bayar dana', 'top up dana'],
                'r' => 'Pilih DANA di checkout → lanjut ke halaman Midtrans → login DANA → konfirmasi pembayaran. Pastikan saldo cukup atau metode DANA aktif.'
            ],
            [
                'k' => ['voucher', 'diskon', 'promo', 'kupon', 'kode promo'],
                'r' => 'Promo/voucher akan diumumkan di banner atau halaman produk jika tersedia. Masukkan kode di checkout untuk menikmati diskon.'
            ],
            [
                'k' => ['retur', 'refund', 'tukar', 'pengembalian', 'tukar size', 'salah ukuran'],
                'r' => 'Ajukan retur maksimal 3x24 jam setelah diterima untuk salah ukuran/defect. Sertakan foto bukti dan nomor pesanan pada saat menghubungi kami.'
            ],
            [
                'k' => ['rusak', 'cacat', 'defect', 'sobek', 'noda'],
                'r' => 'Maaf atas kendalanya! Mohon kirim foto defect dan nomor pesanan. Kami bantu solusi terbaik: retur/tukar/refund sesuai kebijakan.'
            ],
            [
                'k' => ['buka bungkus', 'unboxing', 'video', 'rekam'],
                'r' => 'Rekam unboxing saat paket datang untuk bukti jika terjadi kendala. Ini membantu percepat proses solusi.'
            ],
            [
                'k' => ['care', 'perawatan', 'cuci', 'setrika', 'wash', 'laundry'],
                'r' => 'Ikuti instruksi perawatan di label. Umumnya: cuci terbalik, hindari pemutih, setrika suhu sedang sesuai bahan (katun/denim/Poly berbeda suhu).'
            ],
            [
                'k' => ['asli', 'original', 'keaslian', 'ori'],
                'r' => 'Produk sesuai deskripsi dan foto. Jika ada perbedaan signifikan saat diterima, sampaikan ke kami agar segera ditangani.'
            ],
            [
                'k' => ['ubah pesanan', 'ganti pesanan', 'batalkan', 'cancel order', 'gabung pesanan', 'pisah pesanan'],
                'r' => 'Perubahan/pembatalan bisa sebelum diproses/terkirim. Hubungi admin dengan nomor pesanan untuk permintaan gabung/pisah pesanan.'
            ],
            [
                'k' => ['akun', 'login', 'masuk', 'daftar', 'register', 'password', 'kata sandi', 'lupa password'],
                'r' => 'Jika lupa password, gunakan fitur reset di halaman login. Jika tetap bermasalah, hubungi admin, kami bantu pemulihan akun.'
            ],
            [
                'k' => ['hapus akun', 'hapus data', 'privacy', 'privasi', 'data'],
                'r' => 'Permintaan penghapusan akun/data dapat diajukan ke admin. Kami memproses sesuai kebijakan privasi yang berlaku.'
            ],
            [
                'k' => ['jam', 'operasional', 'buka', 'tutup', 'kapan buka'],
                'r' => 'Support online 09.00–21.00 WIB setiap hari. Pesanan diproses pada jam kerja. Balasan mungkin lebih lambat saat jam sibuk.'
            ],
            [
                'k' => ['kontak', 'whatsapp', 'wa', 'hubungi', 'customer service', 'cs', 'admin'],
                'r' => 'Hubungi admin via WhatsApp: 08xx-xxxx-xxxx. Anda juga bisa menemukan kontak di halaman Profile.'
            ],
            [
                'k' => ['tentang', 'about', 'website ini', 'barang karung apa', 'profil toko'],
                'r' => 'BarangKarung.id adalah toko pakaian kasual hingga formal. Fokus pada kualitas, kenyamanan, dan harga terjangkau.'
            ],
            [
                'k' => ['preorder', 'po', 'indent', 'pesan dulu'],
                'r' => 'Saat ini kami fokus pada produk ready stock. Jika ada pre-order, infonya akan tercantum jelas di halaman produk.'
            ],
            [
                'k' => ['kado', 'gift', 'bungkus kado'],
                'r' => 'Layanan bungkus kado belum tersedia secara default. Bila diperlukan, beri catatan saat checkout—kami usahakan bantu.'
            ],
            [
                'k' => ['invois', 'invoice', 'nota', 'kwitansi'],
                'r' => 'Invoice digital tersedia pada riwayat pesanan. Untuk kebutuhan khusus (stempel/perusahaan), silakan hubungi admin.'
            ],
            [
                'k' => ['estimasi proses', 'proses pesanan', 'diproses kapan'],
                'r' => 'Pesanan diproses pada jam kerja. Pesanan yang masuk di luar jam kerja akan diproses di hari/jam kerja berikutnya.'
            ],
            [
                'k' => ['combine', 'gabung', 'satukan', 'penggabungan'],
                'r' => 'Penggabungan pesanan bisa selama status belum diproses/terkirim. Segera hubungi admin dan berikan nomor pesanan terkait.'
            ],
            [
                'k' => ['pisah kirim', 'split shipment', 'kirim terpisah'],
                'r' => 'Pengiriman terpisah dapat dibantu jika ada kendala stok. Mohon komunikasi dengan admin untuk opsi terbaik.'
            ],
            [
                'k' => ['salah kirim', 'beda barang', 'tidak sesuai', 'mismatch'],
                'r' => 'Mohon maaf bila ada ketidaksesuaian. Kirim foto barang yang diterima dan nomor pesanan, kami bantu tukar/solusi segera.'
            ],
            [
                'k' => ['waktu refund', 'kapan refund', 'lama refund'],
                'r' => 'Proses refund umumnya 1–3 hari kerja setelah disetujui, tergantung metode pembayaran dan bank/e-wallet.'
            ],
            [
                'k' => ['biaya retur', 'ongkir retur', 'retur bayar siapa'],
                'r' => 'Untuk produk defect/salah kirim, biaya retur ditanggung kami. Untuk tukar ukuran, mengikuti kebijakan yang berlaku saat itu.'
            ],
            [
                'k' => ['konversi ukuran', 'ukuran internasional', 'size conversion'],
                'r' => 'Konversi ukuran bisa berbeda tiap brand/model. Silakan sebutkan produk dan ukuran Anda saat ini agar kami bantu rekomendasi.'
            ],
            [
                'k' => ['notifikasi', 'email', 'newsletter', 'info promo'],
                'r' => 'Pantau banner di beranda dan ikuti media sosial kami untuk info promo terbaru.'
            ],
            [
                'k' => ['media sosial', 'instagram', 'tiktok', 'facebook', 'ig'],
                'r' => 'Ikuti media sosial kami untuk update produk dan promo. Detail akun akan ditampilkan di beranda/profil jika tersedia.'
            ],
        ];

        foreach ($rules as $rule) {
            foreach ($rule['k'] as $kw) {
                if ($text->contains($kw)) {
                    return $rule['r'];
                }
            }
        }

        return 'Terima kasih! Bisa jelaskan pertanyaan Anda tentang pakaian atau cara belanja? Saya akan bantu.';
    }
}



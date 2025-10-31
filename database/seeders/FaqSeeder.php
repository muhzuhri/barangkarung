<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            // FAQ Sebelumnya
            [
                'question' => 'Bagaimana cara melakukan pembelian?',
                'answer' => 'Untuk melakukan pembelian, Anda dapat mengikuti langkah-langkah berikut:
                            1. Pilih produk yang ingin dibeli
                            2. Tentukan ukuran dan jumlah yang diinginkan
                            3. Tambahkan ke keranjang
                            4. Klik checkout dan isi data pengiriman
                            5. Pilih metode pembayaran
                            6. Selesaikan pembayaran',
                'category' => 'Pembelian',
                'is_active' => true
            ],
            [
                'question' => 'Berapa lama waktu pengiriman?',
                'answer' => 'Waktu pengiriman tergantung pada lokasi dan jasa ekspedisi yang dipilih. 
                            Umumnya membutuhkan waktu 2-7 hari kerja untuk pengiriman dalam negeri.',
                'category' => 'Pengiriman',
                'is_active' => true
            ],
            [
                'question' => 'Apakah ada garansi produk?',
                'answer' => 'Ya, semua produk kami memiliki garansi pengembalian 7 hari 
                            jika terdapat cacat produksi atau kesalahan pengiriman.',
                'category' => 'Garansi',
                'is_active' => true
            ],
            [
                'question' => 'Metode pembayaran apa saja yang tersedia?',
                'answer' => 'Kami menerima pembayaran melalui:
                            - Transfer bank
                            - E-wallet (OVO, GoPay, DANA)
                            - Virtual Account
                            - Kartu kredit',
                'category' => 'Pembayaran',
                'is_active' => true
            ],
            [
                'question' => 'Bagaimana cara mengetahui ukuran yang tepat?',
                'answer' => 'Anda dapat melihat panduan ukuran di setiap halaman produk. 
                            Jika masih ragu, Anda dapat menghubungi customer service kami 
                            untuk bantuan pemilihan ukuran yang tepat.',
                'category' => 'Produk',
                'is_active' => true
            ],
            
            // FAQ Baru
            [
                'question' => 'Apakah bisa melakukan pengembalian barang?',
                'answer' => 'Ya, pengembalian barang dapat dilakukan dalam waktu 7 hari setelah barang diterima 
                            dengan syarat: barang belum dipakai, tag masih terpasang, dan dalam kondisi asli.',
                'category' => 'Pengembalian',
                'is_active' => true
            ],
            [
                'question' => 'Bagaimana cara melacak pesanan?',
                'answer' => 'Anda dapat melacak pesanan dengan cara:
                            1. Login ke akun Anda
                            2. Buka menu Pesanan
                            3. Klik detail pesanan yang ingin dilacak
                            4. Lihat status pengiriman dan nomor resi',
                'category' => 'Pengiriman',
                'is_active' => true
            ],
            [
                'question' => 'Apakah ada minimal pembelian?',
                'answer' => 'Tidak ada minimal pembelian untuk berbelanja di toko kami. 
                            Anda bebas membeli berapapun jumlahnya.',
                'category' => 'Pembelian',
                'is_active' => true
            ],
            [
                'question' => 'Bagaimana jika ukuran tidak sesuai?',
                'answer' => 'Jika ukuran tidak sesuai, Anda dapat menukar dengan ukuran lain 
                            dalam waktu 7 hari setelah barang diterima, dengan syarat barang belum dipakai.',
                'category' => 'Produk',
                'is_active' => true
            ],
            [
                'question' => 'Apakah ada diskon untuk pembelian dalam jumlah besar?',
                'answer' => 'Ya, kami memberikan diskon khusus untuk pembelian grosir atau dalam jumlah besar. 
                            Silahkan hubungi customer service kami untuk informasi lebih lanjut.',
                'category' => 'Pembelian',
                'is_active' => true
            ],
            [
                'question' => 'Bagaimana cara membatalkan pesanan?',
                'answer' => 'Pembatalan pesanan hanya dapat dilakukan sebelum pesanan dikonfirmasi oleh admin. 
                            Silahkan hubungi customer service kami segera jika ingin membatalkan pesanan.',
                'category' => 'Pesanan',
                'is_active' => true
            ],
            [
                'question' => 'Apakah ada asuransi pengiriman?',
                'answer' => 'Ya, semua pengiriman otomatis diasuransikan untuk melindungi 
                            paket Anda dari kerusakan atau kehilangan selama pengiriman.',
                'category' => 'Pengiriman',
                'is_active' => true
            ],
            [
                'question' => 'Berapa lama proses konfirmasi pembayaran?',
                'answer' => 'Konfirmasi pembayaran biasanya diproses dalam waktu 1x24 jam kerja. 
                            Untuk pembayaran via transfer manual, harap kirimkan bukti transfer ke customer service kami.',
                'category' => 'Pembayaran',
                'is_active' => true
            ],
            [
                'question' => 'Apakah ada program membership?',
                'answer' => 'Ya, kami memiliki program membership dengan berbagai keuntungan:
                            - Poin reward setiap pembelian
                            - Diskon khusus member
                            - Akses ke penjualan private
                            - Prioritas layanan pelanggan',
                'category' => 'Membership',
                'is_active' => true
            ],
            [
                'question' => 'Bagaimana cara mendaftar membership?',
                'answer' => 'Untuk mendaftar membership:
                            1. Login ke akun Anda
                            2. Klik menu Membership
                            3. Pilih paket membership yang diinginkan
                            4. Lakukan pembayaran
                            5. Nikmati benefitnya',
                'category' => 'Membership',
                'is_active' => true
            ],
            [
                'question' => 'Apa yang harus dilakukan jika pesanan belum sampai melebihi estimasi?',
                'answer' => 'Jika pesanan belum sampai melebihi estimasi, Anda dapat:
                            1. Cek status tracking pengiriman
                            2. Hubungi customer service kami
                            3. Kami akan membantu melacak dan menyelesaikan masalah pengiriman Anda',
                'category' => 'Pengiriman',
                'is_active' => true
            ],
            [
                'question' => 'Apakah bisa mengubah alamat pengiriman setelah checkout?',
                'answer' => 'Perubahan alamat pengiriman hanya dapat dilakukan sebelum paket dikirim. 
                            Segera hubungi customer service kami jika ingin mengubah alamat pengiriman.',
                'category' => 'Pengiriman',
                'is_active' => true
            ],
            [
                'question' => 'Bagaimana cara menggunakan kode promo?',
                'answer' => 'Untuk menggunakan kode promo:
                            1. Masukkan barang ke keranjang
                            2. Pada halaman checkout, masukkan kode promo di kolom yang tersedia
                            3. Klik "Gunakan"
                            4. Diskon akan otomatis terpotong dari total belanja',
                'category' => 'Pembelian',
                'is_active' => true
            ],
            [
                'question' => 'Apakah ada layanan pengiriman express?',
                'answer' => 'Ya, kami menyediakan layanan pengiriman express untuk pengiriman lebih cepat. 
                            Pilih opsi "Express Shipping" saat checkout untuk pengiriman 1-2 hari kerja.',
                'category' => 'Pengiriman',
                'is_active' => true
            ],
            [
                'question' => 'Bagaimana prosedur pengembalian dana?',
                'answer' => 'Prosedur pengembalian dana:
                            1. Ajukan permintaan refund dengan bukti pendukung
                            2. Tim kami akan review dalam 2-3 hari kerja
                            3. Jika disetujui, dana akan dikembalikan dalam 5-7 hari kerja
                            4. Pengembalian dana sesuai metode pembayaran awal',
                'category' => 'Pengembalian',
                'is_active' => true
            ],
            [
                'question' => 'Apakah ada panduan perawatan produk?',
                'answer' => 'Ya, setiap produk memiliki panduan perawatan spesifik yang dapat ditemukan:
                            - Di label produk
                            - Di halaman detail produk
                            - Di kartu perawatan yang disertakan dalam paket
                            Ikuti panduan perawatan untuk menjaga kualitas produk.',
                'category' => 'Produk',
                'is_active' => true
            ],
            [
                'question' => 'Bagaimana cara menghubungi customer service?',
                'answer' => 'Anda dapat menghubungi customer service kami melalui:
                            - Live chat di website
                            - WhatsApp: [nomor CS]
                            - Email: cs@barangkarung.com
                            - Instagram DM: @barangkarung
                            Layanan tersedia setiap hari kerja (Senin-Jumat, 09.00-17.00 WIB)',
                'category' => 'Layanan Pelanggan',
                'is_active' => true
            ],
            [
                'question' => 'Apakah ada program afiliasi?',
                'answer' => 'Ya, kami memiliki program afiliasi untuk para influencer dan reseller:
                            - Komisi menarik untuk setiap penjualan
                            - Akses ke katalog khusus reseller
                            - Material promosi yang dapat digunakan
                            - Dashboard tracking penjualan
                            Hubungi tim marketing kami untuk informasi lebih lanjut.',
                'category' => 'Afiliasi',
                'is_active' => true
            ],
            [
                'question' => 'Bagaimana kebijakan privasi data pelanggan?',
                'answer' => 'Kami menjaga kerahasiaan data pelanggan dengan:
                            - Enkripsi data sensitif
                            - Tidak membagikan data ke pihak ketiga
                            - Hanya menggunakan data untuk keperluan transaksi
                            - Mematuhi regulasi perlindungan data yang berlaku
                            Baca kebijakan privasi lengkap di website kami.',
                'category' => 'Privasi & Keamanan',
                'is_active' => true
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
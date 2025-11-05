<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    /**
     * Menghitung kemiripan antara dua string menggunakan algoritma Levenshtein
     */
    private function calculateSimilarity($str1, $str2) {
        $str1 = (string) $str1;
        $str2 = (string) $str2;
        
        $length1 = strlen($str1);
        $length2 = strlen($str2);
        
        if ($length1 === 0) return $length2 === 0 ? 1.0 : 0.0;
        
        $distance = levenshtein($str1, $str2);
        $maxLength = max($length1, $length2);
        
        return 1 - ($distance / $maxLength);
    }
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
    
    /**
     * Ambil FAQ populer untuk quick replies
     */
    public function getPopularFaqs()
    {
        $faqs = Faq::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'question', 'category']);
        
        return response()->json([
            'faqs' => $faqs
        ]);
    }
    
    /**
     * Ambil semua FAQ yang dikelompokkan berdasarkan kategori
     */
    public function getAllFaqs()
    {
        $faqs = Faq::where('is_active', true)
            ->orderBy('category')
            ->orderBy('question')
            ->get(['id', 'question', 'category']);
        
        // Kelompokkan berdasarkan kategori
        $grouped = $faqs->groupBy('category')->map(function ($items) {
            return $items->pluck('question', 'id');
        });
        
        return response()->json([
            'faqs' => $faqs,
            'grouped' => $grouped
        ]);
    }

    private function generateReply($text)
    {
        $text = Str::of(mb_strtolower($text));
        $bestMatch = null;
        $highestSimilarity = 0;
        $relatedAnswers = [];
        
        // Cek jika user meminta daftar pertanyaan
        $helpKeywords = ['bantuan', 'help', 'pertanyaan', 'daftar', 'list', 'apa saja', 'apa yang bisa', 'tanyakan', 'fitur'];
        $isHelpRequest = false;
        foreach ($helpKeywords as $keyword) {
            if ($text->contains($keyword)) {
                $isHelpRequest = true;
                break;
            }
        }
        
        if ($isHelpRequest) {
            $allFaqs = Faq::where('is_active', true)
                ->orderBy('category')
                ->orderBy('question')
                ->get(['question', 'category']);
            
            if ($allFaqs->count() > 0) {
                $response = "📋 Berikut adalah daftar pertanyaan yang bisa Anda tanyakan:\n\n";
                
                // Kelompokkan berdasarkan kategori
                $grouped = $allFaqs->groupBy('category');
                
                foreach ($grouped as $category => $faqs) {
                    $response .= "📌 " . strtoupper($category) . "\n";
                    $num = 1;
                    foreach ($faqs as $faq) {
                        $response .= "   " . $num . ". " . $faq->question . "\n";
                        $num++;
                    }
                    $response .= "\n";
                }
                
                $response .= "💡 Ketik pertanyaan Anda atau klik salah satu pertanyaan di atas untuk mendapatkan jawaban!";
                
                return $response;
            } else {
                return "Maaf, belum ada pertanyaan yang tersedia saat ini. Silakan hubungi admin untuk informasi lebih lanjut.";
            }
        }
        
        // Cari di FAQ terlebih dahulu
        $faqs = Faq::where('is_active', true)->get();
        
        foreach ($faqs as $faq) {
            $lowercaseQuestion = Str::of(mb_strtolower($faq->question));
            $lowercaseAnswer = Str::of(mb_strtolower($faq->answer));
            
            // Hitung kemiripan dengan pertanyaan
            $questionSimilarity = $this->calculateSimilarity($text, $lowercaseQuestion);
            
            // Hitung kemiripan dengan jawaban (untuk mencari kata kunci dalam jawaban)
            $answerSimilarity = $this->calculateSimilarity($text, $lowercaseAnswer);
            
            // Cek kemiripan dengan pertanyaan
            if ($questionSimilarity > 0.35) {
                if ($questionSimilarity > $highestSimilarity) {
                    $highestSimilarity = $questionSimilarity;
                    $bestMatch = $faq;
                }
                
                // Tambahkan ke daftar jawaban terkait
                if ($questionSimilarity > 0.3) {
                    $relatedAnswers[] = [
                        'category' => $faq->category,
                        'question' => $faq->question,
                        'answer' => $faq->answer,
                        'similarity' => $questionSimilarity
                    ];
                }
            }
            
            // Cek kata kunci dalam jawaban
            if ($answerSimilarity > 0.4) {
                if ($answerSimilarity > $highestSimilarity) {
                    $highestSimilarity = $answerSimilarity;
                    $bestMatch = $faq;
                }
            }
            
            // Cek kata kunci dalam kategori
            if ($faq->category && Str::contains($text, Str::of(mb_strtolower($faq->category)))) {
                $categoryExists = false;
                foreach ($relatedAnswers as $existing) {
                    if ($existing['question'] === $faq->question) {
                        $categoryExists = true;
                        break;
                    }
                }
                if (!$categoryExists) {
                    $relatedAnswers[] = [
                        'category' => $faq->category,
                        'question' => $faq->question,
                        'answer' => $faq->answer,
                        'similarity' => 0.5
                    ];
                }
            }
            
            // Cek kata kunci dalam pertanyaan menggunakan contains
            $questionWords = explode(' ', $lowercaseQuestion);
            $textWords = explode(' ', $text);
            $matchingWords = array_intersect($questionWords, $textWords);
            
            if (count($matchingWords) >= 2 && count($matchingWords) >= count($questionWords) * 0.3) {
                $wordSimilarity = count($matchingWords) / max(count($questionWords), count($textWords));
                if ($wordSimilarity > 0.3 && $wordSimilarity > $highestSimilarity) {
                    $highestSimilarity = $wordSimilarity;
                    $bestMatch = $faq;
                }
            }
        }
        
        // Urutkan jawaban terkait berdasarkan kemiripan
        usort($relatedAnswers, function($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });
        
        // Hapus duplikat berdasarkan question
        $uniqueAnswers = [];
        $seenQuestions = [];
        foreach ($relatedAnswers as $related) {
            if (!in_array($related['question'], $seenQuestions)) {
                $uniqueAnswers[] = $related;
                $seenQuestions[] = $related['question'];
            }
        }
        $relatedAnswers = $uniqueAnswers;
        
        // Batasi hanya 3 jawaban terkait teratas
        $relatedAnswers = array_slice($relatedAnswers, 0, 3);
        
        if ($bestMatch && $highestSimilarity > 0.35) {
            $response = "📌 " . $bestMatch->answer;
            
            if (count($relatedAnswers) > 1) {
                $response .= "\n\n💡 Pertanyaan terkait:\n\n";
                foreach ($relatedAnswers as $related) {
                    if ($related['question'] !== $bestMatch->question) {
                        $response .= "▫️ " . $related['question'] . "\n";
                        $response .= "   " . $related['answer'] . "\n\n";
                    }
                }
            }
            
            return $response;
        }

        // Jika tidak ada FAQ yang cocok, gunakan rules default
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



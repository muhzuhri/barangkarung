<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Barang Karung ID</title>

    <!-- Google Fonts & Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/nav_menu-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/beranda-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/katalog-styl;e') }}">
</head>

<body>
    <!-- ===== NAVBAR ===== -->
    <header class="navbar">
        <!-- Logo -->
        <div class="logo">
            <h1>BARANG KARUNG</h1>
        </div>

        <!-- Search bar -->
        <div class="search-box">
            <input type="text" placeholder="Cari produk keren dan terbaik di sini ..." />
            <button><span class="material-icons">search</span></button>
        </div>

        <!-- Right icons -->
        <div class="nav-right">
            <div class="dropdown">
                <a href="#"><span class="material-icons">notifications</span></a>

                <!-- Dropdown Menu -->
                <div class="dropdown-menu">
                    <a href="#">Tidak ada Notifikasi !</a>
                </div>
            </div>

            <a href="keranjang.html"><span class="material-icons">shopping_cart</span></a>

            <div class="dropdown">
                <a href="#"><span class="material-icons">account_circle</span></a>

                <!-- Dropdown Menu -->
                <div class="dropdown-menu">
                    <a href="login.html"><span class="material-icons">login</span>Masuk</a>
                    <a href="#"><span class="material-icons">inventory_2</span>Pesanan</a>
                    <a href="#"><span class="material-icons">help_outline</span>FAQ</a>
                </div>
            </div>
        </div>
    </header>

    <!-- ===== CATEGORY MENU ===== -->
    <nav class="category-menu">
        <a href="beranda.html" class="active">Beranda</a>
        <a href="katalog.html">Katalog</a>
        <a href="pesanan.html">Pesanan</a>
        <a href="profile.html">Profile</a>
    </nav>

    <!-- ===== PROMO SECTION ===== -->
    <section class="promo-section">
        <div class="promo-content">
            <div class="promo-text">
                <h1>Barang Karung ID</h1>
                <h3>Dari Karung ke Lemari, dari Simpel ke Stylish.</h3>
                <p>Thrift berkualitas yang ramah kantong dan penuh karakter. Lorem ipsum dolor sit amet consectetur
                    adipisicing elit. Expedita iusto atque odit ex accusantium consequuntur incidunt aliquam. Nesciunt,
                    ex quibusdam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, non.</p>
                <a href="katalog.html" class="promo-btn">Jelajahi pakaian terbaikmu !!!
                    <span class="material-icons">arrow_forward</span></a>
            </div>
            <div class="promo-image">
                <img src="img/img/p.jpg" alt="Barang Karung ID">
            </div>
        </div>
    </section>

    <!-- ===== IMAGE SLIDER / BERANDA ===== -->
    <section class="hero-slider">
        <div class="slides">
            <div class="slide active">
                <img src="img/img/pict1.jpg" alt="Slide 1">
            </div>
            <div class="slide">
                <img src="img/img/pict2.jpg" alt="Slide 2">
            </div>
            <div class="slide">
                <img src="img/img/pict3.jpg" alt="Slide 3">
            </div>
            <div class="slide">
                <img src="img/img/pict4.jpg" alt="Slide 4">
            </div>
            <div class="slide">
                <img src="img/img/pict5.jpg" alt="Slide 5">
            </div>
        </div>

        <!-- Tombol navigasi -->
        <button class="prev">&#10094;</button>
        <button class="next">&#10095;</button>
    </section>

    <!-- ===== PROMO BRAND SECTION ===== -->
    <section class="promo-brand">
        <h2>Promo Brand Populer dan Keren</h2>

        <div class="promo-card-container">
            <!-- Card 1 -->
            <div class="promo-card">
                <img src="img/baju-img/model1.jpg" alt="Adidas">
                <div class="card-overlay">
                    <div class="sale-label">• 10.10 SALE • 10.10 SALE •</div>
                    <h3>ADIDAS</h3>
                    <p>Up to 40% Off + Voucher 35%</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="promo-card">
                <img src="img/baju-img/model2.jpg" alt="Nike">
                <div class="card-overlay">
                    <div class="sale-label">• 10.10 SALE • 10.10 SALE •</div>
                    <h3>NIKE</h3>
                    <p>Up to 40% Off + Voucher 35%</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="promo-card">
                <img src="img/baju-img/model3.jpg" alt="Skechers">
                <div class="card-overlay">
                    <div class="sale-label">• 10.10 SALE • 10.10 SALE •</div>
                    <h3>SKECHERS</h3>
                    <p>Up to 40% Off + Voucher 25%</p>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="promo-card">
                <img src="img/baju-img/model4.jpg" alt="New Balance">
                <div class="card-overlay">
                    <div class="sale-label">• 10.10 SALE • 10.10 SALE •</div>
                    <h3>NEW BALANCE</h3>
                    <p>Up to 40% Off + Voucher 25%</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== ATTENTION SECTION ===== -->
    <section class="attention-section">
        <div class="attention-wrapper">
            <!-- Kiri: Gambar -->
            <div class="attention-image">
                <img src="img/baju-img/pictpromo.jpg" alt="Promo Barang Karung">
            </div>

            <!-- Kanan: Teks dan Tombol -->
            <div class="attention-content">
                <h2>Perhatian, Fashion Hunters</h2>
                <p>
                    Koleksi terbaru dari <strong>Barang Karung ID</strong> sudah hadir!
                    Temukan pakaian thrift berkualitas tinggi dengan gaya kekinian, harga terjangkau, dan stok yang
                    super terbatas.
                    Semua produk dikurasi khusus buat kamu yang ingin tampil beda
                    tanpa menguras kantong.
                </p>
                <ul class="attention-list">
                    <li><span class="material-icons">check_circle</span> Harga mulai Rp25.000</li>
                    <li><span class="material-icons">check_circle</span> Produk selalu update tiap minggu</li>
                    <li><span class="material-icons">check_circle</span> Gratis ongkir untuk pembelian di atas
                        Rp150.000
                    </li>
                </ul>
                <a href="katalog.html" class="attention-btn">Jelajahi Sekarang</a>
            </div>
        </div>
    </section>

    <!-- ===== SIZE CHART SECTION ===== -->
    <section class="size-chart-section">
        <h2>Panduan Ukuran Pakaian</h2>
        <div class="size-table-container">
            <table class="size-chart-table">
                <thead>
                    <tr>
                        <th>Ukuran</th>
                        <th>Lebar Dada (cm)</th>
                        <th>Panjang Baju (cm)</th>
                        <th>Panjang Lengan (cm)</th>
                        <th>Tinggi Badan Ideal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>S</td>
                        <td>45 - 48</td>
                        <td>65 - 68</td>
                        <td>58 - 60</td>
                        <td>155 - 165 cm</td>
                    </tr>
                    <tr>
                        <td>M</td>
                        <td>49 - 52</td>
                        <td>69 - 72</td>
                        <td>61 - 63</td>
                        <td>165 - 175 cm</td>
                    </tr>
                    <tr>
                        <td>L</td>
                        <td>53 - 56</td>
                        <td>73 - 76</td>
                        <td>64 - 66</td>
                        <td>170 - 180 cm</td>
                    </tr>
                    <tr>
                        <td>XL</td>
                        <td>57 - 60</td>
                        <td>77 - 80</td>
                        <td>67 - 69</td>
                        <td>175 - 185 cm</td>
                    </tr>
                    <tr>
                        <td>XXL</td>
                        <td>61 - 64</td>
                        <td>81 - 84</td>
                        <td>70 - 72</td>
                        <td>180 - 190 cm</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p class="size-note">
            Catatan: Ukuran bisa sedikit berbeda (±1-2 cm) tergantung bahan dan model baju.
        </p>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 <span class="brand">Barang Karung ID</span>. Semua Hak Dilindungi.</p>
            <div class="footer-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat & Ketentuan</a>
                <a href="#">Kontak Kami</a>
            </div>
        </div>
    </footer>

</body>

<script>
    const slides = document.querySelectorAll('.slide');
    const nextBtn = document.querySelector('.next');
    const prevBtn = document.querySelector('.prev');
    let index = 0;

    function showSlide(n) {
        if (n >= slides.length) index = 0;
        else if (n < 0) index = slides.length - 1;
        else index = n;

        document.querySelector('.slides').style.transform = `translateX(-${index * 100}%)`;
    }

    nextBtn.addEventListener('click', () => showSlide(index + 1));
    prevBtn.addEventListener('click', () => showSlide(index - 1));

    // Auto slide tiap 4 detik
    setInterval(() => showSlide(index + 1), 4000);
</script>

</html>

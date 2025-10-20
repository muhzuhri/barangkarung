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
    <link rel="stylesheet" href="{{ asset('css/katalog-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pesanan-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profil-style.css') }}">
</head>

<body>
    <!-- ===== NAVBAR ===== -->
    <x-navbar />

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

   

    <!-- ===== KATALOG PAKAIAN ===== -->
    <section class="katalog-section">
        <h2>Katalog Pakaian</h2>

        <div class="product-grid">
            <!-- Produk 1 -->
            <div class="product-card">
                <img src="img/baju-img/polo1.png" alt="Kaos Polos">
                <h3>Kaos Polos Oversized</h3>
                <p class="brand">Barang Karung</p>
                <div class="price">
                    <span class="discount">Rp 79.000</span>
                    <span class="original">Rp 99.000</span>
                    <span class="off">-20%</span>
                </div>
                <button class="btn-cart">Masukkan ke Tas</button>
            </div>

            <!-- Produk 2 -->
            <div class="product-card">
                <img src="img/baju-img/polo2.png" alt="Hoodie">
                <h3>Hoodie Champion Hitam</h3>
                <p class="brand">Champion</p>
                <div class="price">
                    <span class="discount">Rp 210.000</span>
                    <span class="original">Rp 300.000</span>
                    <span class="off">-30%</span>
                </div>
                <button class="btn-cart">Masukkan ke Tas</button>
            </div>

            <!-- Produk 3 -->
            <div class="product-card">
                <img src="img/baju-img/polo3.png" alt="Kemeja Flanel">
                <h3>Kemeja Flanel Kotak</h3>
                <p class="brand">Barang Karung</p>
                <div class="price">
                    <span class="discount">Rp 95.000</span>
                    <span class="original">Rp 120.000</span>
                    <span class="off">-21%</span>
                </div>
                <button class="btn-cart">Masukkan ke Tas</button>
            </div>

            <!-- Produk 4 -->
            <div class="product-card">
                <img src="img/baju-img/hoodie1.png" alt="Jaket Denim">
                <h3>Jaket Denim Vintage</h3>
                <p class="brand">Levi’s</p>
                <div class="price">
                    <span class="discount">Rp 180.000</span>
                    <span class="original">Rp 250.000</span>
                    <span class="off">-28%</span>
                </div>
                <button class="btn-cart">Masukkan ke Tas</button>
            </div>

            <div class="product-card">
                <img src="img/baju-img/hoodie2.png" alt="Jaket Denim">
                <h3>Jaket Denim Vintage</h3>
                <p class="brand">Levi’s</p>
                <div class="price">
                    <span class="discount">Rp 180.000</span>
                    <span class="original">Rp 250.000</span>
                    <span class="off">-28%</span>
                </div>
                <button class="btn-cart">Masukkan ke Tas</button>
            </div>

            <!-- Produk 4 -->
            <div class="product-card">
                <img src="img/baju-img/hoodie1.png" alt="Jaket Denim">
                <h3>Jaket Denim Vintage</h3>
                <p class="brand">Levi’s</p>
                <div class="price">
                    <span class="discount">Rp 180.000</span>
                    <span class="original">Rp 250.000</span>
                    <span class="off">-28%</span>
                </div>
                <button class="btn-cart">Masukkan ke Tas</button>
            </div>

            <!-- Produk 2 -->
            <div class="product-card">
                <img src="img/baju-img/polo2.png" alt="Hoodie">
                <h3>Hoodie Champion Hitam</h3>
                <p class="brand">Champion</p>
                <div class="price">
                    <span class="discount">Rp 210.000</span>
                    <span class="original">Rp 300.000</span>
                    <span class="off">-30%</span>
                </div>
                <button class="btn-cart">Masukkan ke Tas</button>
            </div>

            <!-- Produk 3 -->
            <div class="product-card">
                <img src="img/baju-img/polo3.png" alt="Kemeja Flanel">
                <h3>Kemeja Flanel Kotak</h3>
                <p class="brand">Barang Karung</p>
                <div class="price">
                    <span class="discount">Rp 95.000</span>
                    <span class="original">Rp 120.000</span>
                    <span class="off">-21%</span>
                </div>
                <button class="btn-cart">Masukkan ke Tas</button>
            </div>
        </div>
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


</html>

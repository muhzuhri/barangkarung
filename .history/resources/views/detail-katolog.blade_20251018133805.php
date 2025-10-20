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
    <link rel="stylesheet" href="{{ asset('css/detail_katlog-style.css') }}">
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
        <a href="beranda.html">Beranda</a>
        <a href="katalog.html">Katalog</a>
        <a href="pesanan.html">Pesanan</a>
        <a href="profile.html">Profile</a>
    </nav>

    <!-- ===== DETAIL PRODUK ===== -->
    <main class="product-detail">
        <div class="product-image">
            <img src="img/baju-img/polo1.png" alt="Kaos Polos Pria Premium">
        </div>

        <div class="product-info">
            <h2 class="product-title">Kaos Polos Pria Premium</h2>
            <p class="product-price">Rp 89.000</p>
            <p class="product-desc">
                Kaos polos dengan bahan katun combed 30s yang lembut, adem, dan nyaman dipakai sehari-hari.
                Tersedia berbagai ukuran dan warna pilihan.
            </p>

            <div class="product-options">
                <div class="option">
                    <label>Warna:</label>
                    <select>
                        <option>Putih</option>
                        <option>Hitam</option>
                        <option>Abu-abu</option>
                        <option>Navy</option>
                    </select>
                </div>

                <div class="option">
                    <label>Ukuran:</label>
                    <select>
                        <option>S</option>
                        <option>M</option>
                        <option>L</option>
                        <option>XL</option>
                    </select>
                </div>
            </div>

            <div class="product-actions">
                <button class="btn btn-primary">
                    <span class="material-icons">shopping_cart</span> Tambah ke Keranjang
                </button>
                <button class="btn btn-outline">
                    <span class="material-icons">bolt</span> Beli Sekarang
                </button>
            </div>
        </div>
    </main>

    <!-- ===== PRODUK REKOMENDASI ===== -->
    <section class="product-recommendations">
        <h3>Produk Lainnya</h3>
        <div class="recommendation-list">
            <div class="card">
                <img src="img/baju-img/hoodie1.png" alt="Kaos Oversize">
                <p>Kaos Oversize</p>
                <span>Rp 99.000</span>
            </div>
            <div class="card">
                <img src="img/baju-img/hoodie2.png" alt="Kemeja Linen">
                <p>Kemeja Linen</p>
                <span>Rp 149.000</span>
            </div>
            <div class="card">
                <img src="img/baju-img/polo2.png" alt="Hoodie Streetwear">
                <p>Hoodie Streetwear</p>
                <span>Rp 199.000</span>
            </div>
        </div>
    </section>
</body>

</html>
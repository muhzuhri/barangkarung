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
    <link rel="stylesheet" href="{{ asset('css/profile-style.css') }}">
</head>

<body>
    <!-- ===== NAVBAR ===== -->
    <x-navbar />

    <!-- ===== PESANAN SAYA ===== -->
    <main class="orders-container">
        <h1>Pesanan Saya</h1>

        <!-- ===== ORDER CARD 1 ===== -->
        <div class="order-card">
            <div class="order-header">
                <div>
                    <p class="order-id">ID Pesanan: <span>#ORD-20251019-01</span></p>
                    <p class="order-date">Tanggal: 19 Oktober 2025</p>
                </div>
                <div class="order-status delivered">Selesai</div>
            </div>

            <div class="order-body">
                <img src="img/baju-img/polo1.png" alt="Produk">
                <div class="order-details">
                    <h3>Kaos Oversize Hitam</h3>
                    <p>Ukuran: L</p>
                    <p>Jumlah: 2</p>
                    <p>Harga: Rp150.000</p>
                </div>
            </div>

            <div class="order-footer">
                <p><strong>Total Pembayaran:</strong> Rp300.000</p>
                <a href="#" class="btn-detail">Lihat Detail</a>
            </div>
        </div>

        <!-- ===== ORDER CARD 2 ===== -->
        <div class="order-card">
            <div class="order-header">
                <div>
                    <p class="order-id">ID Pesanan: <span>#ORD-20251018-02</span></p>
                    <p class="order-date">Tanggal: 18 Oktober 2025</p>
                </div>
                <div class="order-status pending">Sedang Dikirim</div>
            </div>

            <div class="order-body">
                <img src="img/baju-img/polo3.png" alt="Produk">
                <div class="order-details">
                    <h3>Hoodie Streetwear Abu</h3>
                    <p>Ukuran: XL</p>
                    <p>Jumlah: 1</p>
                    <p>Harga: Rp250.000</p>
                </div>
            </div>

            <div class="order-footer">
                <p><strong>Total Pembayaran:</strong> Rp250.000</p>
                <a href="#" class="btn-detail">Lihat Detail</a>
            </div>
        </div>
    </main>


</body>

</html>
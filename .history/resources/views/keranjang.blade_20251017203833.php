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
    <link rel="stylesheet" href="{{ asset('css/keranjang-style.css') }}">
</head>

<body>
    <!-- ===== NAVBAR ===== -->
    <x-navbar />

    <!-- ===== KERANJANG ===== -->
    <section class="keranjang-container">
        <div class="keranjang-item">
            <input type="checkbox" class="item-check">
            <img src="polo1.jpg" alt="Polo Shirt Uniqlo">
            <div class="item-info">
                <h4>Polo Shirt Uniqlo</h4>
                <p>Rp. 90.000</p>
                <small>Tambahkan Kode Voucher ></small>
            </div>
            <div class="item-qty">
                <button class="qty-btn minus">-</button>
                <span class="qty">1</span>
                <button class="qty-btn plus">+</button>
            </div>
        </div>

        <div class="keranjang-item">
            <input type="checkbox" class="item-check">
            <img src="polo2.jpg" alt="Polo Shirt Uniqlo">
            <div class="item-info">
                <h4>Polo Shirt Uniqlo</h4>
                <p>Rp. 90.000</p>
                <small>Tambahkan Kode Voucher ></small>
            </div>
            <div class="item-qty">
                <button class="qty-btn minus">-</button>
                <span class="qty">1</span>
                <button class="qty-btn plus">+</button>
            </div>
        </div>

        <div class="checkout-bar">
            <input type="checkbox" id="select-all"> <label for="select-all">Semua</label>
            <div class="checkout-right">
                <span class="total-harga">Rp0</span>
                <button class="checkout-btn">Checkout (0)</button>
            </div>
        </div>
    </section>
</body>


</html>

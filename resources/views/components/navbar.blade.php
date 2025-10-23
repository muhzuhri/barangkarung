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
            <div class="dropdown-menu">
                <a href="#">Tidak ada Notifikasi !</a>
            </div>
        </div>

        <a href="{{ route('keranjang') }}"><span class="material-icons">shopping_cart</span></a>

        <div class="dropdown">
            <a href="#"><span class="material-icons">account_circle</span></a>
            <div class="dropdown-menu">
                <a href="{{ route('login') }}"><span class="material-icons">login</span>Masuk</a>
                <a href="{{ route('pesanan') }}"><span class="material-icons">inventory_2</span>Pesanan</a>
                <a href="#"><span class="material-icons">help_outline</span>FAQ</a>
            </div>
        </div>

        <!-- Tombol garis tiga -->
        <span class="material-icons menu-toggle">menu</span>
    </div>
</header>

<!-- ===== CATEGORY MENU ===== -->
<nav class="category-menu">
    <a href="{{ route('beranda') }}">Beranda</a>
    <a href="{{ route('katalog') }}">Katalog</a>
    <a href="{{ route('pesanan') }}">Pesanan</a>
    <a href="{{ route('profile') }}">Profile</a>
</nav>

<!-- js toogle menu nav -->
<script>
    const toggle = document.querySelector('.menu-toggle');
    const categoryMenu = document.querySelector('.category-menu');

    toggle.addEventListener('click', () => {
        categoryMenu.classList.toggle('show');
    });
</script>
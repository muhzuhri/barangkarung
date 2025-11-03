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

        <a href="{{ route('keranjang') }}"><span class="material-icons">shopping_cart</span></a>

        <div class="dropdown">
            <a href="#"><span class="material-icons">account_circle</span></a>
            <div class="dropdown-menu">
                @auth
                    <a href="{{ route('profile') }}"><span class="material-icons">person</span>Profile</a>
                    <a href="{{ route('pesanan') }}"><span class="material-icons">inventory_2</span>Pesanan</a>
                    <a href="{{ route('pesanan.history') }}"><span class="material-icons">history</span>Riwayat Pesanan</a>
                    <a href="#"><span class="material-icons">help_outline</span>FAQ</a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #000; font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 12px; padding: 12px 20px; width: 100%; text-align: left; cursor: pointer; transition: background 0.3s;">
                            <span class="material-icons">logout</span>Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"><span class="material-icons">login</span>Masuk</a>
                    <a href="{{ route('register') }}"><span class="material-icons">person_add</span>Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</header>

<!-- ===== CATEGORY MENU ===== -->
<nav class="category-menu">
    <a href="{{ route('beranda') }}">Beranda</a>
    <a href="{{ route('katalog') }}">Katalog</a>
    <a href="{{ route('pesanan') }}">Pesanan</a>
    <a href="{{ route('pesanan.history') }}">Riwayat</a>
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
<!-- ===== NAVBAR ===== -->
<header class="navbar">
    <div class="navbar-top">
        <!-- LOGO -->
        <div class="logo">
            <h1>BARANG KARUNG</h1>
        </div>

        <!-- SECTION SEACRH BOX -->
        <div class="search-box">
            <input type="text" placeholder="Cari produk keren dan terbaik di sini ..." />
            <button><span class="material-icons">search</span></button>
        </div>

        <!-- SECTION RIGHT ICON -->
        <div class="nav-right">

            <!-- KERANJANG -->
            <a href="{{ route('keranjang') }}" class="nav-icon"> <span class="material-icons">shopping_cart</span>
            </a>

            <!-- DROPDOWN SETTING -->
            <div class="dropdown">
                <a href="#" class="nav-icon dropdown-trigger">
                    <span class="material-icons">account_circle</span>
                </a>

                <div class="dropdown-menu">
                    @auth

                        <a href="{{ route('profile') }}">
                            <span class="material-icons">person</span> Profile
                        </a>

                        <a href="{{ route('pesanan') }}">
                            <span class="material-icons">inventory_2</span> Pesanan
                        </a>

                        <a href="{{ route('pesanan.history') }}">
                            <span class="material-icons">history</span> Riwayat Pesanan
                        </a>

                        <!-- Logout di dalam menu -->
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">
                                <span class="material-icons">logout</span> Logout

                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">
                            <span class="material-icons">login</span> Masuk
                        </a>

                        <a href="{{ route('register') }}">
                            <span class="material-icons">person_add</span> Daftar
                        </a>
                    @endauth
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const dropdown = document.querySelector(".dropdown");
                    const trigger = document.querySelector(".dropdown-trigger");

                    // Toggle saat icon diklik
                    trigger.addEventListener("click", (e) => {
                        e.preventDefault();
                        dropdown.classList.toggle("active");
                    });

                    // Tutup jika klik area luar dropdown
                    document.addEventListener("click", (e) => {
                        if (!dropdown.contains(e.target) && !trigger.contains(e.target)) {
                            dropdown.classList.remove("active");
                        }
                    });
                });
            </script>

        </div>
    </div>
</header>

<!-- ===== SECTION CATEGORY MENU ===== -->
<nav class="category-menu" id="categoryMenu">

    <div class="menu-links">
        <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('katalog') }}" class="{{ request()->routeIs('katalog') ? 'active' : '' }}">Katalog</a>
        <a href="{{ route('pesanan') }}" class="{{ request()->routeIs('pesanan') ? 'active' : '' }}">Pesanan</a>
        <a href="{{ route('pesanan.history') }}"
            class="{{ request()->routeIs('pesanan.history') ? 'active' : '' }}">Riwayat</a>
        <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">Profile</a>
    </div>

    <div class="hamburger" id="hamburgerBtn">
        <span class="material-icons" id="hamburgerIcon">menu</span>
    </div>

</nav>


{{-- SCRIPT HAMBURGER MENU --}}
<script>
    const hamburgerBtn = document.getElementById("hamburgerBtn");
    const hamburgerIcon = document.getElementById("hamburgerIcon");
    const categoryMenu = document.getElementById("categoryMenu");

    hamburgerBtn.addEventListener("click", (e) => {
        e.stopPropagation(); // mencegah klik merambat ke nav

        categoryMenu.classList.toggle("active");

        hamburgerIcon.textContent =
            categoryMenu.classList.contains("active") ? "close" : "menu";
    });

    // Tutup menu saat klik link
    document.querySelectorAll(".menu-links a").forEach(link => {
        link.addEventListener("click", () => {
            categoryMenu.classList.remove("active");
            hamburgerIcon.textContent = "menu";
        });
    });
</script>

<!-- ===== SECTION CHARBOT ===== -->


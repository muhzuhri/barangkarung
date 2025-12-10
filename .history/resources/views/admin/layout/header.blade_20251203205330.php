<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Icon web & title --}}
    <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('img/icon/webb-icon.png') }}">

    {{-- Chart JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Google Fonts --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">

    {{-- Style CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin/navbar-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/produk-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/pesanan-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/tambahedit-form-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/user-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/profile-admin-style.css') }}">

    <!-- Tambahkan di dalam <head> -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body>
    <!-- Tambahkan sebelum </body> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- JS Chekbox --}}
    <script>
        $(document).ready(function() {
            $('#status').select2({
                width: '100%',
                placeholder: 'Ubah Status',
                minimumResultsForSearch: Infinity // tanpa kolom pencarian
            });
        });
    </script>

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('show');
        }
    </script>


    <div class="header">
        <div class="header-content">

            <!-- ===== MOBILE MENU OVERLAY ===== -->
            <div class="mobile-menu" id="mobileMenu">
                <div class="mobile-menu-content">

                    <!-- Logo -->
                    <div class="mobile-menu-header">
                        <div class="logo-icon">BK</div>
                        <span>Admin Panel</span>
                        <button class="close-mobile-menu" onclick="toggleMobileMenu()">✕</button>
                    </div>

                    <!-- NAV LINKS -->
                    <ul class="mobile-nav-links">
                        <li><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                        <li><a href="{{ route('admin.products.index') }}">Produk</a></li>
                        <li><a href="{{ route('admin.orders.index') }}">Pesanan</a></li>
                        <li><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
                        <li><a href="{{ route('admin.revenue.index') }}">Profit</a></li>
                    </ul>

                    <!-- ADMIN DROPDOWN (DITARIK KE MOBILE) -->
                    <div class="mobile-admin-section">
                        <a href="{{ route('admin.faq.index') }}" class="dropdown-item">
                            <img src="{{ asset('img/icon/faq-icon.png') }}" class="icon"> FAQ
                        </a>
                        <a href="{{ route('admin.setting.profile') }}" class="dropdown-item">
                            <img src="{{ asset('img/icon/setting-icon.png') }}" class="icon"> Profile
                        </a>
                        <a href="{{ route('admin.setting.payment') }}" class="dropdown-item">
                            <img src="{{ asset('img/icon/income-icon.png') }}" class="icon"> Pembayaran
                        </a>

                        <div class="dropdown-divider"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item logout">
                                <img src="{{ asset('img/icon/logout-icon.png') }}" class="icon"> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="logo">
                <div class="logo-icon">BK</div>
                <h1>Admin Panel</h1>
            </div>

            <nav class="nav-menu">
                <ul class="nav-links">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}"
                            class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            Produk
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders.index') }}"
                            class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            Pesanan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                            class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            Pengguna
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.revenue.index') }}"
                            class="{{ request()->routeIs('admin.revenue.*') ? 'active' : '' }}">
                            Profit
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="admin-info">
                <div class="admin-dropdown">

                    <div class="admin-dropdown-toggle" onclick="toggleDropdown()">
                        <div class="admin-avatar">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                        <div>
                            {{-- <div class="admin-name">{{ $admin->name }}</div> --}}
                            <div class="admin-role">{{ $admin->getRoleDisplayAttribute() }}</div>
                        </div>
                        <img src="{{ asset('img/icon/down-icon.png') }}" alt="Dropdown Icon" class="arrow-icon">
                    </div>

                    <div class="dropdown-menu" id="adminDropdown">
                        <a href="{{ route('admin.faq.index') }}" class="dropdown-item">
                            <img src="{{ asset('img/icon/faq-icon.png') }}" alt="Pengaturan" class="icon">
                            FAQ
                        </a>
                        <a href="{{ route('admin.setting.profile') }}" class="dropdown-item">
                            <img src="{{ asset('img/icon/setting-icon.png') }}" alt="Pengaturan" class="icon">
                            Profile
                        </a>
                        <a href="{{ route('admin.setting.payment') }}" class="dropdown-item">
                            <img src="{{ asset('img/icon/income-icon.png') }}" alt="Pembayaran" class="icon">
                            Pembayaran
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item logout">
                                <img src="{{ asset('img/icon/logout-icon.png') }}" alt="Logout" class="icon">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">☰</button>
            </div>
        </div>
    </div>

    <div class="container">

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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">

    {{-- Style CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin/navbar-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/produk-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/user-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/pesanan-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/tambahedit-form-style.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/admin/profile-admin-style.css') }}"> --}}

</head>

<body>

    <div class="header">
        <div class="header-content">
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
                    {{-- <li>
                        <a href="{{ route('admin.setting.profile') }}"
                            class="{{ request()->routeIs('admin.setting.profile*') ? 'active' : '' }}">
                            Settings
                        </a>
                    </li> --}}
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
                        <a href="{{ route('admin.setting.profile') }}" class="dropdown-item">
                            <img src="{{ asset('img/icon/setting-icon.png') }}" alt="Pengaturan" class="icon">
                            Pengaturan
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

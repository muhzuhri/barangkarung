<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Chart JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Google Fonts --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">

    {{-- Style CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/profile-admin-style.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/admin/produk-admin-style.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/admin/user-admin-style.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/admin/editproduk-admin-style.css') }}"> --}}

    
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
                    <li><a href="{{ route('admin.dashboard') }}" class="active">🏠 Dashboard</a></li>
                    <li><a href="{{ route('admin.products.index') }}">🛍️ Produk</a></li>
                    <li><a href="{{ route('admin.orders.index') }}">📦 Pesanan</a></li>
                    <li><a href="{{ route('admin.users.index') }}">👥 User</a></li>
                    <li><a href="{{ route('admin.revenue.index') }}">💰 Pendapatan</a></li>
                    <li><a href="{{ route('admin.setting.profile') }}">⚙️ Settings</a></li>
                </ul>
            </nav>

            <div class="admin-info">
                <div class="admin-dropdown">
                    <div class="admin-dropdown-toggle" onclick="toggleDropdown()">
                        <div class="admin-avatar">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="admin-name">{{ $admin->name }}</div>
                            <div class="admin-role">{{ $admin->getRoleDisplayAttribute() }}</div>
                        </div>
                        <span style="font-size: 0.8rem;">▼</span>
                    </div>
                    <div class="dropdown-menu" id="adminDropdown">
                        <a href="{{ route('admin.setting.profile') }}" class="dropdown-item">👤 Profile</a>
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">🏠 Dashboard</a>
                        <a href="{{ route('admin.products.index') }}" class="dropdown-item">🛍️ Kelola Produk</a>
                        <a href="{{ route('admin.orders.index') }}" class="dropdown-item">📦 Kelola Pesanan</a>
                        <a href="{{ route('admin.users.index') }}" class="dropdown-item">👥 Kelola User</a>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item logout"
                                style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">🚪
                                Logout</button>
                        </form>
                    </div>
                </div>

                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">☰</button>
            </div>
        </div>
    </div>

    <div class="container">

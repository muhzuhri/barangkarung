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
    <link rel="stylesheet" href="{{ asset('css/admin/navbar-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/profile-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/user-admin-style.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/admin/produk-admin-style.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/admin/editproduk-admin-style.css') }}"> --}}

</head>

<body>
    
    <body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">BK</div>
            <h1>Admin Panel</h1>
        </div>

        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i>🏠</i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i>🛍️</i> Produk
            </a>
            <a href="{{ route('admin.orders.index') }}" class="menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i>📦</i> Pesanan
            </a>
            <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i>👥</i> User
            </a>
            <a href="{{ route('admin.revenue.index') }}" class="menu-item {{ request()->routeIs('admin.revenue.*') ? 'active' : '' }}">
                <i>💰</i> Pendapatan
            </a>
            <a href="{{ route('admin.setting.profile') }}" class="menu-item {{ request()->routeIs('admin.setting.profile*') ? 'active' : '' }}">
                <i>⚙️</i> Settings
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="admin-info">
                <div class="admin-avatar">{{ strtoupper(substr($admin->name, 0, 1)) }}</div>
                <div>
                    <p class="admin-name">{{ $admin->name }}</p>
                    <p class="admin-role">{{ $admin->getRoleDisplayAttribute() }}</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="main-content">
        <div class="topbar">
            <h2>Dashboard</h2>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <section class="page-content">
            <!-- Konten halaman kamu di sini -->
        </section>
    </main>
</body>


    <div class="container">

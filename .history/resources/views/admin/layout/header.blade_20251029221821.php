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
    
   <!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <div class="logo-icon">BK</div>
            <h1>Admin Panel</h1>
        </div>
        <button class="close-btn" onclick="toggleSidebar()">✖</button>
    </div>

    <nav class="sidebar-menu">
        <ul class="nav-links">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    🏠 Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    🛍️ Produk
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    📦 Pesanan
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    👥 User
                </a>
            </li>
            <li>
                <a href="{{ route('admin.revenue.index') }}" class="{{ request()->routeIs('admin.revenue.*') ? 'active' : '' }}">
                    💰 Pendapatan
                </a>
            </li>
            <li>
                <a href="{{ route('admin.setting.profile') }}" class="{{ request()->routeIs('admin.setting.profile*') ? 'active' : '' }}">
                    ⚙️ Settings
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
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
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="dropdown-item logout">🚪 Logout</button>
            </form>
        </div>
    </div>
</aside>

<!-- TOGGLE BUTTON (untuk mobile) -->
<button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>


    <div class="container">

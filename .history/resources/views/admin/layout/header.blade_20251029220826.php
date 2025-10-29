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

   <!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo-icon">BK</div>
        <h1>Admin Panel</h1>
    </div>

    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
               🏠 <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.products.index') }}"
               class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
               🛍️ <span>Produk</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.orders.index') }}"
               class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
               📦 <span>Pesanan</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users.index') }}"
               class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
               👥 <span>User</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.revenue.index') }}"
               class="{{ request()->routeIs('admin.revenue.*') ? 'active' : '' }}">
               💰 <span>Pendapatan</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.profile') }}"
               class="{{ request()->routeIs('admin.setting.profile*') ? 'active' : '' }}">
               ⚙️ <span>Settings</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <div class="admin-info">
            <div class="admin-avatar">{{ strtoupper(substr($admin->name, 0, 1)) }}</div>
            <div>
                <div class="admin-name">{{ $admin->name }}</div>
                <div class="admin-role">{{ $admin->getRoleDisplayAttribute() }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">🚪 Logout</button>
        </form>
    </div>
</aside>


    <div class="container">

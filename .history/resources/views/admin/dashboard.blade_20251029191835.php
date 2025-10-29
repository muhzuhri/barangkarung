<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Barang Karung ID</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard-admin-style.css') }}">

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
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="welcome-card">
            <h1 class="welcome-title">Selamat Datang, {{ $admin->name }}!</h1>
            <p class="welcome-subtitle">Kelola toko thrift Anda dengan mudah melalui dashboard admin</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-number">{{ number_format($totalUsers) }}</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🛍️</div>
                <div class="stat-number">{{ number_format($totalProducts) }}</div>
                <div class="stat-label">Total Products</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🛒</div>
                <div class="stat-number">{{ number_format($totalOrders) }}</div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <div class="stat-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>

        <!-- Recent Orders Section -->
        @if($recentOrders->count() > 0)
        <div class="recent-orders-section">
            <h2 class="section-title">Pesanan Terbaru</h2>
            <div class="orders-table">
                <table>
                    <thead>
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->user->name ?? 'User #'.$order->user_id }}</td>
                            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</body>

</html>
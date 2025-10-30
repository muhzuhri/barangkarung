@include('admin.layout.header')
<title>Dashboard Admin | BK </title>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="dashboard-container">
    <!-- Welcome Card -->
    <div class="welcome-card">
        <div>
            <h1 class="welcome-title">Selamat Datang, {{ $admin->name }} 👋</h1>
            <p class="welcome-subtitle">
                Kelola toko thrift Anda dengan mudah melalui dashboard admin.
            </p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-blue-100 text-blue-600">👥</div>
            <div class="stat-number">{{ number_format($totalUsers) }}</div>
            <div class="stat-label">Total Pengguna</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-emerald-100 text-emerald-600">🛍️</div>
            <div class="stat-number">{{ number_format($totalProducts) }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-indigo-100 text-indigo-600">🛒</div>
            <div class="stat-number">{{ number_format($totalOrders) }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-yellow-100 text-yellow-600">💰</div>
            <div class="stat-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pendapatan</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid">
        <div class="chart-card">
            <h2 class="chart-title">📈 Pendapatan Bulanan</h2>
            <canvas id="revenueChart"></canvas>
        </div>
        <div class="chart-card">
            <h2 class="chart-title">📦 Pesanan Bulanan</h2>
            <canvas id="ordersChart"></canvas>
        </div>
        <div class="chart-card">
            <h2 class="chart-title">👤 Pengguna Baru</h2>
            <canvas id="usersChart"></canvas>
        </div>
        <div class="chart-card">
            <h2 class="chart-title">🧥 Produk Baru</h2>
            <canvas id="productsChart"></canvas>
        </div>
    </div>

    <!-- Recent Orders Section -->
    @if ($recentOrders->count() > 0)
        <div class="recent-orders-section">
            <h2 class="section-title">🕒 Pesanan Terbaru</h2>
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
                        @foreach ($recentOrders as $order)
                            <tr>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->user->name ?? 'User #' . $order->user_id }}</td>
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

@include('admin.layout.footer')

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
                    <li><a href="{{ route('admin.users.index') }}">👥 User</a></li>
                    <li><a href="{{ route('admin.profile') }}">⚙️ Settings</a></li>
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
                        <a href="{{ route('admin.profile') }}" class="dropdown-item">👤 Profile</a>
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">🏠 Dashboard</a>
                        <a href="{{ route('admin.products.index') }}" class="dropdown-item">🛍️ Kelola Produk</a>
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
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ $order->status_display }}
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

        <!-- Revenue Chart Section -->
        @if($monthlyRevenue->count() > 0)
        <div class="chart-section">
            <h2 class="section-title">Grafik Pendapatan (6 Bulan Terakhir)</h2>
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        @endif

    </div>

    <script>
        function toggleAddProductForm() {
            const form = document.getElementById('addProductForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            } else {
                form.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        function toggleDropdown() {
            const dropdown = document.getElementById('adminDropdown');
            dropdown.classList.toggle('show');
        }

        function toggleMobileMenu() {
            // Mobile menu functionality can be added here
            alert('Mobile menu akan ditambahkan');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('adminDropdown');
            const toggle = document.querySelector('.admin-dropdown-toggle');
            
            if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Close form when clicking outside
        document.getElementById('addProductForm').addEventListener('click', function(e) {
            if (e.target === this) {
                toggleAddProductForm();
            }
        });

        // Close form with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const form = document.getElementById('addProductForm');
                if (form.style.display === 'flex') {
                    toggleAddProductForm();
                }
            }
        });

        // Initialize Revenue Chart
        @if($monthlyRevenue->count() > 0)
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const monthlyRevenueData = @json($monthlyRevenue);
        
        const labels = monthlyRevenueData.map(item => {
            const date = new Date(item.month + '-01');
            return date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' });
        });
        
        const data = monthlyRevenueData.map(item => parseFloat(item.revenue));
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: data,
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
        @endif
    </script>
</body>

</html>
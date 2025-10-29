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
        

    </div>

</body>

</html>

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
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const monthlyRevenueData = @json($monthlyRevenue);

    const labels = monthlyRevenueData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('id-ID', {
            month: 'short',
            year: 'numeric'
        });
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
    // Initialize Orders Chart
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    const monthlyOrdersData = @json($monthlyOrders);
    const ordersLabels = monthlyOrdersData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('id-ID', {
            month: 'short',
            year: 'numeric'
        });
    });
    const ordersCounts = monthlyOrdersData.map(item => parseInt(item.count, 10));
    new Chart(ordersCtx, {
        type: 'bar',
        data: {
            labels: ordersLabels,
            datasets: [{
                label: 'Orders',
                data: ordersCounts,
                backgroundColor: 'rgba(34, 197, 94, 0.5)',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    // Initialize Users Chart
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    const monthlyUsersData = @json($monthlyUsers);
    const usersLabels = monthlyUsersData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('id-ID', {
            month: 'short',
            year: 'numeric'
        });
    });
    const usersCounts = monthlyUsersData.map(item => parseInt(item.count, 10));
    new Chart(usersCtx, {
        type: 'bar',
        data: {
            labels: usersLabels,
            datasets: [{
                label: 'User Baru',
                data: usersCounts,
                backgroundColor: 'rgba(99, 102, 241, 0.5)',
                borderColor: 'rgb(99, 102, 241)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    // Initialize Products Chart
    const productsCtx = document.getElementById('productsChart').getContext('2d');
    const monthlyProductsData = @json($monthlyProducts);
    const productsLabels = monthlyProductsData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('id-ID', {
            month: 'short',
            year: 'numeric'
        });
    });
    const productsCounts = monthlyProductsData.map(item => parseInt(item.count, 10));
    new Chart(productsCtx, {
        type: 'bar',
        data: {
            labels: productsLabels,
            datasets: [{
                label: 'Produk Baru',
                data: productsCounts,
                backgroundColor: 'rgba(234, 179, 8, 0.5)',
                borderColor: 'rgb(234, 179, 8)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>

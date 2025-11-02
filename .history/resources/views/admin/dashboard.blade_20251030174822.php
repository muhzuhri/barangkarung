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

<!-- Welcome Card -->
<div class="sambutan">
    <h2>Selamat Datang di Barang Karung</h2>
    <p>
        Halo <span class="nama">{{ $admin->name }}</span>,
        selamat datang di <span class="tebal">Barang Karung</span> — tempat dimana semua koleksi
        pakaian dan referensi tersedia hanya dalam sekali klik.
    </p>
    <p>
        Dengan fitur pencarian cepat, statistik koleksi, hingga visualisasi data yang interaktif,
        kami berharap pengalaman membaca dan mengelola pustaka Anda menjadi lebih mudah, menyenangkan,
        dan bermanfaat. Mari bersama-sama menjelajahi dunia pengetahuan tanpa batas.
    </p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <img src="{{ asset('img/img-dashboard/ds-user.png') }}" alt="Icon Pengguna">
        </div>
        <div class="stat-number">{{ number_format($totalUsers) }}</div>
        <div class="stat-label">Total Pengguna</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <img src="{{ asset('img/img-dashboard/ds-produk.png') }}" alt="Icon Produk">
        </div>
        <div class="stat-number">{{ number_format($totalProducts) }}</div>
        <div class="stat-label">Total Produk</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <img src="{{ asset('img/img-dashboard/ds-chart.png') }}" alt="Icon Pesanan">
        </div>
        <div class="stat-number">{{ number_format($totalOrders) }}</div>
        <div class="stat-label">Total Pesanan</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <img src="{{ asset('img/img-dashboard/ds-money.png') }}" alt="Icon Pendapatan">
        </div>
        <div class="stat-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="stat-label">Total Pendapatan</div>
    </div>
</div>



{{-- <div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon bg-blue-100 text-blue-600"></div>
        <div class="stat-number">{{ number_format($totalUsers) }}</div>
        <div class="stat-label">Total Pengguna</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-emerald-100 text-emerald-600"></div>
        <div class="stat-number">{{ number_format($totalProducts) }}</div>
        <div class="stat-label">Total Produk</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-indigo-100 text-indigo-600"></div>
        <div class="stat-number">{{ number_format($totalOrders) }}</div>
        <div class="stat-label">Total Pesanan</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-yellow-100 text-yellow-600"></div>
        <div class="stat-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="stat-label">Total Pendapatan</div>
    </div>
</div> --}}

<!-- Charts Section -->
{{-- <div class="charts-grid">
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
</div> --}}

<!-- Recent Orders Section -->
@if ($recentOrders->count() > 0)
    <div class="recent-orders-section">
        <h2 class="section-title">🕒 Pesanan Terbaru</h2>
        <div class="orders-table">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
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
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->user->name ?? 'User #' . $order->user_id }}</td>
                            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<script>
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

@include('admin.layout.footer')

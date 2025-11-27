@include('admin.layout.header')
<title>Pendapatan Admin | BK</title>

<style>
    .chart-section {
        margin-top: 2rem;
        /* background: linear-gradient(135deg, #a4c8e9 0%, #9ab7f1 100%); */
        background: #ffffff;
        padding: 1.8rem;
        border-radius: 0.8rem; /* rounded-lg */
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); /* shadow-sm */
        border:solid 1px #e5e7eb;
        transition: all 0.3s ease;
    }

    .chart-section:hover {
        transform: translateY(-3px);
        /* box-shadow: 0 8px 28px rgba(0, 0, 0, 0.08); */
    }

    .chart-section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 1.2rem;
        padding-bottom: 0.8rem;
        border-bottom: 1px solid #cad2e3;
    }

    .chart-section-icon {
        width: 41px;
        height: 41px;
        background: #ffffff;
        padding: 8px;
        border-radius: 10px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); /* shadow-sm */
        object-fit: contain;
    }

    .chart-section-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #161f2e;
        letter-spacing: 0.3px;
    }

    .chart-container {
        background: rgb(247, 248, 252);
        padding: 1.5rem;
        border-radius: 0.8rem; /* rounded-lg */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); /* shadow-sm */
        transition: 0.3s ease;
    }

    .chart-container:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    #revenueChart {
        max-height: 370px;
        width: 100%;
    }
    #ordersChart, #usersChart, #productsChart {
        max-height: 360px;
        width: 100%;
    }
</style>

<div class="page-header">
    <h1 class="page-title">
        <img src={{ asset('img/icon/daftar-icon.png') }} alt="Icon Produk" class="title-icon">
        Kelola Pendapatan
    </h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <img src="{{ asset('img/icon/pendapatan-icon.png') }}" alt="Icon Pengguna">
        </div>
        <div class="stat-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="stat-label">Total Pendapatan</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <img src="{{ asset('img/icon/selesai-icon.png') }}" alt="Icon Pengguna">
        </div>
        <div class="stat-number">{{ number_format($totalOrders) }}</div>
        <div class="stat-label">Pesanan Selesai</div>
    </div>
</div>

<!-- Chart Section -->
<div class="chart-section">
    <div class="chart-section-header">
        <img src={{ asset('img/icon/statistic-icon.png') }} alt="Grafik Pendapatan" class="chart-section-icon">
        <h2 class="chart-section-title">Grafik Pendapatan Per Bulan</h2>
    </div>
    <div class="chart-container">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<!-- Chart Section -->
<div class="chart-section">
    <div class="chart-section-header">
        <img src={{ asset('img/img-dashboard/ds-money.png') }} alt="Grafik Pendapatan" class="chart-section-icon">
        <h2 class="chart-section-title">Pesanan Bulanan</h2>
    </div>
    <div class="chart-container">
        <canvas id="ordersChart"></canvas>
    </div>
</div>

<!-- Chart Section -->
<div class="chart-section">
    <div class="chart-section-header">
        <img src={{ asset('img/img-dashboard/ds-user.png') }} alt="Grafik Pendapatan" class="chart-section-icon">
        <h2 class="chart-section-title">Pengguna Baru</h2>
    </div>
    <div class="chart-container">
        <canvas id="usersChart"></canvas>
    </div>
</div>

<!-- Chart Section -->
<div class="chart-section">
    <div class="chart-section-header">
        <img src={{ asset('img/img-dashboard/ds-produk.png') }} alt="Grafik Pendapatan" class="chart-section-icon">
        <h2 class="chart-section-title">Produk Baru</h2>
    </div>
    <div class="chart-container">
        <canvas id="productsChart"></canvas>
    </div>
</div>

<!-- Table Section -->
<div class="recent-orders-section">
    <div class="section-header">
        <img src={{ asset('img/icon/calendar-icon.png') }} alt="Ringkasan Bulanan" class="section-icon">
        <h2 class="section-title">Ringkasan Bulanan</h2>
    </div>

    @if ($monthly->count() > 0)
        <div class="orders-table">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Pendapatan</th>
                        <th>Pesanan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthly as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->month . '-01')->translatedFormat('F Y') }}</td>
                            <td>Rp {{ number_format($row->revenue, 0, ',', '.') }}</td>
                            <td>{{ $row->orders_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>

<div class="recent-orders-section">
    <div class="section-header">
        <img src={{ asset('img/icon/calendar-icon.png') }} alt="Pesanan Terbaru" class="section-icon">
        <h2 class="section-title">Pesanan Selesai Terbaru</h2>
    </div>

    @if ($completedOrders->count() > 0)
        <div class="orders-table">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Pesanan</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($completedOrders as $order)
                        <tr>
                            <td>{{ $loop->iteration + ($completedOrders->currentPage() - 1) * $completedOrders->perPage() }}
                            </td>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->user->name ?? 'User #' . $order->user_id }}</td>
                            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>{{ $order->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:16px;">{{ $completedOrders->links() }}</div>
    @endif

</div>

<script>
    // ======== REVENUE CHART ========
    const monthlyData = @json($monthly);

    const labels = monthlyData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' });
    });

    const revenueData = monthlyData.map(item => parseFloat(item.revenue || 0));

    const ctx = document.getElementById('revenueChart').getContext('2d');

    // Gradient warna biru
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(102, 126, 234, 0.8)');
    gradient.addColorStop(0.5, 'rgba(102, 126, 234, 0.6)');
    gradient.addColorStop(1, 'rgba(102, 126, 234, 0.3)');

    const hoverGradient = ctx.createLinearGradient(0, 0, 0, 400);
    hoverGradient.addColorStop(0, 'rgba(102, 126, 234, 1)');
    hoverGradient.addColorStop(1, 'rgba(102, 126, 234, 0.6)');

    function createCustomBarChart(ctx, labels, data, color1, color2, labelName, currency = true) {
        // Gradient warna custom
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, `${color1}CC`); // 80%
        gradient.addColorStop(0.5, `${color1}99`); // 60%
        gradient.addColorStop(1, `${color1}55`); // 30%

        const hoverGradient = ctx.createLinearGradient(0, 0, 0, 400);
        hoverGradient.addColorStop(0, `${color1}`);
        hoverGradient.addColorStop(1, `${color1}88`);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: labelName,
                    data: data,
                    backgroundColor: gradient,
                    borderColor: color2,
                    borderWidth: 2,
                    borderRadius: { topLeft: 8, topRight: 8 },
                    borderSkipped: false,
                    hoverBackgroundColor: hoverGradient,
                    hoverBorderColor: color2,
                    hoverBorderWidth: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1500,
                    easing: 'easeInOutQuad',
                    onComplete: function(animation) {
                        const chart = animation.chart;
                        const ctx = chart.ctx;
                        ctx.save();
                        const meta = chart.getDatasetMeta(0);
                        meta.data.forEach((bar, index) => {
                            if (data[index] > 0) {
                                const value = data[index];
                                const x = bar.x;
                                const y = bar.y - 10;
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                ctx.fillStyle = color2;
                                ctx.font = 'bold 11px Poppins';
                                ctx.fillText(
                                    currency
                                        ? 'Rp ' + value.toLocaleString('id-ID')
                                        : value.toLocaleString('id-ID'),
                                    x, y
                                );
                            }
                        });
                        ctx.restore();
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        titleFont: { family: 'Poppins', size: 14, weight: 'bold' },
                        bodyFont: { family: 'Poppins', size: 13 },
                        borderColor: color2,
                        borderWidth: 2,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            title: ctx => ctx[0].label,
                            label: ctx =>
                                currency
                                    ? 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                                    : ctx.parsed.y.toLocaleString('id-ID')
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => {
                                if (currency) {
                                    if (value >= 1_000_000) return 'Rp ' + (value / 1_000_000).toFixed(1) + 'Jt';
                                    if (value >= 1_000) return 'Rp ' + (value / 1_000).toFixed(0) + 'Rb';
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                                return value.toLocaleString('id-ID');
                            },
                            font: { family: 'Poppins', size: 11 },
                            color: '#6b7280'
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)',
                            drawBorder: false
                        },
                        border: { display: false }
                    },
                    x: {
                        ticks: {
                            font: { family: 'Poppins', size: 11 },
                            color: '#6b7280'
                        },
                        grid: { display: false },
                        border: { display: false }
                    }
                },
                layout: {
                    padding: { top: 20, right: 10, bottom: 10, left: 10 }
                }
            }
        });
    }

    // Render Revenue Chart
    createCustomBarChart(ctx, labels, revenueData, '#667EEA', '#667EEA', 'Pendapatan (Rp)', true);

    // ======== ORDERS CHART ========
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    const monthlyOrdersData = @json($monthly);
    const ordersLabels = monthlyOrdersData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' });
    });
    const ordersCounts = monthlyOrdersData.map(item => parseInt(item.orders_count, 10));
    createCustomBarChart(ordersCtx, ordersLabels, ordersCounts, '#22C55E', '#16A34A', 'Orders', false);

    // ======== USERS CHART ========
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    const monthlyUsersData = @json($monthlyUsers);
    const usersLabels = monthlyUsersData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' });
    });
    const usersCounts = monthlyUsersData.map(item => parseInt(item.count, 10));
    createCustomBarChart(usersCtx, usersLabels, usersCounts, '#6366F1', '#4F46E5', 'User Baru', false);

    // ======== PRODUCTS CHART ========
    const productsCtx = document.getElementById('productsChart').getContext('2d');
    const monthlyProductsData = @json($monthlyProducts);
    const productsLabels = monthlyProductsData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' });
    });
    const productsCounts = monthlyProductsData.map(item => parseInt(item.count, 10));
    createCustomBarChart(productsCtx, productsLabels, productsCounts, '#EAB308', '#CA8A04', 'Produk Baru', false);
</script>


@include('admin.layout.footer')

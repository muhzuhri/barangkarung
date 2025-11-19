@include('admin.layout.header')
<title>Pendapatan Admin | BK</title>

<style>
    .chart-section {
        margin-top: 2rem;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        border-radius: 16px;
        padding: 1.8rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .chart-section:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.08);
    }

    .chart-section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 1.2rem;
        padding-bottom: 0.8rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .chart-section-header .chart-section-icon {
        width: 38px;
        height: 38px;
        background: #153089;
        padding: 8px;
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(21, 48, 137, 0.25);
        object-fit: contain;
    }

    .chart-section-header .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #1e293b;
        letter-spacing: 0.3px;
    }

    .chart-container {
        background: white;
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        transition: 0.3s ease;
    }

    .chart-container:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    #revenueChart {
        max-height: 400px;
        width: 100%;
    }
</style>

<div class="page-header">
    <h1 class="page-title">
        <img src={{ asset('img/icon/statistic-icon.png') }} alt="Icon Produk" class="title-icon">
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
        <img src={{ asset('img/icon/statistic-icon.png') }} alt="Grafik Pendapatan" class="-chart-section-icon">
        <h2 class="chart-section-title">Grafik Pendapatan Per Bulan</h2>
    </div>
    <div class="chart-container">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<!-- Additional Charts Section -->
<div class="charts-grid"
    style="margin-top: 2rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
    <div class="chart-card"
        style="background: white; border-radius: 12px; padding: 1rem; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);">
        <h2 class="chart-title" style="font-size: 1rem; margin-bottom: 0.5rem;">📦 Pesanan Bulanan</h2>
        <canvas id="ordersChart" style="max-height: 200px;"></canvas>
    </div>
    <div class="chart-card"
        style="background: white; border-radius: 12px; padding: 1rem; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);">
        <h2 class="chart-title" style="font-size: 1rem; margin-bottom: 0.5rem;">👤 Pengguna Baru</h2>
        <canvas id="usersChart" style="max-height: 200px;"></canvas>
    </div>
    <div class="chart-card"
        style="background: white; border-radius: 12px; padding: 1rem; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);">
        <h2 class="chart-title" style="font-size: 1rem; margin-bottom: 0.5rem;">🧥 Produk Baru</h2>
        <canvas id="productsChart" style="max-height: 200px;"></canvas>
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
    // Prepare data for chart
    const monthlyData = @json($monthly);

    const labels = monthlyData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('id-ID', {
            month: 'short',
            year: 'numeric'
        });
    });

    const revenueData = monthlyData.map(item => parseFloat(item.revenue || 0));

    // Create gradient for bars
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(102, 126, 234, 0.8)');
    gradient.addColorStop(0.5, 'rgba(102, 126, 234, 0.6)');
    gradient.addColorStop(1, 'rgba(102, 126, 234, 0.3)');

    // Create hover gradient
    const hoverGradient = ctx.createLinearGradient(0, 0, 0, 400);
    hoverGradient.addColorStop(0, 'rgba(102, 126, 234, 1)');
    hoverGradient.addColorStop(0.5, 'rgba(102, 126, 234, 0.8)');
    hoverGradient.addColorStop(1, 'rgba(102, 126, 234, 0.5)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: revenueData,
                backgroundColor: gradient,
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 2,
                borderRadius: {
                    topLeft: 8,
                    topRight: 8,
                    bottomLeft: 0,
                    bottomRight: 0
                },
                borderSkipped: false,
                hoverBackgroundColor: hoverGradient,
                hoverBorderColor: 'rgba(102, 126, 234, 1)',
                hoverBorderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                duration: 1500,
                easing: 'easeInOutQuad',
                onComplete: function(animation) {
                    const chart = animation.chart;
                    const ctx = chart.ctx;
                    ctx.save();
                    const meta = chart.getDatasetMeta(0);
                    meta.data.forEach((bar, index) => {
                        if (revenueData[index] > 0) {
                            const data = revenueData[index];
                            const xPos = bar.x;
                            const yPos = bar.y - 10;
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.fillStyle = '#667eea';
                            ctx.font = 'bold 11px Poppins';
                            ctx.fillText('Rp ' + data.toLocaleString('id-ID'), xPos, yPos);
                        }
                    });
                    ctx.restore();
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        family: 'Poppins',
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        family: 'Poppins',
                        size: 13
                    },
                    borderColor: 'rgba(102, 126, 234, 1)',
                    borderWidth: 2,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'Jt';
                            } else if (value >= 1000) {
                                return 'Rp ' + (value / 1000).toFixed(0) + 'Rb';
                            }
                            return 'Rp ' + value.toLocaleString('id-ID');
                        },
                        font: {
                            family: 'Poppins',
                            size: 11
                        },
                        color: '#6b7280'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false,
                        lineWidth: 1
                    },
                    border: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: 'Poppins',
                            size: 11
                        },
                        color: '#6b7280'
                    },
                    border: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            layout: {
                padding: {
                    top: 20,
                    right: 10,
                    bottom: 10,
                    left: 10
                }
            }
        }
    });

    // Initialize Orders Chart
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    const monthlyOrdersData = @json($monthly);
    const ordersLabels = monthlyOrdersData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('id-ID', {
            month: 'short',
            year: 'numeric'
        });
    });
    const ordersCounts = monthlyOrdersData.map(item => parseInt(item.orders_count, 10));
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

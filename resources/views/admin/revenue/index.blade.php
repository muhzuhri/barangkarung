@include('admin.layout.header')
<title>Pendapatan Admin | BK</title>

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
<div class="recent-orders-section" style="margin-top: 2rem;">
    <div class="section-header">
        <img src={{ asset('img/icon/statistic-icon.png') }} alt="Grafik Pendapatan" class="section-icon">
        <h2 class="section-title">Grafik Pendapatan Per Bulan</h2>
    </div>
    <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);">
        <canvas id="revenueChart" style="max-height: 400px;"></canvas>
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

    // Create chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: revenueData,
                backgroundColor: 'rgba(102, 126, 234, 0.6)',
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
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
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
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
</script>

@include('admin.layout.footer')

@include('admin.layout.header')
<title>Pendapatan Admin | BK</title>

<h1 class="section-title">Kelola Pendapatan</h1>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">💵</div>
        <div class="stat-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="stat-label">Total Pendapatan</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-number">{{ number_format($totalOrders) }}</div>
        <div class="stat-label">Pesanan Selesai</div>
    </div>
</div>

@if ($monthly->count() > 0)
    <div style="max-width: 800px; margin: 0 auto 18px auto;">
        <h3 style="text-align:center; font-weight:400; margin:14px 0 8px 0;">Diagram Batang Pendapatan Per Bulan</h3>
        <canvas id="barRevenueChart" height="120"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartData = @json($monthly);
        const labels = chartData.map(row => {
            const date = new Date(row.month + '-01');
            return date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' });
        });
        const data = chartData.map(row => row.revenue);
        const barCtx = document.getElementById('barRevenueChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: data,
                    backgroundColor: 'rgba(52, 120, 246, 0.6)',
                    borderColor: '#1472f6',
                    borderWidth: 2,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    </script>
@endif

@if ($monthly->count() > 0)
    <div class="recent-orders-section">
        <h2 class="section-title">Ringkasan Bulanan</h2>
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
    </div>
@endif

@if ($completedOrders->count() > 0)
    <div class="recent-orders-section">
        <h2 class="section-title">Pesanan Selesai Terbaru</h2>
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
                            <td>{{ $loop->iteration + ($completedOrders->currentPage() - 1) * $completedOrders->perPage() }}</td>
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
    </div>
@endif

@include('admin.layout.footer')

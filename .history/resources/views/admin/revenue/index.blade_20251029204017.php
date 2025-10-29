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

		@if($monthly->count() > 0)
			<div class="recent-orders-section">
				<h2 class="section-title">Ringkasan Bulanan</h2>
				<div class="orders-table">
					<table>
						<thead>
							<tr>
								<th>Bulan</th>
								<th>Pendapatan</th>
								<th>Pesanan</th>
							</tr>
						</thead>
						<tbody>
							@foreach($monthly as $row)
								<tr>
									<td>{{ \Carbon\Carbon::parse($row->month.'-01')->translatedFormat('F Y') }}</td>
									<td>Rp {{ number_format($row->revenue, 0, ',', '.') }}</td>
									<td>{{ $row->orders_count }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		@endif

		@if($completedOrders->count() > 0)
			<div class="recent-orders-section">
				<h2 class="section-title">Pesanan Selesai Terbaru</h2>
				<div class="orders-table">
					<table>
						<thead>
							<tr>
								<th>No. Pesanan</th>
								<th>Customer</th>
								<th>Total</th>
								<th>Tanggal</th>
							</tr>
						</thead>
						<tbody>
							@foreach($completedOrders as $order)
								<tr>
									<td>{{ $order->order_code }}</td>
									<td>{{ $order->user->name ?? 'User #'.$order->user_id }}</td>
									<td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
									<td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div style="margin-top:16px;">{{ $completedOrders->links() }}</div>
			</div>
		@endif




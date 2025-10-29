<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Kelola Pendapatan</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">
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
					<li><a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a></li>
					<li><a href="{{ route('admin.products.index') }}">🛍️ Produk</a></li>
					<li><a href="{{ route('admin.orders.index') }}">📦 Pesanan</a></li>
					<li><a href="{{ route('admin.users.index') }}">👥 User</a></li>
					<li><a href="{{ route('admin.revenue.index') }}" class="active">💰 Pendapatan</a></li>
					<li><a href="{{ route('admin.setting.profile') }}">⚙️ Settings</a></li>
				</ul>
			</nav>

			<div class="admin-info">
				<div class="admin-dropdown">
					<div class="admin-dropdown-toggle" onclick="toggleDropdown()">
						<div class="admin-avatar">{{ strtoupper(substr(($admin?->name ?? 'A'), 0, 1)) }}</div>
						<div>
							<div class="admin-name">{{ $admin?->name ?? 'Admin' }}</div>
							<div class="admin-role">Administrator</div>
						</div>
						<span style="font-size: 0.8rem;">▼</span>
					</div>
					<div class="dropdown-menu" id="adminDropdown">
						<a href="{{ route('admin.profile') }}" class="dropdown-item">👤 Profile</a>
						<a href="{{ route('admin.dashboard') }}" class="dropdown-item">🏠 Dashboard</a>
						<a href="{{ route('admin.products.index') }}" class="dropdown-item">🛍️ Kelola Produk</a>
						<a href="{{ route('admin.orders.index') }}" class="dropdown-item">📦 Kelola Pesanan</a>
						<a href="{{ route('admin.users.index') }}" class="dropdown-item">👥 Kelola User</a>
						<form method="POST" action="{{ route('logout') }}" style="margin: 0;">
							@csrf
							<button type="submit" class="dropdown-item logout" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">🚪 Logout</button>
						</form>
					</div>
				</div>

				<button class="mobile-menu-toggle" onclick="toggleMobileMenu()">☰</button>
			</div>
		</div>
	</div>

	<div class="container">
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
	</div>

	<script>
		function toggleDropdown() {
			const dropdown = document.getElementById('adminDropdown');
			dropdown.classList.toggle('show');
		}

		function toggleMobileMenu() {
			alert('Mobile menu akan ditambahkan');
		}

		document.addEventListener('click', function(e) {
			const dropdown = document.getElementById('adminDropdown');
			const toggle = document.querySelector('.admin-dropdown-toggle');
			if (toggle && !toggle.contains(e.target) && dropdown && !dropdown.contains(e.target)) {
				dropdown.classList.remove('show');
			}
		});
	</script>
</body>
</html>



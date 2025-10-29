@php($title = 'Kelola Pesanan')
@php($admin = ($admin ?? auth('admin')->user()))
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Kelola Pesanan</title>
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
					<li><a href="{{ route('admin.orders.index') }}" class="active">📦 Pesanan</a></li>
					<li><a href="{{ route('admin.users.index') }}">👥 User</a></li>
					<li><a href="{{ route('admin.revenue.index') }}">💰 Pendapatan</a></li>
					<li><a href="{{ route('admin.setting.profile') }}">⚙️ Settings</a></li>
				</ul>
			</nav>

			<div class="admin-info">
				<div class="admin-dropdown">
					<div class="admin-dropdown-toggle" onclick="toggleDropdown()">
						<div class="admin-avatar">
							{{ strtoupper(substr(($admin?->name ?? 'A'), 0, 1)) }}
						</div>
						<div>
							<div class="admin-name">{{ $admin?->name ?? 'Admin' }}</div>
							<div class="admin-role">{{ method_exists($admin, 'getRoleDisplayAttribute') ? $admin->getRoleDisplayAttribute() : 'Administrator' }}</div>
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
		@if(session('success'))
			<div class="alert alert-success">{{ session('success') }}</div>
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

		<h1 class="section-title">Kelola Pesanan</h1>

		<div class="orders-table">
			<table>
				<thead>
					<tr>
						<th>No. Pesanan</th>
						<th>Customer</th>
						<th>Total</th>
						<th>Status</th>
						<th>Tanggal</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($orders as $order)
						<tr>
							<td>{{ $order->order_code ?? $order->id }}</td>
							<td>{{ $order->user->name ?? $order->user_id }}</td>
							<td>Rp {{ number_format(($order->total ?? 0), 0, ',', '.') }}</td>
							<td>
							<span class="status-badge status-{{ \Illuminate\Support\Str::slug($order->status) }}">{{ $order->status }}</span>
							</td>
							<td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
							<td>
								<a class="btn btn-link" href="{{ route('admin.orders.show', $order->id) }}">Detail</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div style="margin-top: 16px;">
			{{ $orders->links() }}
		</div>
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




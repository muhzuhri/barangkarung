@php($admin = ($admin ?? auth('admin')->user()))
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Detail Pesanan</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">
	<link rel="stylesheet" href="{{ asset('css/admin/dashboard-admin-style.css') }}">
	<style>
		/* Scoped enhancements for a modern detail view */
		.order-header{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:16px}
		.order-title{font-size:1.5rem;font-weight:700;margin:0}
		.badge-large{font-size:.85rem;padding:8px 12px;border-radius:999px;display:inline-block}
		.meta-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
		.meta-item{background:#fff;border:1px solid rgba(0,0,0,.06);border-radius:12px;padding:12px}
		.meta-label{font-size:.75rem;color:#6b7280;margin-bottom:4px}
		.meta-value{font-weight:600}
		.summary-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin-top:16px}
		.summary-card{background:#fff;border:1px solid rgba(0,0,0,.06);border-radius:12px;padding:16px;text-align:center}
		.summary-value{font-size:1.1rem;font-weight:700}
		.btn-group{display:flex;gap:8px;flex-wrap:wrap}
		.form-inline{display:flex;gap:12px;align-items:center;flex-wrap:wrap}
		@media (max-width: 768px){.meta-grid{grid-template-columns:1fr}.summary-grid{grid-template-columns:1fr}}
	</style>
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
					<li><a href="{{ route('admin.profile') }}">⚙️ Settings</a></li>
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
		@if (session('success'))
			<div class="alert alert-success">{{ session('success') }}</div>
		@endif

		<div class="order-header">
			<h1 class="order-title">Pesanan #{{ $order->order_code }}</h1>
			<span class="badge-large status-badge status-{{ \Illuminate\Support\Str::slug($order->status) }}">{{ $order->status }}</span>
		</div>

		<div class="meta-grid" style="margin-bottom:16px;">
			<div class="meta-item">
				<div class="meta-label">Customer</div>
				<div class="meta-value">{{ $order->user->name ?? ('User #' . $order->user_id) }}</div>
			</div>
			<div class="meta-item">
				<div class="meta-label">Tanggal Pesanan</div>
				<div class="meta-value">{{ $order->created_at->format('d/m/Y H:i') }}</div>
			</div>
			<div class="meta-item">
				<div class="meta-label">Metode Pengiriman</div>
				<div class="meta-value">{{ $order->shipping_method }}</div>
			</div>
			<div class="meta-item">
				<div class="meta-label">Metode Pembayaran</div>
				<div class="meta-value">{{ $order->payment_method }}</div>
			</div>
			<div class="meta-item" style="grid-column:1/-1;">
				<div class="meta-label">Alamat Pengiriman</div>
				<div class="meta-value">{{ $order->shipping_address }}</div>
			</div>
		</div>

		<div class="summary-grid">
			<div class="summary-card">
				<div class="meta-label">Total Item</div>
				<div class="summary-value">{{ $order->items->sum('quantity') }}</div>
			</div>
			<div class="summary-card">
				<div class="meta-label">Status</div>
				<div class="summary-value">{{ ucfirst($order->status) }}</div>
			</div>
			<div class="summary-card">
				<div class="meta-label">Total Pembayaran</div>
				<div class="summary-value">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
			</div>
		</div>

		<h2 class="section-title" style="margin:24px 0 8px;">Item Pesanan</h2>
		<div class="orders-table">
			<table>
				<thead>
					<tr>
						<th>Produk</th>
						<th>Jumlah</th>
						<th>Ukuran</th>
						<th>Harga</th>
						<th>Subtotal</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($order->items as $item)
						<tr>
							<td>{{ $item->product->name ?? 'Produk dihapus' }}</td>
							<td>{{ $item->quantity }}</td>
							<td>{{ $item->size ?? '-' }}</td>
							<td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
							<td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="form-inline" style="margin-top:16px; gap:12px; align-items:center;">
			@csrf
			@method('PATCH')
			<label for="status" style="min-width:110px;">Ubah Status</label>
			<select id="status" name="status" style="padding:8px 10px; border-radius:8px; border:1px solid #e5e7eb;">
				<option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
				<option value="Sedang Diproses" {{ $order->status === 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
				<option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
				<option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
				<option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
			</select>
			<div class="btn-group">
				<button type="submit" class="btn" style="background:#667eea; color:#fff; padding:10px 14px; border-radius:8px;">Update Status</button>
				<a class="btn btn-secondary" href="{{ route('admin.orders.index') }}" style="background:#6b7280; color:#fff; padding:10px 14px; border-radius:8px;">Kembali</a>
			</div>
		</form>
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




<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Detail Pesanan - BarangKarung ID</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />
	<link rel="stylesheet" href="{{ asset('css/nav_menu-style.css') }}">
	<link rel="stylesheet" href="{{ asset('css/pesanan-style.css') }}">
	<style>
		.order-detail { max-width: 1000px; margin: 24px auto; padding: 0 16px; }
		.detail-card { background:#fff; border:1px solid #eee; border-radius:12px; padding:16px; margin-bottom:16px }
		.detail-row { display:grid; grid-template-columns: 1fr 1fr; gap:12px }
		.detail-label { color:#6b7280; font-size:.9rem }
		.detail-value { font-weight:600 }
		.items-table { width:100%; border-collapse: collapse }
		.items-table th, .items-table td { padding:10px 12px; border-bottom:1px solid #f0f0f0; text-align:left }
		.items-table th { background:#fafafa; font-weight:600; color:#374151 }
		.total-row { display:flex; justify-content:flex-end; gap:24px; margin-top:12px }
	</style>
</head>

<body>
	<x-navbar />

	<main class="order-detail">
		<h1>Detail Pesanan</h1>

		<div class="detail-card">
			<div class="detail-row">
				<div>
					<div class="detail-label">Kode Pesanan</div>
					<div class="detail-value">{{ $order->order_code }}</div>
				</div>
				<div>
					<div class="detail-label">Tanggal</div>
					<div class="detail-value">{{ $order->created_at->setTimezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }}</div>
				</div>
				<div>
					<div class="detail-label">Status</div>
					<div class="detail-value">{{ ucfirst($order->status) }}</div>
				</div>
				<div>
					<div class="detail-label">Telepon</div>
					<div class="detail-value">{{ $order->phone }}</div>
				</div>
				<div>
					<div class="detail-label">Status Pembayaran</div>
					<div class="detail-value">
						@if($order->payment_method === 'dana' || $order->payment_method === 'mandiri')
							<strong>{{ ucfirst($order->payment_status ?? '-') }}</strong>
							@if($order->payment_proof)
								<br>
								<a href="{{ asset('storage/'.$order->payment_proof) }}" target="_blank">Lihat Bukti Transfer</a>
							@endif
							<br>
							@if($order->payment_status === 'pending')
								Menunggu konfirmasi admin
							@elseif($order->payment_status === 'verified')
								Pembayaran terkonfirmasi
							@elseif($order->payment_status === 'rejected')
								Pembayaran ditolak, silakan hubungi admin
							@endif
						@else
							Non-Transfer (Bayar di Tempat/COD)
						@endif
					</div>
					<div class="detail-label">Status Pemesanan</div>
					<div class="detail-value">{{ ucfirst($order->order_status) }}</div>
				</div>
				<div style="grid-column:1/-1;">
					<div class="detail-label">Alamat Pengiriman</div>
					<div class="detail-value">{{ $order->shipping_address }}</div>
				</div>
			</div>
		</div>

		<div class="detail-card">
			<h3 style="margin-bottom:8px;">Item Pesanan</h3>
			<table class="items-table">
				<thead>
					<tr>
						<th>Produk</th>
						<th>Ukuran</th>
						<th>Qty</th>
						<th>Harga</th>
						<th>Subtotal</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($order->items as $item)
					<tr>
						<td>{{ $item->product->name ?? 'Produk dihapus' }}</td>
						<td>{{ $item->size ?? '-' }}</td>
						<td>{{ $item->quantity }}</td>
						<td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
						<td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="total-row">
				<div><strong>Total:</strong></div>
				<div><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></div>
			</div>
		</div>

		<div style="display:flex; gap:8px; flex-wrap:wrap;">
			@if ($order->order_status === 'dikirim')
			<form method="POST" action="{{ route('pesanan.selesai', $order->id) }}">
				@csrf
				<button type="submit" class="btn-detail" style="background:#10b981;">Tandai Selesai</button>
			</form>
			@endif
			<a href="{{ route('pesanan') }}" class="btn-detail" style="background:#6b7280;">Kembali</a>
		</div>
	</main>
</body>
</html>



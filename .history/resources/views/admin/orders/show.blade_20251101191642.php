@php($admin = $admin ?? auth('admin')->user())

@include('admin.layout.header')
<title>Detail Pesanan Admin | BK</title>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="page-header">
    <h1 class="page-title">
        <img src={{ asset('img/icon/tambah-icon.png') }} alt="Icon Produk" class="title-icon">
        Tambah Produk Baru
    </h1>
    <a href="{{ route('admin.products.index') }}" class="btn-kembali">
        <img src={{ asset('img/icon/kembali-icon.png') }} alt="Tambah Produk" class="btn-icon-kembali">
    </a>
</div>

<div class="order-header">
    <h1 class="order-title">Pesanan #{{ $order->order_code }}</h1>
    <span
        class="badge-large status-badge status-{{ \Illuminate\Support\Str::slug($order->status) }}">{{ $order->status }}</span>
</div>

<div class="meta-grid" style="margin-bottom:16px;">
    <div class="meta-item">
        <div class="meta-label">Customer</div>
        <div class="meta-value">{{ $order->user->name ?? 'User #' . $order->user_id }}</div>
    </div>
    <div class="meta-item">
        <div class="meta-label">Tanggal Pesanan</div>
        <div class="meta-value">{{ $order->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</div>
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
                <th>No</th>
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
                    <td>{{ $loop->iteration }}</td>
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

<form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="form-inline"
    style="margin-top:16px; gap:12px; align-items:center;">
    @csrf
    @method('PATCH')
    <label for="status" style="min-width:110px;">Ubah Status</label>
    <select id="status" name="status" style="padding:8px 10px; border-radius:8px; border:1px solid #e5e7eb;">
        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="Sedang Diproses" {{ $order->status === 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses
        </option>
        <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
        <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
        <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
    </select>
    <div class="btn-group">
        <button type="submit" class="btn"
            style="background:#667eea; color:#fff; padding:10px 14px; border-radius:8px;">Update Status</button>
        <a class="btn btn-secondary" href="{{ route('admin.orders.index') }}"
            style="background:#6b7280; color:#fff; padding:10px 14px; border-radius:8px;">Kembali</a>
    </div>
</form>

@include('admin.layout.footer')

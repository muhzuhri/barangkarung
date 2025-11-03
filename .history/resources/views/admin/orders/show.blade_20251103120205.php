@php($admin = $admin ?? auth('admin')->user())

@include('admin.layout.header')
<title>Detail Pesanan Admin | BK</title>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<<<<<<< HEAD
<div class="page-header">
    <h1 class="page-title">
        {{-- <img src={{ asset('img/icon/tambah-icon.png') }} alt="Icon Produk" class="title-icon"> --}}
        Detail Pesanan
    </h1>
    <a href="{{ route('admin.orders.index') }}" class="btn-kembali">
        <img src={{ asset('img/icon/kembali-icon.png') }} alt="Tambah Produk" class="btn-icon-kembali">
    </a>
=======
<div class="order-header">
    <h1 class="order-title">Pesanan #{{ $order->order_code }}</h1>
    <span
        class="badge-large status-badge status-{{ \Illuminate\Support\Str::slug($order->order_status) }}">{{ ucfirst($order->order_status) }}</span>
>>>>>>> 1b61db3f598af8de5f888a82f10d889ae7a60879
</div>

<div class="order-container">
    <!-- Header -->
    <div class="order-header">
        <h1 class="order-title">
            Pesanan #{{ $order->order_code }}
        </h1>
        <span class="status-badge status-{{ \Illuminate\Support\Str::slug($order->status) }}">
            {{ ucfirst($order->status) }}
        </span>
    </div>


        <div class="meta-row">
            <div class="meta-item">
                <div class="meta-label">Metode Pembayaran</div>
                <div class="meta-value">{{ $order->payment_method }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Metode Pengiriman</div>
                <div class="meta-value">{{ $order->shipping_method }}</div>
            </div>
        </div>

        <div class="meta-row full">
            <div class="meta-item full-width">
                <div class="meta-label">Alamat Pengiriman</div>
                <div class="meta-value">{{ $order->shipping_address }}</div>
            </div>
        </div>
    </div>

    <!-- Ringkasan -->
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-label">Total Item</div>
            <div class="summary-value">{{ $order->items->sum('quantity') }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Status</div>
            <div class="summary-value">{{ ucfirst($order->status) }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Total Pembayaran</div>
            <div class="summary-value">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Item Pesanan -->
    <div class="section-header">
        <img src={{ asset('img/icon/calendar-icon.png') }} alt="Pesanan Terbaru" class="section-icon">
        <h2 class="section-title">Table Pesanan</h2>
    </div>
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

    <!-- Form Update Status -->
    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="status-form">
        @csrf
        @method('PATCH')

        <label for="status" class="status-label">Ubah Status</label>
        <select id="status" name="status" class="status-select">
            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="Sedang Diproses" {{ $order->status === 'Sedang Diproses' ? 'selected' : '' }}>Sedang
                Diproses</option>
            <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
            <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
        </select>

        <div class="btn-group">
            <button type="submit" class="btn-submit">Perbarui Status</button>
            {{-- <a href="{{ route('admin.orders.index') }}" class="btn-batal">Kembali</a> --}}
        </div>
    </form>
</div>

<<<<<<< HEAD
<!-- Penutup -->
<div class="penutup">
    <p class="penutup-text">
        Sistem ini terus berkembang untuk memberikan kemudahan dalam pengelolaan toko barang karung.
        Jangan ragu untuk menjelajahi lebih banyak fitur dan manfaatkan semaksimal mungkin.
    </p>
</div>
=======
<form method="POST" action="{{ route('admin.orders.updateOrderStatus', $order->id) }}" class="form-inline"
    style="margin-top:16px; gap:12px; align-items:center;">
    @csrf
    @method('PATCH')
    <label for="order_status" style="min-width:110px;">Ubah Status</label>
    <select id="order_status" name="order_status" style="padding:8px 10px; border-radius:8px; border:1px solid #e5e7eb;">
        <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="diproses" {{ $order->order_status === 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
        <option value="dikirim" {{ $order->order_status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
        <option value="selesai" {{ $order->order_status === 'selesai' ? 'selected' : '' }}>Selesai</option>
        <option value="dibatalkan" {{ $order->order_status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
    </select>
    <div class="btn-group">
        <button type="submit" class="btn"
            style="background:#667eea; color:#fff; padding:10px 14px; border-radius:8px;">Update Status</button>
        <a class="btn btn-secondary" href="{{ route('admin.orders.index') }}"
            style="background:#6b7280; color:#fff; padding:10px 14px; border-radius:8px;">Kembali</a>
    </div>
</form>
>>>>>>> 1b61db3f598af8de5f888a82f10d889ae7a60879

@include('admin.layout.footer')

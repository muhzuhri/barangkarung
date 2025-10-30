@php($admin = $admin ?? auth('admin')->user())

@include('admin.layout.header')
<title>Detail Pesanan Admin | BK</title>

<style>
        /* Scoped enhancements for a modern detail view */
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px
        }

        .order-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0
        }

        .badge-large {
            font-size: .85rem;
            padding: 8px 12px;
            border-radius: 999px;
            display: inline-block
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px
        }

        .meta-item {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .06);
            border-radius: 12px;
            padding: 12px
        }

        .meta-label {
            font-size: .75rem;
            color: #6b7280;
            margin-bottom: 4px
        }

        .meta-value {
            font-weight: 600
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 16px
        }

        .summary-card {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .06);
            border-radius: 12px;
            padding: 16px;
            text-align: center
        }

        .summary-value {
            font-size: 1.1rem;
            font-weight: 700
        }

        .btn-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap
        }

        .form-inline {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap
        }

        @media (max-width: 768px) {
            .meta-grid {
                grid-template-columns: 1fr
            }

            .summary-grid {
                grid-template-columns: 1fr
            }
        }
    </style>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="order-header">
    <h1 class="order-title">Pesanan #{{ $order->order_code }}</h1>
    <span
        class="badge-large status-badge status-{{ \Illuminate\Support\Str::slug($order->order_status) }}">{{ ucfirst($order->order_status) }}</span>
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
    <div class="meta-item">
        <div class="meta-label">Status Pembayaran</div>
        <div class="meta-value">
            @if($order->payment_method === 'dana' || $order->payment_method === 'mandiri')
                <strong>{{ ucfirst($order->payment_status ?? '-') }}</strong>
                <br>
                @if($order->payment_proof)
                    <a href="{{ asset('storage/'.$order->payment_proof) }}" target="_blank" style="display:block;margin-bottom:6px;">Lihat Bukti Transfer</a>
                @endif
            @else
                Non-Transfer (Bayar di Tempat/COD)
            @endif
        </div>
    </div>
    <div class="meta-item">
        <div class="meta-label">Status Pesanan</div>
        <div class="meta-value">{{ ucfirst($order->order_status) }}</div>
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
        <div class="summary-value">{{ ucfirst($order->order_status) }}</div>
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

@include('admin.layout.footer')

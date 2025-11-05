@php
    $admin = $admin ?? auth('admin')->user();
@endphp

@include('admin.layout.header')
<title>Detail Pesanan Admin | BK</title>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="page-header">
    <h1 class="page-title">
        {{-- <img src={{ asset('img/icon/tambah-icon.png') }} alt="Icon Produk" class="title-icon"> --}}
        Detail Pesanan
    </h1>
    <a href="{{ route('admin.orders.index') }}" class="btn-kembali">
        <img src={{ asset('img/icon/kembali-icon.png') }} alt="Tambah Produk" class="btn-icon-kembali">
    </a>
</div>

<div class="order-container">
    <!-- Header -->
    <div class="order-header">
        <h1 class="order-title">
            Pesanan #{{ $order->order_code }}
        </h1>
        <span class="status-badge status-{{ \Illuminate\Support\Str::slug($order->order_status ?? $order->status) }}">
            {{ ucfirst($order->order_status ?? $order->status) }}
        </span>
    </div>

    <!-- Informasi Dasar -->
    <div class="order-meta">
        <div class="meta-row">
            <div class="meta-item">
                <div class="meta-label">Customer</div>
                <div class="meta-value">{{ $order->user->name ?? 'User #' . $order->user_id }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Tanggal Pesanan</div>
                <div class="meta-value">{{ $order->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</div>
            </div>
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
            <div class="summary-value">{{ ucfirst($order->order_status ?? $order->status) }}</div>
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

    <!-- Bukti Pembayaran -->
    @if(in_array($order->payment_method, ['dana', 'mandiri']))
    <div class="recent-orders-section" style="margin-top: 2rem;">
        <div class="section-header">
            <img src={{ asset('img/icon/statistic-icon.png') }} alt="Bukti Pembayaran" class="section-icon">
            <h2 class="section-title">Bukti Pembayaran</h2>
        </div>
        <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);">
            @if($order->payment_proof)
                <div style="margin-bottom: 1rem;">
                    <div style="font-weight: 600; margin-bottom: 0.5rem; color: #333;">Status Pembayaran:</div>
                    <span class="status-badge status-{{ \Illuminate\Support\Str::slug($order->payment_status ?? 'pending') }}" 
                          style="padding: 6px 12px; border-radius: 6px; font-size: 14px; display: inline-block;">
                        {{ ucfirst($order->payment_status ?? 'Pending') }}
                    </span>
                </div>
                <div style="margin-bottom: 1rem;">
                    <div style="font-weight: 600; margin-bottom: 0.5rem; color: #333;">Gambar Bukti Transfer:</div>
                    @php
                        // Path yang disimpan di database adalah 'payments/filename.jpg'
                        $proofUrl = asset('storage/' . $order->payment_proof);
                        $storagePath = storage_path('app/public/' . $order->payment_proof);
                        $publicPath = public_path('storage/' . $order->payment_proof);
                        $fileExists = file_exists($storagePath) || file_exists($publicPath);
                    @endphp
                    <a href="{{ $proofUrl }}" target="_blank" 
                       style="display: inline-block; margin-top: 0.5rem;">
                        <img src="{{ $proofUrl }}" 
                             alt="Bukti Pembayaran" 
                             onerror="this.onerror=null; this.parentElement.innerHTML='<div style=\'padding: 2rem; background: #fff3cd; border-radius: 8px; border: 2px solid #ffc107; color: #856404; text-align: center;\'><strong>⚠️ Gambar tidak dapat dimuat</strong><br><small>URL: {{ $proofUrl }}</small><br><small>Pastikan file ada di: storage/app/public/{{ $order->payment_proof }}</small></div>';"
                             style="max-width: 400px; max-height: 400px; border-radius: 8px; border: 2px solid #e5e7eb; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.1); object-fit: contain;">
                    </a>
                    <div style="margin-top: 0.5rem; color: #666; font-size: 14px;">
                        Klik gambar untuk melihat ukuran penuh
                    </div>
                    @if(!$fileExists)
                        <div style="margin-top: 0.5rem; padding: 0.5rem; background: #fef3c7; border-radius: 6px; font-size: 12px; color: #92400e;">
                            <strong>⚠️ Debug Info:</strong><br>
                            <small>Path DB: {{ $order->payment_proof }}</small><br>
                            <small>URL: <a href="{{ $proofUrl }}" target="_blank" style="color: #667eea;">{{ $proofUrl }}</a></small><br>
                            <small>Storage: {{ $storagePath }}</small>
                        </div>
                    @endif
                </div>
                @if(($order->payment_status ?? 'pending') === 'pending')
                    <form method="POST" action="{{ route('admin.orders.updatePayment', $order->id) }}" style="display: flex; gap: 8px; margin-top: 1rem;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" name="action" value="verified" 
                                style="background: #10b981; color: white; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; transition: background 0.2s;">
                            Verifikasi Pembayaran
                        </button>
                        <button type="submit" name="action" value="rejected" 
                                style="background: #ef4444; color: white; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; transition: background 0.2s;">
                            Tolak Pembayaran
                        </button>
                    </form>
                @endif
            @else
                <div style="color: #666; padding: 1rem; background: #f9fafb; border-radius: 8px; text-align: center;">
                    Bukti pembayaran belum diupload
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Form Update Status -->
    {{-- <form method="POST" action="{{ route('admin.orders.updateOrderStatus', $order->id) }}" class="form-inline" style="margin-top:16px; gap:12px; align-items:center;">
        @csrf
        @method('PATCH')
        <label for="order_status" style="min-width:110px;">Ubah Status</label>
        <select id="order_status" name="order_status" style="padding:8px 10px; border-radius:8px; border:1px solid #e5e7eb;">
            <option value="pending" {{ ($order->order_status ?? $order->status) === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="diproses" {{ ($order->order_status ?? $order->status) === 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
            <option value="dikirim" {{ ($order->order_status ?? $order->status) === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
            <option value="selesai" {{ ($order->order_status ?? $order->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="dibatalkan" {{ ($order->order_status ?? $order->status) === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <div class="btn-group">
            <button type="submit" class="btn" style="background:#667eea; color:#fff; padding:10px 14px; border-radius:8px;">Update Status</button>
            <a class="btn btn-secondary" href="{{ route('admin.orders.index') }}" style="background:#6b7280; color:#fff; padding:10px 14px; border-radius:8px;">Kembali</a>
        </div>
    </form> --}}

    
</div>

<!-- Penutup -->
<div class="penutup">
    <p class="penutup-text">
        Sistem ini terus berkembang untuk memberikan kemudahan dalam pengelolaan toko barang karung.
        Jangan ragu untuk menjelajahi lebih banyak fitur dan manfaatkan semaksimal mungkin.
    </p>
</div>

@include('admin.layout.footer')
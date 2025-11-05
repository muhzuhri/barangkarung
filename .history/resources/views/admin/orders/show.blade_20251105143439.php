@php
    $admin = $admin ?? auth('admin')->user();
@endphp

<style>
    /* Style utama untuk dropdown */
    /* Label */
    .status-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
    }

    /* Select2 container */
    .select2-container .select2-selection--single {
        height: 50px !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 14px !important;
        display: flex !important;
        align-items: center;
        background-color: #fff !important;
        padding: 6px 14px !important;
        transition: all 0.25s ease;
        box-shadow: none !important;
        font-family: 'Inter', sans-serif;
    }

    /* Hover & Focus */
    .select2-container--default .select2-selection--single:hover {
        border-color: #93c5fd !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #3B82F6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }

    /* Text */
    .select2-container .select2-selection__rendered {
        color: #374151 !important;
        font-size: 15px !important;
        font-weight: 500 !important;
        padding-left: 4px !important;
    }

    /* Dropdown arrow */
    .select2-container--default .select2-selection__arrow {
        height: 100% !important;
        right: 14px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        transition: transform 0.25s ease;
    }

    .select2-container--open .select2-selection__arrow {
        transform: translateY(-50%) rotate(180deg) !important;
    }

    .select2-container--default .select2-selection__arrow b {
        border-color: #6b7280 transparent transparent transparent !important;
        border-width: 6px 5px 0 5px !important;
    }

    /* Dropdown Panel */
    .select2-dropdown {
        margin-top: 6px !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08) !important;
        overflow: hidden !important;
    }

    /* Option list */
    .select2-results__option {
        padding: 10px 16px !important;
        font-size: 15px !important;
        font-weight: 500 !important;
        color: #374151 !important;
        transition: all 0.15s ease;
    }

    /* Hover / highlighted option */
    .select2-results__option--highlighted {
        background-color: #EFF6FF !important;
        color: #1E40AF !important;
    }

    /* Remove search box */
    .select2-search--dropdown {
        display: none !important;
    }

    /* Scrollbar styling (opsional, biar halus) */
    .select2-results__options::-webkit-scrollbar {
        width: 6px;
    }

    .select2-results__options::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 10px;
    }
</style>

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
    @if (in_array($order->payment_method, ['dana', 'mandiri']))
        <div class="payment-section">
            <div class="section-header">
                <img src="{{ asset('img/icon/bukti-icon.png') }}" alt="Bukti Pembayaran" class="section-icon">
                <h2 class="section-title">Bukti Pembayaran</h2>
            </div>

            <div class="payment-card">
                @if ($order->payment_proof)
                    <div class="payment-status">
                        <div class="label">Status Pembayaran:</div>
                        <span
                            class="status-badge status-{{ \Illuminate\Support\Str::slug($order->payment_status ?? 'pending') }}">
                            {{ ucfirst($order->payment_status ?? 'Pending') }}
                        </span>
                    </div>

                    <div class="payment-proof">
                        <div class="label">Gambar Bukti Transfer:</div>
                        @php
                            $proofUrl = asset('storage/' . $order->payment_proof);
                            $storagePath = storage_path('app/public/' . $order->payment_proof);
                            $publicPath = public_path('storage/' . $order->payment_proof);
                            $fileExists = file_exists($storagePath) || file_exists($publicPath);
                        @endphp

                        <a href="{{ $proofUrl }}" target="_blank" class="proof-link">
                            <img src="{{ $proofUrl }}" alt="Bukti Pembayaran"
                                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'image-error\'><strong>⚠️ Gambar tidak dapat dimuat</strong><br><small>{{ $proofUrl }}</small></div>';"
                                class="proof-image">
                        </a>
                        <div class="note">Klik gambar untuk melihat ukuran penuh</div>

                        @if (!$fileExists)
                            <div class="debug-info">
                                <strong>⚠️ Debug Info:</strong><br>
                                <small>Path DB: {{ $order->payment_proof }}</small><br>
                                <small>URL: <a href="{{ $proofUrl }}"
                                        target="_blank">{{ $proofUrl }}</a></small><br>
                                <small>Storage: {{ $storagePath }}</small>
                            </div>
                        @endif
                    </div>

                    @if (($order->payment_status ?? 'pending') === 'pending')
                        <form method="POST" action="{{ route('admin.orders.updatePayment', $order->id) }}"
                            class="payment-actions">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="action" value="verified" class="btn btn-verify">
                                Verifikasi Pembayaran
                            </button>
                            <button type="submit" name="action" value="rejected" class="btn btn-reject">
                                Tolak Pembayaran
                            </button>
                        </form>
                    @endif
                @else
                    <div class="no-proof">Bukti pembayaran belum diupload</div>
                @endif
            </div>
        </div>
    @endif

    <!-- Form Update Status -->
    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="status-form">
        @csrf
        @method('PATCH')

        {{-- <label for="status" class="status-label">Ubah Status</label>
        <select id="status" name="status" class="status-select">
            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="Sedang Diproses" {{ $order->status === 'Sedang Diproses' ? 'selected' : '' }}>Sedang
                Diproses</option>
            <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
            <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
        </select> --}}

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
            <button type="submit" class="btn-submit">Perbarui</button>
            {{-- <a href="{{ route('admin.orders.index') }}" class="btn-batal">Kembali</a> --}}
        </div>
    </form>
</div>

<!-- Penutup -->
<div class="penutup">
    <p class="penutup-text">
        Sistem ini terus berkembang untuk memberikan kemudahan dalam pengelolaan toko barang karung.
        Jangan ragu untuk menjelajahi lebih banyak fitur dan manfaatkan semaksimal mungkin.
        Sistem ini terus berkembang untuk memberikan kemudahan dalam pengelolaan toko barang karung.
        Jangan ragu untuk menjelajahi lebih banyak fitur dan manfaatkan semaksimal mungkin.
        Sistem ini terus berkembang untuk memberikan kemudahan dalam pengelolaan toko barang karung.
        Jangan ragu untuk menjelajahi lebih banyak fitur dan manfaatkan semaksimal mungkin.
        Sistem ini terus berkembang untuk memberikan kemudahan dalam pengelolaan toko barang karung.
        Jangan ragu untuk menjelajahi lebih banyak fitur dan manfaatkan semaksimal mungkin.
    </p>
</div>

@include('admin.layout.footer')

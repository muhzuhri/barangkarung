@php
    $admin = $admin ?? auth('admin')->user();
@endphp

<style>
    .status-form-pesanan {
        background: linear-gradient(to right, #f1f6fe, #e2e8ff);
        /* from-blue-50 to-indigo-200 */
        border: 1px solid #e0e4ed;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        border-radius: 0.7rem;
        padding: 24px 26px;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 18px;
        flex-wrap: wrap;
        font-family: 'Inter', sans-serif;
        margin-top: 25px;
        transition: all 0.3s ease;
    }

    /* Label */
    .status-label-pesanan {
        color: #29313c;
        font-weight: 600;
        font-size: 1rem;
        letter-spacing: 0.3px;
        display: block;
        text-transform: uppercase;
    }


    /* Select2 container */
    .select2-container .select2-selection--single {
        height: 52px !important;
        border: 2px solid #dbdfe9 !important;
        border-radius: 14px !important;
        display: flex !important;
        align-items: center;
        background-color: #ffffff !important;
        padding: 6px 14px !important;
        transition: all 0.25s ease;
        box-shadow: none !important;
    }

    /* Hover & Focus */
    .select2-container--default .select2-selection--single:hover {
        border-color: #bfdbfe !important;
        background-color: #f9fafb !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #3B82F6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15) !important;
        background-color: #ffffff !important;
    }

    /* Text */
    .select2-container .select2-selection__rendered {
        color: #1f2937 !important;
        font-size: 15px !important;
        letter-spacing: 0.4px !important;
        font-weight: 500 !important;
        padding-left: 2px !important;
    }

    /* Dropdown arrow */
    .select2-container--default .select2-selection__arrow {
        height: 100% !important;
        right: 14px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        transition: transform 0.25s ease, filter 0.2s ease;
        filter: grayscale(60%);
    }

    .select2-container--open .select2-selection__arrow {
        transform: translateY(-50%) rotate(180deg) !important;
        filter: grayscale(0%);
    }

    .select2-container--default .select2-selection__arrow b {
        border-color: #6b7280 transparent transparent transparent !important;
        border-width: 6px 5px 0 5px !important;
    }

    /* Dropdown Panel */
    .select2-dropdown {
        margin-top: 8px !important;
        border: none !important;
        border-radius: 14px !important;
        background-color: #ffffff !important;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08) !important;
        overflow: hidden !important;
        animation: dropdownFade 0.15s ease-out;
    }

    @keyframes dropdownFade {
        from {
            opacity: 0;
            transform: translateY(-4px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Option list */
    .select2-results__option {
        padding: 12px 16px !important;
        font-size: 15px !important;
        font-weight: 500 !important;
        color: #374151 !important;
        transition: all 0.2s ease;
        border-radius: 8px !important;
        margin: 2px 6px !important;
    }

    /* Hover / highlighted option */
    .select2-results__option--highlighted {
        background-color: #eff6ff !important;
        color: #1E3A8A !important;
    }

    /* Remove search box */
    .select2-search--dropdown {
        display: none !important;
    }

    /* Custom Scrollbar — soft modern look */
    .select2-results__options::-webkit-scrollbar {
        width: 8px;
        background: transparent;
    }

    .select2-results__options::-webkit-scrollbar-track {
        background: transparent;
        margin: 8px;
    }

    .select2-results__options::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #d1d5db 0%, #9ca3af 100%);
        border-radius: 10px;
        border: 2px solid #f9fafb;
        transition: background 0.3s ease;
    }

    .select2-results__options::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #9ca3af 0%, #6b7280 100%);
    }

    /* Tombol grup */
    .btn-group-perbarui-pesanan {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Tombol submit */
    .btn-submit-perbarui-pesanan {
        background: #2c53d3;
        border: none;
        color: #fff;
        font-size: 1rem;
        font-weight: 500;
        letter-spacing: 0.7px;
        padding: 12px 24px;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .btn-submit-perbarui-pesanan:hover {
        background: #2049cd;
        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
    }

    /* Responsif */
    @media (max-width: 768px) {
        .status-form-pesanan {
            flex-direction: column;
            align-items: stretch;
        }

        .status-select,
        .btn-submit-perbarui-pesanan {
            width: 100%;
        }
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
        <span class="status-badge status-{{ \Illuminate\Support\Str::slug($order->status) }}">
            {{ ucfirst($order->status) }}
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

    <!-- Ringkasan 3 box -->
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-label">Total Item</div>
            <div class="stat-icon">
                <img src="{{ asset('img/icon/produk-icon.png') }}" alt="Icon Pengguna">
            </div>
            <div class="summary-value">{{ $order->items->sum('quantity') }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Status</div>
            <div class="stat-icon">
                <img src="{{ asset('img/icon/status-icon.png') }}" alt="Icon Pengguna">
            </div>
            <div class="summary-value">{{ ucfirst($order->order_status ?? $order->status) }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Total Pembayaran</div>
            <div class="stat-icon">
                <img src="{{ asset('img/icon/pendapatan-icon.png') }}" alt="Icon Pengguna">
            </div>
            <div class="summary-value">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Table Item Pesanan -->
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
    @if (in_array($order->payment_method, ['dana', 'mandiri', 'qris']))
        <div class="payment-section">
            <div class="section-header">
                <img src="{{ asset('img/icon/bukti-icon.png') }}" alt="Bukti Pembayaran" class="section-icon">
                <h2 class="section-title">Bukti Pembayaran</h2>
            </div>

            <div class="payment-card">
                @if ($order->payment_proof)
                    <div class="payment-status">
                        <div class="label">Status Pembayaran :</div>
                        <span
                            class="status-badge-pembayaran{{ \Illuminate\Support\Str::slug($order->payment_status ?? 'pending') }}">
                            {{ ucfirst($order->payment_status ?? 'Pending') }}
                        </span>
                    </div>

                    <div class="payment-proof">
                        <div class="label">Gambar Bukti Transfer :</div>
                        @php
                            $proofUrl = asset('storage/' . $order->payment_proof);
                            $storagePath = storage_path('app/public/' . $order->payment_proof);
                            $publicPath = public_path('storage/' . $order->payment_proof);
                            $fileExists = file_exists($storagePath) || file_exists($publicPath);
                        @endphp

                        <a href="{{ $proofUrl }}" target="_blank" class="proof-link">
                            <img src="{{ $proofUrl }}" alt="Bukti Pembayaran"
                                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'image-error\'><strong>⚠ Gambar tidak dapat dimuat</strong><br><small>{{ $proofUrl }}</small></div>';"
                                class="proof-image">
                        </a>
                        <div class="note">Klik gambar untuk melihat ukuran penuh</div>

                        @if (!$fileExists)
                            <div class="debug-info">
                                <strong>⚠ Debug Info:</strong><br>
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
    <form form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}"
        class="status-form-pesanan">
        @csrf
        @method('PATCH')

        <label for="status" class="status-label-pesanan">Ubah Status</label>
        <select id="status" name="status" class="status-select">
            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="Sedang Diproses" {{ $order->status === 'Sedang Diproses' ? 'selected' : '' }}>Sedang
                Diproses</option>
            <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
            <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
        </select>

        <!-- Input Nomor Resi (muncul hanya jika status dikirim) -->
        <div id="tracking-number-container"
            style="display: {{ $order->status === 'dikirim' ? 'block' : 'none' }}; width: 100%;">
            <label for="tracking_number">Nomor Resi</label>
            <input type="text" id="tracking_number" name="tracking_number" class="form-input"
                value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="Masukkan nomor resi J&T"
                style="margin-top: 4px;">
        </div>

        <div class="btn-group">
            <button type="submit" class="btn-submit">Perbarui</button>
        </div>
    </form>

    <script>
        // Function to toggle tracking number field
        function toggleTrackingField() {
            const statusSelect = $('#status');
            const trackingContainer = $('#tracking-number-container');

            if (statusSelect.length && trackingContainer.length) {
                if (statusSelect.val() === 'dikirim') {
                    trackingContainer.show();
                } else {
                    trackingContainer.hide();
                }
            }
        }

        // Run on page load and after select2 initialization
        $(document).ready(function() {
            // Initialize select2 if not already initialized
            if (!$('#status').hasClass('select2-hidden-accessible')) {
                $('#status').select2({
                    width: '100%',
                    placeholder: 'Ubah Status',
                    minimumResultsForSearch: Infinity
                });
            }

            toggleTrackingField();

            // Add event listener to status select for real-time toggle
            $('#status').on('change', toggleTrackingField);
        });
    </script>

</div>

<!-- Penutup -->
<div class="penutup">
    <p class="penutup-text">
        Sistem ini terus dikembangkan untuk memberikan kemudahan maksimal dalam pengelolaan toko barang karung.
        Melalui
        pembaruan dan peningkatan fitur, pengguna dapat mengelola stok, transaksi, dan data pelanggan dengan lebih
        efisien. Dengan antarmuka yang sederhana namun fungsional, sistem ini membantu mempercepat proses
        operasional
        toko sekaligus meminimalkan kesalahan. Jelajahi berbagai fiturnya dan manfaatkan secara optimal untuk
        mendukung
        pengelolaan toko yang lebih modern dan efektif.
    </p>
</div>

@include('admin.layout.footer')

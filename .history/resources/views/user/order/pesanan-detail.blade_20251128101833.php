<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Icon web & title --}}
    <title>Detail Pesanan | Barang Karung</title>
    <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('img/icon/webb-icon.png') }}">

    <!-- Google Fonts & Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/user/nav_menu-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/pesanan-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/pesanan-detail-style.css') }}">

</head>

<body>
    <!-- ===== SECTION NAVBAR ===== -->
    <x-navbar />

    <main class="order-detail">
        <h1>Detail Pesanan Produk</h1>

        <div class="detail-card">
            <div class="detail-row">

                <!-- Kode Pesanan -->
                <div class="detail-item">
                    <div class="detail-label">Kode Pesanan</div>
                    <div class="detail-value">{{ $order->order_code }}</div>
                </div>

                <!-- Tanggal -->
                <div class="detail-item">
                    <div class="detail-label">Tanggal</div>
                    <div class="detail-value">
                        {{ $order->created_at->setTimezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }}
                    </div>
                </div>

                <!-- Status -->
                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">{{ ucfirst($order->status) }}</div>
                </div>

                <!-- Nomor Resi -->
                @if ($order->tracking_number)
                    <div class="detail-item">
                        <div class="detail-label">Nomor Resi</div>
                        <div class="detail-value">
                            {{ $order->tracking_number }}
                            @if ($order->status === 'dikirim')
                                <br>
                                <a class="resi-link" href="https://jet.co.id/track" target="_blank">
                                    Cek Status Pengiriman J&T
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Telepon -->
                <div class="detail-item">
                    <div class="detail-label">Telepon</div>
                    <div class="detail-value">{{ $order->phone }}</div>
                </div>

                <!-- Status Pembayaran -->
                <div class="detail-item">
                    <div class="detail-label">Status Pembayaran</div>
                    <div class="detail-value">
                        @if ($order->payment_method === 'dana' || $order->payment_method === 'mandiri')
                            <strong>{{ ucfirst($order->payment_status ?? '-') }}</strong>

                            @if ($order->payment_proof)
                                <br>
<<<<<<< HEAD
                                <a class="resi-link" href="{{ asset('storage/' . $order->payment_proof) }}"
                                    target="_blank">
                                    Lihat Bukti Transfer
                                </a>
=======
                                @php
                                    $isCloudProof = str_contains($order->payment_proof, 'http');
                                    $relativeProof = ltrim(str_replace('storage/', '', $order->payment_proof), '/');
                                    $proofUrl = $isCloudProof ? $order->payment_proof : asset('storage/' . $relativeProof);
                                @endphp
                                <a href="{{ $proofUrl }}" target="_blank">Lihat Bukti
                                    Transfer</a>

                            @endif
                            <br>

                            @if ($order->payment_status === 'pending')
                                Menunggu konfirmasi admin
                            @elseif($order->payment_status === 'verified')
                                Pembayaran terkonfirmasi
                            @elseif($order->payment_status === 'rejected')
                                Pembayaran ditolak, silakan hubungi admin
                            @endif
                        @else
                            Non-Transfer (Bayar di Tempat / COD)
                        @endif
                    </div>
                </div>

                <!-- Status Pemesanan -->
                <div class="detail-item">
                    <div class="detail-label">Status Pemesanan</div>
                    <div class="detail-value">{{ ucfirst($order->status) }}</div>
                </div>

                <!-- Alamat Pengiriman -->
                <div class="detail-item full">
                    <div class="detail-label">Alamat Pengiriman</div>
                    <div class="detail-value">{{ $order->shipping_address }}</div>
                </div>

            </div>

        </div>

        <div class="detail-card">
            <h3>Item Pesanan</h3>
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

        <div class="detail-card">
            @if ($order->status === 'dikirim')
                <form method="POST" action="{{ route('pesanan.selesai', $order->id) }}">
                    @csrf
                    <button type="submit" class="btn-detail">Tandai Selesai</button>
                </form>
            @endif
            <a href="{{ route('pesanan') }}" class="btn-kembali">Kembali</a>
        </div>

        <!-- Footer Informasi Tracking -->
        <div class="detail-card">
            <div class="traking-row">
                <strong>Informasi Pengiriman</strong>
                Untuk mengecek status paket/barang Anda sudah di mana, silakan kunjungi
                <a href="https://jet.co.id/track" target="_blank">
                    https://jet.co.id/track
                </a>
                Untuk informasi lebih lanjut tentang pengiriman J&T Express.
            </div>
        </div>
    </main>
</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - BarangKarung ID</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />
    <link rel="stylesheet" href="{{ asset('css/nav_menu-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pesanan-style.css') }}">
</head>

<body>
    <x-navbar />

    <main class="orders-container">
        <h1>Pesanan Saya</h1>

        @forelse ($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <p class="order-id">
                            ID Pesanan:
                            <span>#ORD-{{ $order->created_at->format('Ymd') }}-{{ sprintf('%02d', $order->id) }}</span>
                        </p>
                        <p class="order-date">Tanggal: {{ $order->created_at->translatedFormat('d F Y') }}</p>
                    </div>

                    @php
                        $statusClass = [
                            'pending' => 'pending',
                            'processing' => 'processing',
                            'shipped' => 'shipping',
                            'delivered' => 'delivered',
                            'cancelled' => 'cancelled',
                        ][$order->status] ?? 'pending';
                    @endphp

                    <div class="order-status {{ $statusClass }}">
                        {{ ucfirst($order->status) }}
                    </div>
                </div>

                @foreach ($order->items as $item)
                    <div class="order-body">
                        <img src="{{ $item->product->image_url ?? asset('img/no-image.png') }}" alt="{{ $item->product->name }}">
                        <div class="order-details">
                            <h3>{{ $item->product->name }}</h3>
                            @if ($item->size)
                                <p>Ukuran: {{ $item->size }}</p>
                            @endif
                            <p>Jumlah: {{ $item->quantity }}</p>
                            <p>Harga: Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach

                <div class="order-footer">
                    <p><strong>Total Pembayaran:</strong> Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                    <a href="{{ route('pesanan.detail', $order->id) }}" class="btn-detail">Lihat Detail</a>
                </div>
            </div>
        @empty
            <p class="no-orders">Belum ada pesanan 😔</p>
        @endforelse
    </main>
</body>
</html>

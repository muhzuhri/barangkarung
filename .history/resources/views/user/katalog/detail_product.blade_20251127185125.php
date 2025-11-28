<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- Icon web & title --}}
    <title>{{ $product->name }} | Barang Karung ID</title>
    <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('img/icon/webb-icon.png') }}">

    <!-- Google Fonts & Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/nav_menu-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/beranda-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/detail_katalog-style.css') }}">
</head>

<body>
    <!-- ===== NAVBAR ===== -->
    <x-navbar />

    <!-- ===== DETAIL PRODUK ===== -->
    <main class="product-detail">
        <div class="product-image">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
        </div>

        <div class="product-info">
            <h2 class="product-title">{{ $product->name }}</h2>

            @if ($product->brand)
                <p class="product-brand">{{ $product->brand }}</p>
            @endif

            <div class="product-prices">
                <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                @if ($product->original_price)
                    <p class="product-original">
                        <span class="line-through text-gray-500">
                            Rp {{ number_format($product->original_price, 0, ',', '.') }}
                        </span>
                    </p>
                @endif
            </div>

            <p class="product-desc">
                {{ $product->description ?? 'Deskripsi belum tersedia untuk produk ini.' }}
            </p>

            <p class="product-stock">
                <strong>Stok:</strong> {{ $product->stock > 0 ? $product->stock : 'Habis' }}
            </p>

            @if ($product->size)
                <p class="product-stock">
                    <strong>Ukuran:</strong> {{ $product->size }}
                </p>
            @endif

            
        </div>
    </main>

    <!-- ===== SECTION FOOTER ===== -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 <span class="brand">Barang Karung ID</span>. Semua Hak Dilindungi.</p>
            <div class="footer-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat & Ketentuan</a>
                <a href="#">Kontak Kami</a>
            </div>
        </div>
    </footer>
</body>

</html>

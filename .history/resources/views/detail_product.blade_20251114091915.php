<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $product->name }} | Barang Karung ID</title>

    <!-- Google Fonts & Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/nav_menu-style.css') }}">
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

            @if($product->brand)
                <p class="product-brand">{{ $product->brand }}</p>
            @endif

            <div class="product-prices">
                <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                @if($product->original_price)
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

            @if($product->size)
            <p class="product-stock">
                <strong>Ukuran:</strong> {{ $product->size }}
            </p>
            @endif

            <div class="product-actions">
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    @if($product->size)
                        <input type="hidden" name="size" value="{{ $product->size }}">
                    @endif
                    <button type="submit" class="btn btn-primary">
                        <span class="material-icons">shopping_cart</span> Masukkan ke Keranjang
                    </button>
                </form>

                {{-- <a href="{{ route('checkout') }}" class="btn btn-outline">
                    <span class="material-icons">bolt</span> Beli Sekarang
                </a> --}}
            </div>
        </div>
    </main>

    <!-- ===== PRODUK REKOMENDASI ===== -->
    {{-- <section class="product-recommendations">
        <h3>Produk Lainnya</h3>
        <div class="recommendation-list">
            @foreach($relatedProducts as $related)
                <div class="card">
                    <a href="{{ route('produk.show', $related->id) }}">
                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}">
                        <p>{{ $related->name }}</p>
                        <span>Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                    </a>
                </div>
            @endforeach
        </div>
    </section> --}}
</body>

</html>

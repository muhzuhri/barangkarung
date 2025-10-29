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
    <link rel="stylesheet" href="{{ asset('css/nav_menu-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail_katalog-style.css') }}">
</head>

<body>
    <!-- ===== NAVBAR ===== -->
    <x-navbar />

    <!-- ===== DETAIL PRODUK ===== -->
    <main class="product-detail">
        <div class="product-image">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <img src="{{ asset('img/no-image.png') }}" alt="Tidak ada gambar">
            @endif
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

            <div class="product-actions">
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
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

<script>
     // Add to cart from modal
        document.getElementById('addToCartModal').addEventListener('click', function() {
            const selectedSize = document.querySelector('.size-btn.selected').getAttribute('data-size');
            const quantity = parseInt(document.getElementById('modalQtyDisplay').textContent);

            // Get current product ID from the modal
            const currentProduct = products.find(p =>
                document.getElementById('modalProductName').textContent === p.name
            );
            const productId = currentProduct ? currentProduct.id : null;

            const originalText = this.innerHTML;

            // Disable button dan ubah text dengan animasi loading
            this.disabled = true;
            this.innerHTML =
                '<span style="display: inline-block; animation: spin 1s linear infinite;">⟳</span> Menambahkan...';

            // Kirim request ke server
            fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity,
                        size: selectedSize
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.innerHTML = '<span style="color: #4CAF50;">✓ Ditambahkan!</span>';

                        // Close modal after 1 second
                        setTimeout(() => {
                            closeModal();
                            this.disabled = false;
                            this.innerHTML = originalText;
                        }, 1000);

                        // Tampilkan notifikasi sukses dengan efek
                        notifications.success(data.message, {
                            title: 'Berhasil!',
                            duration: 5000,
                            sound: true,
                            vibration: true
                        });
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.disabled = false;
                    this.innerHTML = originalText;
                    notifications.error('Gagal menambahkan ke keranjang', {
                        title: 'Error!',
                        duration: 3000,
                        sound: true,
                        vibration: true
                    });
                });
        });
</script>
</html>

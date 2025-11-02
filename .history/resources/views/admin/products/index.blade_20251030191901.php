@include('admin.layout.header')
<title>Produk Admin | BK</title>

<div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>

<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Daftar Produk</h1>
    <a href="{{ route('admin.products.create') }}" class="btn-primary">
        <img src="/images/add-product.png" alt="Tambah Produk" class="btn-icon">
        Tambah Produk Baru
    </a>
</div>

@if ($products->count() > 0)
    <div class="products-grid">
        @foreach ($products as $product)
            <div class="product-card">
                @if ($product->image)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <div class="product-image"
                        style="background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999;">
                        Tidak Ada Gambar
                    </div>
                @endif

                <div class="product-info">
                    <h3 class="product-name">{{ $product->name }}</h3>
                    @if ($product->brand)
                        <p class="product-brand">Brand: {{ $product->brand }}</p>
                    @endif
                    <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    @if ($product->original_price && $product->original_price > $product->price)
                        <p style="font-size: 0.9rem; color: #999; text-decoration: line-through;">
                            Rp {{ number_format($product->original_price, 0, ',', '.') }}
                        </p>
                    @endif
                    <p class="product-stock">Stok: {{ $product->stock }}</p>

                    <span class="product-status {{ $product->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>

                    <div class="product-actions">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-secondary">Edit</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}"
                            style="display: inline;"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="no-products">
        <h3>Belum ada produk</h3>
        <p>Klik tombol "Tambah Produk Baru" untuk menambahkan produk pertama Anda.</p>
    </div>
@endif


@include('admin.layout.footer')

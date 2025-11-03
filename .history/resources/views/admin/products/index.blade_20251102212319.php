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
    <h1 class="page-title">
        <img src={{ asset('img/icon/daftar-icon.png') }} alt="Icon Produk" class="title-icon">
        Daftar Produk
    </h1>

    <a href="{{ route('admin.products.create') }}" class="btn-tambah">
        <img src={{ asset('img/icon/tambah-icon.png') }} alt="Tambah Produk" class="btn-icon">
        Tambah Produk Baru
    </a>
</div>

@if ($products->count() > 0)
    <div class="catalog-container">
        @foreach ($products as $product)
            <div class="catalog-card">
                <div class="catalog-image">
                    @if ($product->image)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    @else
                        <div class="no-image">Tidak Ada Gambar</div>
                    @endif

                    <!-- STATUS PINDAH KE SINI -->
                    <span class="product-status {{ $product->is_active ? 'active' : 'inactive' }}">
                        {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>

                <div class="catalog-details">
                    <h3 class="product-name">{{ $product->name }}</h3>

                    @if ($product->brand)
                        <p class="product-brand">{{ $product->brand }}</p>
                    @endif

                    <div class="product-pricing">
                        <span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @if ($product->original_price && $product->original_price > $product->price)
                            <span class="product-original">
                                Rp {{ number_format($product->original_price, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>

                    <p class="product-stock">Stok: {{ $product->stock }}</p>

                    <div class="product-actions">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-edit-katalog"
                            title="Edit Produk">
                            <img src="{{ asset('img/icon/ubah-icon.png') }}" alt="Edit" class="action-icon">
                        </a>

                        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-katalog" title="Hapus Produk">
                                <img src="{{ asset('img/icon/hapus-icon.png') }}" alt="Hapus" class="table-icon-katalog">
                            </button>
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

<!-- Penutup -->
<div class="penutup">
    <p class="penutup-text">
        Sistem ini terus berkembang untuk memberikan kemudahan dalam pengelolaan toko barang karung.
        Jangan ragu untuk menjelajahi lebih banyak fitur dan manfaatkan semaksimal mungkin.
    </p>
</div>

@include('admin.layout.footer')

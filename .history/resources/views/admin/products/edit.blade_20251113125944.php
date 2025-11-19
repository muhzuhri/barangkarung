@include('admin.layout.header')
<title>Edit Produk | BK</title>

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

<div class="page-header">
    <h1 class="page-title">
        <img src={{ asset('img/icon/ubah-icon.png') }} alt="Icon Produk" class="title-icon">
        Ubah Data Produk
    </h1>
    <a href="{{ route('admin.products.index') }}" class="btn-kembali">
        <img src={{ asset('img/icon/kembali-icon.png') }} alt="Tambah Produk" class="btn-icon-kembali">
    </a>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
    class="form-container">
    @csrf
    <!-- Header Form -->
    <div class="form-header">
        <h2 class="form-title">Form Pengubahan Data Produk</h2>
        <p class="form-subtitle">Isi detail produk dengan lengkap agar tampil optimal di etalase toko.</p>
    </div>

    @method('PUT')
    <div class="form-body">
        <div class="form-group">
            <label for="name" class="form-label">Nama Produk *</label>
            <input type="text" id="name" name="name" class="form-input"
                value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="form-group">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" id="brand" name="brand" class="form-input"
                value="{{ old('brand', $product->brand) }}">
        </div>

        <div class="form-group">
            <label for="size" class="form-label">Ukuran (opsional)</label>
            <input type="text" id="size" name="size" class="form-input" maxlength="10"
                value="{{ old('size', $product->size) }}">
        </div>

        <div class="form-group">
            <label for="price" class="form-label">Harga (Rp) *</label>
            <input type="number" id="price" name="price" class="form-input" step="0.01"
                value="{{ old('price', $product->price) }}" required>
        </div>

        <div class="form-group">
            <label for="original_price" class="form-label">Harga Asli (Rp)</label>
            <input type="number" id="original_price" name="original_price" class="form-input" step="0.01"
                value="{{ old('original_price', $product->original_price) }}">
        </div>

        <div class="form-group">
            <label for="stock" class="form-label">Stok *</label>
            <input type="number" id="stock" name="stock" class="form-input" min="0"
                value="{{ old('stock', $product->stock) }}" required>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea id="description" name="description" class="form-textarea" rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="is_active" class="form-label">Status</label>
            <select id="is_active" name="is_active" class="form-input">
                <option value="1" {{ old('is_active', $product->is_active) ? 'selected' : '' }}>Aktif
                </option>
                <option value="0" {{ !old('is_active', $product->is_active) ? 'selected' : '' }}>Tidak Aktif
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="image" class="form-label">Gambar Produk</label>
            <input type="file" id="image" name="image" class="form-file-edit" accept="image/*">
            @if ($product->image)
                <div class="current-image">
                    <p class="form-label">Gambar saat ini:</p>
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                </div>
            @endif
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.products.index') }}" class="btn-batal">Batal</a>
        <button type="submit" class="btn-submit">Simpan Pembaruan</button>
    </div>
</form>

@include('admin.layout.footer')

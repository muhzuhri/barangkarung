@include('admin.layout.header')
<title>Tambah Produk | BK</title>

<div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
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
        <img src={{ asset('img/icon/tambah-icon.png') }} alt="Icon Produk" class="title-icon">
        Tambah Produk Baru
    </h1>
    <a href="{{ route('admin.products.index') }}" class="btn-kembali">
        <img src={{ asset('img/icon/kembali-icon.png') }} alt="Tambah Produk" class="btn-icon-kembali">
    </a>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="form-container">
    @csrf

    <h2 class="form-title">Form Penambahan Produk Baru</h2>
    <p class="form-subtitle">Lengkapi detail produk dengan teliti sebelum disimpan.</p>

    <div class="form-grid">
        <div class="form-group">
            <label for="name" class="form-label">Nama Produk :</label>
            <input type="text" id="name" name="name" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="brand" class="form-label">Brand/ Merk :</label>
            <input type="text" id="brand" name="brand" class="form-input">
        </div>

        <div class="form-group form-full">
            <label for="description" class="form-label">Deskripsi :</label>
            <textarea id="description" name="description" class="form-textarea" rows="4" placeholder="Tuliskan deskripsi singkat produk..."></textarea>
        </div>

        <div class="form-group">
            <label for="price" class="form-label">Harga Produk :</label>
            <input type="number" id="price" name="price" class="form-input" min="0" step="100" required>
        </div>

        <div class="form-group">
            <label for="original_price" class="form-label">Harga Asli (untuk diskon) :</label>
            <input type="number" id="original_price" name="original_price" class="form-input" min="0" step="100">
        </div>

        <div class="form-group">
            <label for="stock" class="form-label">Stok Produk :</label>
            <input type="number" id="stock" name="stock" class="form-input" min="0" required>
        </div>

        <div class="form-group">
            <label for="image" class="form-label">Gambar Produk</label>
            <input type="file" id="image" name="image" class="form-file" accept="image/*">
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.products.index') }}" class="btn-batal">Batal</a>
        <button type="submit" class="btn-submit">Simpan Produk</button>
    </div>
</form>


@include('admin.layout.footer')

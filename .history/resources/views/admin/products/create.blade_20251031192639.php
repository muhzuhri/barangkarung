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

    <!-- Header Form -->
    <div class="form-header">
        <h2 class="form-title"Tambah Produk Baru</h2>
        <p class="form-subtitle">Isi detail produk dengan lengkap agar tampil optimal di etalase toko.</p>
    </div>

    <!-- Form Body -->
    <div class="form-body">
        <div class="form-group">
            <label for="name" class="form-label">Nama Produk <span class="required">*</span></label>
            <input type="text" id="name" name="name" class="form-input" placeholder="Contoh: Jaket Oversize Denim" required>
        </div>

        <div class="form-group">
            <label for="brand" class="form-label">Brand / Merk</label>
            <input type="text" id="brand" name="brand" class="form-input" placeholder="Contoh: Uniqlo, H&M">
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Deskripsi Produk</label>
            <textarea id="description" name="description" class="form-textarea" rows="4" placeholder="Tuliskan deskripsi singkat produk..."></textarea>
        </div>

        <div class="form-group">
            <label for="price" class="form-label">Harga Produk <span class="required">*</span></label>
            <div class="input-with-prefix">
                <span class="prefix">Rp</span>
                <input type="number" id="price" name="price" class="form-input" min="0" step="100" placeholder="0" required>
            </div>
        </div>

        <div class="form-group">
            <label for="original_price" class="form-label">Harga Asli (Sebelum Diskon)</label>
            <div class="input-with-prefix">
                <span class="prefix">Rp</span>
                <input type="number" id="original_price" name="original_price" class="form-input" min="0" step="100" placeholder="0">
            </div>
        </div>

        <div class="form-group">
            <label for="stock" class="form-label">Stok Produk <span class="required">*</span></label>
            <input type="number" id="stock" name="stock" class="form-input" min="0" placeholder="Contoh: 20" required>
        </div>

        <div class="form-group">
            <label for="image" class="form-label">Gambar Produk</label>
            <div class="file-upload-box">
                <input type="file" id="image" name="image" class="form-file" accept="image/*">
                <p class="file-hint">📁 Pilih gambar berformat JPG, JPEG, atau PNG</p>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="form-actions">
        <a href="{{ route('admin.products.index') }}" class="btn-batal">Batal</a>
        <button type="submit" class="btn-submit">Simpan Produk</button>
    </div>
</form>


@include('admin.layout.footer')

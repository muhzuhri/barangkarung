@include('admin.layout.header')
<title>Tambah Produk | BK</title>

<div class="page-header">
    <h1 class="page-title">Tambah Produk Baru</h1>
    <a href="{{ route('admin.products.index') }}" class="btn-secondary">← Kembali</a>
</div>


<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="form-container">
    @csrf

    <div class="form-group">
        <label for="name" class="form-label">Nama Produk *</label>
        <input type="text" id="name" name="name" class="form-input" required>
    </div>

    <div class="form-group">
        <label for="brand" class="form-label">Brand</label>
        <input type="text" id="brand" name="brand" class="form-input">
    </div>

    <div class="form-group">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea id="description" name="description" class="form-textarea" rows="4"></textarea>
    </div>

    <div class="form-group">
        <label for="price" class="form-label">Harga *</label>
        <input type="number" id="price" name="price" class="form-input" min="0" step="100" required>
    </div>

    <div class="form-group">
        <label for="original_price" class="form-label">Harga Asli (untuk diskon)</label>
        <input type="number" id="original_price" name="original_price" class="form-input" min="0" step="100">
    </div>

    <div class="form-group">
        <label for="stock" class="form-label">Stok *</label>
        <input type="number" id="stock" name="stock" class="form-input" min="0" required>
    </div>

    <div class="form-group">
        <label for="image" class="form-label">Gambar Produk</label>
        <input type="file" id="image" name="image" class="form-file" accept="image/*">
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.products.index') }}" class="btn-cancel">Batal</a>
        <button type="submit" class="btn-submit">Simpan Produk</button>
    </div>
</form>

@include('admin.layout.footer')

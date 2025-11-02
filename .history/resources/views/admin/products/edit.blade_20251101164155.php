@include('admin.layout.header')
<title>Edit | BK</title>

{{-- <style>
    .form-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .form-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .form-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .form-subtitle {
        color: #666;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #333;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .current-image {
        margin-top: 1rem;
    }

    .current-image img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 2px solid #f0f0f0;
    }

    .btn-cancel,
    .btn-submit {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-cancel {
        background: #f0f0f0;
        color: #666;
    }

    .btn-cancel:hover {
        background: #e0e0e0;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: background 0.3s ease;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: background 0.3s ease;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        font-weight: 500;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert ul {
        margin: 0;
        padding-left: 1.5rem;
    }

    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            gap: 1rem;
        }

        .container {
            padding: 0 1rem;
        }

        .form-card {
            padding: 1rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }
    }
</style> --}}

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
    </div>


    <div class="form-group">
        <label for="image" class="form-label">Gambar Produk</label>
        <input type="file" id="image" name="image" class="form-file" accept="image/*">
        @if ($product->image)
            <div class="current-image">
                <p class="form-label">Gambar saat ini:</p>
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            </div>
        @endif
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.products.index') }}" class="btn-batal">Batal</a>
        <button type="submit" class="btn-submit">Simpan Pembaruan</button>
    </div>
</form>

@include('admin.layout.footer')

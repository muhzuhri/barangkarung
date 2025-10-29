@layout('admin.layout.header')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-error">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="form-card">
    <div class="form-header">
        <h1 class="form-title">Edit Produk</h1>
        <p class="form-subtitle">Perbarui informasi produk</p>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label for="name">Nama Produk *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-group">
                <label for="brand">Brand</label>
                <input type="text" id="brand" name="brand" value="{{ old('brand', $product->brand) }}">
            </div>

            <div class="form-group">
                <label for="size">Ukuran (opsional)</label>
                <input type="text" id="size" name="size" maxlength="10" value="{{ old('size', $product->size) }}">
            </div>

            <div class="form-group">
                <label for="price">Harga (Rp) *</label>
                <input type="number" id="price" name="price" step="0.01"
                    value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="form-group">
                <label for="original_price">Harga Asli (Rp)</label>
                <input type="number" id="original_price" name="original_price" step="0.01"
                    value="{{ old('original_price', $product->original_price) }}">
            </div>

            <div class="form-group">
                <label for="stock">Stok *</label>
                <input type="number" id="stock" name="stock" min="0" value="{{ old('stock', $product->stock) }}"
                    required>
            </div>

            <div class="form-group">
                <label for="is_active">Status</label>
                <select id="is_active" name="is_active">
                    <option value="1" {{ old('is_active', $product->is_active) ? 'selected' : '' }}>Aktif
                    </option>
                    <option value="0" {{ !old('is_active', $product->is_active) ? 'selected' : '' }}>Tidak Aktif
                    </option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="image">Gambar Produk</label>
            <input type="file" id="image" name="image" accept="image/*">
            @if($product->image)
            <div class="current-image">
                <p style="margin-bottom: 0.5rem; font-weight: 600;">Gambar saat ini:</p>
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            </div>
            @endif
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description"
                rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.products.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">Perbarui Produk</button>
        </div>
    </form>
</div>
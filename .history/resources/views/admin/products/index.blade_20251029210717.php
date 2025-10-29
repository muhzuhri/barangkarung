@include('admin.layout.header')
<title>Produk Admin | BK</title>

<style>
    .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 3000; /* dinaikkan */
}

.modal-overlay.active {
    display: flex !important;
}

.modal-content {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    max-width: 600px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    transform: scale(0.95);
    opacity: 0;
    transition: all 0.3s ease;
}

.modal-overlay.active .modal-content {
    transform: scale(1);
    opacity: 1;
}

    .container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 2rem;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
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

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .product-image {
        width: 100%;
        height: auto;
        max-height: 200px;
        object-fit: contain;
    }

    .product-info {
        padding: 1.5rem;
    }

    .product-name {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .product-brand {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .product-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .product-stock {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 1rem;
    }

    .product-status {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .status-active {
        background: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }

    .product-actions {
        display: flex;
        gap: 0.5rem;
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

    .no-products {
        text-align: center;
        padding: 3rem;
        color: #666;
    }

    .no-products h3 {
        margin-bottom: 1rem;
        color: #333;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 2000;
    }

    .modal-content {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #6b7280;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        background: #f3f4f6;
        color: #374151;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #374151;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1rem;
        resize: vertical;
        min-height: 100px;
        transition: border-color 0.3s ease;
    }

    .form-textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-file {
        width: 100%;
        padding: 0.75rem;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        background: #f9fafb;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .form-file:hover {
        border-color: #667eea;
        background: #f0f4ff;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-cancel:hover {
        background: #5a6268;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .loading {
        display: none;
        text-align: center;
        padding: 1rem;
    }

    .spinner {
        border: 3px solid #f3f4f6;
        border-top: 3px solid #667eea;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            gap: 1rem;
        }

        .container {
            padding: 0 1rem;
        }

        .page-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .products-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container">
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

        <div class="page-header">
            <h1 class="page-title">Kelola Produk</h1>
            <button onclick="toggleAddProductForm()" class="btn-primary">Tambah Produk Baru</button>
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

                            <span
                                class="product-status {{ $product->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>

                            <div class="product-actions">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="btn-secondary">Edit</a>
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
    </div>

<!-- Modal Form Tambah Produk -->
<div id="addProductModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Tambah Produk Baru</h2>
            <button class="modal-close" onclick="toggleAddProductForm()">&times;</button>
        </div>

        <form id="addProductForm" enctype="multipart/form-data">
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
                <input type="number" id="price" name="price" class="form-input" min="0" step="100"
                    required>
            </div>

            <div class="form-group">
                <label for="original_price" class="form-label">Harga Asli (untuk diskon)</label>
                <input type="number" id="original_price" name="original_price" class="form-input" min="0"
                    step="100">
            </div>

            <div class="form-group">
                <label for="stock" class="form-label">Stok *</label>
                <input type="number" id="stock" name="stock" class="form-input" min="0" required>
            </div>

            <div class="form-group">
                <label for="image" class="form-label">Gambar Produk</label>
                <input type="file" id="image" name="image" class="form-file" accept="image/*">
            </div>

            <div class="loading" id="loadingIndicator">
                <div class="spinner"></div>
                <p>Menyimpan produk...</p>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="toggleAddProductForm()">Batal</button>
                <button type="submit" class="btn-submit" id="submitBtn">Simpan Produk</button>
            </div>
        </form>
    </div>

</div>

<script>
    function toggleAddProductForm() {
        const modal = document.getElementById('addProductModal');
        modal.classList.toggle('active'); // gunakan class toggle

        if (modal.classList.contains('active')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
            resetForm();
        }
    }

    function resetForm() {
        const form = document.getElementById('addProductForm');
        if (form) form.reset();

        const loading = document.getElementById('loadingIndicator');
        const submitBtn = document.getElementById('submitBtn');

        if (loading) loading.style.display = 'none';
        if (submitBtn) submitBtn.disabled = false;
    }

    // Tutup modal saat klik di luar
    document.getElementById('addProductModal').addEventListener('click', function (e) {
        if (e.target === this) toggleAddProductForm();
    });

    // Tutup modal dengan tombol ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('addProductModal');
            if (modal.classList.contains('active')) toggleAddProductForm();
        }
    });

    // Kirim form pakai AJAX
    document.getElementById('addProductForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = document.getElementById('submitBtn');
        const loadingIndicator = document.getElementById('loadingIndicator');

        submitBtn.disabled = true;
        loadingIndicator.style.display = 'block';

        fetch('{{ route('admin.products.store') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Produk berhasil ditambahkan!', 'success');
                toggleAddProductForm();

                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showNotification(data.message || 'Terjadi kesalahan saat menyimpan produk', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat menyimpan produk', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            loadingIndicator.style.display = 'none';
        });
    });

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'error'}`;
        notification.textContent = message;

        Object.assign(notification.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            zIndex: '3000',
            minWidth: '300px',
            padding: '1rem',
            borderRadius: '8px',
            boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)',
            backgroundColor: type === 'success' ? '#16a34a' : '#dc2626',
            color: 'white'
        });

        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }
</script>


@include('admin.layout.footer')

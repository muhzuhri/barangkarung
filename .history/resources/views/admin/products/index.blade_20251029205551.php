@include('admin.layout.header')
<title>Produk Admin | BK</title>

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

<div class="container"></div>
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

    <script>

        function toggleAddProductForm() {
            const modal = document.getElementById('addProductModal');
            if (modal.style.display === 'none' || modal.style.display === '') {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            } else {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
                resetForm();
            }
        }

        function resetForm() {
            document.getElementById('addProductForm').reset();
            document.getElementById('loadingIndicator').style.display = 'none';
            document.getElementById('submitBtn').disabled = false;
        }


        // Close modal when clicking outside
        document.getElementById('addProductModal').addEventListener('click', function(e) {
            if (e.target === this) {
                toggleAddProductForm();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('addProductModal');
                if (modal.style.display === 'flex') {
                    toggleAddProductForm();
                }
            }
        });

        // Handle form submission
        document.getElementById('addProductForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = document.getElementById('submitBtn');
            const loadingIndicator = document.getElementById('loadingIndicator');

            // Show loading state
            submitBtn.disabled = true;
            loadingIndicator.style.display = 'block';

            // Send AJAX request
            fetch('{{ route('admin.products.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        showNotification('Produk berhasil ditambahkan!', 'success');

                        // Close modal
                        toggleAddProductForm();

                        // Reload page to show new product
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        // Show error message
                        showNotification(data.message || 'Terjadi kesalahan saat menyimpan produk', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan saat menyimpan produk', 'error');
                })
                .finally(() => {
                    // Hide loading state
                    submitBtn.disabled = false;
                    loadingIndicator.style.display = 'none';
                });
        });

        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'error'}`;
            notification.textContent = message;
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.zIndex = '3000';
            notification.style.minWidth = '300px';
            notification.style.padding = '1rem';
            notification.style.borderRadius = '8px';
            notification.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';

            document.body.appendChild(notification);

            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>

</div>



@include('admin.layout.footer')

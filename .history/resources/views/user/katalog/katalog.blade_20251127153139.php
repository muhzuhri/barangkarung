<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- Icon web & title --}}
    <title>Katalog | Barang Karung</title>
    <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('img/icon/webb-icon.png') }}">

    <!-- Google Fonts & Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/nav_menu-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/beranda-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/katalog-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/product-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
</head>

<body>
    <!-- ===== SECTION NAVBAR ===== -->
    <x-navbar />

    <!-- ===== SECTION IMAGE SLIDER / BERANDA ===== -->
    <section class="hero-slider">
        <div class="slides">
            <div class="slide active">
                <img src="{{ asset('img/img/pict1.jpg') }}" alt="Slide 1">
            </div>
            <div class="slide">
                <img src="{{ asset('img/img/pict2.jpg') }}" alt="Slide 2">
            </div>
            <div class="slide">
                <img src="{{ asset('img/img/pict3.jpg') }}" alt="Slide 3">
            </div>
            <div class="slide">
                <img src="{{ asset('img/img/pict4.jpg') }}" alt="Slide 4">
            </div>
            <div class="slide">
                <img src="{{ asset('img/img/pict5.jpg') }}" alt="Slide 5">
            </div>
        </div>

        <!-- Tombol navigasi -->
        <button class="prev"><span class="material-icons">chevron_left</span></button>
        <button class="next"><span class="material-icons">chevron_right</span></button>
    </section>

    <!-- ===== SECTION KATALOG PAKAIAN ===== -->
    <section class="katalog-section">
        <h2>Katalog Pakaian</h2>
        <div class="product-grid">
            @foreach ($products as $product)
                <div class="product-card">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    <a href="{{ route('produk.show', $product->id) }}">{{ $product->name }}</a>
                    <p class="brand">{{ $product->brand }}</p>
                    <div class="price">
                        <span class="discount">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @if ($product->original_price)
                            <span class="original">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                            <span class="off">-{{ $product->discount_percentage }}%</span>
                        @endif
                    </div>
                    <button class="btn-cart" data-product-id="{{ $product->id }}">Masukkan ke Tas</button>
                </div>
            @endforeach
        </div>
    </section>

    <!-- ===== SECTION FOOTER ===== -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 <span class="brand">Barang Karung ID</span>. Semua Hak Dilindungi.</p>
            <div class="footer-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat & Ketentuan</a>
                <a href="#">Kontak Kami</a>
            </div>
        </div>
    </footer>

    <!-- ===== SECTION PRODUCT DETAIL MODAL ===== -->
    <div class="product-modal" id="productModal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <button class="modal-close" id="modalClose">&times;</button>
            <div class="modal-body">
                <div class="product-image-section">
                    <img id="modalProductImage" src="" alt="Product Image">
                </div>
                <div class="product-details-section">
                    <h3 id="modalProductName"></h3>
                    <p class="product-brand" id="modalProductBrand"></p>
                    <div class="product-price-section">
                        <span class="current-price" id="modalProductPrice"></span>
                        <span class="original-price" id="modalOriginalPrice"></span>
                        <span class="discount-badge" id="modalDiscountBadge"></span>
                    </div>
                    <div class="product-description">
                        <p id="modalProductDescription"></p>
                    </div>

                    <!-- Size Selection -->
                    <div class="size-selection">
                        <label>Ukuran:</label>
                        <div class="size-options">
                            <button class="size-btn" data-size="S">S</button>
                            <button class="size-btn" data-size="M">M</button>
                            <button class="size-btn" data-size="L">L</button>
                            <button class="size-btn" data-size="XL">XL</button>
                            <button class="size-btn" data-size="XXL">XXL</button>
                        </div>
                    </div>

                    <!-- Quantity Selection -->
                    <div class="quantity-selection">
                        <label>Jumlah:</label>
                        <div class="quantity-controls">
                            <button class="qty-btn minus" id="modalQtyMinus">-</button>
                            <span class="qty-display" id="modalQtyDisplay">1</span>
                            <button class="qty-btn plus" id="modalQtyPlus">+</button>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <button class="add-to-cart-modal-btn" id="addToCartModal">
                        <span class="btn-text">Masukkan ke Keranjang</span>
                        <span class="btn-price" id="modalTotalPrice"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>

<!-- Modern Notifications -->
<script src="{{ asset('js/modern-notifications.js') }}"></script>

<script>
    const slides = document.querySelectorAll('.slide');
    const nextBtn = document.querySelector('.next');
    const prevBtn = document.querySelector('.prev');
    let index = 0;

    function showSlide(n) {
        if (n >= slides.length) index = 0;
        else if (n < 0) index = slides.length - 1;
        else index = n;

        document.querySelector('.slides').style.transform = `translateX(-${index * 100}%)`;
    }

    nextBtn.addEventListener('click', () => showSlide(index + 1));
    prevBtn.addEventListener('click', () => showSlide(index - 1));

    // Auto slide tiap 4 detik
    setInterval(() => showSlide(index + 1), 4000);

    // Cart functionality
    document.addEventListener('DOMContentLoaded', function() {
        const cartButtons = document.querySelectorAll('.btn-cart');
        const productModal = document.getElementById('productModal');
        const modalClose = document.getElementById('modalClose');
        const modalOverlay = document.querySelector('.modal-overlay');

        // Product data from server
        const products = @json($products);

        cartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const product = products.find(p => p.id == productId);

                if (product) {
                    showProductModal(product);
                }
            });
        });

        // Modal close functionality
        modalClose.addEventListener('click', closeModal);
        modalOverlay.addEventListener('click', closeModal);

        // ESC key to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && productModal.classList.contains('show')) {
                closeModal();
            }
        });

        function showProductModal(product) {
            // Populate modal with product data
            document.getElementById('modalProductImage').src = product.image_url;
            document.getElementById('modalProductName').textContent = product.name;
            document.getElementById('modalProductBrand').textContent = product.brand;
            document.getElementById('modalProductPrice').textContent =
                `Rp ${parseInt(product.price).toLocaleString('id-ID')}`;
            document.getElementById('modalProductDescription').textContent = product.description ||
                'Produk berkualitas tinggi dengan desain yang trendy dan nyaman digunakan.';

            // Handle original price and discount
            const originalPriceEl = document.getElementById('modalOriginalPrice');
            const discountBadgeEl = document.getElementById('modalDiscountBadge');

            if (product.original_price && product.original_price > product.price) {
                originalPriceEl.textContent = `Rp ${parseInt(product.original_price).toLocaleString('id-ID')}`;
                originalPriceEl.style.display = 'inline';
                discountBadgeEl.textContent = `-${product.discount_percentage}%`;
                discountBadgeEl.style.display = 'inline';
            } else {
                originalPriceEl.style.display = 'none';
                discountBadgeEl.style.display = 'none';
            }

            // Reset modal state
            resetModalState();
            updateTotalPrice(product);

            // Show modal
            productModal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            productModal.classList.remove('show');
            document.body.style.overflow = '';
        }

        function resetModalState() {
            // Reset quantity
            document.getElementById('modalQtyDisplay').textContent = '1';

            // Reset size selection
            document.querySelectorAll('.size-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            // Select M by default
            document.querySelector('.size-btn[data-size="M"]').classList.add('selected');
        }

        // Size selection
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.size-btn').forEach(b => b.classList.remove(
                    'selected'));
                this.classList.add('selected');
            });
        });

        // Quantity controls
        document.getElementById('modalQtyMinus').addEventListener('click', function() {
            const qtyDisplay = document.getElementById('modalQtyDisplay');
            let qty = parseInt(qtyDisplay.textContent);
            if (qty > 1) {
                qty--;
                qtyDisplay.textContent = qty;
                const currentProduct = products.find(p =>
                    document.getElementById('modalProductName').textContent === p.name
                );
                if (currentProduct) updateTotalPrice(currentProduct);
            }
        });

        document.getElementById('modalQtyPlus').addEventListener('click', function() {
            const qtyDisplay = document.getElementById('modalQtyDisplay');
            let qty = parseInt(qtyDisplay.textContent);
            qty++;
            qtyDisplay.textContent = qty;
            const currentProduct = products.find(p =>
                document.getElementById('modalProductName').textContent === p.name
            );
            if (currentProduct) updateTotalPrice(currentProduct);
        });

        // Add to cart from modal
        document.getElementById('addToCartModal').addEventListener('click', function() {
            const selectedSize = document.querySelector('.size-btn.selected').getAttribute('data-size');
            const quantity = parseInt(document.getElementById('modalQtyDisplay').textContent);

            // Get current product ID from the modal
            const currentProduct = products.find(p =>
                document.getElementById('modalProductName').textContent === p.name
            );
            const productId = currentProduct ? currentProduct.id : null;

            const originalText = this.innerHTML;

            // Disable button dan ubah text dengan animasi loading
            this.disabled = true;
            this.innerHTML =
                '<span style="display: inline-block; animation: spin 1s linear infinite;">⟳</span> Menambahkan...';

            // Kirim request ke server
            fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity,
                        size: selectedSize
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.innerHTML = '<span style="color: #4CAF50;">✓ Ditambahkan!</span>';

                        // Close modal after 1 second
                        setTimeout(() => {
                            closeModal();
                            this.disabled = false;
                            this.innerHTML = originalText;
                        }, 1000);

                        // Tampilkan notifikasi sukses dengan efek
                        notifications.success(data.message, {
                            title: 'Berhasil!',
                            duration: 5000,
                            sound: true,
                            vibration: true
                        });
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.disabled = false;
                    this.innerHTML = originalText;
                    notifications.error('Gagal menambahkan ke keranjang', {
                        title: 'Error!',
                        duration: 3000,
                        sound: true,
                        vibration: true
                    });
                });
        });

        function updateTotalPrice(product) {
            const quantity = parseInt(document.getElementById('modalQtyDisplay').textContent);
            const totalPrice = product.price * quantity;
            document.getElementById('modalTotalPrice').textContent =
                `Rp ${parseInt(totalPrice).toLocaleString('id-ID')}`;
        }
    });
</script>

</html>

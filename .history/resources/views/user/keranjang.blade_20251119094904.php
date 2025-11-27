<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
{{-- Icon web & title --}}
    <title>Beranda | Barang Karung</title>
    <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('img/icon/webb-icon.png') }}">
    
    <!-- Google Fonts & Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/nav_menu-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/keranjang-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
</head>

<body>
    <!-- ===== NAVBAR ===== -->
    <x-navbar />

    <!-- ===== KERANJANG ===== -->
    <section class="keranjang-container">
        @if ($cartItems->count() > 0)
            @foreach ($cartItems as $cartItem)
                <div class="keranjang-item" data-cart-id="{{ $cartItem->id }}">
                    <input type="checkbox" class="item-check" data-price="{{ $cartItem->product->price }}"
                        data-quantity="{{ $cartItem->quantity }}">
                    <img src="{{ asset($cartItem->product->image) }}" alt="{{ $cartItem->product->name }}">
                    <div class="item-info">
                        <h4>{{ $cartItem->product->name }}</h4>
                        <p>Rp {{ number_format($cartItem->product->price, 0, ',', '.') }}</p>
                        <small>Ukuran: {{ $cartItem->size }} | Tambahkan Kode Voucher ></small>
                    </div>
                    <div class="item-qty">
                        <button class="qty-btn minus" data-cart-id="{{ $cartItem->id }}">-</button>
                        <span class="qty">{{ $cartItem->quantity }}</span>
                        <button class="qty-btn plus" data-cart-id="{{ $cartItem->id }}">+</button>
                    </div>
                    <button class="remove-btn" data-cart-id="{{ $cartItem->id }}">×</button>
                </div>
            @endforeach

            <div class="checkout-bar">
                <div class="checkout-left">
                    <input type="checkbox" id="select-all"> <label for="select-all">Pilih Semua</label>
                    <button class="clear-all-btn" id="clear-all">Hapus Semua</button>
                </div>
                <div class="checkout-right">
                    <form id="checkout-form" method="GET" action="{{ route('checkout') }}">
                        <input type="hidden" name="selected_items" id="selected-items-input">
                        <a href="#" class="checkout-btn" id="checkout-btn">Checkout (0)</a>
                    </form>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <h3>Keranjang Anda Kosong</h3>
                <p>Silakan tambahkan produk ke keranjang Anda</p>
                <a href="{{ route('katalog') }}" class="btn-primary">Lihat Katalog</a>
            </div>
        @endif
    </section>
</body>

<!-- Modern Notifications -->
<script src="{{ asset('js/modern-notifications.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update quantity functionality
        const plusButtons = document.querySelectorAll('.qty-btn.plus');
        const minusButtons = document.querySelectorAll('.qty-btn.minus');
        const removeButtons = document.querySelectorAll('.remove-btn');
        const itemCheckboxes = document.querySelectorAll('.item-check');
        const selectAllCheckbox = document.getElementById('select-all');
        const clearAllBtn = document.getElementById('clear-all');
        const checkoutBtn = document.getElementById('checkout-btn');
        const totalHargaSpan = document.querySelector('.total-harga');

        // Plus button
        plusButtons.forEach(button => {
            button.addEventListener('click', function() {
                const cartId = this.getAttribute('data-cart-id');
                const qtySpan = this.parentElement.querySelector('.qty');
                const currentQty = parseInt(qtySpan.textContent);
                const newQty = currentQty + 1;

                updateQuantity(cartId, newQty, qtySpan);
            });
        });

        // Minus button
        minusButtons.forEach(button => {
            button.addEventListener('click', function() {
                const cartId = this.getAttribute('data-cart-id');
                const qtySpan = this.parentElement.querySelector('.qty');
                const currentQty = parseInt(qtySpan.textContent);

                if (currentQty > 1) {
                    const newQty = currentQty - 1;
                    updateQuantity(cartId, newQty, qtySpan);
                }
            });
        });

        // Remove button
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const cartId = this.getAttribute('data-cart-id');
                const cartItem = this.closest('.keranjang-item');

                // Use modern confirmation modal
                confirmation.show(
                    'Apakah Anda yakin ingin menghapus item ini dari keranjang?', {
                        title: 'Hapus Item',
                        confirmText: 'Ya, Hapus',
                        cancelText: 'Batal',
                        type: 'warning'
                    }).then(result => {
                    if (result) {
                        removeFromCart(cartId, cartItem);
                    }
                });
            });
        });

        // Checkbox functionality
        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateTotalPrice();
                updateCheckoutButton();
                updateSelectAllCheckbox();
            });
        });
        checkoutBtn.addEventListener('click', function(e) {
            const checkedBoxes = document.querySelectorAll('.item-check:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                notifications.warning('Pilih minimal satu item untuk checkout', {
                    title: 'Perhatian!',
                    duration: 3000
                });
                return;
            }

            // Ambil ID item yang dicentang
            const selectedIds = Array.from(checkedBoxes).map(cb => cb.closest('.keranjang-item')
                .getAttribute('data-cart-id'));
            document.getElementById('selected-items-input').value = selectedIds.join(',');

            // Submit form
            document.getElementById('checkout-form').submit();
        });


        // Initialize on page load
        updateTotalPrice();
        updateCheckoutButton();
        updateSelectAllCheckbox();

        // Select all checkbox
        selectAllCheckbox.addEventListener('change', function() {
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateTotalPrice();
            updateCheckoutButton();
        });

        // Clear all button
        clearAllBtn.addEventListener('click', function() {
            confirmation.show('Apakah Anda yakin ingin menghapus semua item dari keranjang?', {
                title: 'Hapus Semua Item',
                confirmText: 'Ya, Hapus Semua',
                cancelText: 'Batal',
                type: 'warning'
            }).then(result => {
                if (result) {
                    clearAllItems();
                }
            });
        });

        function updateQuantity(cartId, quantity, qtySpan) {
            fetch(`/cart/update/${cartId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        qtySpan.textContent = quantity;
                        // Update data-quantity attribute on checkbox
                        const cartItem = qtySpan.closest('.keranjang-item');
                        const checkbox = cartItem.querySelector('.item-check');
                        checkbox.setAttribute('data-quantity', quantity);
                        updateTotalPrice();
                        updateCheckoutButton();
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
                    notifications.error('Gagal mengupdate quantity', {
                        title: 'Error!',
                        duration: 3000,
                        sound: true,
                        vibration: true
                    });
                });
        }

        function removeFromCart(cartId, cartItem) {
            fetch(`/cart/remove/${cartId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        cartItem.remove();
                        updateTotalPrice();
                        updateCheckoutButton();
                        updateSelectAllCheckbox();
                        notifications.success(data.message, {
                            title: 'Berhasil!',
                            duration: 5000,
                            sound: true,
                            vibration: true
                        });

                        // Check if cart is empty
                        const remainingItems = document.querySelectorAll('.keranjang-item');
                        if (remainingItems.length === 0) {
                            location.reload(); // Reload to show empty cart message
                        }
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    notifications.error('Gagal menghapus item', {
                        title: 'Error!',
                        duration: 3000
                    });
                });
        }

        function updateTotalPrice() {
            let total = 0;
            let selectedCount = 0;

            itemCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const price = parseFloat(checkbox.getAttribute('data-price'));
                    const quantity = parseInt(checkbox.getAttribute('data-quantity'));
                    total += price * quantity;
                    selectedCount++;
                }
            });

            if (totalHargaSpan) {
                totalHargaSpan.textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }
            if (checkoutBtn) {
                checkoutBtn.textContent = `Checkout (${selectedCount})`;
            }
        }

        function updateCheckoutButton() {
            const checkedBoxes = document.querySelectorAll('.item-check:checked');
            if (checkoutBtn) {
                if (checkedBoxes.length > 0) {
                    checkoutBtn.style.pointerEvents = 'auto';
                    checkoutBtn.style.opacity = '1';
                    checkoutBtn.style.cursor = 'pointer';
                } else {
                    checkoutBtn.style.pointerEvents = 'none';
                    checkoutBtn.style.opacity = '0.5';
                    checkoutBtn.style.cursor = 'not-allowed';
                }
            }
        }

        function updateSelectAllCheckbox() {
            const totalCheckboxes = itemCheckboxes.length;
            const checkedCheckboxes = document.querySelectorAll('.item-check:checked').length;

            if (selectAllCheckbox) {
                if (checkedCheckboxes === 0) {
                    selectAllCheckbox.indeterminate = false;
                    selectAllCheckbox.checked = false;
                } else if (checkedCheckboxes === totalCheckboxes) {
                    selectAllCheckbox.indeterminate = false;
                    selectAllCheckbox.checked = true;
                } else {
                    selectAllCheckbox.indeterminate = true;
                }
            }
        }

        function clearAllItems() {
            // Send request to clear all items
            fetch('/cart/clear-all', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        notifications.success(data.message, {
                            title: 'Berhasil!',
                            duration: 5000,
                            sound: true,
                            vibration: true
                        });
                        location.reload(); // Reload to show empty cart
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    notifications.error('Gagal menghapus semua item', {
                        title: 'Error!',
                        duration: 3000,
                        sound: true,
                        vibration: true
                    });
                });
        }

    });
</script>

</html>

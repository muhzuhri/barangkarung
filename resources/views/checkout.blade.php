<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran - BarangKarung ID</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <style>
        
    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />

    <link rel="stylesheet" href="{{ asset('css/nav_menu-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/beranda-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/katalog-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pesanan-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/keranjang-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
    <link rel="stylesheet" href="{{ asset('css/checkout-style.css') }}">
</head>

<body>
    <x-navbar />

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Address Card -->
        <div class="address-card" onclick="editAddress()">
            <div class="location-icon">📍</div>
            <div class="address-info">
                <div class="address-name">{{ $user->name }}</div>
                <div class="address-text">{{ $user->address ?? 'Alamat belum diisi' }}</div>
            </div>
            <div class="arrow-icon">→</div>
        </div>
        <!-- Modal Edit Alamat -->
        <div id="editAddressModal" class="modal">
            <div class="modal-content">
                <h2>Edit Alamat</h2>
                <textarea id="addressInput" placeholder="Masukkan alamat baru"></textarea>
                <div class="modal-buttons">
                    <button id="cancelBtn" class="btn btn-cancel">Batal</button>
                    <button id="saveBtn" class="btn btn-save">Simpan</button>
                </div>
            </div>
        </div>
        


        <!-- Main Layout -->
        <div class="checkout-layout">
            <!-- Left Column - Order Details -->
            <div class="order-details">
                <div class="seller-name">BarangKarung.id</div>

                @foreach ($cartItems as $item)
                    <div class="product-item">
                        <div class="product-image">
                            @if ($item->product->image)
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                            @else
                                <span>📦</span>
                            @endif
                        </div>
                        <div class="product-info">
                            <div class="product-name">{{ $item->product->name }}</div>
                            <div class="product-price">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="product-quantity">x {{ $item->quantity }}</div>
                    </div>
                @endforeach

                <div class="option-item" onclick="selectShipping()">
                    <div>
                        <div class="option-label">Opsi Pengiriman</div>
                        <div class="option-value">Reguler</div>
                    </div>
                    <div class="option-arrow">→</div>
                </div>

                <div class="option-item" onclick="selectPayment()">
                    <div>
                        <div class="option-label">Metode Pembayaran</div>
                        <div class="option-value">COD</div>
                    </div>
                    <div class="option-arrow">→</div>
                </div>

                <div class="option-item" onclick="addMessage()">
                    <div>
                        <div class="option-label">Pesan Untuk Penjual</div>
                        <div class="option-value">Tinggalkan Pesan</div>
                    </div>
                    <div class="option-arrow">→</div>
                </div>

                <div class="option-item" onclick="selectVoucher()">
                    <div>
                        <div class="option-label">Voucher Diskon</div>
                        <div class="option-value">Pilih</div>
                    </div>
                    <div class="option-arrow">→</div>
                </div>
            </div>

            <!-- Right Column - Payment Summary -->
            <div class="payment-summary">
                <div class="summary-title">Rincian Pembayaran</div>

                <div class="summary-item">
                    <span class="summary-label">Subtotal Pesanan</span>
                    <span class="summary-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Subtotal Pengiriman</span>
                    <span class="summary-value">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Biaya Layanan</span>
                    <span class="summary-value">Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Voucher Diskon</span>
                    <span class="summary-value">Rp {{ number_format($discount, 0, ',', '.') }}</span>
                </div>

                <div class="summary-item total">
                    <span class="summary-label">Total</span>
                    <span class="summary-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <form method="POST" action="{{ route('checkout.process') }}">
                    @csrf
                    <input type="hidden" name="shipping_address" value="{{ $user->address ?? '' }}">
                    <input type="hidden" name="phone" value="{{ $user->phone ?? '' }}">
                    <input type="hidden" name="shipping_method" value="reguler">
                    <input type="hidden" name="payment_method" value="cod">
                    <input type="hidden" name="notes" value="">

                    <button type="submit" class="checkout-button">
                        Buat Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editAddress() {
            // Ambil elemen teks alamat
            const addressText = document.querySelector('.address-text');

            // Tampilkan prompt untuk edit alamat
            const newAddress = prompt('Masukkan alamat baru:', addressText.textContent);

            // Jika ada input baru dan tidak kosong
            if (newAddress !== null && newAddress.trim() !== '') {
                addressText.textContent = newAddress.trim();

                // Update hidden input form untuk checkout
                const shippingInput = document.querySelector('input[name="shipping_address"]');
                shippingInput.value = newAddress.trim();
            }
        }
        // Element
        const modal = document.getElementById('editAddressModal');
        const addressText = document.querySelector('.address-text');
        const shippingInput = document.querySelector('input[name="shipping_address"]');
        const addressInput = document.getElementById('addressInput');
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');

        // Buka modal saat klik alamat
        function editAddress() {
            addressInput.value = addressText.textContent.trim();
            modal.style.display = 'flex';
        }

        // Tutup modal
        cancelBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Simpan alamat baru
        saveBtn.addEventListener('click', () => {
            const newAddress = addressInput.value.trim();
            if (newAddress !== '') {
                addressText.textContent = newAddress;
                shippingInput.value = newAddress;
                modal.style.display = 'none';
            } else {
                alert('Alamat tidak boleh kosong!');
            }
        });

        // Tutup modal jika klik di luar box
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });



        function selectShipping() {
            alert('Fitur pilih pengiriman akan ditambahkan');
        }

        function selectPayment() {
            alert('Fitur pilih pembayaran akan ditambahkan');
        }

        function addMessage() {
            alert('Fitur pesan penjual akan ditambahkan');
        }

        function selectVoucher() {
            alert('Fitur voucher diskon akan ditambahkan');
        }

        // Form submission with loading state
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = document.querySelector('.checkout-button');
            button.disabled = true;
            button.textContent = 'Memproses...';
        });
    </script>
</body>

</html>

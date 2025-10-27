<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran - BarangKarung ID</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <style>

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Address Card */
        .address-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            cursor: pointer;
            transition: box-shadow 0.3s ease;
        }

        .address-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .location-icon {
            width: 24px;
            height: 24px;
            background: #333;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .address-info {
            flex: 1;
        }

        .address-name {
            font-weight: 600;
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .address-text {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .arrow-icon {
            color: #666;
            font-size: 1.2rem;
        }

        /* Main Layout */
        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }

        /* Left Column - Order Details */
        .order-details {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .seller-name {
            font-weight: 700;
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .product-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-image {
            width: 60px;
            height: 60px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: #666;
            flex-shrink: 0;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .product-price {
            color: #666;
            font-size: 0.9rem;
        }

        .product-quantity {
            color: #666;
            font-size: 0.9rem;
        }

        /* Options */
        .option-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .option-item:hover {
            background: #f8f9fa;
        }

        .option-item:last-child {
            border-bottom: none;
        }

        .option-label {
            font-weight: 500;
            color: #333;
        }

        .option-value {
            color: #666;
            font-size: 0.9rem;
        }

        .option-arrow {
            color: #666;
            font-size: 1rem;
        }

        /* Right Column - Payment Summary */
        .payment-summary {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 2rem;
        }

        .summary-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            color: #666;
        }

        .summary-item.total {
            border-top: 1px solid #f0f0f0;
            margin-top: 1rem;
            padding-top: 1rem;
            font-weight: 700;
            font-size: 1.1rem;
            color: #333;
        }

        .summary-label {
            font-size: 0.9rem;
        }

        .summary-value {
            font-weight: 500;
        }

        .summary-item.total .summary-value {
            font-weight: 700;
            color: #e74c3c;
        }

        /* Checkout Button */
        .checkout-button {
            width: 100%;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 1.5rem;
        }

        .checkout-button:hover {
            background: #c0392b;
        }

        .checkout-button:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .checkout-layout {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .container {
                padding: 1rem;
            }

            .header-content {
                padding: 0 0.5rem;
            }

            .header-title {
                font-size: 1.2rem;
            }

            .address-card {
                padding: 1rem;
            }

            .order-details,
            .payment-summary {
                padding: 1rem;
            }

            .product-item {
                gap: 0.75rem;
            }

            .product-image {
                width: 50px;
                height: 50px;
            }
        }

        /* Alert Messages */
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
            alert('Fitur edit alamat akan ditambahkan');
        }

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

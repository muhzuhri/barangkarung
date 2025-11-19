<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran - BarangKarung ID</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />

    <link rel="stylesheet" href="{{ asset('css/user/nav_menu-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/checkout-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
</head>

<body class="checkout-page">

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

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin:8px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Address Card -->
        <div class="address-card" onclick="editAddress()">
            <div class="location-icon">📍</div>
            <div class="address-info">
                <div class="address-name">{{ $user->name }}</div>
                <div class="address-text">{{ $user->address ?? 'Alamat belum diisi' }}</div>
                <div class="address-phone">{{ $user->phone ?? 'No. Telp belum diisi' }}</div>
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


        <!-- Main Layout - Tag pembuka form pindah ke bagian luar -->
        <form id="checkoutForm" method="POST" action="{{ route('checkout.process') }}" enctype="multipart/form-data">
            @csrf
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

                    <!-- Opsi Pengiriman -->
                    <div class="option-item">
                        <div class="option-label">Opsi Pengiriman</div>
                        <select id="shippingMethod" name="shipping_method" class="option-select">
                            <option value="reguler" selected>Reguler (Rp 25.000)</option>
                            <option value="kargo">Kargo (Rp 12.000)</option>
                        </select>
                    </div>
                    <!-- Metode Pembayaran -->
                    <div class="option-item">
                        <div class="option-label">Metode Pembayaran</div>
                        <select id="paymentMethod" name="payment_method" class="option-select">
                            <option value="cod" selected>COD (Bayar di Tempat)</option>
                            <option value="dana">DANA (Transfer)</option>
                            <option value="mandiri">Mandiri (Transfer)</option>
                            <option value="qris">QRIS Umum</option>
                        </select>
                    </div>

                    <!-- Info Transfer -->
                    <div class="option-item" id="transferInfoBox" style="display:none;">
                        <div class="option-label" id="rekeningLabel"></div>
                        <div class="rekening-info" id="rekeningInfo"></div>

                        <div id="qrisImageContainer" style="display:none; margin-top: 1rem; text-align:center;">
                            <img id="qrisImage"
                                src=""
                                alt="QRIS"
                                style="max-width: 300px; max-height: 300px; border: 2px solid #e5e7eb; border-radius: 8px; margin-bottom: 0.5rem;">
                            <p id="qrisInstructions" style="font-size: 12px; color: #666; margin-top: 0.5rem;"></p>
                        </div>

                        <div class="option-label">Upload Bukti Transfer</div>
                        <input type="file" name="payment_proof" accept="image/*" class="option-input">
                    </div>

                    <!-- Pesan untuk Penjual -->
                    <div class="option-item">
                        <div class="option-label">Pesan Untuk Penjual</div>
                        <textarea id="notesInput" name="notes" class="option-textarea" placeholder="Tulis pesan untuk penjual..."></textarea>
                    </div>
                </div>

                <!-- Right Column - Payment Summary -->
                <div class="payment-summary">
                    <div class="summary-title">Rincian Pembayaran</div>
                    
                    <div class="summary-item">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-item">
                        <span class="summary-label">Biaya Pengiriman</span>
                        <span class="summary-value" id="summaryShipping">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-item">
                        <span class="summary-label">Biaya Layanan</span>
                        <span class="summary-value">Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
                    </div>
                    
                    @if($discount > 0)
                    <div class="summary-item">
                        <span class="summary-label">Diskon</span>
                        <span class="summary-value" style="color: #27ae60;">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    
                    <div class="summary-item total">
                        <span class="summary-label">Total Pembayaran</span>
                        <span class="summary-value" id="totalSummary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    @foreach ($cartItems as $item)
                        <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
                    @endforeach
                    <input type="hidden" name="shipping_address" value="{{ $user->address ?? '' }}">
                    <input type="hidden" name="phone" value="{{ $user->phone ?? '' }}">
                    <button type="submit" class="checkout-button">Buat Pesanan</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Simpan payment settings data untuk JavaScript
        const paymentSettingsData = @json($paymentSettingsJs ?? []);

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


        // Elemen ringkasan biaya
        const summaryShipping = document.getElementById('summaryShipping');
        const totalSummary = document.getElementById('totalSummary');

        let subtotal = {{ $subtotal }};
        let serviceFee = {{ $serviceFee }};
        let discount = {{ $discount }};
        let shippingCost = {{ $shippingCost }};


        function selectVoucher() {
            alert('Fitur voucher diskon akan ditambahkan');
        }

        // Form submission with loading state
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = document.querySelector('.checkout-button');
            button.disabled = true;
            button.textContent = 'Memproses...';
        });
        // Hidden inputs sudah ada di form, tidak perlu selector terpisah
        const shippingSelect = document.getElementById('shippingMethod');
        const paymentSelect = document.getElementById('paymentMethod');
        const notesTextarea = document.getElementById('notesInput');

        function recalcTotals() {
            shippingCost = (shippingSelect.value === 'kargo') ? 12000 : 25000;
            if (summaryShipping) {
                summaryShipping.textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
            }
            const total = subtotal + serviceFee + shippingCost - discount;
            if (totalSummary) {
                totalSummary.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }
        }

        // Sinkronkan pilihan pengiriman dan hitung ulang total
        shippingSelect.addEventListener('change', () => {
            recalcTotals();
        });

        // Inisialisasi awal (jaga-jaga bila default bukan reguler)
        recalcTotals();

        const transferInfoBox = document.getElementById('transferInfoBox');
        const rekeningLabel = document.getElementById('rekeningLabel');
        const rekeningInfo = document.getElementById('rekeningInfo');
        const qrisImageContainer = document.getElementById('qrisImageContainer');

        document.getElementById('paymentMethod').addEventListener('change', function() {
            const val = this.value;
            const qrisImage = document.getElementById('qrisImage');
            const qrisInstructions = document.getElementById('qrisInstructions');
            const paymentData = paymentSettingsData[val];
            
            if(val === 'dana') {
                transferInfoBox.style.display = 'block';
                if(paymentData) {
                    if(paymentData.qris_image) {
                        // Jika ada QRIS, tampilkan QRIS saja
                        rekeningLabel.textContent = paymentData.label || 'QRIS DANA';
                        rekeningInfo.textContent = '';
                        qrisImageContainer.style.display = 'block';
                        qrisImage.src = paymentData.qris_image;
                        qrisInstructions.textContent = paymentData.instructions || 'Scan QRIS di atas untuk melakukan pembayaran.';
                    } else {
                        // Jika tidak ada QRIS, tampilkan info rekening
                        rekeningLabel.textContent = paymentData.label || 'Nomor DANA';
                        let rekeningText = paymentData.account_number || '';
                        if(paymentData.account_name) {
                            rekeningText += ' a.n. ' + paymentData.account_name;
                        }
                        rekeningInfo.textContent = rekeningText || '0812xxxxxxx a.n. Contoh DANA';
                        qrisImageContainer.style.display = 'none';
                    }
                } else {
                    rekeningLabel.textContent = 'Nomor DANA';
                    rekeningInfo.textContent = '0812xxxxxxx a.n. Contoh DANA';
                    qrisImageContainer.style.display = 'none';
                }
            } else if(val === 'mandiri') {
                transferInfoBox.style.display = 'block';
                if(paymentData) {
                    if(paymentData.qris_image) {
                        // Jika ada QRIS, tampilkan QRIS saja
                        rekeningLabel.textContent = paymentData.label || 'QRIS Mandiri';
                        rekeningInfo.textContent = '';
                        qrisImageContainer.style.display = 'block';
                        qrisImage.src = paymentData.qris_image;
                        qrisInstructions.textContent = paymentData.instructions || 'Scan QRIS di atas untuk melakukan pembayaran.';
                    } else {
                        // Jika tidak ada QRIS, tampilkan info rekening
                        rekeningLabel.textContent = paymentData.label || 'Rekening Mandiri';
                        let rekeningText = paymentData.account_number || '';
                        if(paymentData.account_name) {
                            rekeningText += ' a.n. ' + paymentData.account_name;
                        }
                        rekeningInfo.textContent = rekeningText || '123000xxxxx a.n. Contoh Mandiri';
                        qrisImageContainer.style.display = 'none';
                    }
                } else {
                    rekeningLabel.textContent = 'Rekening Mandiri';
                    rekeningInfo.textContent = '123000xxxxx a.n. Contoh Mandiri';
                    qrisImageContainer.style.display = 'none';
                }
            } else if(val === 'qris') {
                transferInfoBox.style.display = 'block';
                qrisImageContainer.style.display = 'block';
                rekeningLabel.textContent = 'QRIS';
                rekeningInfo.textContent = '';
                
                if(paymentData && paymentData.qris_image) {
                    qrisImage.src = paymentData.qris_image;
                    qrisInstructions.textContent = paymentData.instructions || 'Scan QRIS di atas untuk melakukan pembayaran.';
                } else {
                    qrisImage.src = "{{ asset('img/qris.jpeg') }}";
                    qrisInstructions.textContent = "Scan QRIS di atas untuk melakukan pembayaran.";
                }
            } else {
                transferInfoBox.style.display = 'none';
                qrisImageContainer.style.display = 'none';
                rekeningLabel.textContent = '';
                rekeningInfo.textContent = '';
            }
        });
        

        /////
        // document.getElementById('paymentMethod').addEventListener('change', function() {
        //     const val = this.value;

        //     if (val === 'dana') {
        //         transferInfoBox.style.display = 'block';
        //         qrisImageContainer.style.display = 'block';
        //         rekeningLabel.textContent = 'QRIS DANA';
        //         rekeningInfo.textContent = 'Silakan scan kode QR berikut untuk transfer melalui DANA.';
        //         qrisImage.src = "{{ asset('img/qris.jpeg') }}"; // Gambar QRIS DANA

        //     } else if (val === 'mandiri') {
        //         transferInfoBox.style.display = 'block';
        //         qrisImageContainer.style.display = 'block';
        //         rekeningLabel.textContent = 'QRIS Mandiri';
        //         rekeningInfo.textContent = 'Scan QR berikut untuk transfer via Bank Mandiri.';
        //         qrisImage.src = "{{ asset('img/qris.jpeg') }}"; // jika ada QR mandiri

        //     } else if (val === 'qris') {
        //         transferInfoBox.style.display = 'block';
        //         qrisImageContainer.style.display = 'block';
        //         rekeningLabel.textContent = 'QRIS Umum';
        //         rekeningInfo.textContent = '';
        //         qrisImage.src = "{{ asset('img/qris.jpeg') }}"; // default QR umum

        //     } else {
        //         transferInfoBox.style.display = 'none';
        //         qrisImageContainer.style.display = 'none';
        //         rekeningLabel.textContent = '';
        //         rekeningInfo.textContent = '';
        //     }
        // });

        // trigger di load jika (misal reload dari validasi)
        document.addEventListener('DOMContentLoaded', ()=>{
          document.getElementById('paymentMethod').dispatchEvent(new Event('change'));
        });
    </script>
</body>

</html>

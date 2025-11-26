@include('admin.layout.header')
<title>Pengaturan Pembayaran | BK</title>

<style>
    /* ====== Form Group ====== */
    .form-group-payment {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .form-label-payment {
        font-weight: 600;
        color: #374151;
        font-size: 0.95rem;
    }

    /* ====== Icon Preview (klik untuk buka gambar) ====== */
    .icon-preview {
        display: inline-block;
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .icon-preview:hover {
        transform: scale(1.02);
        /* box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12); */
    }

    .icon-image {
        display: block;
        width: 100px;
        height: auto;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
        object-fit: contain;
    }

    /* ====== Gambar QRIS Preview ====== */
    .qris-preview {
        display: inline-block;
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .qris-preview:hover {
        transform: scale(1.02);
    }

    .qris-image {
        display: block;
        width: 180px;
        height: auto;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
        object-fit: contain;
    }

    /* ====== Fallback bila gambar error ====== */
    .image-error {
        width: 180px;
        padding: 0.75rem;
        text-align: center;
        border-radius: 12px;
        background: #fff7f7;
        border: 1px solid #fca5a5;
        color: #b91c1c;
        font-size: 0.8rem;
        line-height: 1.3;
    }

    /* ====== File Upload Box ====== */
    .file-upload-box {
        border: 2px dashed #d1d5db;
        border-radius: 10px;
        padding: 1.25rem;
        text-align: center;
        background: #f9fafb;
        transition: all 0.25s ease;
    }

    .file-upload-box:hover {
        border-color: #6366f1;
        background: #f3f4f6;
    }

    .form-file {
        width: 100%;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
        cursor: pointer;
    }

    .file-hint {
        color: #6b7280;
        font-size: 0.8rem;
        line-height: 1.4;
    }

    /* ====== Tombol Hapus ====== */
    .btn-delete {
        background: #ef4444;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 500;
        transition: background 0.2s ease;
        margin-left: 0.5rem;
    }

    .btn-delete:hover {
        background: #dc2626;
    }

    /* ====== Form Tambah Baru ====== */
    .add-payment-container {
        background: #f0f9ff;
        border: 2px dashed #3b82f6;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .add-payment-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .add-payment-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e40af;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .toggle-form-btn {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 500;
        transition: background 0.2s ease;
    }

    .toggle-form-btn:hover {
        background: #2563eb;
    }

    .add-payment-form {
        display: none;
    }

    .add-payment-form.show {
        display: block;
    }
</style>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom: 1.5rem;">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-error" style="margin-bottom: 1.5rem; background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem; border-radius: 8px;">
        <strong>⚠ Terjadi kesalahan:</strong>
        <ul style="margin: 0.5rem 0 0 1.5rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="page-header">
    <h1 class="page-title">
        <img src={{ asset('img/icon/income-icon.png') }} alt="Icon Setting" class="title-icon">
        Pengaturan Pembayaran
    </h1>
</div>

<!-- Form Tambah Metode Pembayaran Baru -->
<div class="add-payment-container">
    <div class="add-payment-header">
        <div class="add-payment-title">
            <span>➕</span>
            <span>Tambah Metode Pembayaran Baru</span>
        </div>
        <button type="button" class="toggle-form-btn" onclick="toggleAddForm()">
            <span id="toggleBtnText">Tampilkan Form</span>
        </button>
    </div>

    <form id="addPaymentForm" class="add-payment-form" method="POST" action="{{ route('admin.setting.payment.store') }}"
        enctype="multipart/form-data">
        @csrf

        <div class="form-body">
            <div class="form-group">
                <label class="form-label">Kode Metode Pembayaran <span style="color: #ef4444;">*</span></label>
                <input type="text" name="payment_method" class="form-input" 
                    value="{{ old('payment_method') }}" 
                    placeholder="contoh: transfer_bca, dana, qris, ovo, dll" required>
                <small style="color: #6b7280; font-size: 0.85rem; margin-top: 0.25rem; display: block;">
                    Gunakan huruf kecil dan underscore (tanpa spasi). Contoh: transfer_bca, dana, qris
                </small>
            </div>

            <div class="form-group">
                <label class="form-label">Label</label>
                <input type="text" name="label" class="form-input" 
                    value="{{ old('label') }}" 
                    placeholder="contoh: Transfer BCA, DANA, QRIS">
                <small style="color: #6b7280; font-size: 0.85rem; margin-top: 0.25rem; display: block;">
                    Label yang akan ditampilkan di halaman checkout
                </small>
            </div>

            <div class="form-group-payment">
                <label class="form-label-payment">Icon/Logo Metode Pembayaran</label>
                <div class="file-upload-box">
                    <input type="file" name="icon_image" class="form-file" accept="image/*">
                    <p class="file-hint">📁 Pilih gambar berformat <strong>JPG, JPEG, atau PNG</strong>. Max:
                        <strong>2MB</strong>.
                    </p>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Nomor Rekening/Nomor</label>
                <input type="text" name="account_number" class="form-input"
                    value="{{ old('account_number') }}" 
                    placeholder="contoh: 1234567890 atau 081234567890">
            </div>

            <div class="form-group">
                <label class="form-label">Nama Pemilik</label>
                <input type="text" name="account_name" class="form-input"
                    value="{{ old('account_name') }}" 
                    placeholder="contoh: Nama Pemilik Rekening">
            </div>

            <div class="form-group-payment">
                <label class="form-label-payment">Gambar QRIS</label>
                <div class="file-upload-box">
                    <input type="file" name="qris_image" class="form-file" accept="image/*">
                    <p class="file-hint">📁 Pilih gambar berformat <strong>JPG, JPEG, atau PNG</strong>. Max:
                        <strong>2MB</strong>.
                    </p>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Instruksi Pembayaran</label>
                <textarea name="instructions" class="form-input" rows="3" 
                    placeholder="contoh: Silakan transfer ke rekening di atas lalu upload bukti pembayaran.">{{ old('instructions') }}</textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span>Aktif</span>
                </label>
                <small style="color: #6b7280; font-size: 0.85rem; margin-top: 0.25rem; display: block;">
                    Metode pembayaran aktif akan muncul di halaman checkout
                </small>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="form-actions">
            <button type="submit" class="btn-submit">Tambah Metode Pembayaran</button>
            <button type="button" class="btn-delete" onclick="toggleAddForm()" style="background: #6b7280;">Batal</button>
        </div>
    </form>
</div>

@foreach ($payments as $payment)
    <div class="order-container">
        <h2  class="form-title" style="margin-bottom: 1rem">{{ $payment->label ?? ucfirst($payment->payment_method) }}</h2>

        <form method="POST" action="{{ route('admin.setting.payment.update', $payment->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-body">
                <div class="form-group">
                    <label class="form-label">Label</label>
                    <input type="text" name="label" class="form-input" value="{{ old('label', $payment->label) }}">
                </div>

                <div class="form-group-payment">
                    <label class="form-label-payment">Icon/Logo Metode Pembayaran</label>
                    @if ($payment->icon_image)
                        @php
                            $iconUrl = asset('storage/' . $payment->icon_image);
                        @endphp
                        <a href="{{ $iconUrl }}" target="_blank" class="icon-preview">
                            <img src="{{ $iconUrl }}" alt="Icon" class="icon-image"
                                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'image-error\'><strong>⚠ Gambar tidak dapat dimuat</strong><br><small>{{ $iconUrl }}</small></div>';">
                        </a>
                    @endif
                    <div class="file-upload-box">
                        <input type="file" id="image" name="icon_image" class="form-file" accept="image/*">
                        <p class="file-hint">📁 Pilih gambar berformat <strong>JPG, JPEG, atau PNG</strong>. Max:
                            <strong>2MB</strong>.
                        </p>
                    </div>
                </div>


                <div class="form-group">
                    <label class="form-label">Nomor Rekening/Nomor</label>
                    <input type="text" name="account_number" class="form-input"
                        value="{{ old('account_number', $payment->account_number) }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Pemilik</label>
                    <input type="text" name="account_name" class="form-input"
                        value="{{ old('account_name', $payment->account_name) }}">
                </div>

                <div class="form-group-payment">
                    <label class="form-label-payment">Gambar QRIS</label>
                    @if ($payment->qris_image)
                        @php
                            $qrisUrl = asset('storage/' . $payment->qris_image);
                        @endphp
                        <a href="{{ $qrisUrl }}" target="_blank" class="qris-preview">
                            <img src="{{ $qrisUrl }}" alt="QRIS" class="qris-image"
                                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'image-error\'><strong>⚠ Gambar tidak dapat dimuat</strong><br><small>{{ $qrisUrl }}</small></div>';">
                        </a>
                    @endif
                    <div class="file-upload-box">
                        <input type="file" id="image" name="qris_image" class="form-file" accept="image/*">
                        <p class="file-hint">📁 Pilih gambar berformat <strong>JPG, JPEG, atau PNG</strong>. Max:
                            <strong>2MB</strong>.
                        </p>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" name="is_active" value="1"
                            {{ $payment->is_active ? 'checked' : '' }}>
                        <span>Aktif</span>
                    </label>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
                <button type="button" class="btn-delete" onclick="confirmDelete({{ $payment->id }}, '{{ $payment->label ?? $payment->payment_method }}')">
                    Hapus
                </button>
            </div>
        </form>
    </div>
@endforeach

<!-- Form Hapus (Hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    // Auto-show form jika ada error validation
    document.addEventListener('DOMContentLoaded', function() {
        @if($errors->any() && old('payment_method'))
            toggleAddForm();
        @endif
    });

    function toggleAddForm() {
        const form = document.getElementById('addPaymentForm');
        const btnText = document.getElementById('toggleBtnText');
        
        if (form.classList.contains('show')) {
            form.classList.remove('show');
            btnText.textContent = 'Tampilkan Form';
        } else {
            form.classList.add('show');
            btnText.textContent = 'Sembunyikan Form';
        }
    }

    function confirmDelete(id, label) {
        if (confirm('Apakah Anda yakin ingin menghapus metode pembayaran "' + label + '"?\n\nPerhatian: Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data termasuk gambar yang terkait.')) {
            const form = document.getElementById('deleteForm');
            form.action = '/admin/payment-settings/' + id;
            form.submit();
        }
    }
</script>

@include('admin.layout.footer')
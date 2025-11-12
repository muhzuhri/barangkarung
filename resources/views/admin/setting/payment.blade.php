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
</style>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom: 1.5rem;">
        {{ session('success') }}
    </div>
@endif

<div class="page-header">
    <h1 class="page-title">
        <img src={{ asset('img/icon/income-icon.png') }} alt="Icon Setting" class="title-icon">
        Pengaturan Pembayaran
    </h1>
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
            </div>
        </form>
    </div>
@endforeach

@include('admin.layout.footer')
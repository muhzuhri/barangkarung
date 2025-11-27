@include('admin.layout.header')
<title>Tambah FAQ | BK</title>

<div class="page-header">
    <h1 class="page-title">
        <img src={{ asset('img/icon/tambah-icon.png') }} alt="Icon Produk" class="title-icon">
        Tambah FAQ Baru
    </h1>
    <a href="{{ route('admin.faq.index') }}" class="btn-kembali">
        <img src={{ asset('img/icon/kembali-icon.png') }} alt="Tambah Produk" class="btn-icon-kembali">
    </a>
</div>

<form action="{{ route('admin.faq.store') }}" method="POST" class="form-container">
    @csrf
    <!-- Header Form -->
    <div class="form-header">
        <h2 class="form-title">Form Penambahan FAQ Baru</h2>
        <p class="form-subtitle">Isi data FAQ dengan lengkap agar tidak ada kesalahan.</p>
    </div>

    <div class="form-body">
        <div class="form-group">
            <label for="category" class="form-label">Kategori</label>
            <input type="text" name="category" id="category"
                class="form-input @error('category') is-invalid @enderror" value="{{ old('category') }}" required>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="question" class="form-label">Pertanyaan</label>
            <input type="text" name="question" id="question"
                class="form-input @error('question') is-invalid @enderror" value="{{ old('question') }}" required>
            @error('question')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="answer" class="form-label">Jawaban</label>
            <textarea name="answer" id="answer" rows="5" class="form-textarea @error('answer') is-invalid @enderror"
                required>{{ old('answer') }}</textarea>
            @error('answer')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="" class="form-label">Status</label>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                    {{ old('is_active') ? 'checked' : '' }}>
                <label class="custom-control-label" for="is_active">Aktif</label>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.faq.index') }}" class="btn-batal">Batal</a>
        <button type="submit" class="btn-submit">Simpan FAQ</button>
    </div>
</form>

@include('admin.layout.footer')
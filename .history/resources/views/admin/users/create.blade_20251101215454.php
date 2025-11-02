@include('admin.layout.header')
<title>Tambah User Admin | BK</title>

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
    <h1 class="page-title">
        <img src={{ asset('img/icon/tambah-icon.png') }} alt="Icon Produk" class="title-icon">
        Tambah User Baru
    </h1>
    <a href="{{ route('admin.users.index') }}" class="btn-kembali">
        <img src={{ asset('img/icon/kembali-icon.png') }} alt="Tambah Produk" class="btn-icon-kembali">
    </a>
</div>


<form method="POST" action="{{ route('admin.users.store') }}" class="form-container">
    @csrf
    <!-- Header Form -->
    <div class="form-header">
        <h2 class="form-title">Form Penambahan User Baru</h2>
        <p class="form-subtitle">Isi da produk dengan lengkap agar tampil optimal di etalase toko.</p>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="name" class="form-label required">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="email" class="form-label required">Email</label>
            <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="password" class="form-label required">Password</label>
            <input type="password" id="password" name="password" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label required">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="phone" class="form-label">Nomor Telepon</label>
            <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label for="gender" class="form-label">Jenis Kelamin</label>
            <select id="gender" name="gender" class="form-select">
                <option value="">Pilih Jenis Kelamin</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="address" class="form-label">Alamat</label>
        <textarea id="address" name="address" class="form-textarea" rows="3">{{ old('address') }}</textarea>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="birth_date" class="form-label">Tanggal Lahir</label>
            <input type="date" id="birth_date" name="birth_date" class="form-input" value="{{ old('birth_date') }}">
        </div>

        <div class="form-group">
            <label for="religion" class="form-label">Agama</label>
            <input type="text" id="religion" name="religion" class="form-input" value="{{ old('religion') }}">
        </div>
    </div>

    <div class="form-group">
        <label for="profession" class="form-label">Profesi</label>
        <input type="text" id="profession" name="profession" class="form-input" value="{{ old('profession') }}">
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.users.index') }}" class="btn-cancel">Batal</a>
        <button type="submit" class="btn-submit">Simpan User</button>
    </div>
</form>


@include('admin.layout.footer')

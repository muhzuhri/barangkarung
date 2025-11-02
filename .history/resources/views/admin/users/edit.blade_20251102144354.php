@include('admin.layout.header')
<title>Edit User | BK</title>

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
        <img src={{ asset('img/icon/ubah-icon.png') }} alt="Icon Produk" class="title-icon">
        Ubah Data User : {{ $user->name }}
    </h1>
    <a href="{{ route('admin.users.index') }}" class="btn-kembali">
        <img src={{ asset('img/icon/kembali-icon.png') }} alt="Tambah Produk" class="btn-icon-kembali">
    </a>
</div>

<form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="form-container">
    @csrf
    @method('PUT')

    <div class="form-body">
        <div class="form-group">
            <label for="name" class="form-label required">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-input"
                value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email" class="form-label required">Email</label>
            <input type="email" id="email" name="email" class="form-input"
                value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <strong>Catatan :</strong><p class="form-label">Kosongkan field password jika tidak ingin mengubah password.</p>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password Baru</label>
            <input type="password" id="password" name="password" class="form-input">
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input">
        </div>

        <div class="form-group">
            <label for="phone" class="form-label">Nomor Telepon</label>
            <input type="text" id="phone" name="phone" class="form-input"
                value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="form-group gender-select">
            <label for="gender" class="form-label">Jenis Kelamin</label>
            <div class="select-wrapper">
                <select id="gender" name="gender" class="form-select">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="address" class="form-label">Alamat</label>
            <textarea id="address" name="address" class="form-textarea" rows="3">{{ old('address', $user->address) }}</textarea>
        </div>

        <div class="form-group">
            <label for="birth_date" class="form-label">Tanggal Lahir</label>
            <input type="date" id="birth_date" name="birth_date" class="form-input"
                value="{{ old('birth_date', $user->birth_date) }}">
        </div>

        <div class="form-group">
            <label for="religion" class="form-label">Agama</label>
            <input type="text" id="religion" name="religion" class="form-input"
                value="{{ old('religion', $user->religion) }}">
        </div>

        <div class="form-group">
            <label for="profession" class="form-label">Profesi</label>
            <input type="text" id="profession" name="profession" class="form-input"
                value="{{ old('profession', $user->profession) }}">
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.users.index') }}" class="btn-batal">Batal</a>
        <button type="submit" class="btn-submit">Perbarui User</button>
    </div>
</form>


@include('admin.layout.footer')

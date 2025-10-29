@include('admin.layout.header')
<title>Pesanan Admin | BK</title>

s

        @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="page-header">
            <h1 class="page-title">Edit User: {{ $user->name }}</h1>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                ← Kembali ke Daftar User
            </a>
        </div>

        <div class="form-container">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="form-row">
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
                </div>

                <div class="password-note">
                    <strong>Catatan:</strong> Kosongkan field password jika tidak ingin mengubah password.
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" id="password" name="password" class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-input">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" class="form-input"
                            value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class="form-group">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <select id="gender" name="gender" class="form-select">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : ''
                                }}>Laki-laki</option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : ''
                                }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea id="address" name="address" class="form-textarea"
                        rows="3">{{ old('address', $user->address) }}</textarea>
                </div>

                <div class="form-row">
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
                </div>

                <div class="form-group">
                    <label for="profession" class="form-label">Profesi</label>
                    <input type="text" id="profession" name="profession" class="form-input"
                        value="{{ old('profession', $user->profession) }}">
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.users.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Update User</button>
                </div>
            </form>
        </div>

@include('admin.layout.footer')

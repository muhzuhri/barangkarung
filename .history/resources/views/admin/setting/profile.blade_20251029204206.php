
        @include('admin.layout.header')
<title>Pesanan Admin | BK</title>
        
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                </div>
                <h1 class="profile-name">{{ $admin->name }}</h1>
                <p class="profile-role">{{ $admin->getRoleDisplayAttribute() }}</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.setting.profile.update') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $admin->phone) }}">
                </div>

                <div class="form-group">
                    <label for="current_password">Password Lama (untuk mengubah password)</label>
                    <input type="password" id="current_password" name="current_password">
                </div>

                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" id="password" name="password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation">
                </div>

                <button type="submit" class="btn">Update Profile</button>
            </form>
        </div>
   

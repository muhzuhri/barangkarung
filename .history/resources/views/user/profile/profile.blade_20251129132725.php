<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    {{-- Icon web & title --}}
    <title>Profile | Barang Karung</title>
    <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('img/icon/webb-icon.png') }}">

    <!-- Google Fonts & Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/nav_menu-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/profile-style.css') }}">
</head>

<body>
    <!-- ===== NAVBAR ===== -->
    <x-navbar />

    <!-- ===== PROFILE DATA DIRI ===== -->
    <section class="data-pengguna">
        <h2>Data Pengguna</h2>
        @if (session('success'))
            <div class="alert alert-success" style="margin:12px 0;">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error" style="margin:12px 0;">
                <ul style="margin:0 0 0 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <div class="data-container">
                <div class="data-group">
                    <label>Nama</label>
                    <input type="text" name="name" value="{{ old('name', (isset($user) ? $user->name : Auth::user()->name)) }}">
                </div>

                <div class="data-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', (isset($user) && $user->birth_date) ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : (Auth::user()->birth_date ? \Carbon\Carbon::parse(Auth::user()->birth_date)->format('Y-m-d') : '') ) }}">
                </div>

                <div class="data-group">
                    <label>Alamat</label>
                    <input type="text" name="address" value="{{ old('address', (isset($user) ? $user->address : Auth::user()->address)) }}">
                </div>

                <div class="data-group">
                    <label>Jenis Kelamin</label>
                    @php($g = old('gender', (isset($user) ? $user->gender : Auth::user()->gender)))
                    <div class="radio-group">
                        <label class="radio-item">
                            <input type="radio" name="gender" value="male" {{ $g === 'male' ? 'checked' : '' }}>
                            <span>Laki-laki</span>
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="gender" value="female" {{ $g === 'female' ? 'checked' : '' }}>
                            <span>Perempuan</span>
                        </label>
                    </div>
                </div>

                <div class="data-group">
                    <label>No. Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', (isset($user) ? $user->phone : Auth::user()->phone)) }}">
                </div>

                <div class="data-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', (isset($user) ? $user->email : Auth::user()->email)) }}">
                </div>

                <div class="data-group">
                    <label>Agama</label>
                    <input type="text" name="religion" value="{{ old('religion', (isset($user) ? $user->religion : Auth::user()->religion)) }}">
                </div>

                <div class="data-group">
                    <label>Profesi</label>
                    <input type="text" name="profession" value="{{ old('profession', (isset($user) ? $user->profession : Auth::user()->profession)) }}">
                </div>
            </div>

            <div class="button-profile">
                <button type="submit" class="btn-save" style="background:#667eea; color:#fff; border:none; border-radius:8px; padding:10px 16px; font-weight:600; cursor:pointer;">Simpan Perubahan</button>
            </div>
        </form>
    </section>
</body>

</html>
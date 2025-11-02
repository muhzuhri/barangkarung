<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Icon web & title --}}
    <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('img/icon/webb-icon.png') }}">
    <title>Login | Barang Karung</title>

    <!-- Google Font & Font Awesome -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
</head>

<body>

    <div class="container">
        <!-- Kiri: Form Login -->
        <div class="login-section">
            <h1>Halaman Login</h1>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="alert alert-success" data-success="{{ session('success') }}" style="display: none;">
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

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <img src="img/user-icon.png" alt="User Icon" class="icon">
                    <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                </div>

                <div class="form-group password-group">
                    <img src="img/pass-icon.png" alt="Password Icon" class="icon">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <img src="img/eye-icon.png" alt="Toggle Password" id="togglePassword" class="toggle-icon">
                </div>

                <p class="note">Cek dulu apakah sudah dengan benar</p>
                <button type="submit" class="btn-login-a">MASUK</button>
            </form>

            <!-- Link Registrasi -->
            <div class="register-link">
                <p>Belum punya akun? <a href="{{ route('register') }}" class="register-link-text">Daftar di sini</a></p>
            </div>
        </div>

        <!-- Kanan: Brand dan Gambar -->
        <div class="brand-section">
            <h1>Barang Karung ID</h1>
            <p>Thrift For Everybody</p>
            <img src="img/login-icon.png" alt="Gambar baju thrift">
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('js/notifications.js') }}"></script>

    <script>
        // Toggle buka/tutup password
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.src = type === 'password' ? 'img/eye-icon.png' : 'img/close_eye-icon.png';
        });
    </script>

</body>

</html>

</html>

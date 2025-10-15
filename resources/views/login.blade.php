<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login | Barang Karung ID</title>
    <link rel="stylesheet" href="style.css">

    <!-- Google Font & Font Awesome -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" /> 
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
        <!-- Kiri: Form Login -->
        <div class="login-section">
            <h1>Halaman Login</h1>

            <div class="form-group">
                <img src="img/user-icon.png" alt="User Icon" class="icon">
                <input type="text" placeholder="Username" required>
            </div>

            <div class="form-group password-group">
                <img src="img/pass-icon.png" alt="Password Icon" class="icon">
                <input type="password" id="password" placeholder="Password" required>
                <img src="img/eye-icon.png" alt="Toggle Password" id="togglePassword" class="toggle-icon">
            </div>

            <p class="note">Pastikan isi username dan password dengan benar</p>
            <!-- <button class="btn-login">MASUK</button> -->
            <a href="beranda.html" class="btn-login-a">MASUK</a>
        </div>

        <!-- Kanan: Brand dan Gambar -->
        <div class="brand-section">
            <h1>Barang Karung ID</h1>
            <p>Thrift For Everybody</p>
            <img src="img/login-icon.png" alt="Gambar baju thrift">
        </div>
    </div>

    <script>
        // Toggle buka/tutup password
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.src = type === 'password' ? 'img/eye-icon.png' : 'img/close_eye-icon.png';
        });
    </script>

</body>

</html>

</html>
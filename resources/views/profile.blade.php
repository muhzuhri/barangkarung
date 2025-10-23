<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Barang Karung ID</title>

    <!-- Google Fonts & Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/nav_menu-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/beranda-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/katalog-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pesanan-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-style.css') }}">
</head>

<body>
    <!-- ===== NAVBAR ===== -->
    <x-navbar />

    <!-- ===== PROFILE DATA DIRI ===== -->
    <section class="data-pengguna">
        <h2>Data Pengguna</h2>

        <div class="data-container">
            <div class="data-group">
                <label>Nama</label>
                <input type="text" value="Agung Aksa" readonly>
            </div>

            <div class="data-group">
                <label>Tanggal Lahir</label>
                <input type="text" value="10 - 02 - 2005" readonly>
            </div>

            <div class="data-group">
                <label>Alamat</label>
                <input type="text" value="Negara Bailangu" readonly>
            </div>

            <div class="data-group">
                <label>Jenis Kelamin</label>
                <input type="text" value="Trans Gender" readonly>
            </div>

            <div class="data-group">
                <label>No. Telpon</label>
                <input type="text" value="0812 - 3456 - 7890" readonly>
            </div>

            <div class="data-group">
                <label>Email</label>
                <input type="text" value="AksaGans@gmail.com" readonly>
            </div>

            <div class="data-group">
                <label>Agama</label>
                <input type="text" value="Islam" readonly>
            </div>

            <div class="data-group">
                <label>Profesi</label>
                <input type="text" value="Mahasiswa" readonly>
            </div>
        </div>
    </section>
</body>

</html>
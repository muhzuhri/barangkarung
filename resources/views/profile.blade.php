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
                <input type="text" value="{{ Auth::user()->name }}" readonly>
            </div>

            <div class="data-group">
                <label>Tanggal Lahir</label>
                <input type="text" value="{{ Auth::user()->birth_date ? \Carbon\Carbon::parse(Auth::user()->birth_date)->format('d - m - Y') : 'Belum diisi' }}" readonly>
            </div>

            <div class="data-group">
                <label>Alamat</label>
                <input type="text" value="{{ Auth::user()->address ?? 'Belum diisi' }}" readonly>
            </div>

            <div class="data-group">
                <label>Jenis Kelamin</label>
                <input type="text" value="{{ Auth::user()->gender ?? 'Belum diisi' }}" readonly>
            </div>

            <div class="data-group">
                <label>No. Telpon</label>
                <input type="text" value="{{ Auth::user()->phone ?? 'Belum diisi' }}" readonly>
            </div>

            <div class="data-group">
                <label>Email</label>
                <input type="text" value="{{ Auth::user()->email }}" readonly>
            </div>

            <div class="data-group">
                <label>Agama</label>
                <input type="text" value="{{ Auth::user()->religion ?? 'Belum diisi' }}" readonly>
            </div>

            <div class="data-group">
                <label>Profesi</label>
                <input type="text" value="{{ Auth::user()->profession ?? 'Belum diisi' }}" readonly>
            </div>
        </div>
    </section>
</body>

</html>
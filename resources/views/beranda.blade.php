<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Beranda - Barang Karung ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/beranda.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <x-navbar />

    <!-- Hero Section -->
    <div class="container">
        <div class="hero-section">
            <div class="hero-text">
                <h1>Barang Karung ID</h1>
                <p class="fw-bold text-success">Dari Karung ke Lemari, dari Simpel ke Stylish.</p>
                <p>Thrift berkualitas yang ramah kantong dan penuh karakter.</p>
                <a href="#" class="btn btn-primary mt-2">Mari Berjelajah!!! &nbsp; <i
                        class="bi bi-arrow-right"></i></a>
            </div>
            <div class="hero-img">
                <img src="{{ asset('img/baju1.png') }}" alt="Baju 1">
                <img src="{{ asset('img/baju2.png') }}" alt="Baju 2">
                <img src="{{ asset('img/baju3.png') }}" alt="Baju 3">
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

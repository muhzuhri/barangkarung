<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('beranda') }}">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
            <span class="ms-2 fw-bold">Barang Karung ID</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link {{ Request::routeIs('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Product</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Pesanan</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Logout</a></li>
                <li class="nav-item d-flex align-items-center ms-3">
                    <a href="#" class="me-2"><i class="bi bi-bell"></i></a>
                    <a href="#" class="me-2"><i class="bi bi-cart"></i></a>
                    <a href="#"><i class="bi bi-person"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div>
    <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
</div>
@include('admin.layout.header')
<title>User Admin | BK</title>

<div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <img src={{ asset('img/icon/daftar-icon.png') }} alt="Icon Produk" class="title-icon">
        Daftar User
    </h1>

    <a href="{{ route('admin.users.create') }}" class="btn-tambah">
        <img src={{ asset('img/icon/tambah-icon.png') }} alt="Tambah Produk" class="btn-icon">
        Tambah User Baru
    </a>
</div>

<div class="recent-orders-section">
    <div class="section-header">
        <img src={{ asset('img/icon/calendar-icon.png') }} alt="Pesanan Terbaru" class="section-icon">
        <h2 class="section-title">Table User</h2>
    </div>
</div>



@include('admin.layout.footer')

@include('admin.layout.header')
<title>Detail User Admin | BK</title>

<div class="page-header">
    <h1 class="page-title">
        <img src={{ asset('img/icon/detail-icon.png') }} alt="Icon Produk" class="title-icon">
        Detail User
    </h1>
    <a href="{{ route('admin.users.index') }}" class="btn-kembali">
        <img src={{ asset('img/icon/kembali-icon.png') }} alt="Tambah Produk" class="btn-icon-kembali">
    </a>
    {{-- <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-primary">
        <img src={{ asset('img/icon/ubah-icon.png') }} alt="Icon Produk" class="title-icon">
        Edit User
    </a> --}}
</div>

<div class="user-profile">
    <div class="user-header">
        <div class="user-header-left">
            <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <div class="user-info">
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>
                @if ($user->profession)
                    <p>{{ $user->profession }}</p>
                @endif
            </div>
        </div>

        <div class="user-stats">
            <div class="stat-item">
                <span class="stat-number">{{ $user->carts->count() }}</span>
                <span>Keranjang</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $user->created_at->format('d/m/Y') }}</span>
                <span>Bergabung</span>
            </div>
        </div>
    </div>


    <div class="user-details">
        <div class="detail-section">
            <h3>Informasi Personal</h3>
            <div class="detail-item">
                <span class="detail-label">Nama Lengkap:</span>
                <span class="detail-value">{{ $user->name }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Email:</span>
                <span class="detail-value">{{ $user->email }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Nomor Telepon:</span>
                <span class="detail-value">{{ $user->phone ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Jenis Kelamin:</span>
                <span class="detail-value">
                    @if ($user->gender)
                        {{ $user->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}
                    @else
                        -
                    @endif
                </span>
            </div>
        </div>

        <div class="detail-section">
            <h3>Informasi Tambahan</h3>
            <div class="detail-item">
                <span class="detail-label">Tanggal Lahir:</span>
                <span
                    class="detail-value">{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') : '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Agama:</span>
                <span class="detail-value">{{ $user->religion ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Profesi:</span>
                <span class="detail-value">{{ $user->profession ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Alamat:</span>
                <span class="detail-value">{{ $user->address ?? '-' }}</span>
            </div>
        </div>
    </div>
</div>

@include('admin.layout.footer')

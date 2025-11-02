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
    @if ($users->count() > 0)
        <div class="orders-table">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Statistik</th>
                        <th>Tgl Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="user-details">
                                        <h4>{{ $user->name }}</h4>
                                        @if ($user->profession)
                                            <p>{{ $user->profession }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                <div class="user-stats">
                                    <div class="stat-item">
                                        <span>{{ $user->carts_count }} keranjang</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group-table">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn-detail">
                                        <img src={{ asset('img/icon/detail-icon.png') }} alt="Icon Produk"
                                            class="table-icon">
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-edit">
                                        <img src={{ asset('img/icon/ubah-icon.png') }} alt="Icon Produk"
                                            class="table-icon">
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-hapus">
                                            <img src={{ asset('img/icon/hapus-icon.png') }} alt="Icon Produk"
                                                class="table-icon">
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            {{ $users->links() }}
        </div>
    @else
        <div class="no-users">
            <h3>Belum ada user</h3>
            <p>Klik tombol "Tambah User Baru" untuk menambahkan user pertama.</p>
        </div>
    @endif
</div>



@include('admin.layout.footer')

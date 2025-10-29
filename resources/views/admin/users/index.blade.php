@include('admin.layout.header')
<title>User Admin | BK</title>


@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
>>>>>>> 33474cbc824934a8a5e5b4c7836c568b9a04a9f3
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

<div class="page-header">
    <h1 class="page-title">Daftar User</h1>
    <a href="{{ route('admin.users.create') }}" class="btn-primary">
        ➕ Tambah User Baru
    </a>
</div>

@if ($users->count() > 0)
    <div class="users-table">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Statistik</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
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
                                    <span>🛍️</span>
                                    <span>{{ $user->carts_count }} keranjang</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn-info">👁️</a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-secondary">✏️</a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                    style="display: inline;"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger">🗑️</button>
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

@include('admin.layout.footer')

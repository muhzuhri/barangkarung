<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar User - Admin Panel</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">
</head>

<body>
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <div class="logo-icon">BK</div>
                <h1>Admin Panel</h1>
            </div>

            <nav class="nav-menu">
                <ul class="nav-links">
                    <li><a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a></li>
                    <li><a href="{{ route('admin.products.index') }}">🛍️ Produk</a></li>
                    <li><a href="{{ route('admin.orders.index') }}">📦 Pesanan</a></li>

                    <li><a href="{{ route('admin.users.index') }}" class="active">👥 User</a></li>
                    <li><a href="{{ route('admin.revenue.index') }}">💰 Pendapatan</a></li>
                    <li><a href="{{ route('admin.setting.profile') }}">⚙️ Settings</a></li>
                </ul>
            </nav>

            <div class="admin-info">
                <div class="admin-dropdown">
                    <div class="admin-dropdown-toggle" onclick="toggleDropdown()">
                        <div class="admin-avatar">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="admin-name">{{ $admin->name }}</div>
                            <div class="admin-role">{{ $admin->getRoleDisplayAttribute() }}</div>
                        </div>
                        <span style="font-size: 0.8rem;">▼</span>
                    </div>
                    <div class="dropdown-menu" id="adminDropdown">
                        <a href="{{ route('admin.setting.profile') }}" class="dropdown-item">👤 Profile</a>
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">🏠 Dashboard</a>
                        <a href="{{ route('admin.products.index') }}" class="dropdown-item">🛍️ Kelola Produk</a>
                        <a href="{{ route('admin.users.index') }}" class="dropdown-item">👥 Kelola User</a>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item logout"
                                style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">🚪
                                Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
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
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="btn-secondary">✏️</a>
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
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('adminDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('adminDropdown');
            const toggle = document.querySelector('.admin-dropdown-toggle');

            if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>
</body>

</html>

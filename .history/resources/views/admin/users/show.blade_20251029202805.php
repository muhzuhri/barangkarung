<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User - Admin Panel</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            height: 70px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links a:hover {
            color: #1f2937;
            background: #f9fafb;
        }

        .nav-links a.active {
            color: #1f2937;
            background: #f3f4f6;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #6b7280 0%, #374151 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 0.9rem;
        }

        .admin-dropdown {
            position: relative;
        }

        .admin-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .admin-dropdown-toggle:hover {
            background: #f9fafb;
        }

        .admin-name {
            font-weight: 600;
            color: #1f2937;
        }

        .admin-role {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: block;
            padding: 0.75rem 1rem;
            color: #374151;
            text-decoration: none;
            transition: background 0.3s ease;
            border-bottom: 1px solid #f3f4f6;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: #f9fafb;
        }

        .dropdown-item.logout {
            color: #dc2626;
        }

        .dropdown-item.logout:hover {
            background: #fef2f2;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
        }

        
    </style>
</head>

<body>
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <div class="logo-icon">BK</div>
                <h1>Detail User</h1>
            </div>

            <nav class="nav-menu">
                <ul class="nav-links">
                    <li><a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a></li>
                    <li><a href="{{ route('admin.products.index') }}">🛍️ Produk</a></li>
                    <li><a href="{{ route('admin.users.index') }}" class="active">👥 User</a></li>
                    <li><a href="{{ route('admin.profile') }}">⚙️ Settings</a></li>
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
                        <a href="{{ route('admin.profile') }}" class="dropdown-item">👤 Profile</a>
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
        <div class="page-header">
            <h1 class="page-title">Detail User</h1>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                    ← Kembali ke Daftar User
                </a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-primary">
                    ✏️ Edit User
                </a>
            </div>
        </div>

        <div class="user-profile">
            <div class="user-header">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="user-info">
                    <h2>{{ $user->name }}</h2>
                    <p>{{ $user->email }}</p>
                    @if($user->profession)
                    <p>{{ $user->profession }}</p>
                    @endif
                    <div class="user-stats">
                        <div class="stat-item">
                            <div class="stat-number">{{ $user->carts->count() }}</div>
                            <div class="stat-label">Keranjang</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $user->created_at->format('d/m/Y') }}</div>
                            <div class="stat-label">Bergabung</div>
                        </div>
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
                            @if($user->gender)
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
                        <span class="detail-value">{{ $user->birth_date ?
                            \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') : '-' }}</span>
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
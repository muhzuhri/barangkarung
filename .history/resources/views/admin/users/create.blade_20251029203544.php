<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah User - Admin Panel</title>
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

        
    </style>
</head>

<body>
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <div class="logo-icon">BK</div>
                <h1>Tambah User</h1>
            </div>

            <nav class="nav-menu">
                <ul class="nav-links">
                    <li><a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a></li>
                    <li><a href="{{ route('admin.products.index') }}">🛍️ Produk</a></li>
                    <li><a href="{{ route('admin.orders.index') }}">📦 Pesanan</a></li>
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
                        <a href="{{ route('admin.orders.index') }}" class="dropdown-item">📦 Kelola Pesanan</a>
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
        @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="page-header">
            <h1 class="page-title">Tambah User Baru</h1>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                ← Kembali ke Daftar User
            </a>
        </div>

        <div class="form-container">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="name" class="form-label required">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}"
                            required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label required">Password</label>
                        <input type="password" id="password" name="password" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label required">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-input" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone') }}">
                    </div>

                    <div class="form-group">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <select id="gender" name="gender" class="form-select">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="male" {{ old('gender')=='male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea id="address" name="address" class="form-textarea" rows="3">{{ old('address') }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="birth_date" class="form-label">Tanggal Lahir</label>
                        <input type="date" id="birth_date" name="birth_date" class="form-input"
                            value="{{ old('birth_date') }}">
                    </div>

                    <div class="form-group">
                        <label for="religion" class="form-label">Agama</label>
                        <input type="text" id="religion" name="religion" class="form-input"
                            value="{{ old('religion') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="profession" class="form-label">Profesi</label>
                    <input type="text" id="profession" name="profession" class="form-input"
                        value="{{ old('profession') }}">
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.users.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Simpan User</button>
                </div>
            </form>
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


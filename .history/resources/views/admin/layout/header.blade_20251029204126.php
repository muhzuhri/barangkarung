<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Chart JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Google Fonts --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">

    {{-- Style CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/profile-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/produk-admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/user-admin-style.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/admin/editproduk-admin-style.css') }}"> --}}

    <style>
        /* Scoped enhancements for a modern detail view */
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px
        }

        .order-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0
        }

        .badge-large {
            font-size: .85rem;
            padding: 8px 12px;
            border-radius: 999px;
            display: inline-block
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px
        }

        .meta-item {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .06);
            border-radius: 12px;
            padding: 12px
        }

        .meta-label {
            font-size: .75rem;
            color: #6b7280;
            margin-bottom: 4px
        }

        .meta-value {
            font-weight: 600
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 16px
        }

        .summary-card {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .06);
            border-radius: 12px;
            padding: 16px;
            text-align: center
        }

        .summary-value {
            font-size: 1.1rem;
            font-weight: 700
        }

        .btn-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap
        }

        .form-inline {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap
        }

        @media (max-width: 768px) {
            .meta-grid {
                grid-template-columns: 1fr
            }

            .summary-grid {
                grid-template-columns: 1fr
            }
        }
    </style>
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
                    <li><a href="{{ route('admin.dashboard') }}" class="active">🏠 Dashboard</a></li>
                    <li><a href="{{ route('admin.products.index') }}">🛍️ Produk</a></li>
                    <li><a href="{{ route('admin.orders.index') }}">📦 Pesanan</a></li>
                    <li><a href="{{ route('admin.users.index') }}">👥 User</a></li>
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
                        <a href="{{ route('admin.orders.index') }}" class="dropdown-item">📦 Kelola Pesanan</a>
                        <a href="{{ route('admin.users.index') }}" class="dropdown-item">👥 Kelola User</a>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item logout"
                                style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">🚪
                                Logout</button>
                        </form>
                    </div>
                </div>

                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">☰</button>
            </div>
        </div>
    </div>

    <div class="container">

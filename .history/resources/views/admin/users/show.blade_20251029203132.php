@include('admin.layout.header')
<title>Detail User Admin | BK</title>
<style>
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

        .btn-secondary {
            background: #6c757d;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .user-profile {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .user-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .user-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 2.5rem;
        }

        .user-info h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .user-info p {
            color: #6b7280;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .user-stats {
            display: flex;
            gap: 2rem;
            margin-top: 1rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .user-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .detail-section h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #374151;
        }

        .detail-value {
            color: #6b7280;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            .container {
                padding: 0 1rem;
            }

            .page-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .user-profile,
            .orders-section {
                padding: 1rem;
            }

            .user-header {
                flex-direction: column;
                text-align: center;
            }

            .user-details {
                grid-template-columns: 1fr;
            }

            .user-stats {
                justify-content: center;
            }
        }
</style>

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
            @if ($user->profession)
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

@include('admin.layout.header')
<title>Kelola FAQ | BK</title>

<style>
    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.35rem 0.75rem;
        font-size: 0.8125rem;
        font-weight: 600;
        border-radius: 9999px;
        /* pill shape */
        letter-spacing: 0.3px;
        transition: all 0.25s ease-in-out;
        text-transform: capitalize;
    }

    .badge-success {
        color: #0f5132;
        background: #e4f9ef;
        border: 1px solid #a3cfbb;
    }

    .badge-success:hover {
        background: #bcdcc8;
        transform: scale(1.05);
    }

    .badge-danger {
        color: #842029;
        background: #f8dddf;
        border: 1px solid #f5c2c7;
    }

    .badge-danger:hover {
        background: #f1bfc4;
        transform: scale(1.05);
    }
</style>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <img src={{ asset('img/icon/daftar-icon.png') }} alt="Icon Produk" class="title-icon">
        Daftar FAQ
    </h1>

    <a href="{{ route('admin.faq.create') }}" class="btn-tambah">
        <img src={{ asset('img/icon/tambah-icon.png') }} alt="Tambah Produk" class="btn-icon">
        Tambah FAQ Baru
    </a>
</div>

<div class="recent-orders-section">
    <div class="section-header">
        <img src={{ asset('img/icon/calendar-icon.png') }} alt="Pesanan Terbaru" class="section-icon">
        <h2 class="section-title">Table Data FAQ</h2>
    </div>
    <div class="orders-table">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Pertanyaan</th>
                    <th>Status</th>
                    <th style="text-align: center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($faqs as $index => $faq)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $faq->category }}</td>
                        <td>{{ $faq->question }}</td>
                        <td>
                            @if ($faq->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group-table">
                                <a href="{{ route('admin.faq.edit', $faq) }}" class="btn-edit">
                                    <img src={{ asset('img/icon/ubah-icon.png') }} alt="Icon Produk" class="table-icon">
                                </a>
                                <form action="{{ route('admin.faq.destroy', $faq) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-hapus"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')">
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
</div>

@include('admin.layout.footer')

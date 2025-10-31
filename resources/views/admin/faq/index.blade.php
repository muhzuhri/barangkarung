@include('admin.layout.header')
<title>Kelola FAQ | BK</title>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kelola FAQ</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.faq.create') }}" class="btn btn-primary btn-sm">
                            Tambah FAQ Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Pertanyaan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($faqs as $index => $faq)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $faq->category }}</td>
                                        <td>{{ $faq->question }}</td>
                                        <td>
                                            @if($faq->is_active)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.faq.edit', $faq) }}" class="btn btn-sm btn-info">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.faq.destroy', $faq) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.layout.footer')
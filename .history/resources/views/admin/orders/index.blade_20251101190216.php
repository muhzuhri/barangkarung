@php($title = 'Kelola Pesanan')
@php($admin = $admin ?? auth('admin')->user())

@include('admin.layout.header')
<title>Pesanan Admin | BK</title>

<div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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

<h1 class="section-title">Kelola Pesanan</h1>

<div class="page-header">
    <h1 class="page-title">
        <img src={{ asset('img/icon/daftar-icon.png') }} alt="Icon Produk" class="title-icon">
        Kelola Pesanan
    </h1>
</div>

<div class="orders-table">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Pesanan</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                    <td>{{ $order->order_code ?? $order->id }}</td>
                    <td>{{ $order->user->name ?? $order->user_id }}</td>
                    <td>Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</td>
                    <td>
                        <span
                            class="status-badge status-{{ \Illuminate\Support\Str::slug($order->status) }}">{{ $order->status }}</span>
                    </td>
                    <td>{{ $order->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                    <td>
                        <a class="btn btn-link" href="{{ route('admin.orders.show', $order->id) }}">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top: 16px;">
    {{ $orders->links() }}
</div>

@include('admin.layout.footer')

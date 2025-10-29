<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Barang Karung ID</title>

    <!-- Google Fonts & Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/nav_menu-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/beranda-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/katalog-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pesanan-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profil-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail_katalog-style.css') }}">
</head>

<body>
    <!-- ===== NAVBAR ===== -->
    <x-navbar />

    <!-- ===== DETAIL PRODUK ===== -->
    @extends('layouts.app')

@section('content')
<section class="container mx-auto py-12 px-6">
    <div class="grid md:grid-cols-2 gap-12">
        <div>
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="rounded-2xl shadow-lg w-full">
        </div>
        <div>
            <h1 class="text-3xl font-bold mb-3">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-2">Brand: {{ $product->brand }}</p>

            <div class="price mb-4">
                <span class="text-2xl font-semibold text-green-600">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
                @if($product->original_price)
                    <span class="text-gray-400 line-through ml-2">
                        Rp {{ number_format($product->original_price, 0, ',', '.') }}
                    </span>
                    <span class="ml-2 text-red-500">-{{ $product->discount_percentage }}%</span>
                @endif
            </div>

            <p class="text-gray-700 mb-6">
                {{ $product->description ?? 'Deskripsi belum tersedia.' }}
            </p>

            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                Masukkan ke Tas
            </button>

            <div class="mt-4">
                <a href="{{ route('katalog') }}" class="text-gray-500 hover:text-gray-700">← Kembali ke Katalog</a>
            </div>
        </div>
    </div>
</section>
@endsection


    <!-- ===== PRODUK REKOMENDASI ===== -->
    <section class="product-recommendations">
        <h3>Produk Lainnya</h3>
        <div class="recommendation-list">
            <div class="card">
                <img src="img/baju-img/hoodie1.png" alt="Kaos Oversize">
                <p>Kaos Oversize</p>
                <span>Rp 99.000</span>
            </div>
            <div class="card">
                <img src="img/baju-img/hoodie2.png" alt="Kemeja Linen">
                <p>Kemeja Linen</p>
                <span>Rp 149.000</span>
            </div>
            <div class="card">
                <img src="img/baju-img/polo2.png" alt="Hoodie Streetwear">
                <p>Hoodie Streetwear</p>
                <span>Rp 199.000</span>
            </div>
        </div>
    </section>
</body>

</html>
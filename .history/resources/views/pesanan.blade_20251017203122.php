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
</head>

<body>
    <!-- ===== NAVBAR ===== -->
    <x-navbar />

    <!-- ===== IMAGE SLIDER / BERANDA ===== -->
    <section class="hero-slider">
        <div class="slides">
            <div class="slide active">
                <img src="img/img/pict1.jpg" alt="Slide 1">
            </div>
            <div class="slide">
                <img src="img/img/pict2.jpg" alt="Slide 2">
            </div>
            <div class="slide">
                <img src="img/img/pict3.jpg" alt="Slide 3">
            </div>
            <div class="slide">
                <img src="img/img/pict4.jpg" alt="Slide 4">
            </div>
            <div class="slide">
                <img src="img/img/pict5.jpg" alt="Slide 5">
            </div>
        </div>

        <!-- Tombol navigasi -->
        <button class="prev">&#10094;</button>
        <button class="next">&#10095;</button>
    </section>

</body>

<script>
    const slides = document.querySelectorAll('.slide');
    const nextBtn = document.querySelector('.next');
    const prevBtn = document.querySelector('.prev');
    let index = 0;

    function showSlide(n) {
        if (n >= slides.length) index = 0;
        else if (n < 0) index = slides.length - 1;
        else index = n;

        document.querySelector('.slides').style.transform = `translateX(-${index * 100}%)`;
    }

    nextBtn.addEventListener('click', () => showSlide(index + 1));
    prevBtn.addEventListener('click', () => showSlide(index - 1));

    // Auto slide tiap 4 detik
    setInterval(() => showSlide(index + 1), 4000);
</script>

</html>

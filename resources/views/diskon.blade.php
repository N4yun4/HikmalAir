<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Diskon Spesial - HikmalAir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/diskon.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body>
    @include('partials.navbar')

    <div class="hero-section"></div>
    <div class="diskon-container">

        <!-- Card 1 -->
        <div class="diskon-card" data-aos="fade-up" data-aos-delay="100">
        <div class="image-wrapper">
            <img src="/images/diskonLogo.jpg" alt="Salad" />
        </div>
        <div class="diskon-text">
            <h5>Diskon 30%</h5>
            <p>Dapatkan potongan harga untuk perjalanan anda.</p>
        </div>
        <div class="diskon-actions">
            <a href="/konfirmasi" class="btn btn-sm btn-custom px-3 py-1">Gunakan Diskon</a>
        </div>
        </div>

        <!-- Card 2 -->
        <div class="diskon-card" data-aos="fade-up" data-aos-delay="100">
        <div class="image-wrapper">
            <img src="/images/diskonLogo.jpg" alt="Fried Rice" />
        </div>
        <div class="diskon-text">
            <h5>Diskon 20%</h5>
            <p>Dapatkan potongan harga untuk perjalanan anda.</p>
        </div>
        <div class="diskon-actions">
            <a href="/konfirmasi" class="btn btn-sm btn-custom px-3 py-1">Gunakan Diskon</a>
        </div>
        </div>

        <!-- Card 3 -->
        <div class="diskon-card" data-aos="fade-up" data-aos-delay="100">
        <div class="image-wrapper">
            <img src="/images/diskonLogo.jpg" alt="Mineral Water" />
        </div>
        <div class="diskon-text">
            <h5>Diskon 70%</h5>
            <p>Dapatkan potongan harga untuk perjalanan anda.</p>
        </div>
        <div class="diskon-actions">
            <a href="/konfirmasi" class="btn btn-sm btn-custom px-3 py-1">Gunakan Diskon</a>
        </div>
        </div>

        <!-- Card 4 -->
        <div class="diskon-card" data-aos="fade-up" data-aos-delay="100">
        <div class="image-wrapper">
            <img src="/images/diskonLogo.jpg" alt="Latte" />
        </div>
        <div class="diskon-text">
            <h5>Diskon 50%</h5>
            <p>Dapatkan potongan harga untuk perjalanan anda.</p>
        </div>
        <div class="diskon-actions">
            <a href="/konfirmasi" class="btn btn-sm btn-custom px-3 py-1">Gunakan Diskon</a>
        </div>
        </div>

    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>AOS.init({duration: 800,once: true});</script>
</body>
</html>

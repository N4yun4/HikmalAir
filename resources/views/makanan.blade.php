<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Meals On Board! - HikmalAir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/makanan.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body>
    @include('partials.navbar')

    <div class="hero-section"></div>
    <div class="meals-container">

        <!-- Card 1 -->
        <div class="meal-card" data-aos="fade-up" data-aos-delay="100">
        <div class="image-wrapper">
            <img src="/images/salad.jpg" alt="Salad" />
        </div>
        <div class="meal-text">
            <h5>Salad</h5>
            <p>Perpaduan segar dari aneka sayuran hijau pilihan, daun selada yang renyah, tomat, paprika merah, dan potongan mentimun segar yang disajikan dengan saus yang ringan dan menyegarkan.</p>
        </div>
        <div class="meal-actions">
            <button class="btn btn-sm btn-custom px-3 py-1">Pesan</button>
        </div>
        </div>

        <!-- Card 2 -->
        <div class="meal-card" data-aos="fade-up" data-aos-delay="100">
        <div class="image-wrapper">
            <img src="/images/nasgor.jpg" alt="Fried Rice" />
        </div>
        <div class="meal-text">
            <h5>Nasi Goreng</h5>
            <p>Nasi goreng harum yang dimasak dengan cita rasa lokal, dipadu dengan potongan sayuran segar, telur, dan sentuhan kecap asin yang seimbang. Cita rasa gurih dan teksturnya yang lembut menghadirkan pengalaman kuliner yang menghibur dan mengenyangkan di atas ketinggian ribuan meter.</p>
        </div>
        <div class="meal-actions">
            <button class="btn btn-sm btn-custom px-3 py-1">Pesan</button>
        </div>
        </div>

        <!-- Card 3 -->
        <div class="meal-card" data-aos="fade-up" data-aos-delay="100">
        <div class="image-wrapper">
            <img src="/images/mineral.jpg" alt="Mineral Water" />
        </div>
        <div class="meal-text">
            <h5>Air Mineral</h5>
            <p>Air mineral murni yang dikemas dalam botol untuk menjaga hidrasi tubuh selama perjalanan. Dingin dan menyegarkan, minuman ini memberikan kesegaran instan yang penting untuk kenyamanan selama penerbangan Anda.</p>
        </div>
        <div class="meal-actions">
            <button class="btn btn-sm btn-custom px-3 py-1">Pesan</button>
        </div>
        </div>

        <!-- Card 4 -->
        <div class="meal-card" data-aos="fade-up" data-aos-delay="100">
        <div class="image-wrapper">
            <img src="/images/coffee.jpg" alt="Latte" />
        </div>
        <div class="meal-text">
            <h5>Kopi</h5>
            <p>Racikan kopi espresso yang lembut dan kuat, dipadukan dengan susu berkualitas. Dihidangkan hangat dengan aroma khas yang menenangkan latte ini adalah teman sempurna untuk momen relaksasi di udara.</p>
        </div>
        <div class="meal-actions">
            <button class="btn btn-sm btn-custom px-3 py-1">Pesan</button>
        </div>
        </div>
        <div class="text-center my-4">
            <button class="btn btn-custom px-4 py-2">Konfirmasi Pesanan</button>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>AOS.init({duration: 800,once: true});</script>
</body>
</html>
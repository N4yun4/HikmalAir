<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Destinasi - HikmalAir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/destinasi.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body>
@include('partials.navbar')

<div class="hero-section"></div>

<div class="destinasi-container">
    @foreach ($destinasi as $item)
    <div class="destinasi-card" data-aos="fade-up" data-aos-delay="100">
    <div class="image-wrapper">
        <img src="{{ $item['gambar'] }}" alt="{{ $item['nama'] }}" />
    </div>
    <div class="destinasi-text">
        <h5>{{ $item['nama'] }}</h5>
        <div class="rating d-flex align-items-center">
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= floor($item['rating']))
                    <i class="bi bi-star-fill text-warning"></i>
                @elseif ($i - $item['rating'] < 1)
                    <i class="bi bi-star-half text-warning"></i>
                @else
                    <i class="bi bi-star text-warning"></i>
                @endif
            @endfor
            <span class="rating-value ms-2">{{ number_format($item['rating'], 1) }}</span>
        </div>
        <p>{{ $item['deskripsi'] }}</p>
    </div>
    <div class="destinasi-actions">
        <a href="/pilihtiket" class="btn btn-sm btn-custom px-3 py-1">Pesan</a>
    </div>
    </div>
    @endforeach

</div>

@include('partials.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/navbar.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init({ duration: 800, once: true });</script>
</body>
</html>

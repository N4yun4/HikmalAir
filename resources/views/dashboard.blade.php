<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | HikmalAir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .main-content-wrapper {
            flex-grow: 1;
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <div class="main-content-wrapper">
        {{-- Hero Section --}}
        <section class="hero-section">
            <img src="{{ asset('images/dashboard-image.png') }}" alt="Background Pesawat" class="hero-background">
            <div class="container">
                <div class="search-panel-hero">
                    <div class="return-trip-switch">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="returnTripSwitch" checked>
                            <label class="form-check-label" for="returnTripSwitch"><small>Pulang-Pergi?</small></label>
                        </div>
                    </div>
                    <h2 class="panel-title">Cek Tiketmu, Yuk!</h2>
                    <form class="row g-3 align-items-end">
                        <div class="col-lg col-md-6">
                            <label for="departureCity" class="form-label visually-hidden">Dari (Kota atau Bandara)</label>
                            <input type="text" class="form-control form-control-lg" id="departureCity" placeholder="Dari (Kota atau Bandara)">
                        </div>
                        <div class="col-auto d-none d-md-flex align-items-center">
                            <i class="bi bi-arrow-left-right fs-4 interchange-icon" id="swapLocationsButton" style="cursor: pointer;"></i>
                        </div>
                        <div class="col-lg col-md-6">
                            <label for="arrivalCity" class="form-label visually-hidden">Ke (Kota atau Bandara)</label>
                            <input type="text" class="form-control form-control-lg" id="arrivalCity" placeholder="Ke (Kota atau Bandara)">
                        </div>
                        <div class="col-lg col-md-6 mt-md-0 mt-3">
                            <label for="departureDate" class="form-label visually-hidden">Tanggal Pergi</label>
                            <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control form-control-lg" id="departureDate" placeholder="Tanggal Pergi"> {{-- id diubah --}}
                        </div>
                        <div class="col-lg col-md-6 mt-md-0 mt-3" id="returnDateContainer">
                            <label for="returnDate" class="form-label visually-hidden">Tanggal Pulang</label>
                            <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control form-control-lg" id="returnDate" placeholder="Tanggal Pulang"> {{-- id diubah --}}
                        </div>
                        <div class="col-lg-auto col-md-12 mt-md-0 mt-3">
                            <label for="promoCode" class="form-label visually-hidden">Kode Promo</label>
                            <input type="text" class="form-control form-control-lg" id="promoCode" placeholder="Kode Promo">
                        </div>
                        <div class="col-lg-auto col-md-12 mt-lg-0 mt-3">
                            <button type="submit" class="btn btn-warning btn-lg w-100">Cari <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        {{-- promo--}}
        <section class="content-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-center mb-4">Promo Tergacor Buat Liburan Anda</h2>
                        <p class="text-center"><em>soon</em></p>
                    </div>
                </div>
            </div>
        </section>

        {{-- destinasi pilihan--}}
        <section class="content-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-center mb-4">Lihat Destinasi Pilihan Dari kami</h2>
                        <p class="text-center"><em>soon</em></p>
                    </div>
                </div>
            </div>
        </section>

        {{-- kelebihan hikmal air --}}
        <section class="content-section bg-light">
            <div class="container">
                <h2 class="text-center mb-4">Kenapa Pilih HikmalAir?</h2>
                <div class="row gy-4">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-shield-check fs-1 text-primary mb-2"></i>
                                <h5 class="card-title">Aman & Terpercaya</h5>
                                <p class="card-text">Keamanan penerbangan adalah prioritas utama kami.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-cash-coin fs-1 text-success mb-2"></i>
                                <h5 class="card-title">Harga Terbaik</h5>
                                <p class="card-text">Nikmati harga kompetitif untuk semua rute.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-headset fs-1 text-info mb-2"></i>
                                <h5 class="card-title">Layanan Pelanggan 24/7</h5>
                                <p class="card-text">Tim kami siap membantu Anda kapan saja.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</html>

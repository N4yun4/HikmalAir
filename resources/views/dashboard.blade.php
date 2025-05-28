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
                            <input class="form-check-input" type="checkbox" id="returnTripSwitch" name="pulang_pergi" value="1" checked>
                            <label class="form-check-label" for="returnTripSwitch"><small>Pulang-Pergi?</small></label>
                        </div>
                    </div>
                    <h2 class="panel-title">Cek Tiketmu, Yuk!</h2>
                    <form class="row g-3 align-items-end" method="GET" action="{{ route('pilihtiket') }}">
                        <div class="col-lg col-md-6">
                            <label for="departureCity" class="form-label visually-hidden">Dari (Kota atau Bandara)</label>
                            <input type="text" class="form-control form-control-lg" id="departureCity" name="dari" placeholder="Dari (Kota atau Bandara)" required>
                        </div>
                        <div class="col-auto d-none d-md-flex align-items-center">
                            <i class="bi bi-arrow-left-right fs-4 interchange-icon" id="swapLocationsButton" style="cursor: pointer;"></i>
                        </div>
                        <div class="col-lg col-md-6">
                            <label for="arrivalCity" class="form-label visually-hidden">Ke (Kota atau Bandara)</label>
                            <input type="text" class="form-control form-control-lg" id="arrivalCity" name="ke" placeholder="Ke (Kota atau Bandara)" required>
                        </div>
                        <div class="col-lg col-md-6 mt-md-0 mt-3">
                            <label for="departureDate" class="form-label visually-hidden">Tanggal Pergi</label>
                            <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control form-control-lg" id="departureDate" name="tanggal_berangkat" placeholder="Tanggal Pergi" required>
                        </div>
                        <div class="col-lg col-md-6 mt-md-0 mt-3" id="returnDateContainer"> {{-- ID diubah --}}
                            <label for="returnDate" class="form-label visually-hidden">Tanggal Pulang</label>
                            <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control form-control-lg" id="returnDate" name="tanggal_pulang" placeholder="Tanggal Pulang">
                        </div>
                        <div class="col-lg-auto col-md-12 mt-md-0 mt-3">
                            <label for="promoCode" class="form-label visually-hidden">Kode Promo</label>
                            <input type="text" class="form-control form-control-lg" id="promoCode" name="promo" placeholder="Kode Promo">
                        </div>
                        <div class="col-lg-auto col-md-12 mt-lg-0 mt-3">
                            <button type="submit" class="btn btn-warning btn-lg w-100">Cari <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        {{-- promo --}}
        <section class="content-section promo-tergacor-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-4">
                            <i class="bi bi-fire fs-2 text-danger me-3"></i>
                            <h2 class="mb-0 section-title-dashboard">Promo Tergacor Buat Liburan Anda</h2>
                        </div>
                    </div>
                </div>
                <div class="row g-lg-4 g-md-3 g-3">
                    @if (isset($promoTickets) && count($promoTickets) > 0)
                        @foreach ($promoTickets as $ticket)
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch">
                            <div class="card ticket-item h-100">
                                <div class="card-body p-3 d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="fw-bold small">{{ $ticket['airline_name'] }} {{ $ticket['flight_number'] }}</span>
                                        <span class="badge rounded-pill text-bg-light ms-auto" style="font-size: 0.7rem;">{{ $ticket['flight_class'] }}</span>
                                    </div>
                                    <div class="flight-route-summary flex-grow-1">
                                        <div class="d-flex align-items-center justify-content-around text-center flight-route">
                                            <div class="departure-info">
                                                <div class="fs-5 fw-bold flight-time">{{ $ticket['departure_time'] }}</div>
                                                <div class="small airport-code">{{ $ticket['departure_code'] }}</div>
                                            </div>
                                            <div class="route-line mx-1 mx-sm-2">
                                                <small class="text-muted flight-duration d-block mb-1">{{ $ticket['duration'] }}</small>
                                                <div class="line"></div>
                                                <small class="text-primary fw-medium flight-transit d-block mt-1">{{ $ticket['transit_info'] }}</small>
                                            </div>
                                            <div class="arrival-info">
                                                <div class="fs-5 fw-bold flight-time">{{ $ticket['arrival_time'] }}</div>
                                                <div class="small airport-code">{{ $ticket['arrival_code'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-3 price-info">
                                        <div class="ticket-price fw-bold fs-5 text-danger mb-2">IDR {{ $ticket['price_display'] }}</div>
                                        <a href="{{ route('tiket.deskripsi', ['id' => $ticket['id']]) }}" class="btn btn-sm btn-warning fw-bold w-100 btn-pilih- tiket-promo">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <p class="text-center text-muted"><em>Belum ada promo tiket tergacor saat ini.</em></p>
                        </div>
                    @endif
                </div>
                @if (isset($promoTickets) && count($promoTickets) > 0)
                <div class="text-center mt-4">
                    <a href="{{ route('pilihtiket') }}" class="btn btn-outline-primary rounded-pill">Lihat Semua Tiket Promo <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
                @endif
            </div>
        </section>

        {{-- destinasi pilihan --}}
        <section class="content-section destination-section pb-md-5 pt-4 pt-md-3">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-compass-fill fs-2 text-success me-3"></i>
                            <h2 class="mb-0 section-title-dashboard">Lihat Destinasi Pilihan Dari Kami</h2>
                        </div>
                    </div>
                </div>
                <div class="row g-lg-4 g-md-3 g-3">
                    @if (isset($popularDestinations) && count($popularDestinations) > 0)
                        @foreach($popularDestinations as $destination)
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch">
                            <a href="{{ $destination['link'] }}" class="card destination-card text-decoration-none w-100">
                                <div class="destination-card-image-wrapper">
                                    <img src="{{ asset($destination['image']) }}" class="destination-card-img" alt="{{ $destination['name'] }}">
                                    <div class="destination-overlay">
                                        <h5 class="destination-name mb-0 d-flex justify-content-between align-items-center">
                                            {{ $destination['name'] }}
                                            @if(isset($destination['rating']))
                                            <span class="rating text-warning"><i class="bi bi-star-fill"></i> {{ $destination['rating'] }}</span>
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                                @if(isset($destination['tagline']))
                                <div class="card-body text-center d-flex flex-column">
                                    <p class="card-text small text-muted mb-2 flex-grow-1">{{ $destination['tagline'] }}</p>
                                </div>
                                @endif
                            </a>
                        </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <p class="text-center text-muted"><em>Belum ada destinasi pilihan untuk ditampilkan.</em></p>
                        </div>
                    @endif
                </div>
                @if (isset($popularDestinations) && count($popularDestinations) > 0)
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-outline-primary rounded-pill">Lihat Semua Destinasi <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
                @endif
            </div>
        </section>

        {{-- kelebihan hikmal air --}}
        <section class="content-section bg-light">
            <div class="container">
                <h2 class="text-center mb-4">Kenapa Pilih HikmalAir?</h2>
                <div class="row gy-4">
                    <div class="col-md-4">
                        <div class="card text-center h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="my-auto">
                                    <i class="bi bi-shield-check fs-1 text-primary mb-3"></i>
                                    <h5 class="card-title">Aman & Terpercaya</h5>
                                    <p class="card-text">Keamanan penerbangan adalah prioritas utama kami.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="my-auto">
                                    <i class="bi bi-cash-coin fs-1 text-success mb-3"></i>
                                    <h5 class="card-title">Harga Terbaik</h5>
                                    <p class="card-text">Nikmati harga kompetitif untuk semua rute.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="my-auto">
                                    <i class="bi bi-headset fs-1 text-info mb-3"></i>
                                    <h5 class="card-title">Layanan Pelanggan 24/7</h5>
                                    <p class="card-text">Tim kami siap membantu Anda kapan saja.</p>
                                </div>
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
    <script src="{{ asset('js/searchpanel.js') }}"></script>
</body>
</html>

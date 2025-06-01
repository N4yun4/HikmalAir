<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Hotel | HikmalAir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hotel.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <div class="hero-section"></div>

    <main class="pilihhhotel-main-content py-4">
        <div class="hotel-main-container">
            {{-- Daftar Pilihan Hotel --}}
            <div class="hotel-list-container">
                @if (isset($hotels) && count($hotels) > 0)
                    @foreach ($hotels as $hotel)
                    <div class="hotel-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="hotel-card-content">
                            <div class="hotel-image-wrapper">
                                <img src="{{ asset($hotel['image']) }}" class="hotel-image" alt="{{ $hotel['name'] }}">
                            </div>
                            <div class="hotel-info">
                                <h5 class="hotel-name">{{ $hotel['name'] }}</h5>
                                <p class="hotel-location"><i class="bi bi-geo-alt-fill me-1"></i>{{ $hotel['location'] }}</p>
                                <div class="hotel-rating">
                                    @for ($i = 0; $i < floor($hotel['rating']); $i++)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @endfor
                                    @if ($hotel['rating'] - floor($hotel['rating']) >= 0.5)
                                        <i class="bi bi-star-half text-warning"></i>
                                    @endif
                                    <span class="ms-1 fw-bold">{{ $hotel['rating'] }}</span>
                                </div>
                                <p class="hotel-description">{{ $hotel['description'] }}</p>
                                <div class="hotel-action">
                                    <button class="btn select-room-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHotel{{ $hotel['id'] }}" aria-expanded="false" aria-controls="collapseHotel{{ $hotel['id'] }}">
                                        Pilih Kamar & Tanggal <i class="bi bi-chevron-down ms-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="collapse hotel-booking-details" id="collapseHotel{{ $hotel['id'] }}">
                            <div class="booking-form-container">
                                <h6>Pilih Tanggal & Kamar untuk: {{ $hotel['name'] }}</h6>
                                <form class="hotel-selection-form" data-hotel-id="{{ $hotel['id'] }}" data-hotel-name="{{ $hotel['name'] }}">
                                    <div class="form-group">
                                        <label for="checkinDate{{ $hotel['id'] }}">Tanggal Check-in</label>
                                        <input type="date" class="form-control" id="checkinDate{{ $hotel['id'] }}" name="checkin_date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="checkoutDate{{ $hotel['id'] }}">Tanggal Check-out</label>
                                        <input type="date" class="form-control" id="checkoutDate{{ $hotel['id'] }}" name="checkout_date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="roomType{{ $hotel['id'] }}">Tipe Kamar</label>
                                        <select class="form-select" id="roomType{{ $hotel['id'] }}" name="room_type" required>
                                            <option selected disabled value="">Pilih tipe kamar...</option>
                                            @foreach ($hotel['room_types'] as $room)
                                                <option value="{{ $room['name'] }}" data-price="{{ $room['price_int'] }}">{{ $room['name'] }} (IDR {{ $room['price_display'] }}/malam)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn add-to-summary-btn">
                                            <i class="bi bi-cart-plus-fill me-1"></i> Tambahkan ke Pesanan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="alert alert-light text-center">Belum ada data hotel yang tersedia.</div>
                @endif
            </div>

            {{-- Konfirmasi Pemesanan --}}
            <div class="order-summary-container">
                <h3 class="title-section"><i class="bi bi-receipt-cutoff me-2"></i>Ringkasan Pemesanan Hotel Anda</h3>
                <div id="hotelOrderSummaryList" class="mb-3">
                    <div class="text-center py-4 no-selection-message">
                        <i class="bi bi-basket3 fs-1 text-muted"></i>
                        <p class="mt-2 text-muted">Keranjang pesanan hotel Anda masih kosong.</p>
                        <p class="small text-muted">Silakan pilih hotel, tanggal, dan tipe kamar di atas.</p>
                    </div>
                </div>
                <div class="text-end mt-4 pt-3 border-top" id="totalSection" style="display: none;">
                    <h4>Total Estimasi: <span id="totalOverallPrice" class="text-primary fw-bold">IDR 0</span></h4>
                    <button class="btn confirm-all-bookings-btn" disabled>
                        <i class="bi bi-check2-circle-fill me-1"></i> Konfirmasi Semua Pesanan Hotel
                    </button>
                </div>
            </div>

        </div>
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/hotel.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, once: true });</script>
</body>
</html>

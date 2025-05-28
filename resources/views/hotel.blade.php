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
</head>
<body>
    @include('partials.navbar')

    <main class="pilihhhotel-main-content py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0 page-title">Pilih Hotel Terbaik untuk Perjalanan Anda</h1>
                <a href="{{ route('konfirmasi') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-chevron-left"></i> Kembali
                </a>
            </div>

            {{-- Daftar Pilihan Hotel --}}
            <div class="hotel-list-container">
                @if (isset($hotels) && count($hotels) > 0)
                    @foreach ($hotels as $hotel)
                    <div class="card hotel-item mb-4 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset($hotel['image']) }}" class="img-fluid rounded-start hotel-image" alt="{{ $hotel['name'] }}">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column h-100">
                                    <h5 class="card-title hotel-name">{{ $hotel['name'] }}</h5>
                                    <p class="card-text text-muted hotel-location mb-1"><i class="bi bi-geo-alt-fill me-1"></i>{{ $hotel['location'] }}</p>
                                    <div class="hotel-rating mb-2">
                                        @for ($i = 0; $i < floor($hotel['rating']); $i++)
                                            <i class="bi bi-star-fill text-warning"></i>
                                        @endfor
                                        @if ($hotel['rating'] - floor($hotel['rating']) >= 0.5)
                                            <i class="bi bi-star-half text-warning"></i>
                                        @endif
                                        <span class="ms-1 fw-bold">{{ $hotel['rating'] }}</span>
                                    </div>
                                    <p class="card-text hotel-description small flex-grow-1">{{ $hotel['description'] }}</p>
                                    <div class="mt-auto">
                                        <button class="btn btn-outline-primary select-room-btn w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHotel{{ $hotel['id'] }}" aria-expanded="false" aria-controls="collapseHotel{{ $hotel['id'] }}">
                                            Pilih Kamar & Tanggal <i class="bi bi-chevron-down ms-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="collapse hotel-booking-details border-top" id="collapseHotel{{ $hotel['id'] }}">
                            <div class="p-3">
                                <h6 class="mb-3 fw-semibold">Pilih Tanggal & Kamar untuk: {{ $hotel['name'] }}</h6>
                                <form class="row g-3 hotel-selection-form" data-hotel-id="{{ $hotel['id'] }}" data-hotel-name="{{ $hotel['name'] }}">
                                    <div class="col-md-6">
                                        <label for="checkinDate{{ $hotel['id'] }}" class="form-label small">Tanggal Check-in</label>
                                        <input type="date" class="form-control form-control-sm" id="checkinDate{{ $hotel['id'] }}" name="checkin_date" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="checkoutDate{{ $hotel['id'] }}" class="form-label small">Tanggal Check-out</label>
                                        <input type="date" class="form-control form-control-sm" id="checkoutDate{{ $hotel['id'] }}" name="checkout_date" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="roomType{{ $hotel['id'] }}" class="form-label small">Tipe Kamar</label>
                                        <select class="form-select form-select-sm" id="roomType{{ $hotel['id'] }}" name="room_type" required>
                                            <option selected disabled value="">Pilih tipe kamar...</option>
                                            @foreach ($hotel['room_types'] as $room)
                                                <option value="{{ $room['name'] }}" data-price="{{ $room['price_int'] }}">{{ $room['name'] }} (IDR {{ $room['price_display'] }}/malam)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-success btn-sm add-to-summary-btn w-100">
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
            <div class="order-summary-container mt-5 pt-4 border-top">
                <h3 class="mb-4 title-section"><i class="bi bi-receipt-cutoff me-2"></i>Ringkasan Pemesanan Hotel Anda</h3>
                <div id="hotelOrderSummaryList" class="mb-3">
                    <div class="text-center py-4 no-selection-message">
                        <i class="bi bi-basket3 fs-1 text-muted"></i>
                        <p class="mt-2 text-muted">Keranjang pesanan hotel Anda masih kosong.</p>
                        <p class="small text-muted">Silakan pilih hotel, tanggal, dan tipe kamar di atas.</p>
                    </div>
                </div>
                <div class="text-end mt-4 pt-3 border-top" id="totalSection" style="display: none;">
                    <h4 class="mb-3">Total Estimasi: <span id="totalOverallPrice" class="text-primary fw-bold">IDR 0</span></h4>
                    <button class="btn btn-primary btn-lg confirm-all-bookings-btn" disabled>
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
</body>
</html>

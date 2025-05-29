<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pilih Merchant | HikmalAir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/merchant.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet" />
</head>
<body>
    @include('partials.navbar')

    <div class="hero-section"></div>

    <main class="merchant-main-content py-4">
        <div class="merchant-main-container">
            <div class="merchant-list-container">
                @if (isset($merchants) && count($merchants) > 0)
                    @foreach ($merchants as $merchant)
                    <div class="merchant-card" 
                        data-aos="fade-up" 
                        data-aos-delay="100" 
                        data-merchant-id="{{ $merchant['id'] }}"
                        data-price="{{ $merchant['price'] ?? 0 }}">
                        <div class="merchant-card-content">
                            <div class="merchant-image-wrapper">
                                <img src="{{ asset($merchant['image']) }}" class="merchant-image" alt="{{ $merchant['name'] }}" />
                            </div>
                            <div class="merchant-info">
                                <h5 class="merchant-name">{{ $merchant['name'] }}</h5>
                                <p class="merchant-price fw-semibold text-success">
                                    IDR {{ number_format($merchant['price'] ?? 0, 0, ',', '.') }}
                                </p>
                                <div class="merchant-rating">
                                    @for ($i = 0; $i < floor($merchant['rating']); $i++)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @endfor
                                    @if (($merchant['rating'] - floor($merchant['rating'])) >= 0.5)
                                        <i class="bi bi-star-half text-warning"></i>
                                    @endif
                                    <span class="ms-1 fw-bold">{{ $merchant['rating'] }}</span>
                                </div>
                                <p class="merchant-description">{{ $merchant['description'] }}</p>

                                <div class="merchant-quantity-control mt-3">
                                    <div class="d-flex align-items-center">
                                        <label class="me-2 fw-medium">Jumlah:</label>
                                        <div class="quantity-control">
                                            <button type="button" class="quantity-decrement btn btn-outline-secondary">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="number" class="form-control quantity-input mx-2" value="0" min="0" max="10" readonly />
                                            <button type="button" class="quantity-increment btn btn-outline-secondary">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="alert alert-light text-center">Belum ada data merchant yang tersedia.</div>
                @endif
            </div>

            <div class="order-summary-container">
                <h3 class="title-section"><i class="bi bi-receipt-cutoff me-2"></i>Ringkasan Pemesanan Merchant Anda</h3>
                <div id="merchantOrderSummaryList" class="mb-3">
                    <div class="text-center py-4 no-selection-message">
                        <i class="bi bi-basket3 fs-1 text-muted"></i>
                        <p class="mt-2 text-muted">Keranjang pesanan merchant Anda masih kosong.</p>
                        <p class="small text-muted">Silakan pilih jumlah item di merchant yang tersedia.</p>
                    </div>
                </div>
                <div class="text-end mt-4 pt-3 border-top" id="totalSection" style="display: none;">
                    <h4>Total Estimasi: <span id="totalOverallPrice" class="text-primary fw-bold">IDR 0</span></h4>
                    <a class="btn confirm-all-bookings-btn" disabled href="/konfirmasi">
                        <i class="bi bi-check2-circle-fill me-1"></i> Konfirmasi Semua Pesanan
                    </a>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="{{ asset('js/merchant.js') }}"></script>
    <script>AOS.init({ duration: 800, once: true });</script>
</body>
</html>

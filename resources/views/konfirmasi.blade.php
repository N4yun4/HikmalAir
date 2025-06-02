<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pemesanan | HikmalAir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/konfirmasi.css') }}">
</head>
<body>
    @include('partials.navbar')

    <main class="konfirmasi-pesanan-main-content py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h2 mb-0 page-title">Konfirmasi Pemesanan Anda</h1>
                            <a href="{{ route('pilihtiket') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-chevron-left"></i> Kembali
                        </a>
                    </div>

                    {{-- detail tiket dan pemesan --}}
                    <div class="card info-card mb-4 shadow-sm">
                        <div class="card-header section-title-header">
                            <i class="bi bi-ticket-detailed-fill me-2"></i>Detail Tiket & Pemesan
                        </div>
                        <div class="card-body">
                            <h5 class="card-subtitle mb-2 fw-bold">{{ $selectedTicket['airline_name'] }} ({{ $selectedTicket['flight_number'] }}) - {{ $selectedTicket['flight_class'] }}</h5>
                            <p class="mb-1">
                                <span class="fw-medium">{{ $selectedTicket['departure_city'] }} ({{ $selectedTicket['departure_code'] }})</span> <i class="bi bi-arrow-right mx-1"></i> <span class="fw-medium">{{ $selectedTicket['arrival_city'] }} ({{ $selectedTicket['arrival_code'] }})</span>
                            </p>
                            <p class="text-muted small mb-1">
                                Berangkat: {{ $selectedTicket['formatted_date'] }}, Pukul {{ $selectedTicket['departure_time'] }}
                            </p>
                            <p class="text-muted small mb-3">
                                Tiba: Pukul {{ $selectedTicket['arrival_time'] }} (Durasi: {{ $selectedTicket['duration'] }})
                            </p>
                            <hr>
                            <h6 class="mb-2">Data Pemesan:</h6>
                            <p class="mb-1"><strong>Nama:</strong> {{ $bookerDetails['contact_full_name'] }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $bookerDetails['contact_email'] }}</p>
                            <p class="mb-0"><strong>Telepon:</strong> {{ $bookerDetails['contact_phone'] }}</p>

                            {{-- Tampilkan Kursi yang Dipilih --}}
                            @if(!empty($selectedSeats))
                                <hr>
                                    <h6 class="mb-2">Kursi Anda:</h6>
                                        <p class="mb-0">
                                            @foreach($selectedSeats as $seatCode)
                                                <span class="badge bg-info text-dark me-1">{{ $seatCode }}</span>
                                            @endforeach
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- asuransi--}}
                    <div class="card info-card mb-4 shadow-sm">
                        <div class="card-header section-title-header">
                            <i class="bi bi-shield-check me-2"></i>Lindungi Perjalanan Anda
                        </div>
                        <div class="card-body">
                            <p class="mb-2">Tambahkan asuransi perjalanan untuk kenyamanan ekstra?</p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input addon-option" type="radio" name="opsiAsuransi" id="asuransiYa" value="{{ $addOnPrices['insurance'] }}" data-summary-label="Asuransi Perjalanan">
                                <label class="form-check-label" for="asuransiYa">Ya, Tambahkan (IDR {{ number_format($addOnPrices['insurance'], 0, ',', '.') }})</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input addon-option" type="radio" name="opsiAsuransi" id="asuransiTidak" value="0" checked>
                                <label class="form-check-label" for="asuransiTidak">Tidak, Terima Kasih</label>
                            </div>
                        </div>
                    </div>

                    {{-- tambah bagasi --}}
                    <div class="card info-card mb-4 shadow-sm">
                        <div class="card-header section-title-header">
                            <i class="bi bi-briefcase-fill me-2"></i>Tambah Bagasi Ekstra
                        </div>
                        <div class="card-body">
                            <p class="mb-2">Butuh bagasi lebih? Pilih tambahan (harga per penerbangan):</p>
                            <select class="form-select addon-option" id="opsiBagasi" data-summary-label-template="Bagasi Tambahan ({weight})">
                                <option value="0" data-weight="0kg" selected>Tidak ada tambahan bagasi</option>
                                @foreach ($addOnPrices['baggage'] as $weight => $price)
                                <option value="{{ $price }}" data-weight="{{ $weight }}">Tambah {{ $weight }} (IDR {{ number_format($price, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- food & drink --}}
                    <div class="card info-card mb-4 shadow-sm">
                        <div class="card-header section-title-header">
                            <i class="bi bi-cup-straw me-2"></i>Makanan & Minuman di Pesawat
                        </div>
                        <div class="card-body">
                            @if (!empty($selectedMealsDetails))
                                <h6 class="mb-2">Pesanan Makanan Anda:</h6>
                                <ul>
                                    @foreach ($selectedMealsDetails as $makananItem)
                                        <li>{{ $makananItem->name }} - IDR {{ number_format($makananItem->price, 0, ',', '.') }}</li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('makanan.index', ['booking_code' => $booking->booking_code]) }}"
                                class="btn btn-sm btn-outline-secondary mt-2">
                                    <i class="bi bi-pencil-square me-1"></i> Ubah Pilihan Makanan
                                </a>
                            @else
                                <p class="mb-2">Anda belum memilih makanan atau minuman.</p>
                                <a href="{{ route('makanan.index', ['booking_code' => $booking->booking_code]) }}"
                                class="btn btn-outline-primary">
                                    <i class="bi bi-cup-straw me-1"></i> Pilih Makanan dan Minuman
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Merchandise --}}
                    <div class="card info-card mb-4 shadow-sm">
                        <div class="card-header section-title-header">
                            <i class="bi bi-bag-heart me-2"></i>Merchandise Eksklusif dari HikmalAir
                        </div>
                        <div class="card-body">
                            @if (!empty($selectedMerchDetails) && !empty($selectedMerchDetails['items']))
                                <h6 class="mb-2">Merchandise Pilihan Anda:</h6>
                                <ul>
                                    @foreach ($selectedMerchDetails['items'] as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                                <p><strong>Subtotal Merchandise: IDR {{ $selectedMerchDetails['price_display'] ?? '0' }}</strong></p>
                                <a href="{{ route('merchant') }}" class="btn btn-sm btn-outline-secondary mt-2">
                                    <i class="bi bi-pencil-square me-1"></i> Ubah Pilihan Merchandise
                                </a>
                            @else
                                <p class="mb-2">Anda belum memilih merchandise apapun.</p>
                                <a href="{{ route('merchant') }}" class="btn btn-outline-primary">
                                    Pilih Merchandise <i class="bi bi-arrow-right-short"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- hotel --}}
                    <div class="card info-card mb-4 shadow-sm">
                        <div class="card-header section-title-header">
                            <i class="bi bi-building-check me-2"></i>Akomodasi Hotel
                        </div>
                        <div class="card-body">
                            @if ($selectedHotelDetails)
                                <h6 class="mb-2">Hotel yang Anda Pilih:</h6>
                                <p class="mb-1"><strong>{{ $selectedHotelDetails['hotel']['name'] ?? 'Nama Hotel Tidak Ditemukan' }}</strong></p>
                                <p class="mb-1 text-muted small">Kamar: {{ $selectedHotelDetails['selected_room'] ?? 'Tipe Kamar Tidak Ditemukan' }}</p>
                                <a href="{{ route('hotel') }}" class="btn btn-sm btn-outline-secondary mt-2">
                                    <i class="bi bi-pencil-square me-1"></i> Ubah Pilihan Hotel
                                </a>
                            @else
                                <p class="mb-2">Anda belum memilih akomodasi hotel.</p>
                                <a href="{{ route('hotel') }}" class="btn btn-outline-success">
                                    <i class="bi bi-plus-circle-fill me-1"></i> Tambahkan Hotel
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- penjemputan --}}
                    <div class="card info-card mb-4 shadow-sm">
                        <div class="card-header section-title-header">
                            <i class="bi bi-car-front-fill me-2"></i>Layanan Antar-Jemput Bandara
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input addon-option" type="checkbox" role="switch" id="opsiPenjemputanSwitch" data-summary-label-template="Antar-Jemput ({type})">
                                <label class="form-check-label" for="opsiPenjemputanSwitch">Ya, saya ingin layanan antar-jemput</label>
                            </div>
                            <div id="detailPenjemputan" style="display: none;">
                                <label for="tipeKendaraanPenjemputan" class="form-label">Pilih Tipe Kendaraan:</label>
                                <select class="form-select addon-option" id="tipeKendaraanPenjemputan">
                                    <option value="0" data-type="-" selected>Pilih tipe...</option>
                                    @foreach ($addOnPrices['pickup'] as $type => $price)
                                    <option value="{{ $price }}" data-type="{{ ucfirst(str_replace('_',' ',$type)) }}">
                                        {{ ucfirst(str_replace('_',' ',$type)) }} (IDR {{ number_format($price, 0, ',', '.') }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- rekapan pembayaran --}}
                    <div class="card info-card shadow-sm">
                        <div class="card-header section-title-header bg-primary text-white">
                            <i class="bi bi-receipt me-2"></i>Rincian Pembayaran
                        </div>
                        <div class="card-body p-4">
                            <dl class="price-summary-list">
                                <div class="d-flex justify-content-between">
                                    <dt>Harga Tiket ({{ $selectedTicket['airline_name'] }})</dt>
                                    <dd>IDR {{ $selectedTicket['price_display'] }}</dd>
                                </div>
                                @if($totalMakanan > 0)
                                <div class="d-flex justify-content-between">
                                    <dt>Makanan & Minuman</dt>
                                    <dd>IDR {{ number_format($totalMakanan, 0, ',', '.') }}</dd>
                                </div>
                                @endif
                                <!-- Tambahkan bagian lain jika ada (asuransi, bagasi, dll) -->
                            </dl>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center grand-total">
                                <h4 class="mb-0">Total Pembayaran</h4>
                                <h4 class="mb-0 fw-bold text-danger" id="grandTotalText">
                                    IDR {{ number_format($totalPembayaran, 0, ',', '.') }}
                                </h4>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="button" class="btn btn-success btn-lg fw-bold pay-now-btn" id="payNowButton">
                                    <i class="bi bi-credit-card-2-front-fill me-2"></i>Bayar Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <div class="modal fade" id="paymentSuccessModal" tabindex="-1" aria-labelledby="paymentSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentSuccessModalLabel">Pembayaran Berhasil!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                    <p class="mt-3 fs-5">Terima kasih atas pemesanan Anda.</p>
                    <p>Detail pemesanan telah dikirimkan ke email Anda.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary btn-back-dashbord" id="goToDashboardButton">Kembali ke Dashboard</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/konfirmasi.js') }}"></script>
    <script>
        const RIDEPOData = {
            selectedTicketPrice: {{ $selectedTicket['price_int'] ?? 0 }},
            selectedHotel: @json($selectedHotelDetails),
            selectedMeals: @json($selectedMealsDetails),
            addOnPrices: @json($addOnPrices)
        };

        const payNowButton = document.getElementById('payNowButton');
        const paymentSuccessModal = new bootstrap.Modal(document.getElementById('paymentSuccessModal'));
        const goToDashboardButton = document.getElementById('goToDashboardButton');

        payNowButton.addEventListener('click', function() {
            paymentSuccessModal.show();
        });

        goToDashboardButton.addEventListener('click', function() {
            window.location.href = '/dashboard';
        });

        const modalElement = document.getElementById('paymentSuccessModal');
        modalElement.addEventListener('hidden.bs.modal', function () {
        });
    </script>
</body>
</html>

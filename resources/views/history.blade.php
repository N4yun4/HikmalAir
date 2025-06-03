<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histori Pemesanan | HikmalAir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/history.css') }}">
</head>
<body>
    @include('partials.navbar')

    <main class="histori-pesanan-main-content py-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="mb-0 page-title">Histori Pemesanan Anda</h1>
                    </div>
                </div>
            </div>

            <div class="history-list-container">
                @if (isset($daftarPemesanan) && count($daftarPemesanan) > 0)
                    @foreach ($daftarPemesanan as $pesanan)
                    <div class="card pesanan-item mb-3 shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-1 text-center d-none d-md-block icon-col">
                                    @if ($pesanan['tipe_pesanan'] == 'Tiket Pesawat')
                                        <i class="bi bi-airplane-fill fs-2 text-primary"></i>
                                    @elseif ($pesanan['tipe_pesanan'] == 'Hotel')
                                        <i class="bi bi-building-fill fs-2 text-success"></i>
                                    @else
                                        <i class="bi bi-bag-check-fill fs-2 text-secondary"></i>
                                    @endif
                                </div>
                                <div class="col-md-5 item-details">
                                    <h5 class="item-title mb-1">{{ $pesanan['detail_utama'] }}</h5>
                                    <p class="text-muted small mb-1">ID Pemesanan: <span class="fw-medium">{{ $pesanan['id_pemesanan'] }}</span></p>
                                    <p class="text-muted small mb-0">Tgl. Pesan: {{ $pesanan['tanggal_pemesanan'] }}</p>
                                </div>
                                <div class="col-md-3 item-status-date mt-3 mt-md-0 text-md-center">
                                    <p class="text-muted small mb-1">Tgl. Perjalanan/Check-in:</p>
                                    <p class="fw-medium mb-1">{{ $pesanan['tanggal_perjalanan_atau_checkin'] }}</p>
                                    @php
                                        $statusClass = '';
                                        if ($pesanan['status'] == 'Selesai') $statusClass = 'text-bg-success';
                                        else if ($pesanan['status'] == 'Dibatalkan') $statusClass = 'text-bg-danger';
                                        else if ($pesanan['status'] == 'Menunggu Pembayaran') $statusClass = 'text-bg-warning';
                                        else if ($pesanan['status'] == 'Aktif') $statusClass = 'text-bg-info';
                                        else $statusClass = 'text-bg-secondary';
                                    @endphp
                                    <span class="badge rounded-pill {{ $statusClass }}">{{ $pesanan['status'] }}</span>
                                </div>
                                <div class="col-md-3 item-action mt-3 mt-md-0 text-md-end">
                                    <p class="price-display fw-bold mb-2">IDR {{ $pesanan['total_harga_display'] }}</p>
                                    {{-- <a href="{{ $pesanan['link_detail'] }}" class="btn btn-sm btn-outline-primary w-100 w-md-auto mb-2">
                                        Lihat Detail
                                    </a> --}}

                                    @if ($pesanan['tipe_pesanan'] == 'Tiket Pesawat' && $pesanan['status'] == 'Selesai')
                                        @if (isset($pesanan['sudah_rating']) && $pesanan['sudah_rating'] == true && isset($pesanan['rating_value']))
                                            <div class="rated-display mt-2">
                                                <small class="text-muted d-block">Rating Anda:</small>
                                                @for ($i = 1; $i <= 4; $i++)
                                                    <i class="bi bi-star-fill {{ $i <= $pesanan['rating_value'] ? 'text-warning' : 'text-light' }}" style="{{ $i <= $pesanan['rating_value'] ? '' : 'opacity:0.5;' }}"></i>
                                                @endfor
                                            </div>
                                        @else
                                            <div class="mt-2">
                                                <select class="form-select form-select-sm give-rating-dropdown" aria-label="Beri rating untuk {{ $pesanan['id_pemesanan'] }}" data-order-id="{{ $pesanan['id_pemesanan'] }}">
                                                    <option selected disabled value="">Beri Rating (1-4)</option>
                                                    <option value="1">⭐ (Buruk)</option>
                                                    <option value="2">⭐⭐ (Kurang)</option>
                                                    <option value="3">⭐⭐⭐ (Cukup)</option>
                                                    <option value="4">⭐⭐⭐⭐ (Baik)</option>
                                                </select>
                                                <button type="button" class="btn btn-sm btn-success mt-1 submit-rating-btn" data-order-id="{{ $pesanan['id_pemesanan'] }}">Kirim</button>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-clock-history fs-1 text-muted"></i>
                        <h4 class="mt-3">Belum Ada Histori Pemesanan</h4>
                        <p class="text-muted">Semua pemesanan tiket dan hotel Anda akan muncul di sini.</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-2">Mulai Cari Tiket atau Hotel</a>
                    </div>
                @endif
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
</body>
</html>

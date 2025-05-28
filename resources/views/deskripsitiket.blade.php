<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket: Surabaya - Jakarta | HikmalAir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/deskripsitiket.css') }}">
</head>
<body>
    @include('partials.navbar')

    <main class="deskripsi-tiket-main-content container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h2 mb-0">Detail Tiket & Pesan</h1>
                    <a href="{{ url('/pilihtiket') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-chevron-left"></i> Kembali
                    </a>
                </div>

                {{-- Detail Penerbangan Card --}}
                <div class="card detail-card flight-summary mb-4">
                    <h5 class="card-header section-header">
                        Surabaya (SUB) <i class="bi bi-arrow-right-short"></i> Jakarta (CGK)
                    </h5>
                    <div class="card-body p-lg-4 p-3">
                        <div class="row align-items-center mb-3">
                            <div class="col-auto airline-logo-wrapper">
                                <i class="bi bi-airplane-fill"></i>
                            </div>
                            <div class="col">
                                <h3 class="h5 mb-0 fw-bold">HikmalAir Contoh <small class="fw-normal">(HA-007)</small></h3>
                                <span class="badge text-bg-info fw-normal">Ekonomi Plus</span>
                            </div>
                            <div class="col-md-auto text-md-end mt-2 mt-md-0">
                                <span class="text-muted">Tanggal:</span> <strong>Min, 10 Agu 2025</strong>
                            </div>
                        </div>

                        <div class="row flight-details-grid align-items-center text-center">
                            <div class="col-md-4 location-info departure-info">
                                <div class="time">10:00</div>
                                <div class="code">SUB</div>
                                <div class="city text-muted">Surabaya</div>
                                <div class="small text-muted mt-1">Terminal: T1 Domestik</div>
                            </div>
                            <div class="col-md-4 duration-info my-3 my-md-0">
                                <div><i class="bi bi-clock me-1"></i> 1j 35m</div>
                                <div class="line my-1"></div>
                                <div><i class="bi bi-signpost-split me-1"></i> Langsung</div>
                            </div>
                            <div class="col-md-4 location-info arrival-info">
                                <div class="time">11:35</div>
                                <div class="code">CGK</div>
                                <div class="city text-muted">Jakarta Pusat</div>
                                <div class="small text-muted mt-1">Terminal: T3 Ultimate</div>
                            </div>
                        </div>

                        <hr class="my-3">
                        <p class="mb-1 small"><strong>Catatan Penerbangan:</strong></p>
                        <p class="text-muted small mb-0">Ini adalah deskripsi contoh untuk penerbangan. Termasuk bagasi kabin 7kg, pilihan kursi standar, dan makanan ringan gratis.</p>

                        <hr class="my-3">
                        <p class="mb-1 small"><strong>Fasilitas standar:</strong></p>
                        <div>
                            <span class="badge text-bg-light border me-1 mb-1 py-2 px-2 fw-normal">Kabin 7kg</span>
                            <span class="badge text-bg-light border me-1 mb-1 py-2 px-2 fw-normal">Pilihan Kursi</span>
                        </div>
                    </div>
                </div>

                {{-- Form Data Pemesan --}}
                <div class="card detail-card passenger-form-section mb-4">
                    <h5 class="card-header section-header">Isi Data Pemesan</h5>
                    <div class="card-body p-lg-4 p-3">
                        <form id="bookingForm" action="#" method="POST">
                            {{-- @csrf --}}
                            <input type="hidden" name="ticket_id_dummy" value="777">
                            <div class="mb-3">
                                <label for="contactFullName" class="form-label">Nama Lengkap Pemesan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="contactFullName" name="contact_full_name" placeholder="Sesuai KTP/Paspor" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="contactEmail" class="form-label">Alamat Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg" id="contactEmail" name="contact_email" placeholder="Untuk pengiriman e-tiket" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contactPhone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control form-control-lg" id="contactPhone" name="contact_phone" placeholder="Contoh: 08123456789" required>
                                </div>
                            </div>
                            <div class="form-text mb-0">Pastikan semua data pemesan sudah benar.</div>
                        </form>
                    </div>
                </div>

                <div class="card detail-card price-summary">
                    <h5 class="card-header section-header">Rincian Biaya</h5>
                    <div class="card-body p-lg-4 p-3">
                        <dl class="price-details mb-3">
                            <div class="row">
                                <dt class="col-sm-7">Harga Tiket (1 Dewasa)</dt>
                                <dd class="col-sm-5 text-sm-end">IDR 950.000</dd>
                            </div>
                            <div class="row">
                                <dt class="col-sm-7">Pajak & Biaya Lain</dt>
                                <dd class="col-sm-5 text-sm-end text-success">Termasuk</dd>
                            </div>
                        </dl>
                    <div class="d-grid mt-3">
                        <button type="submit" form="bookingForm" class="btn btn-lg fw-bold btn-konfirmasi-custom">LANJUTKAN KE KONFIRMASI PEMESANAN</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
</body>
</html>

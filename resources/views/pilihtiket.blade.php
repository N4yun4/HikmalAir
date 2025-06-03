<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Tiket | HikmalAir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pilihtiket.css') }}">
</head>
<body>
    @include('partials.navbar')

    <div class="pilihtiket-main-content">
        <div class="search-panel">
            <form class="row g-3 align-items-end" method="GET" action="{{ route('pilihtiket') }}">
                <div class="col-lg col-md-6">
                    <label for="departureCity" class="form-label visually-hidden">Dari (Kota atau Bandara)</label>
                    <input type="text" class="form-control form-control-lg" id="departureCity" name="dari" placeholder="Dari (Kota atau Bandara)" value="{{ $searchParams['dari'] ?? '' }}">
                </div>
                <div class="col-auto d-none d-md-flex align-items-center">
                    <i class="bi bi-arrow-left-right fs-4 interchange-icon" id="swapLocationsButton" style="cursor: pointer;"></i>
                </div>
                <div class="col-lg col-md-6">
                    <label for="arrivalCity" class="form-label visually-hidden">Ke (Kota atau Bandara)</label>
                    <input type="text" class="form-control form-control-lg" id="arrivalCity" name="ke" placeholder="Ke (Kota atau Bandara)" value="{{ $searchParams['ke'] ?? '' }}">
                </div>
                <div class="col-lg col-md-6 mt-md-0 mt-3">
                    <label for="departureDate" class="form-label visually-hidden">Tanggal Pergi</label>
                    <input type="date" class="form-control form-control-lg" id="departureDate" name="tanggal_berangkat" placeholder="Tanggal Pergi" value="{{ $searchParams['tanggal_berangkat'] ?? '' }}">
                </div>
                <div class="col-lg col-md-6 mt-md-0 mt-3" id="returnDateContainer">
                    <label for="returnDate" class="form-label visually-hidden">Tanggal Pulang</label>
                    <input type="date" class="form-control form-control-lg" id="returnDate" name="tanggal_pulang" placeholder="Tanggal Pulang" value="{{ $searchParams['tanggal_pulang'] ?? '' }}">
                </div>
                <div class="col-lg-auto col-md-12 mt-md-0 mt-3">
                    <label for="promoCode" class="form-label visually-hidden">Kode Promo</label>
                    <input type="text" class="form-control form-control-lg" id="promoCode" name="promo" placeholder="Kode Promo" value="{{ $searchParams['promo'] ?? '' }}">
                </div>
                <div class="col-lg-auto col-md-12 mt-lg-0 mt-3">
                    <button type="submit" class="btn btn-warning btn-lg w-100">Ubah Pencarian</button>
                </div>
                <div class="col-12 mt-3">
                    <div class="form-check form-switch d-flex justify-content-end">
                        <input class="form-check-input" type="checkbox" id="returnTripSwitch" name="pulang_pergi" value="1" {{ ($searchParams['pulang_pergi'] ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label ms-2" for="returnTripSwitch"><small>Pulang-Pergi?</small></label>
                    </div>
                </div>
            </form>
        </div>

        <div class="ticket-results-container">
            @if (!empty($searchParams['dari']) || !empty($searchParams['ke']) || !empty($searchParams['tanggal_berangkat']))
                <div class="search-summary text-center mb-3 p-2 bg-light border rounded">
                    <p class="mb-0">
                        Menampilkan tiket untuk:
                        @if(!empty($searchParams['dari'])) <strong class="text-primary">{{ $searchParams['dari'] }}</strong> @endif
                        @if(!empty($searchParams['dari']) && !empty($searchParams['ke'])) <i class="bi bi-arrow-right-short"></i> @endif
                        @if(!empty($searchParams['ke'])) <strong class="text-primary">{{ $searchParams['ke'] }}</strong> @endif
                        @if(!empty($searchParams['tanggal_berangkat']))
                            pada
                            <strong>{{ \Carbon\Carbon::parse($searchParams['tanggal_berangkat'])->translatedFormat('D, d M Y') }}</strong>
                        @endif
                        @if(($searchParams['pulang_pergi'] ?? false) && !empty($searchParams['tanggal_pulang']))
                            <br>Pulang: <strong>{{ \Carbon\Carbon::parse($searchParams['tanggal_pulang'])->translatedFormat('D, d M Y') }}</strong>
                        @endif
                    </p>
                </div>
            @endif

            <div class="filter-controls mb-4">
                <button class="btn filter-btn active" data-filter="semua">Semua</button>
                <button class="btn filter-btn" data-filter="pagi">Jam Pagi (05-11)</button>
                <button class="btn filter-btn" data-filter="siang">Jam Siang (11-15)</button>
                <button class="btn filter-btn" data-filter="malam">Jam Malam (18-00)</button>
            </div>

            <div id="ticketListContainer">
                @if (isset($tickets) && count($tickets) > 0)
                    <h3 class="mt-4 mb-3">Tiket Pergi</h3>
                    @foreach ($tickets as $ticket)
                    <div class="card ticket-item mb-3 shadow-sm">
                        <div class="card-body p-3">
                            <div class="row g-2 align-items-center">
                                <div class="col-lg-8 col-md-7">
                                    <div class="d-flex align-items-center justify-content-around text-center flight-route">
                                        <div class="departure-info">
                                            <div class="fs-5 fw-bold flight-time">{{ $ticket->departure_time->format('H:i') }}</div>
                                            <div class="small airport-code">{{ $ticket->departure_code }}</div>
                                            <div class="text-muted city-name" style="font-size: 0.75rem;">{{ $ticket->departure_city }}</div>
                                        </div>
                                        <div class="route-line mx-sm-2 mx-1">
                                            <small class="text-muted flight-duration d-block mb-1">{{ $ticket->duration }}</small>
                                            <div class="line"></div>
                                            <small class="text-primary fw-medium flight-transit d-block mt-1">{{ $ticket->transit_info }}</small>
                                        </div>
                                        <div class="arrival-info">
                                            <div class="fs-5 fw-bold flight-time">{{ $ticket->arrival_time->format('H:i') }}</div>
                                            <div class="small airport-code">{{ $ticket->arrival_code }}</div>
                                            <div class="text-muted city-name" style="font-size: 0.75rem;">{{ $ticket->arrival_city }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-5 text-md-end text-center mt-3 mt-md-0 price-info">
                                    <div class="ticket-price fw-bold fs-5 mb-2">IDR {{ $ticket->price_display }}</div>
                                    <a href="{{ route('tiket.deskripsi', ['id' => $ticket->id]) }}" class="btn btn-warning btn-sm fw-bold w-50 w-md-auto btn-pilih-tiket">PILIH</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="alert alert-warning text-center shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
                        <h5 class="alert-heading mt-1">Tiket Pergi Tidak Ditemukan</h5>
                        <p class="mb-0">Maaf, tidak ada penerbangan pergi yang tersedia untuk rute dan tanggal yang Anda pilih. Silakan coba ubah pencarian Anda.</p>
                    </div>
                @endif
            </div>

            @if (isset($returnTickets) && count($returnTickets) > 0)
                <h3 class="mt-5 mb-3">Tiket Pulang</h3>
                <div id="returnTicketListContainer">
                    @foreach ($returnTickets as $ticket)
                        <div class="card ticket-item mb-3 shadow-sm">
                            <div class="card-body p-3">
                                <div class="row g-2 align-items-center">
                                    <div class="col-lg-8 col-md-7">
                                        <div class="d-flex align-items-center justify-content-around text-center flight-route">
                                            <div class="departure-info">
                                                <div class="fs-5 fw-bold flight-time">{{ $ticket->departure_time->format('H:i') }}</div>
                                                <div class="small airport-code">{{ $ticket->departure_code }}</div>
                                                <div class="text-muted city-name" style="font-size: 0.75rem;">{{ $ticket->departure_city }}</div>
                                            </div>
                                            <div class="route-line mx-sm-2 mx-1">
                                                <small class="text-muted flight-duration d-block mb-1">{{ $ticket->duration }}</small>
                                                <div class="line"></div>
                                                <small class="text-primary fw-medium flight-transit d-block mt-1">{{ $ticket->transit_info }}</small>
                                            </div>
                                            <div class="arrival-info">
                                                <div class="fs-5 fw-bold flight-time">{{ $ticket->arrival_time->format('H:i') }}</div>
                                                <div class="small airport-code">{{ $ticket->arrival_code }}</div>
                                                <div class="text-muted city-name" style="font-size: 0.75rem;">{{ $ticket->arrival_city }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-5 text-md-end text-center mt-3 mt-md-0 price-info">
                                        <div class="ticket-price fw-bold fs-5 mb-2">IDR {{ $ticket->price_display }}</div>
                                        <a href="{{ route('tiket.deskripsi', ['id' => $ticket->id]) }}" class="btn btn-warning btn-sm fw-bold w-50 w-md-auto btn-pilih-tiket">PILIH</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif(($searchParams['pulang_pergi'] ?? false) && !empty($searchParams['tanggal_pulang']))
                <div class="alert alert-warning text-center mt-4 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
                    <h5 class="alert-heading mt-1">Tiket Pulang Tidak Ditemukan</h5>
                    <p class="mb-0">Maaf, tidak ada penerbangan pulang yang tersedia untuk rute dan tanggal yang Anda pilih. Silakan coba ubah pencarian Anda.</p>
                </div>
            @endif
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/searchpanel.js')}}"></script>
    <script src="{{ asset('js/pilihtiket.js')}}"></script>
    <script>
        const returnTripSwitch = document.getElementById('returnTripSwitch');
        const returnDateContainer = document.getElementById('returnDateContainer');
        const returnDateInput = document.getElementById('returnDate');

        function toggleReturnDate() {
            if (returnTripSwitch.checked) {
                returnDateContainer.style.display = 'block';
                returnDateInput.setAttribute('required', 'required');
            } else {
                returnDateContainer.style.display = 'none';
                returnDateInput.removeAttribute('required');
                returnDateInput.value = '';
            }
        }

        returnTripSwitch.addEventListener('change', toggleReturnDate);

        toggleReturnDate();

        const swapLocationsButton = document.getElementById('swapLocationsButton');
        const departureCityInput = document.getElementById('departureCity');
        const arrivalCityInput = document.getElementById('arrivalCity');

        swapLocationsButton.addEventListener('click', function() {
            const temp = departureCityInput.value;
            departureCityInput.value = arrivalCityInput.value;
            arrivalCityInput.value = temp;
        });

        const filterButtons = document.querySelectorAll('.filter-btn');
        const ticketItems = document.querySelectorAll('.ticket-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const filterType = this.dataset.filter;

                ticketItems.forEach(item => {
                    const departureTimeStr = item.querySelector('.flight-time').textContent;
                    const [hours, minutes] = departureTimeStr.split(':').map(Number);
                    const departureHour = hours;

                    let showTicket = false;

                    switch (filterType) {
                        case 'semua':
                            showTicket = true;
                            break;
                        case 'pagi':
                            showTicket = (departureHour >= 5 && departureHour < 11);
                            break;
                        case 'siang':
                            showTicket = (departureHour >= 11 && departureHour < 15);
                            break;
                        case 'malam':
                            showTicket = (departureHour >= 18 && departureHour < 24);
                            break;
                    }

                    if (showTicket) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>

    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Pilih Kursi | HikmalAir</title>
        <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
        <link rel="stylesheet" href="{{ asset('css/seat.css') }}">
    </head>
    <body>
        @include('partials.navbar')

        <div class="main-content">
            <form id="seatSelectionForm" action="{{ route('booking.finalize') }}" method="POST">
                @csrf
                <input type="hidden" name="ticket_id" value="{{ request('ticket_id') }}">
                <input type="hidden" name="contact_full_name" value="{{ request('contact_full_name') }}">
                <input type="hidden" name="contact_email" value="{{ request('contact_email') }}">
                <input type="hidden" name="contact_phone" value="{{ request('contact_phone') }}">
                <input type="hidden" name="selected_makanan" value="{{ $selected_makanan ?? '[]' }}">
                <input type="hidden" name="selected_hotel" value="{{ $selected_hotel ?? '[]' }}">
                <input type="hidden" name="selected_seats" id="selectedSeatsInput">

                <div class="seat-map">
                    <div class="seats-layout">
                        <div class="row-numbers">
                            <script>
                                document.write([...Array(17)].map((_, i) => `<div>${i + 1}</div>`).join(''));
                            </script>
                        </div>

                        <div class="seat-section">
                            <div class="seat-labels">
                                <div>A</div><div>B</div><div>C</div>
                            </div>
                            <div class="seat-column" id="left-seats"></div>
                        </div>

                        <div class="seat-section">
                            <div class="seat-labels">
                                <div>D</div><div>E</div><div>F</div>
                            </div>
                            <div class="seat-column" id="right-seats"></div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="confirm-btn">Konfirmasi Kursi</button>
            </form>
        </div>

        @include('partials.footer')

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/navbar.js') }}"></script>
        <script src="{{ asset('js/seat.js')}}"></script>
        <script>
            document.querySelector('.confirm-btn').addEventListener('click', function(event) {
                const selectedSeats = [];
                const seatElements = document.querySelectorAll('.seat.selected');

                seatElements.forEach(function(seat) {
                    selectedSeats.push(seat.dataset.seatCode);
                });

                console.log("Elemen kursi yang dipilih (.seat.selected):", selectedSeats);

                if (selectedSeats.length === 0) {
                    event.preventDefault();
                    alert('Silakan pilih setidaknya satu kursi sebelum melanjutkan.');
                    return;
                }

                document.getElementById('selectedSeatsInput').value = JSON.stringify(selectedSeats);
            });
        </script>
    </body>
    </html>

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
            <form id="seatSelectionForm" action="{{ route('booking.processBooking') }}" method="POST">
                @csrf
                {{-- Bidang tersembunyi untuk meneruskan data sebelumnya --}}
                <input type="hidden" name="ticket_id" value="{{ request('ticket_id') }}">
                <input type="hidden" name="contact_full_name" value="{{ request('contact_full_name') }}">
                <input type="hidden" name="contact_email" value="{{ request('contact_email') }}">
                <input type="hidden" name="contact_phone" value="{{ request('contact_phone') }}">
                {{-- Ini akan menyimpan kursi yang dipilih --}}
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
            // Pastikan kode seat.js selesai dijalankan sebelum ini
            // Tambahkan delay sedikit jika perlu, atau pastikan script tagnya di defer/async
        
            // Tambahkan console.log di sini untuk melihat elemen kursi yang ada
            console.log("Semua elemen dengan class 'seat':", document.querySelectorAll('.seat'));
        
            document.querySelector('.confirm-btn').addEventListener('click', function(event) {
                // event.preventDefault(); // Hentikan submit form sementara untuk debugging
        
                let selectedSeats = [];
                let seatElements = document.querySelectorAll('.seat.selected');
        
                console.log("Elemen kursi yang dipilih (.seat.selected):", seatElements);
        
                if (seatElements.length === 0) {
                    console.warn("Tidak ada kursi dengan class 'seat selected' ditemukan.");
                }
        
                seatElements.forEach(function(seatElement) {
                    let seatId = seatElement.dataset.seatCode;
                    if (seatId) {
                        selectedSeats.push(seatId);
                    } else {
                        console.error("Elemen kursi tidak memiliki data-seat-id:", seatElement);
                    }
                });
        
                console.log("Kursi yang terkumpul (selectedSeats array):", selectedSeats);
        
                let selectedSeatsInput = document.getElementById('selectedSeatsInput');
                selectedSeatsInput.value = JSON.stringify(selectedSeats);
        
                console.log("Nilai input tersembunyi #selectedSeatsInput:", selectedSeatsInput.value);
        
                // Jika Anda menggunakan event.preventDefault() di atas, hapus baris di bawah ini
                // jika Anda ingin form tetap disubmit setelah debugging.
                // document.getElementById('seatSelectionForm').submit();
            });
        </script>
    </body>
    </html>
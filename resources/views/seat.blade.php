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

    <button class="confirm-btn" onclick="handleConfirm()">Konfirmasi Kursi</button>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/seat.js')}}"></script>
</body>
</html>

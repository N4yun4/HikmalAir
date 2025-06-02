<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Meals On Board! - HikmalAir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/makanan.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body>
    @include('partials.navbar')

    <div class="hero-section"></div>

    <main class="makanan-main-content">
    <div class="meals-container">
    <div class="makanan-list-container">
        @if (isset($daftarMakanan) && count($daftarMakanan) > 0)
        @foreach ($daftarMakanan as $item)

        <div class="meal-card item-card"
            data-aos="fade-up"
            data-aos-delay="{{ $item['data_aos_delay'] ?? '100' }}"
            data-id="{{ $item['id'] }}"
            data-price="{{ $item['price'] }}">
            <div class="meal-card-content">
            <div class="image-wrapper meal-image-wrapper">
            <img src="{{ asset($item['image']) }}" class="meal-image" alt="{{ $item['name'] }}" />
            </div>
            <div class="meal-text item-info">
            <h5 class="item-name meal-name">{{ $item['name'] }}</h5>

            <p class="item-price meal-price fw-semibold text-success">
                IDR {{ $item['price_display'] }}
            </p>

            <p class="meal-description item-description">{{ $item['deskripsi'] }}</p>
            <div class="item-quantity-control mt-3">
                <div class="d-flex align-items-center">
                <label class="me-2 fw-medium">Jumlah:</label>
                <div class="quantity-control">
                <button type="button" class="quantity-decrement btn">
                    <i class="bi bi-dash"></i>
                </button>
                <input type="number" class="form-control quantity-input mx-2" value="0" min="0" max="10" readonly />
                <button type="button" class="quantity-increment btn">
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
        <div class="alert alert-light text-center">Belum ada data makanan yang tersedia saat ini.</div>
        @endif
    </div>

    @if (isset($daftarMakanan) && count($daftarMakanan) > 0)
    <div class="order-summary-container">
        <h3 class="title-section"><i class="bi bi-cup-straw me-2"></i>Ringkasan Pesanan Makanan</h3>
        <div id="orderSummaryList" class="mb-3">
        <div class="text-center py-4 no-selection-message">
            <i class="bi bi-basket3 fs-1 text-muted"></i>
            <p class="mt-2 text-muted">Keranjang makanan Anda masih kosong.</p>
            <p class="small text-muted">Pilih jumlah item makanan atau minuman di atas.</p>
        </div>
        </div>
        <div class="text-end mt-4 pt-3 border-top" id="totalSection" style="display: none;">
        <h4>Total Makanan: <span id="totalOverallPrice" class="fw-bold">IDR 0</span></h4>
        <form id="confirmMealsForm" action="{{ route('makanan.simpan') }}" method="POST">
            @csrf
            <input type="hidden" name="booking_code" value="{{ $booking_code }}">
            <div id="selectedMealsInputs"></div>
            <button type="submit" class="btn confirm-summary-btn mt-2">
                <i class="bi bi-check2-circle-fill me-1"></i> Konfirmasi Pilihan Makanan
            </button>
        </form>
        </div>
    </div>
    @endif
    </div>
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="{{ asset('js/makanan.js') }}"></script>
    <script>
        AOS.init({duration: 800, once: true});

        function updateSelectedMealsForm() {
            const selectedMealsContainer = document.getElementById('selectedMealsInputs');
            selectedMealsContainer.innerHTML = '';

            const selectedMeals = {};
            const quantityInputs = document.querySelectorAll('.quantity-input');

            quantityInputs.forEach(input => {
                const quantity = parseInt(input.value);
                if (quantity > 0) {
                    const mealCard = input.closest('.meal-card');
                    const mealId = mealCard.getAttribute('data-id');
                    selectedMeals[mealId] = quantity;

                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = `selectedMeals[${mealId}]`;
                    hiddenInput.value = quantity;
                    selectedMealsContainer.appendChild(hiddenInput);
                }
            });

            return selectedMeals;
        }

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('quantity-increment') ||
                e.target.classList.contains('quantity-decrement') ||
                e.target.closest('.quantity-increment') ||
                e.target.closest('.quantity-decrement')) {

                setTimeout(() => {
                    updateSelectedMealsForm();
                }, 100);
            }
        });

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity-input')) {
                updateSelectedMealsForm();
            }
        });

        document.getElementById('confirmMealsForm').addEventListener('submit', function(e) {
            const selectedMeals = updateSelectedMealsForm();

            if (Object.keys(selectedMeals).length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu makanan terlebih dahulu!');
                return false;
            }
        });

            function updateOrderSummary() {
        const orderSummaryList = document.getElementById('orderSummaryList');
        const totalSection = document.getElementById('totalSection');
        const noSelectionMessage = orderSummaryList.querySelector('.no-selection-message');
        const totalOverallPrice = document.getElementById('totalOverallPrice');

        const selectedMeals = updateSelectedMealsForm();
        const mealCards = document.querySelectorAll('.meal-card');

        if (Object.keys(selectedMeals).length > 0) {
            noSelectionMessage.style.display = 'none';
            totalSection.style.display = 'block';

            // Kosongkan ringkasan sebelum diisi ulang
            orderSummaryList.innerHTML = '';

            let totalPrice = 0;

            // Buat elemen untuk setiap makanan yang dipilih
            Object.entries(selectedMeals).forEach(([mealId, quantity]) => {
                const mealCard = document.querySelector(`.meal-card[data-id="${mealId}"]`);
                const mealName = mealCard.querySelector('.meal-name').textContent;
                const mealPrice = parseFloat(mealCard.getAttribute('data-price'));
                const mealTotal = mealPrice * quantity;

                totalPrice += mealTotal;

                const mealElement = document.createElement('div');
                mealElement.className = 'd-flex justify-content-between py-2 border-bottom';
                mealElement.innerHTML = `
                    <div>
                        <span class="fw-medium">${mealName}</span>
                        <span class="text-muted">x${quantity}</span>
                    </div>
                    <div>IDR ${mealTotal.toLocaleString('id-ID')}</div>
                `;

                orderSummaryList.appendChild(mealElement);
            });

            totalOverallPrice.textContent = `IDR ${totalPrice.toLocaleString('id-ID')}`;
            } else {
                noSelectionMessage.style.display = 'block';
                totalSection.style.display = 'none';
            }
        }

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('quantity-increment') ||
                e.target.classList.contains('quantity-decrement') ||
                e.target.closest('.quantity-increment') ||
                e.target.closest('.quantity-decrement')) {

                setTimeout(() => {
                    updateSelectedMealsForm();
                    updateOrderSummary();
                }, 100);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            updateOrderSummary();
        });
    </script>
</body>
</html>

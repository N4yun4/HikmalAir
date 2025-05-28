document.addEventListener('DOMContentLoaded', function() {
    // Logika dasar untuk menangani tanggal check-out tidak boleh sebelum check-in
    const forms = document.querySelectorAll('.hotel-selection-form');
    forms.forEach(form => {
        const checkinDateInput = form.querySelector('input[name="checkin_date"]');
        const checkoutDateInput = form.querySelector('input[name="checkout_date"]');

        if (checkinDateInput && checkoutDateInput) {
            // Atur tanggal minimal untuk check-in ke hari ini
            const today = new Date().toISOString().split('T')[0];
            checkinDateInput.min = today;

            checkinDateInput.addEventListener('change', function() {
                if (this.value) {
                    checkoutDateInput.min = this.value;
                    // Jika checkout sudah diisi dan jadi sebelum checkin (atau sama), reset checkout
                    if (checkoutDateInput.value && new Date(checkoutDateInput.value) <= new Date(this.value)) {
                        checkoutDateInput.value = '';
                        // Tambahkan satu hari ke checkin sebagai nilai default checkout jika diinginkan
                        let nextDay = new Date(this.value);
                        nextDay.setDate(nextDay.getDate() + 1);
                        checkoutDateInput.value = nextDay.toISOString().split('T')[0];
                        checkoutDateInput.min = checkoutDateInput.value; // Set min checkout baru
                    } else if (checkoutDateInput.value && new Date(checkoutDateInput.value) > new Date(this.value)) {
                        // Jika checkout valid, pastikan min juga diupdate
                        checkoutDateInput.min = this.value;
                         // Agar tidak bisa pilih tanggal checkout sebelum tanggal checkin + 1 hari
                        let minCheckout = new Date(this.value);
                        minCheckout.setDate(minCheckout.getDate() + 1);
                        checkoutDateInput.min = minCheckout.toISOString().split('T')[0];
                    } else {
                        // Jika checkin diubah dan checkout kosong, set min checkout ke checkin + 1
                        let minCheckout = new Date(this.value);
                        minCheckout.setDate(minCheckout.getDate() + 1);
                        checkoutDateInput.min = minCheckout.toISOString().split('T')[0];
                    }
                } else {
                    checkoutDateInput.min = today; // Jika checkin kosong, kembalikan min checkout ke hari ini
                }
            });

            checkoutDateInput.addEventListener('focus', function() {
                // Pastikan checkin sudah diisi sebelum memilih checkout
                if (!checkinDateInput.value) {
                    alert('Silakan pilih tanggal check-in terlebih dahulu.');
                    checkinDateInput.focus();
                    this.blur(); // Hapus fokus dari checkout
                    this.type = 'text'; // Kembalikan ke text agar placeholder terlihat
                    this.type = 'date'; // Lalu kembalikan ke date
                } else {
                    // Set min checkout saat fokus, jika belum diset atau checkin berubah
                    let minCheckout = new Date(checkinDateInput.value);
                    minCheckout.setDate(minCheckout.getDate() + 1);
                    this.min = minCheckout.toISOString().split('T')[0];
                }
            });

            checkoutDateInput.addEventListener('change', function() {
                if (this.value && checkinDateInput.value && new Date(this.value) <= new Date(checkinDateInput.value)) {
                    alert('Tanggal check-out tidak boleh sebelum atau sama dengan tanggal check-in.');
                    this.value = ''; // Kosongkan jika tidak valid
                }
            });
        }
    });

    const addToSummaryButtons = document.querySelectorAll('.add-to-summary-btn');
    const hotelOrderSummaryList = document.getElementById('hotelOrderSummaryList');
    const noSelectionMessage = hotelOrderSummaryList.querySelector('.no-selection-message');
    const totalSection = document.getElementById('totalSection');
    const totalOverallPriceEl = document.getElementById('totalOverallPrice');
    const confirmAllBookingsBtn = document.querySelector('.confirm-all-bookings-btn');
    let currentSelections = []; // Array untuk menyimpan pilihan hotel

    addToSummaryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.hotel-selection-form');
            const hotelId = form.dataset.hotelId;
            const hotelName = form.dataset.hotelName;
            const checkinDate = form.querySelector('input[name="checkin_date"]').value;
            const checkoutDate = form.querySelector('input[name="checkout_date"]').value;
            const roomTypeSelect = form.querySelector('select[name="room_type"]');
            const roomTypeName = roomTypeSelect.value;
            const selectedOption = roomTypeSelect.options[roomTypeSelect.selectedIndex];
            const roomPricePerNight = selectedOption ? parseInt(selectedOption.dataset.price) : 0;

            if (!checkinDate || !checkoutDate || !roomTypeName) {
                alert('Silakan lengkapi tanggal check-in, check-out, dan tipe kamar.');
                return;
            }
            if (new Date(checkoutDate) <= new Date(checkinDate)) {
                alert('Tanggal check-out harus setelah tanggal check-in.');
                return;
            }

            const date1 = new Date(checkinDate);
            const date2 = new Date(checkoutDate);
            const diffTime = Math.abs(date2 - date1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays <= 0) {
                alert('Durasi menginap minimal 1 malam.');
                return;
            }

            const estimatedPrice = roomPricePerNight * diffDays;
            // Buat ID unik untuk item ringkasan berdasarkan hotel, tipe kamar, dan tanggal check-in
            // Ini untuk mencegah duplikasi atau mempermudah update jika diperlukan
            const selectionId = `hotel-${hotelId}-${roomTypeName.replace(/\s+/g, '-')}-${checkinDate}`;

            // Cek apakah item dengan ID ini sudah ada di ringkasan
            const existingSelectionIndex = currentSelections.findIndex(sel => sel.id === selectionId);

            if (existingSelectionIndex > -1) {
                // Jika sudah ada, mungkin update atau beri notifikasi
                alert('Pilihan hotel, kamar, dan tanggal ini sudah ada di ringkasan Anda.');
                // currentSelections[existingSelectionIndex].duration = diffDays; // Contoh jika mau update
                // currentSelections[existingSelectionIndex].price = estimatedPrice;
            } else {
                // Jika belum ada, tambahkan baru
                const selection = {
                    id: selectionId,
                    hotelId: hotelId,
                    hotelName: hotelName,
                    checkin: checkinDate,
                    checkout: checkoutDate,
                    roomType: roomTypeName,
                    duration: diffDays,
                    price: estimatedPrice,
                    pricePerNight: roomPricePerNight
                };
                currentSelections.push(selection);
            }

            renderSummary();

            // Tutup collapse setelah ditambahkan (opsional)
            const collapseElement = form.closest('.collapse');
            if (collapseElement) {
                const bsCollapse = bootstrap.Collapse.getInstance(collapseElement);
                if (bsCollapse) {
                    bsCollapse.hide();
                }
            }
        });
    });

    function renderSummary() {
        if (noSelectionMessage) {
            noSelectionMessage.style.display = currentSelections.length === 0 ? 'block' : 'none';
        }
        if (totalSection) {
            totalSection.style.display = currentSelections.length === 0 ? 'none' : 'block';
        }
        if (confirmAllBookingsBtn) {
            confirmAllBookingsBtn.disabled = currentSelections.length === 0;
        }

        // Hapus item ringkasan lama sebelum render ulang
        const existingItems = hotelOrderSummaryList.querySelectorAll('.selected-hotel-item');
        existingItems.forEach(item => item.remove());

        let totalOverall = 0;
        currentSelections.forEach(sel => {
            totalOverall += sel.price;
            const itemHTML = `
                <div class="card selected-hotel-item mb-3 shadow-sm" data-summary-id="${sel.id}">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-title mb-1">${sel.hotelName}</h6>
                                <p class="card-text small text-muted mb-1">
                                    Tipe Kamar: <span class="room-type-summary fw-semibold">${sel.roomType}</span>
                                </p>
                                <p class="card-text small text-muted mb-0">
                                    Menginap: <span class="checkin-date-summary">${formatDate(sel.checkin)}</span> - <span class="checkout-date-summary">${formatDate(sel.checkout)}</span>
                                    (<span class="duration-summary">${sel.duration}</span> malam)
                                </p>
                            </div>
                            <button class="btn btn-sm btn-outline-danger remove-hotel-btn border-0" data-remove-id="${sel.id}" title="Hapus item ini"><i class="bi bi-x-lg"></i></button>
                        </div>
                        <hr class="my-2">
                        <p class="card-text fw-bold text-end price-summary">IDR ${sel.price.toLocaleString('id-ID')}</p>
                    </div>
                </div>`;
            // Masukkan sebelum pesan "belum ada pilihan" jika pesan itu ada
            if (noSelectionMessage) {
                noSelectionMessage.insertAdjacentHTML('beforebegin', itemHTML);
            } else {
                hotelOrderSummaryList.insertAdjacentHTML('beforeend', itemHTML);
            }
        });

        if (totalOverallPriceEl) {
            totalOverallPriceEl.textContent = `IDR ${totalOverall.toLocaleString('id-ID')}`;
        }

        // Tambahkan event listener ke tombol hapus yang baru dibuat
        hotelOrderSummaryList.querySelectorAll('.remove-hotel-btn').forEach(btn => {
            // Hapus event listener lama jika ada untuk mencegah duplikasi
            // (cara yang lebih baik adalah dengan event delegation pada parent, tapi ini cukup untuk sekarang)
            const newBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(newBtn, btn);

            newBtn.addEventListener('click', function() {
                const idToRemove = this.dataset.removeId;
                currentSelections = currentSelections.filter(s => s.id !== idToRemove);
                renderSummary(); // Render ulang ringkasan setelah menghapus
            });
        });
    }

    function formatDate(dateString) {
        if (!dateString) return '';
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        // Tambahkan penyesuaian zona waktu jika tanggal dari input date adalah UTC
        // dan ingin ditampilkan sebagai tanggal lokal tanpa konversi zona waktu yang rumit
        const date = new Date(dateString + 'T00:00:00'); // Anggap input adalah tanggal lokal tengah malam
        return date.toLocaleDateString('id-ID', options);
    }

    // Panggil renderSummary di awal untuk mengatur tampilan awal ringkasan
    renderSummary();
});

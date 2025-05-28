document.addEventListener('DOMContentLoaded', function () {
    // Ambil elemen-elemen interaktif
    const opsiPenjemputanSwitch = document.getElementById('opsiPenjemputanSwitch');
    const detailPenjemputanDiv = document.getElementById('detailPenjemputan');
    const tipeKendaraanSelect = document.getElementById('tipeKendaraanPenjemputan');

    // Semua elemen form yang bisa mengubah harga (Asuransi, Bagasi, Switch Penjemputan, Tipe Kendaraan)
    const addonOptions = document.querySelectorAll('.addon-option');

    // Elemen untuk menampilkan ringkasan harga
    const priceSummaryList = document.querySelector('.price-summary-list');
    const grandTotalText = document.getElementById('grandTotalText');

    // Mengambil data harga dari variabel global yang di-inject Blade
    const baseTicketPrice = RIDEPOData.selectedTicketPrice;
    const selectedHotel = RIDEPOData.selectedHotel;   // Bisa null atau objek hotel
    const selectedMeals = RIDEPOData.selectedMeals; // Bisa null atau objek makanan
    const addOnPrices = RIDEPOData.addOnPrices;

    // Fungsi untuk toggle tampilan detail penjemputan
    if (opsiPenjemputanSwitch && detailPenjemputanDiv) {
        opsiPenjemputanSwitch.addEventListener('change', function () {
            detailPenjemputanDiv.style.display = this.checked ? 'block' : 'none';
            if (!this.checked && tipeKendaraanSelect) {
                tipeKendaraanSelect.value = "0"; // Reset pilihan kendaraan
            }
            updatePriceSummary();
        });
        // Inisialisasi tampilan detail penjemputan
        detailPenjemputanDiv.style.display = opsiPenjemputanSwitch.checked ? 'block' : 'none';
    }

    // Fungsi untuk memformat angka menjadi format mata uang IDR
    function formatCurrency(amount) {
        return 'IDR ' + parseInt(amount).toLocaleString('id-ID');
    }

    // Fungsi untuk mengupdate ringkasan harga dan Grand Total
    function updatePriceSummary() {
        let currentTotal = baseTicketPrice;
        let summaryHTML = `
            <div class="d-flex justify-content-between">
                <dt>Harga Tiket (${RIDEPOData.selectedTicket ? RIDEPOData.selectedTicket.airline_name : 'Maskapai'})</dt>
                <dd>${formatCurrency(baseTicketPrice)}</dd>
            </div>`;

        // Kalkulasi dan tampilkan Hotel jika ada
        if (selectedHotel && selectedHotel.price_int > 0) {
            currentTotal += selectedHotel.price_int;
            summaryHTML += `
                <div class="d-flex justify-content-between">
                    <dt>Hotel (${selectedHotel.name})</dt>
                    <dd>${formatCurrency(selectedHotel.price_int)}</dd>
                </div>`;
        }

        // Kalkulasi dan tampilkan Makanan jika ada
        if (selectedMeals && selectedMeals.price_int > 0) {
            currentTotal += selectedMeals.price_int;
            summaryHTML += `
                <div class="d-flex justify-content-between">
                    <dt>Makanan & Minuman</dt>
                    <dd>${formatCurrency(selectedMeals.price_int)}</dd>
                </div>`;
        }

        // Kalkulasi Asuransi
        const asuransiYa = document.getElementById('asuransiYa');
        if (asuransiYa && asuransiYa.checked) {
            const insurancePrice = parseInt(asuransiYa.value); // value sudah harga
            if (insurancePrice > 0) {
                currentTotal += insurancePrice;
                summaryHTML += `
                    <div class="d-flex justify-content-between">
                        <dt>Asuransi Perjalanan</dt>
                        <dd>${formatCurrency(insurancePrice)}</dd>
                    </div>`;
            }
        }

        // Kalkulasi Bagasi
        const opsiBagasiSelect = document.getElementById('opsiBagasi');
        if (opsiBagasiSelect && opsiBagasiSelect.value !== "0") {
            const baggagePrice = parseInt(opsiBagasiSelect.value);
            const selectedOption = opsiBagasiSelect.options[opsiBagasiSelect.selectedIndex];
            const baggageWeight = selectedOption.dataset.weight;
            if (baggagePrice > 0) {
                currentTotal += baggagePrice;
                summaryHTML += `
                    <div class="d-flex justify-content-between">
                        <dt>Bagasi Tambahan (${baggageWeight})</dt>
                        <dd>${formatCurrency(baggagePrice)}</dd>
                    </div>`;
            }
        }

        // Kalkulasi Penjemputan
        if (opsiPenjemputanSwitch && opsiPenjemputanSwitch.checked && tipeKendaraanSelect && tipeKendaraanSelect.value !== "0") {
            const pickupPrice = parseInt(tipeKendaraanSelect.value);
            const selectedOption = tipeKendaraanSelect.options[tipeKendaraanSelect.selectedIndex];
            const vehicleType = selectedOption.dataset.type;
            if (pickupPrice > 0) {
                currentTotal += pickupPrice;
                summaryHTML += `
                    <div class="d-flex justify-content-between">
                        <dt>Antar-Jemput (${vehicleType})</dt>
                        <dd>${formatCurrency(pickupPrice)}</dd>
                    </div>`;
            }
        }

        // Update daftar ringkasan di HTML
        if (priceSummaryList) {
            priceSummaryList.innerHTML = summaryHTML;
        }

        // Update Grand Total di HTML
        if (grandTotalText) {
            grandTotalText.textContent = formatCurrency(currentTotal);
        }
    }

    // Tambahkan event listener ke semua elemen yang bisa mengubah harga
    addonOptions.forEach(element => {
        element.addEventListener('change', updatePriceSummary);
    });

    // Panggil updatePriceSummary sekali saat halaman dimuat untuk set nilai awal
    // berdasarkan pilihan default dan data dari server (hotel, makanan)
    updatePriceSummary();
});

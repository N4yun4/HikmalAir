document.addEventListener('DOMContentLoaded', function () {
    const opsiPenjemputanSwitch = document.getElementById('opsiPenjemputanSwitch');
    const detailPenjemputanDiv = document.getElementById('detailPenjemputan');
    const tipeKendaraanSelect = document.getElementById('tipeKendaraanPenjemputan');

    const addonOptions = document.querySelectorAll('.addon-option');

    const priceSummaryList = document.querySelector('.price-summary-list');
    const grandTotalText = document.getElementById('grandTotalText');

    const baseTicketPrice = RIDEPOData.selectedTicketPrice;
    const selectedHotel = RIDEPOData.selectedHotel;
    const selectedMeals = RIDEPOData.selectedMeals;
    const addOnPrices = RIDEPOData.addOnPrices;

    let totalMealPrice = 0;
    if (selectedMeals && Array.isArray(selectedMeals)) {
        totalMealPrice = selectedMeals.reduce((total, meal) => total + Number(meal.price), 0);
    }

    if (opsiPenjemputanSwitch && detailPenjemputanDiv) {
        opsiPenjemputanSwitch.addEventListener('change', function () {
            detailPenjemputanDiv.style.display = this.checked ? 'block' : 'none';
            if (!this.checked && tipeKendaraanSelect) {
                tipeKendaraanSelect.value = "0";
            }
            updatePriceSummary();
        });
        detailPenjemputanDiv.style.display = opsiPenjemputanSwitch.checked ? 'block' : 'none';
    }

    function formatCurrency(amount) {
        return 'IDR ' + parseInt(amount).toLocaleString('id-ID', {
            maximumFractionDigits: 0
        });
    }

    function updatePriceSummary() {
        let currentTotal = Number(baseTicketPrice) + Number(totalMealPrice);
        let summaryHTML = `
            <div class="d-flex justify-content-between">
                <dt>Harga Tiket</dt>
                <dd>${formatCurrency(baseTicketPrice)}</dd>
            </div>`;

        // Tambahkan makanan
        if (totalMealPrice > 0) {
            summaryHTML += `
                <div class="d-flex justify-content-between">
                    <dt>Makanan & Minuman</dt>
                    <dd>${formatCurrency(totalMealPrice)}</dd>
                </div>`;
        }

        // Tambahkan hotel jika ada
        if (selectedHotel && selectedHotel.hotel && selectedHotel.price) {
            currentTotal += Number(selectedHotel.price);
            summaryHTML += `
                <div class="d-flex justify-content-between">
                    <dt>Hotel (${selectedHotel.hotel.name})</dt>
                    <dd>${formatCurrency(selectedHotel.price)}</dd>
                </div>`;
        }

        // Asuransi
        const asuransiYa = document.getElementById('asuransiYa');
        if (asuransiYa && asuransiYa.checked) {
            const insurancePrice = Number(asuransiYa.value);
            if (insurancePrice > 0) {
                currentTotal += insurancePrice;
                summaryHTML += `
                    <div class="d-flex justify-content-between">
                        <dt>Asuransi Perjalanan</dt>
                        <dd>${formatCurrency(insurancePrice)}</dd>
                    </div>`;
            }
        }

        // Bagasi
        const opsiBagasiSelect = document.getElementById('opsiBagasi');
        if (opsiBagasiSelect && opsiBagasiSelect.value !== "0") {
            const baggagePrice = Number(opsiBagasiSelect.value);
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

        // Penjemputan
        if (opsiPenjemputanSwitch && opsiPenjemputanSwitch.checked && tipeKendaraanSelect && tipeKendaraanSelect.value !== "0") {
            const pickupPrice = Number(tipeKendaraanSelect.value);
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

        if (priceSummaryList) {
            priceSummaryList.innerHTML = summaryHTML;
        }

        if (grandTotalText) {
            grandTotalText.textContent = formatCurrency(currentTotal);
        }
    }

    addonOptions.forEach(element => {
        element.addEventListener('change', updatePriceSummary);
    });

    updatePriceSummary();
});

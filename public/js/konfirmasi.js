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
        return 'IDR ' + parseInt(amount).toLocaleString('id-ID');
    }

    function updatePriceSummary() {
        let currentTotal = baseTicketPrice;
        let summaryHTML = `
            <div class="d-flex justify-content-between">
                <dt>Harga Tiket (${RIDEPOData.selectedTicket ? RIDEPOData.selectedTicket.airline_name : 'Maskapai'})</dt>
                <dd>${formatCurrency(baseTicketPrice)}</dd>
            </div>`;

        if (selectedHotel && selectedHotel.price_int > 0) {
            currentTotal += selectedHotel.price_int;
            summaryHTML += `
                <div class="d-flex justify-content-between">
                    <dt>Hotel (${selectedHotel.name})</dt>
                    <dd>${formatCurrency(selectedHotel.price_int)}</dd>
                </div>`;
        }

        if (selectedMeals && selectedMeals.price_int > 0) {
            currentTotal += selectedMeals.price_int;
            summaryHTML += `
                <div class="d-flex justify-content-between">
                    <dt>Makanan & Minuman</dt>
                    <dd>${formatCurrency(selectedMeals.price_int)}</dd>
                </div>`;
        }

        const asuransiYa = document.getElementById('asuransiYa');
        if (asuransiYa && asuransiYa.checked) {
            const insurancePrice = parseInt(asuransiYa.value);
            if (insurancePrice > 0) {
                currentTotal += insurancePrice;
                summaryHTML += `
                    <div class="d-flex justify-content-between">
                        <dt>Asuransi Perjalanan</dt>
                        <dd>${formatCurrency(insurancePrice)}</dd>
                    </div>`;
            }
        }

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

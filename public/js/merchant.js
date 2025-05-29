document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.quantity-control').forEach(control => {
        const decrement = control.querySelector('.quantity-decrement');
        const increment = control.querySelector('.quantity-increment');
        const input = control.querySelector('.quantity-input');
        const merchantCard = control.closest('.merchant-card');
        const merchantId = merchantCard.dataset.merchantId;
        const price = parseInt(merchantCard.dataset.price) || 0;

        decrement.addEventListener('click', () => {
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
                updateOrderSummary(merchantId, price);
            }
        });

        increment.addEventListener('click', () => {
            if (parseInt(input.value) < 10) {
                input.value = parseInt(input.value) + 1;
                updateOrderSummary(merchantId, price);
            }
        });

        updateOrderSummary(merchantId, price);
    });

    function updateOrderSummary(merchantId, itemPrice) {
        const merchantCard = document.querySelector(`.merchant-card[data-merchant-id="${merchantId}"]`);
        const merchantName = merchantCard.querySelector('.merchant-name').textContent;
        const quantityInput = merchantCard.querySelector('.quantity-input');
        const quantity = parseInt(quantityInput.value);

        const totalPrice = itemPrice * quantity;

        const formattedPrice = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(totalPrice);

        const summaryList = document.getElementById('merchantOrderSummaryList');
        const existingItem = summaryList.querySelector(`.summary-item[data-merchant-id="${merchantId}"]`);

        if (quantity === 0) {
            if (existingItem) {
                existingItem.remove();
            }
        } else {
            if (!existingItem) {
                const summaryItem = document.createElement('div');
                summaryItem.className = 'summary-item card mb-2';
                summaryItem.dataset.merchantId = merchantId;
                summaryItem.innerHTML = `
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">${merchantName}</h6>
                                <p class="mb-1 small">${quantity} item</p>
                            </div>
                            <div>
                                <span class="text-primary fw-bold">${formattedPrice}</span>
                            </div>
                        </div>
                    </div>
                `;
                summaryList.appendChild(summaryItem);
            } else {
                existingItem.querySelector('.small').textContent = `${quantity} item`;
                existingItem.querySelector('.text-primary').textContent = formattedPrice;
            }
        }

        const noSelectionMessage = summaryList.querySelector('.no-selection-message');
        const items = summaryList.querySelectorAll('.summary-item');
        const totalSection = document.getElementById('totalSection');

        if (items.length > 0) {
            if (noSelectionMessage) noSelectionMessage.remove();
            totalSection.style.display = 'block';
            document.querySelector('.confirm-all-bookings-btn').disabled = false;
        } else {
            if (!noSelectionMessage) {
                summaryList.innerHTML = `
                    <div class="text-center py-4 no-selection-message">
                        <i class="bi bi-basket3 fs-1 text-muted"></i>
                        <p class="mt-2 text-muted">Keranjang pesanan merchant Anda masih kosong.</p>
                        <p class="small text-muted">Silakan pilih jumlah item di merchant yang tersedia.</p>
                    </div>
                `;
            }
            totalSection.style.display = 'none';
            document.querySelector('.confirm-all-bookings-btn').disabled = true;
        }
        updateTotalPrice();
    }

    function updateTotalPrice() {
        let total = 0;
        document.querySelectorAll('.summary-item').forEach(item => {
            const priceText = item.querySelector('.text-primary').textContent;
            const priceValue = parseInt(priceText.replace(/\D/g, '')) || 0;
            total += priceValue;
        });

        const formattedTotal = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(total);

        document.getElementById('totalOverallPrice').textContent = formattedTotal;
    }

    document.querySelector('.confirm-all-bookings-btn').addEventListener('click', function() {
        const items = [];
        document.querySelectorAll('.merchant-card').forEach(card => {
            const merchantId = card.dataset.merchantId;
            const quantityInput = card.querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value);

            if (quantity > 0) {
                items.push({
                    merchantId: merchantId,
                    quantity: quantity
                });
            }
        });

        alert(`Pesanan berhasil dikonfirmasi! Total item: ${items.length}`);
        console.log('Items to confirm:', items);
    });
});

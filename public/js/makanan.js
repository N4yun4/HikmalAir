document.addEventListener('DOMContentLoaded', function() {
    const confirmBtn = document.querySelector('.confirm-summary-btn');
    const originalHref = confirmBtn.getAttribute('href');

    document.querySelectorAll('.quantity-control').forEach(control => {
        const decrement = control.querySelector('.quantity-decrement');
        const increment = control.querySelector('.quantity-increment');
        const input = control.querySelector('.quantity-input');
        const mealCard = control.closest('.meal-card');
        const foodId = mealCard.dataset.id;
        const price = parseInt(mealCard.dataset.price) || 0;

        decrement.addEventListener('click', () => {
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
                updateOrderSummary(foodId, price);
            }
        });

        increment.addEventListener('click', () => {
            if (parseInt(input.value) < 10) {
                input.value = parseInt(input.value) + 1;
                updateOrderSummary(foodId, price);
            }
        });

        updateOrderSummary(foodId, price);
    });

    function updateOrderSummary(foodId, itemPrice) {
        const mealCard = document.querySelector(`.meal-card[data-id="${foodId}"]`);
        const foodName = mealCard.querySelector('.meal-name').textContent;
        const quantityInput = mealCard.querySelector('.quantity-input');
        const quantity = parseInt(quantityInput.value);

        const totalPrice = itemPrice * quantity;

        const formattedPrice = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(totalPrice);

        const summaryList = document.getElementById('orderSummaryList');
        const existingItem = summaryList.querySelector(`.summary-item[data-food-id="${foodId}"]`);

        if (quantity === 0) {
            if (existingItem) {
                existingItem.remove();
            }
        } else {
            if (!existingItem) {
                const summaryItem = document.createElement('div');
                summaryItem.className = 'summary-item card mb-2';
                summaryItem.dataset.foodId = foodId;
                summaryItem.innerHTML = `
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">${foodName}</h6>
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
            confirmBtn.classList.remove('disabled');
            confirmBtn.setAttribute('href', originalHref);
        } else {
            if (!noSelectionMessage) {
                summaryList.innerHTML = `
                    <div class="text-center py-4 no-selection-message">
                        <i class="bi bi-basket3 fs-1 text-muted"></i>
                        <p class="mt-2 text-muted">Keranjang makanan Anda masih kosong.</p>
                        <p class="small text-muted">Pilih jumlah item makanan atau minuman di atas.</p>
                    </div>
                `;
            }
            totalSection.style.display = 'none';
            confirmBtn.classList.add('disabled');
            confirmBtn.removeAttribute('href');
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
});

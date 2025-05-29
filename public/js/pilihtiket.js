document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-controls .filter-btn');
    const ticketCards = document.querySelectorAll('.ticket-item');
    const ticketListContainer = document.getElementById('ticketListContainer');

    let noResultsMessage = null;

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const filterValue = this.dataset.filter;
            applyFilter(filterValue);
        });
    });

    function applyFilter(filter) {
        let visibleCount = 0;
        ticketCards.forEach(card => {
            const departureTimeElement = card.querySelector('.departure-info .flight-time');

            if (!departureTimeElement) {
                card.style.display = 'none';
                return;
            }

            const departureTimeStr = departureTimeElement.textContent.trim();
            const hours = parseInt(departureTimeStr.split(':')[0], 10);

            let showCard = false;

            if (filter === 'semua') {
                showCard = true;
            } else if (filter === 'pagi') {
                if (hours >= 5 && hours < 11) {
                    showCard = true;
                }
            } else if (filter === 'siang') {
                if (hours >= 11 && hours < 15) {
                    showCard = true;
                }
            } else if (filter === 'malam') {
                if (hours >= 18 && hours <= 23) {
                    showCard = true;
                }
            }

            if (showCard) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noResultsMessage) {
            noResultsMessage.remove();
            noResultsMessage = null;
        }

        if (visibleCount === 0 && filter !== 'semua' && ticketListContainer) {
            noResultsMessage = document.createElement('div');
            noResultsMessage.className = 'alert alert-info text-center shadow-sm mt-3';
            noResultsMessage.setAttribute('role', 'alert');
            noResultsMessage.innerHTML = `
                <i class="bi bi-info-circle-fill fs-4 me-2"></i>
                <h5 class="alert-heading mt-1">Tidak Ada Tiket Sesuai Filter</h5>
                <p class="mb-0">Maaf, tidak ada penerbangan yang cocok dengan filter jam "<span class="fw-bold">${filter.charAt(0).toUpperCase() + filter.slice(1)}</span>" yang Anda pilih.</p>
            `;
            ticketListContainer.appendChild(noResultsMessage);
        }
    }

    const initialActiveFilter = document.querySelector('.filter-controls .filter-btn.active');
    if (initialActiveFilter) {
        applyFilter(initialActiveFilter.dataset.filter);
    }
});

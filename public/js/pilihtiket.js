document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-controls .filter-btn');
    const ticketCards = document.querySelectorAll('.ticket-item'); // Target kartu tiket dengan kelas .ticket-item
    const ticketListContainer = document.getElementById('ticketListContainer'); // Target div pembungkus kartu

    let noResultsMessage = null; // Variabel untuk menyimpan pesan "tidak ada hasil"

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Hapus kelas active dari semua tombol, lalu tambahkan ke tombol yang diklik
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

            // Sembunyikan kartu jika elemen waktu tidak ditemukan (sebagai fallback)
            if (!departureTimeElement) {
                card.style.display = 'none';
                return;
            }

            const departureTimeStr = departureTimeElement.textContent.trim(); // Contoh: "07:00"
            const hours = parseInt(departureTimeStr.split(':')[0], 10); // Ambil jamnya saja

            let showCard = false;

            if (filter === 'semua') {
                showCard = true;
            } else if (filter === 'pagi') { // Jam Pagi: 05:00 - 10:59
                if (hours >= 5 && hours < 11) {
                    showCard = true;
                }
            } else if (filter === 'siang') { // Jam Siang: 11:00 - 14:59
                if (hours >= 11 && hours < 15) {
                    showCard = true;
                }
            } else if (filter === 'malam') { // Jam Malam: 18:00 - 23:59
                if (hours >= 18 && hours <= 23) {
                    showCard = true;
                }
            }

            if (showCard) {
                card.style.display = ''; // Tampilkan card (kembalikan ke display defaultnya)
                visibleCount++;
            } else {
                card.style.display = 'none'; // Sembunyikan card
            }
        });

        // Hapus pesan "tidak ada hasil" yang lama jika ada
        if (noResultsMessage) {
            noResultsMessage.remove();
            noResultsMessage = null;
        }

        // Tampilkan pesan jika tidak ada tiket yang terlihat setelah filter (dan filter bukan 'semua')
        if (visibleCount === 0 && filter !== 'semua' && ticketListContainer) {
            noResultsMessage = document.createElement('div');
            noResultsMessage.className = 'alert alert-info text-center shadow-sm mt-3'; // Kelas Bootstrap untuk styling
            noResultsMessage.setAttribute('role', 'alert');
            noResultsMessage.innerHTML = `
                <i class="bi bi-info-circle-fill fs-4 me-2"></i>
                <h5 class="alert-heading mt-1">Tidak Ada Tiket Sesuai Filter</h5>
                <p class="mb-0">Maaf, tidak ada penerbangan yang cocok dengan filter jam "<span class="fw-bold">${filter.charAt(0).toUpperCase() + filter.slice(1)}</span>" yang Anda pilih.</p>
            `;
            ticketListContainer.appendChild(noResultsMessage);
        }
    }

    // Panggil filter 'semua' saat halaman pertama kali dimuat jika tombol 'Semua' aktif
    const initialActiveFilter = document.querySelector('.filter-controls .filter-btn.active');
    if (initialActiveFilter) {
        applyFilter(initialActiveFilter.dataset.filter);
    }
});

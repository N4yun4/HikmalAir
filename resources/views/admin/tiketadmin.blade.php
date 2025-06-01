<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Flight HikmalAir</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/tiketadmin.css') }}" />
</head>
<body onload="fetchFlights()">
    <div class="container">
        <header>
            <h1>Data Flight HikmalAir</h1>
        </header>

        <!-- Form untuk menambahkan flight -->
        <section class="form-section">
            <h2>Tambah Flight</h2>
            <form onsubmit="event.preventDefault(); addFlight();">
                <div class="form-row">
                    <div class="form-group">
                        <label for="airline_name">Nama Maskapai</label>
                        <input type="text" id="airline_name" placeholder="Contoh: Garuda Indonesia" required />
                    </div>
                    <div class="form-group">
                        <label for="flight_class">Kelas Penerbangan</label>
                        <select id="flight_class" required>
                            <option value="">Pilih Kelas</option>
                            <option value="Economy">Economy</option>
                            <option value="Premium Economy">Premium Economy</option>
                            <option value="Business">Business</option>
                            <option value="First Class">First Class</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="departure_city">Kota Keberangkatan</label>
                        <input type="text" id="departure_city" placeholder="Contoh: Jakarta" required />
                    </div>
                    <div class="form-group">
                        <label for="departure_code">Kode Keberangkatan</label>
                        <input type="text" id="departure_code" placeholder="Contoh: CGK" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="arrival_city">Kota Tujuan</label>
                        <input type="text" id="arrival_city" placeholder="Contoh: Surabaya" required />
                    </div>
                    <div class="form-group">
                        <label for="arrival_code">Kode Tujuan</label>
                        <input type="text" id="arrival_code" placeholder="Contoh: MLG" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="departure_time">Waktu Keberangkatan</label>
                        <input type="time" id="departure_time" required />
                    </div>
                    <div class="form-group">
                        <label for="arrival_time">Waktu Tiba</label>
                        <input type="time" id="arrival_time" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="duration">Durasi</label>
                        <input type="text" id="duration" placeholder="Contoh: 1j 30m" required />
                    </div>
                    <div class="form-group">
                        <label for="date">Tanggal Penerbangan</label>
                        <input type="date" id="date" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="transit_info">Info Transit</label>
                        <input type="text" id="transit_info" placeholder="Contoh: Langsung / 1 Transit" />
                    </div>
                    <div class="form-group">
                        <label for="price_int">Harga (Angka)</label>
                        <input type="number" id="price_int" placeholder="Contoh: 850000" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="price_display">Harga Display</label>
                        <input type="text" id="price_display" placeholder="Contoh: Rp 850.000" required />
                    </div>
                </div>

                <button type="submit">Tambah Flight</button>
                <div id="addMessage"></div>
            </form>
        </section>

        <!-- Tabel Data Flight -->
        <section class="table-section">
            <h2>Data Flight</h2>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Maskapai</th>
                            <th>Rute</th>
                            <th>Waktu</th>
                            <th>Durasi</th>
                            <th>Transit</th>
                            <th>Harga</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="flightTableBody">
                        <tr>
                            <td colspan="10">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Form Edit (Modal) -->
        <div id="overlay" class="overlay" onclick="closeEditForm()"></div>
        <div id="editFormContainer" class="form-section">
            <h2>Edit Flight</h2>
            <form onsubmit="event.preventDefault(); updateFlight();">
                <input type="hidden" id="edit_id" />

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_airline_name">Nama Maskapai</label>
                        <input type="text" id="edit_airline_name" required />
                    </div>
                    <div class="form-group">
                        <label for="edit_flight_class">Kelas Penerbangan</label>
                        <select id="edit_flight_class" required>
                            <option value="">Pilih Kelas</option>
                            <option value="Economy">Economy</option>
                            <option value="Premium Economy">Premium Economy</option>
                            <option value="Business">Business</option>
                            <option value="First Class">First Class</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_departure_city">Kota Keberangkatan</label>
                        <input type="text" id="edit_departure_city" required />
                    </div>
                    <div class="form-group">
                        <label for="edit_departure_code">Kode Keberangkatan</label>
                        <input type="text" id="edit_departure_code" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_arrival_city">Kota Tujuan</label>
                        <input type="text" id="edit_arrival_city" required />
                    </div>
                    <div class="form-group">
                        <label for="edit_arrival_code">Kode Tujuan</label>
                        <input type="text" id="edit_arrival_code" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_departure_time">Waktu Keberangkatan</label>
                        <input type="time" id="edit_departure_time" required />
                    </div>
                    <div class="form-group">
                        <label for="edit_arrival_time">Waktu Tiba</label>
                        <input type="time" id="edit_arrival_time" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_duration">Durasi</label>
                        <input type="text" id="edit_duration" required />
                    </div>
                    <div class="form-group">
                        <label for="edit_date">Tanggal Penerbangan</label>
                        <input type="date" id="edit_date" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_transit_info">Info Transit</label>
                        <input type="text" id="edit_transit_info" />
                    </div>
                    <div class="form-group">
                        <label for="edit_price_int">Harga (Angka)</label>
                        <input type="number" id="edit_price_int" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_price_display">Harga Display</label>
                        <input type="text" id="edit_price_display" required />
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit">Simpan Perubahan</button>
                    <button type="button" onclick="closeEditForm()" class="cancel-btn">Batal</button>
                </div>
                <div id="editMessage"></div>
            </form>
        </div>
    </div>

    <script>
        const apiUrl = '/api/flights';

        // Setup CSRF token for all AJAX requests
        function setupCSRF() {
            const token = document.querySelector('meta[name="csrf-token"]');
            if (token) {
                window.csrfToken = token.getAttribute('content');
            }
        }

        // Call setup on page load
        setupCSRF();

        async function fetchFlights() {
            try {
                const response = await fetch(apiUrl);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                const tableBody = document.getElementById('flightTableBody');

                if (data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="10">Tidak ada data flight</td></tr>';
                    return;
                }

                tableBody.innerHTML = '';
                data.forEach((flight) => {
                    const departureTime = new Date(`1970-01-01T${flight.departure_time}`).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});
                    const arrivalTime = new Date(`1970-01-01T${flight.arrival_time}`).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});
                    const flightDate = new Date(flight.date).toLocaleDateString('id-ID');

                    tableBody.innerHTML += `
                        <tr>
                            <td>${flight.id}</td>
                            <td>${flight.airline_name}</td>
                            <td>${flight.departure_city} (${flight.departure_code}) → ${flight.arrival_city} (${flight.arrival_code})</td>
                            <td>${departureTime} - ${arrivalTime}</td>
                            <td>${flight.duration}</td>
                            <td>${flight.transit_info || '-'}</td>
                            <td><span class="price-badge">${flight.price_display}</span></td>
                            <td><span class="class-badge">${flight.flight_class}</span></td>
                            <td>${flightDate}</td>
                            <td>
                                <button class="action-btn edit-btn" onclick="showEditForm(${flight.id})">Edit</button>
                                <button class="action-btn delete-btn" onclick="deleteFlight(${flight.id})">Hapus</button>
                            </td>
                        </tr>`;
                });
            } catch (error) {
                console.error('Error fetching flights:', error);
                document.getElementById('flightTableBody').innerHTML =
                    '<tr><td colspan="10">Gagal memuat data flight</td></tr>';
            }
        }

        async function addFlight() {
            const messageDiv = document.getElementById('addMessage');
            messageDiv.innerHTML = '';

            const payload = {
                airline_name: document.getElementById('airline_name').value.trim(),
                departure_city: document.getElementById('departure_city').value.trim(),
                departure_code: document.getElementById('departure_code').value.trim(),
                arrival_city: document.getElementById('arrival_city').value.trim(),
                arrival_code: document.getElementById('arrival_code').value.trim(),
                departure_time: document.getElementById('departure_time').value,
                arrival_time: document.getElementById('arrival_time').value,
                duration: document.getElementById('duration').value.trim(),
                transit_info: document.getElementById('transit_info').value.trim() || null,
                price_display: document.getElementById('price_display').value.trim(),
                price_int: parseInt(document.getElementById('price_int').value),
                flight_class: document.getElementById('flight_class').value,
                date: document.getElementById('date').value
            };

            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken || ''
                    },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (response.ok) {
                    messageDiv.innerHTML = '<div class="success-message">Flight berhasil ditambahkan</div>';
                    clearAddForm();
                    fetchFlights();
                } else {
                    let errorMsg = result.message || 'Gagal menambah flight';
                    if (result.errors) {
                        errorMsg += '<br>' + Object.values(result.errors).flat().join('<br>');
                    }
                    messageDiv.innerHTML = `<div class="error-message">${errorMsg}</div>`;
                }
            } catch (error) {
                console.error('Error adding flight:', error);
                messageDiv.innerHTML = '<div class="error-message">Terjadi kesalahan saat menambah flight</div>';
            }
        }

        function clearAddForm() {
            document.getElementById('airline_name').value = '';
            document.getElementById('departure_city').value = '';
            document.getElementById('departure_code').value = '';
            document.getElementById('arrival_city').value = '';
            document.getElementById('arrival_code').value = '';
            document.getElementById('departure_time').value = '';
            document.getElementById('arrival_time').value = '';
            document.getElementById('duration').value = '';
            document.getElementById('transit_info').value = '';
            document.getElementById('price_display').value = '';
            document.getElementById('price_int').value = '';
            document.getElementById('flight_class').value = '';
            document.getElementById('date').value = '';
        }

        async function showEditForm(id) {
            try {
                const response = await fetch(apiUrl);
                const flights = await response.json();
                const flight = flights.find(f => f.id === id);

                if (!flight) {
                    alert('Flight tidak ditemukan');
                    return;
                }

                document.getElementById('overlay').style.display = 'block';
                document.getElementById('editFormContainer').style.display = 'block';
                document.getElementById('edit_id').value = flight.id;
                document.getElementById('edit_airline_name').value = flight.airline_name;
                document.getElementById('edit_departure_city').value = flight.departure_city;
                document.getElementById('edit_departure_code').value = flight.departure_code;
                document.getElementById('edit_arrival_city').value = flight.arrival_city;
                document.getElementById('edit_arrival_code').value = flight.arrival_code;
                document.getElementById('edit_departure_time').value = flight.departure_time.substring(0, 5);
                document.getElementById('edit_arrival_time').value = flight.arrival_time.substring(0, 5);
                document.getElementById('edit_duration').value = flight.duration;
                document.getElementById('edit_transit_info').value = flight.transit_info || '';
                document.getElementById('edit_price_display').value = flight.price_display;
                document.getElementById('edit_price_int').value = flight.price_int;
                document.getElementById('edit_flight_class').value = flight.flight_class;
                document.getElementById('edit_date').value = flight.date;
                document.getElementById('editMessage').innerHTML = '';
            } catch (error) {
                console.error('Error loading flight data:', error);
                alert('Gagal memuat data flight');
            }
        }

        function closeEditForm() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('editFormContainer').style.display = 'none';
        }

        async function updateFlight() {
            const messageDiv = document.getElementById('editMessage');
            messageDiv.innerHTML = '';

            const id = document.getElementById('edit_id').value;
            const payload = {
                airline_name: document.getElementById('edit_airline_name').value.trim(),
                departure_city: document.getElementById('edit_departure_city').value.trim(),
                departure_code: document.getElementById('edit_departure_code').value.trim(),
                arrival_city: document.getElementById('edit_arrival_city').value.trim(),
                arrival_code: document.getElementById('edit_arrival_code').value.trim(),
                departure_time: document.getElementById('edit_departure_time').value,
                arrival_time: document.getElementById('edit_arrival_time').value,
                duration: document.getElementById('edit_duration').value.trim(),
                transit_info: document.getElementById('edit_transit_info').value.trim() || null,
                price_display: document.getElementById('edit_price_display').value.trim(),
                price_int: parseInt(document.getElementById('edit_price_int').value),
                flight_class: document.getElementById('edit_flight_class').value,
                date: document.getElementById('edit_date').value
            };

            try {
                const response = await fetch(`${apiUrl}/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken || ''
                    },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (response.ok) {
                    messageDiv.innerHTML = '<div class="success-message">Flight berhasil diperbarui</div>';
                    fetchFlights();
                    // Tutup form edit setelah 1 detik
                    setTimeout(closeEditForm, 1000);
                } else {
                    let errorMsg = result.message || 'Gagal memperbarui flight';
                    if (result.errors) {
                        errorMsg += '<br>' + Object.values(result.errors).flat().join('<br>');
                    }
                    messageDiv.innerHTML = `<div class="error-message">${errorMsg}</div>`;
                }
            } catch (error) {
                console.error('Error updating flight:', error);
                messageDiv.innerHTML = '<div class="error-message">Terjadi kesalahan saat memperbarui flight</div>';
            }
        }

        async function deleteFlight(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus flight ini?')) {
                return;
            }

            try {
                const response = await fetch(`${apiUrl}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': window.csrfToken || ''
                    }
                });

                if (response.ok) {
                    alert('Flight berhasil dihapus');
                    fetchFlights();
                } else {
                    const result = await response.json();
                    alert(`Gagal menghapus flight: ${result.message}`);
                }
            } catch (error) {
                console.error('Error deleting flight:', error);
                alert('Terjadi kesalahan saat menghapus flight');
            }
        }
    </script>
</body>
</html>

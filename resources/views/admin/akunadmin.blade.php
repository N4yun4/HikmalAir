<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Admin HikmalAir</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/akunadmin.css') }}" />
</head>
<body onload="fetchAdmins()">
    @include('partials.adminnavbar')

    <div class="container">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h1>Data Admin HikmalAir</h1>
            <a href="{{ route('admin.dashboardadmin') }}" class="btn btn-custom">
                ← Kembali ke Dashboard
            </a>
        </header>

        <section class="form-section">
            <h2>Tambah Admin</h2>
            <form onsubmit="event.preventDefault(); addAdmin();">
                <input type="text" id="usr_admin" placeholder="Username" required />
                <input type="password" id="pass_admin" placeholder="Password" required />
                <input type="text" id="notlp_admin" placeholder="No Telepon" />
                <button type="submit">Tambah</button>
                <div id="addMessage"></div>
            </form>
        </section>

        <section class="table-section">
            <h2>Data Admin</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nomor Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="adminTableBody">
                    <tr>
                        <td colspan="4">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <div id="overlay" class="overlay" style="display: none;" onclick="closeEditForm()"></div>
        <div id="editFormContainer" style="display: none;" class="form-section">
            <h2>Edit Admin</h2>
            <form onsubmit="event.preventDefault(); updateAdmin();">
                <input type="hidden" id="edit_id" />
                <input type="text" id="edit_usr_admin" placeholder="Username" required />
                <input type="password" id="edit_pass_admin" placeholder="(Kosongkan jika tidak mengganti)" />
                <input type="text" id="edit_notlp_admin" placeholder="No Telepon" />
                <div id="editMessage"></div>
                <div class="form-buttons">
                    <button type="submit">Simpan Perubahan</button>
                    <button type="button" onclick="closeEditForm()" class="cancel-btn">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const apiUrl = '/api/admins';

        function setupCSRF() {
            const token = document.querySelector('meta[name="csrf-token"]');
            if (token) {
                window.csrfToken = token.getAttribute('content');
            }
        }

        setupCSRF();

        async function fetchAdmins() {
            try {
                const response = await fetch(apiUrl);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                const tableBody = document.getElementById('adminTableBody');

                if (data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="4">Tidak ada data admin</td></tr>';
                    return;
                }

                tableBody.innerHTML = '';
                data.forEach((admin) => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${admin.id}</td>
                            <td>${admin.usr_admin}</td>
                            <td>${admin.notlp_admin || '-'}</td>
                            <td>
                                <button class="action-btn edit-btn" onclick="showEditForm(${admin.id}, '${admin.usr_admin}', '${admin.notlp_admin || ''}')">
                                    Edit
                                </button>
                                <button class="action-btn delete-btn" onclick="deleteAdmin(${admin.id})">Hapus</button>
                            </td>
                        </tr>`;
                });
            } catch (error) {
                console.error('Error fetching admins:', error);
                document.getElementById('adminTableBody').innerHTML =
                    '<tr><td colspan="4">Gagal memuat data admin</td></tr>';
            }
        }

        async function addAdmin() {
            const messageDiv = document.getElementById('addMessage');
            messageDiv.innerHTML = '';

            const payload = {
                usr_admin: document.getElementById('usr_admin').value.trim(),
                pass_admin: document.getElementById('pass_admin').value,
                notlp_admin: document.getElementById('notlp_admin').value.trim() || null,
            };

            if (!payload.usr_admin) {
                messageDiv.innerHTML = '<div class="error-message">Username tidak boleh kosong</div>';
                return;
            }
            if (!payload.pass_admin || payload.pass_admin.length < 6) {
                messageDiv.innerHTML = '<div class="error-message">Password minimal 6 karakter</div>';
                return;
            }

            try {
                const response = await fetch('/api/admins', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken || ''
                    },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (response.ok) {
                    messageDiv.innerHTML = '<div class="success-message">Admin berhasil ditambahkan</div>';
                    clearAddForm();
                    fetchAdmins();
                } else {
                    let errorMsg = result.message || 'Gagal menambah admin';
                    if (result.errors) {
                        errorMsg += '<br>' + Object.values(result.errors).flat().join('<br>');
                    }
                    messageDiv.innerHTML = `<div class="error-message">${errorMsg}</div>`;
                }
            } catch (error) {
                console.error('Error adding admin:', error);
                messageDiv.innerHTML = '<div class="error-message">Terjadi kesalahan saat menambah admin</div>';
            }
        }

        function clearAddForm() {
            document.getElementById('usr_admin').value = '';
            document.getElementById('pass_admin').value = '';
            document.getElementById('notlp_admin').value = '';
        }

        function showEditForm(id, usr_admin, notlp_admin) {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('editFormContainer').style.display = 'block';
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_usr_admin').value = usr_admin;
            document.getElementById('edit_pass_admin').value = '';
            document.getElementById('edit_notlp_admin').value = notlp_admin || '';
            document.getElementById('editMessage').innerHTML = '';
        }

        function closeEditForm() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('editFormContainer').style.display = 'none';
        }

        async function updateAdmin() {
            const messageDiv = document.getElementById('editMessage');
            messageDiv.innerHTML = '';

            const id = document.getElementById('edit_id').value;
            const usr_admin = document.getElementById('edit_usr_admin').value.trim();
            const pass_admin = document.getElementById('edit_pass_admin').value;
            const notlp_admin = document.getElementById('edit_notlp_admin').value.trim();

            const payload = { usr_admin, notlp_admin };
            if (pass_admin.trim() !== '') payload.pass_admin = pass_admin;

            if (!usr_admin) {
                messageDiv.innerHTML = '<div class="error-message">Username tidak boleh kosong</div>';
                return;
            }

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
                    messageDiv.innerHTML = '<div class="success-message">Admin berhasil diperbarui</div>';
                    setTimeout(() => {
                        closeEditForm();
                        fetchAdmins();
                    }, 1500);
                } else {
                    let errorMsg = result.message || 'Gagal memperbarui admin';
                    if (result.errors) {
                        errorMsg += '<br>' + Object.values(result.errors).flat().join('<br>');
                    }
                    messageDiv.innerHTML = `<div class="error-message">${errorMsg}</div>`;
                }
            } catch (error) {
                console.error('Error updating admin:', error);
                messageDiv.innerHTML = '<div class="error-message">Terjadi kesalahan saat update</div>';
            }
        }

        async function deleteAdmin(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus admin ini?')) {
                return;
            }

            try {
                const response = await fetch(`${apiUrl}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': window.csrfToken || ''
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    alert('Admin berhasil dihapus');
                    fetchAdmins();
                } else {
                    alert(result.message || 'Gagal menghapus admin');
                }
            } catch (error) {
                console.error('Error deleting admin:', error);
                alert('Terjadi kesalahan saat menghapus admin');
            }
        }
    </script>
</body>
</html>

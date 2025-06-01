<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
</head>
<body class="bg-light">
    @include('partials.adminnavbar')

    <div class="container py-5">
        <h2 class="mb-4 text-center">Dashboard Admin</h2>
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="card card-hover shadow text-center" onclick="location.href='{{ url('/admin/akunadmin') }}'">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Akun Admin</h5>
                        <p class="card-text">Tambah, ubah, dan hapus akun admin.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card card-hover shadow text-center" onclick="location.href='{{ url('/admin/tiketadmin') }}'">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Tiket</h5>
                        <p class="card-text">Lihat dan kelola tiket penerbangan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

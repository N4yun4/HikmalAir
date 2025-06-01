<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/loginadmin.css') }}">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card-admin-login">

                    <h3 class="text-center mb-4"><i class="bi bi-person-circle"></i> Login Admin</h3>

                    @if ($errors->any())
                        <div class="error-list">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="usr_admin" class="form-label">Username</label>
                            <input type="text" name="usr_admin" class="form-control" id="usr_admin" value="{{ old('usr_admin') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="pass_admin" class="form-label">Password</label>
                            <input type="password" name="pass_admin" class="form-control" id="pass_admin" required>
                        </div>

                        <button type="submit" class="btn btn-admin w-100">Login</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
</html>

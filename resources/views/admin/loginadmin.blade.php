<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 25rem;">
        <h4 class="text-center mb-4">Login Admin</h4>
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        <form method="POST" action="{{ url('/admin/login') }}">
            @csrf
            <div class="mb-3">
                <label for="usr_admin" class="form-label">Username</label>
                <input type="text" name="usr_admin" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="pass_admin" class="form-label">Password</label>
                <input type="password" name="pass_admin" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>

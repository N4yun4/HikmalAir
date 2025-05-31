<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | HikmalAir</title>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container fade-in">
    <div class="left-section fade-in">
      <img src="/images/logoNoBorder.png" alt="HikmalAir Logo" class="logo">
      <div class="separator"></div>
      <div class="slogan">
        <h1>Where Every<br>Journey Becomes<br><span class="legacy">a Legacy!</span></h1>
      </div>
    </div>

    <div class="form-section fade-in">
      <h2>Login</h2>

      {{-- MENAMPILKAN PESAN SUKSES DARI SESSION --}}
      @if (session('success'))
        <div style="color: green; background-color: #d4edda; border-color: #c3e6cb; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            {{ session('success') }}
        </div>
      @endif

      {{-- MENAMPILKAN PESAN ERROR DARI SESSION (misal: login gagal) --}}
      @if (session('error'))
        <div style="color: red; background-color: #f8d7da; border-color: #f5c6cb; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            {{ session('error') }}
        </div>
      @endif

      {{-- MENAMPILKAN PESAN ERROR VALIDASI (misal: input kosong) --}}
      @if ($errors->any())
        <div style="color:red; background-color: #f8d7da; border-color: #f5c6cb; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif

      {{-- PERHATIKAN: action form harus mengarah ke rute POST 'actionlogin' --}}
      <form action="{{ route('actionlogin') }}" method="POST">
        @csrf
        <div class="input-group">
          {{-- PERHATIKAN: nama input adalah 'email_or_username' sesuai LoginController --}}
          <label for="email_or_username">Email atau Username</label>
          <input type="text" id="email_or_username" name="email_or_username" value="{{ old('email_or_username') }}" required autofocus>
          {{-- Menampilkan error spesifik untuk input ini --}}
          @error('email_or_username')
              <div style="color:red; font-size:0.8em; margin-top: 5px;">{{ $message }}</div>
          @enderror
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
          {{-- Menampilkan error spesifik untuk password --}}
          @error('password')
              <div style="color:red; font-size:0.8em; margin-top: 5px;">{{ $message }}</div>
          @enderror
        </div>

        <div class="actions">
          <a href="{{ route('register') }}">Belum punya akun?</a> {{-- Gunakan route() --}}
          <button type="submit">Masuk</button>
        </div>
      </form>
    </div>
  </div>
</body>
<style>
    * {
      box-sizing: border-box;
      font-family: 'Lato', sans-serif;
    }

    body {
      margin: 0;
      padding: 0;
      background: url('/images/bgLogin.jpg') no-repeat center center fixed;
      background-size: cover;
    }

    @keyframes fade-in {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in {
      animation: fade-in 0.8s ease-out;
    }

    .container {
      display: flex;
      align-items: center;
      height: 100vh;
    }

    .left-section {
      flex: 1;
      max-width: 950px;
      display: flex;
      align-items: center;
      background: rgba(0, 0, 0, 0.55);
      padding: 40px 50px;
      color: white;
    }

    .logo {
      width: 190px;
      height: auto;
      margin-right: 20px;
    }

    .separator {
      border-left: 3px solid white;
      height: 26vh;
      margin: 0 10px;
    }

    .slogan h1 {
      margin: 0;
      font-size: 32px;
      line-height: 1.4;
      color: white;
    }

    .legacy {
      color: #D4AF37;
    }

    .form-section {
      background: rgba(23, 53, 83, 0.95);
      padding: 30px;
      border-radius: 15px;
      width: 420px;
      height : 400px;
      color: white;
      display: flex;
      flex-direction: column;
      margin-right: 40px;
      justify-content: center;
      padding-top: 10px;
    }

    .form-section h2 {
      margin-top: 0;
      margin-bottom: 20px;
      font-size: 24px;
      text-align: center;
      font-weight: normal;
    }

    .form-section label {
      font-size: 13px;
      margin-bottom: 4px;
      display: block;
      font-weight: normal;
    }

    .form-section input[type="text"],
    .form-section input[type="password"] {
      width: 100%;
      padding: 8px 10px;
      margin-bottom: 12px;
      border: none;
      border-radius: 6px;
      font-size: 13px;
      transition: all 0.3s ease;
    }

    .form-section input:focus {
      outline: none;
      box-shadow: 0 0 5px rgba(255, 255, 255, 0.7);
      background-color: rgba(255, 255, 255, 0.95);
      color: #000;
    }

    .form-section .input-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 10px;
    }

    .form-section .actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .form-section .actions a {
      color: #fff;
      text-decoration: underline;
      font-size: 13px;
    }

    .form-section button {
      background-color: white;
      color: #001324;
      border: none;
      padding: 8px 16px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: normal;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    .form-section button:hover {
      background-color: #ddd;
      transform: scale(1.02);
    }
    
    .success-message, .error-message {
        font-size: 0.95em;
        line-height: 1.4;
    }
    .success-message li, .error-message li {
        list-style: none; /* Hapus bullet point untuk list di pesan error */
    }
</style>
</html>
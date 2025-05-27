<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar | HikmalAir</title>
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
      <h2>Sign Up</h2>
      <form action="" method="POST">
        @csrf
        <div class="row">
          <div class="input-group">
            <label for="first_name">Nama Depan</label>
            <input type="text" id="first_name" name="first_name" required>
          </div>
          <div class="input-group">
            <label for="last_name">Nama Belakang</label>
            <input type="text" id="last_name" name="last_name" required>
          </div>
        </div>

        <div class="input-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div class="input-group">
          <label for="phone">Nomor HP</label>
          <input type="tel" id="phone" name="phone" required>
        </div>

        <div class="input-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required>
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>

        <div class="checkbox">
          <label>
            <input type="checkbox" required>
            dengan ini, anda menyetujui segala kebijakan dari maskapai kami
          </label>
        </div>

        <div class="actions">
          <a href="/login">Sudah memiliki akun</a>
          <button type="submit">Buat akun</button>
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
      color: white;
      display: flex;
      flex-direction: column;
      margin-right: 40px;
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
    .form-section input[type="email"],
    .form-section input[type="password"],
    .form-section input[type="tel"] {
      width: 100%;
      padding: 8px 10px;
      margin-bottom: 10px;
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

    .form-section .row {
      display: flex;
      gap: 8px;
    }

    .form-section .row .input-group {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .form-section .input-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 10px;
    }

    .form-section .checkbox {
      margin-bottom: 15px;
      font-size: 12px;
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
</style>
</html>
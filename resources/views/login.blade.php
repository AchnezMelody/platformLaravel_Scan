<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Masuk · Mesin Penukaran Botol</title>
@include('partials.gaya')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  form.masuk { display: flex; flex-direction: column; gap: 16px; }
  input { width: 100%; padding: 16px 24px; border-radius: 999px; border: 2px solid #b9cbc4;
          font-size: 18px; background: #fff; color: #111; }
  input:focus { outline: 3px solid #f5c518; border-color: #226b52; }
  .galat { color: #b3261e; font-weight: 500; }
  .ket { color: #444; font-size: 15px; }

  /* ---- Input dengan icon (ID User & Password) ---- */
  .input-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
    text-align: left;          /* reset center dari parent */
  }
  .input-group label {
    font-size: 14px;
    font-weight: 600;
    color: #226b52;
    text-align: left;
    align-self: flex-start;
  }

  .input-icon, .password-wrapper { position: relative; }

  .input-icon i,
  .password-wrapper .lock-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #9aaeb9;
    font-size: 16px;
    pointer-events: none;
  }

  .input-icon input,
  .password-wrapper input {
    width: 100%;
    padding: 14px 20px 14px 46px;
    border-radius: 999px;
    border: 2px solid #b9cbc4;
    font-size: 16px;
    background: #fff;
    color: #111;
    box-sizing: border-box;
    text-align: left;          /* pastikan teks input rata kiri */
  }

  .input-icon input:focus,
  .password-wrapper input:focus {
    outline: 3px solid #f5c518;
    border-color: #226b52;
  }

  .password-wrapper input { padding-right: 46px; }

  .toggle-password {
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
    cursor: pointer;
    font-size: 16px;
  }
  .toggle-password:hover { color: #226b52; }

  /* ---- Tombol Masuk dengan icon ---- */
  button[type="submit"] {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
  }
  button[type="submit"] i { font-size: 16px; }
</style>
</head>
<body>
  @include('partials.kiri')

  <div class="kanan">
    <div class="layar aktif">
      <h1>Masuk untuk Menukar Botol</h1>
      <p class="ket">Gunakan akun yang sama dengan akun dompet poinmu.</p>

      @if ($errors->any())
        <p class="galat" role="alert">{{ $errors->first() }}</p>
      @endif

      <form class="masuk" method="POST" action="{{ url('/login') }}">
        @csrf

        <div class="input-group">
          <label for="id_user">ID User</label>
          <div class="input-icon">
            <i class="fas fa-id-card"></i>
            <input type="text" name="id_user" id="id_user" placeholder="Masukkan ID User"
                   value="{{ old('id_user') }}" autocomplete="username" required autofocus>
          </div>
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <div class="password-wrapper">
            <i class="fas fa-lock lock-icon"></i>
            <input type="password" name="password" id="password"
                   placeholder="Masukkan password"
                   autocomplete="current-password" required>
            <i class="fas fa-eye toggle-password" id="togglePassword"></i>
          </div>
        </div>

        <button type="submit">
          <i class="fas fa-sign-in-alt"></i> Masuk
        </button>
      </form>
    </div>
  </div>

  <script>
    (function () {
      const toggle = document.getElementById('togglePassword');
      const input  = document.getElementById('password');
      if (!toggle || !input) return;
      toggle.addEventListener('click', function () {
        input.type = input.type === 'password' ? 'text' : 'password';
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
    })();
  </script>
</body>
</html>
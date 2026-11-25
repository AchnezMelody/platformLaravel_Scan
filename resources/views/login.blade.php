<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Masuk · Mesin Penukaran Botol</title>
@include('partials.gaya')
<style>
  form.masuk { display: flex; flex-direction: column; gap: 16px; }
  input { width: 100%; padding: 16px 24px; border-radius: 999px; border: 2px solid #b9cbc4;
          font-size: 18px; background: #fff; color: #111; }
  input:focus { outline: 3px solid #f5c518; border-color: #226b52; }
  .galat { color: #b3261e; font-weight: 500; }
  .ket { color: #444; font-size: 15px; }
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
        <input type="text" name="id_user" placeholder="ID User atau Email"
               value="{{ old('id_user') }}" autocomplete="username" required autofocus>
        <input type="password" name="password" placeholder="Password"
               autocomplete="current-password" required>
        <button type="submit">Masuk</button>
      </form>
    </div>
  </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mesin Penukaran Botol · Universitas Sanata Dharma</title>
@include('partials.gaya')
<style>
  .ket { color: #444; font-size: 17px; }
</style>
</head>
<body>
  @include('partials.kiri')

  <div class="kanan">
    <div class="layar aktif">
      <h1>Selamat Datang di Machine<br>Penukaran Sampah Botol Plastik</h1>
      <p class="ket">Tukarkan botol plastikmu menjadi poin.</p>
      <form method="GET" action="{{ url('/login') }}">
        <button type="submit" style="width:100%">Mulai</button>
      </form>
    </div>
  </div>
</body>
</html>

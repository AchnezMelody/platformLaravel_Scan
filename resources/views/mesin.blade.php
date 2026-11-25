<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Mesin Penukaran Botol</title>
@include('partials.gaya')
<!-- FontAwesome untuk Icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  .centang { width: 84px; height: 84px; margin: 0 auto; border-radius: 50%; background: #226b52; color: #fff;
             font-size: 48px; display: grid; place-items: center; }
  .besar { font-size: 56px; font-weight: 800; color: #0f5c4d; line-height: 1; }
  .ket { color: #333; font-size: 17px; line-height: 1.5; }
  .ket.kecil { font-size: 14px; color: #666; }
  .sapa { color: #333; font-size: 17px; line-height: 1.6; }
</style>
</head>
<body>
  @include('partials.kiri')

  <div class="kanan">
    <!-- LAYAR 1: AWAL -->
    <div class="layar" id="awal">
      <h1>Selamat Datang di Machine<br>Penukaran Sampah Botol Plastik</h1>
      <p class="sapa">Halo, <b>{{ $nama }}</b><br>Poin kamu: <b id="poinAkun">{{ $poinAkun }}</b></p>
      <button onclick="kirim('/mulai')">Mulai</button>
      <form method="POST" action="{{ url('/logout') }}">
        @csrf
        <button type="submit" class="garis">Keluar</button>
      </form>
    </div>

    <!-- LAYAR 2: MASUKKAN BOTOL -->
    <div class="layar" id="botol">
      <h1>Silahkan Masukkan Botol</h1>
      <div class="baris"><span>🍼 Botol</span><b id="jBotol">0</b></div>
      <div class="baris"><span>🪙 Poin</span><b id="jPoin">0</b></div>
      <button id="btnAmbil" onclick="kirim('/ambil')">AMBIL POIN</button>
      <button class="garis" onclick="batalkan()">BATALKAN</button>
      <button class="garis" style="font-size:13px;padding:8px" onclick="kirim('/tambah')">[TES] Masukkan 1 botol</button>
    </div>

    <!-- LAYAR 3: TERIMA KASIH -->
    <div class="layar" id="selesai">
      <div class="centang">✓</div>
      <h1>Terima kasih!</h1>
      <p class="ket">Kamu sudah menukarkan <b id="sBotol">0</b> botol<br>dan mendapat</p>
      <p class="besar"><span id="sPoin">0</span> poin</p>
      <p class="ket">Total poin kamu sekarang: <b id="sTotal">0</b></p>
      <button onclick="kembali()">Selesai</button>
      <p class="ket kecil">Kembali ke layar awal dalam <span id="hitung">5</span> detik</p>
    </div>
  </div>

<script>
  const token = document.querySelector('meta[name=csrf-token]').content;
  let terimaKasih = false;
  let timer = null;
  let kameraNyala = false;

  // ==========================================
  // LOGIKA TAMPILAN & KAMERA
  // ==========================================

  function tampil(d) {
    if (d.layar === 'selesai') d.layar = 'awal';
    
    document.querySelectorAll('.layar').forEach(el => el.classList.remove('aktif'));
    document.getElementById(d.layar).classList.add('aktif');
    
    jBotol.textContent = d.botol;
    jPoin.textContent  = d.poin;
    btnAmbil.disabled  = d.botol < 1;
    if (d.poin_akun !== undefined) poinAkun.textContent = d.poin_akun;

    // Ganti Tampilan KIRI (Mesin ke Kamera Python)
    const ilustrasi = document.getElementById('ilustrasiMesin');
    const layarScan = document.getElementById('layarScan');
    const videoStream = document.getElementById('videoStream');

    if (d.layar === 'botol') {
        ilustrasi.style.display = 'none';
        layarScan.style.display = 'flex';
        
        // Nyalakan stream dari Python
        if (!kameraNyala) {
            videoStream.src = "http://127.0.0.1:5000/video_feed?t=" + new Date().getTime();
            kameraNyala = true;
        }
    } else {
        ilustrasi.style.display = 'block';
        layarScan.style.display = 'none';
        
        // Matikan stream
        if (kameraNyala) {
            videoStream.src = "";
            kameraNyala = false;
        }
    }
  }

  // ==========================================
  // LOGIKA FETCH & API
  // ==========================================
  async function panggil(url, opsi) {
    const r = await fetch(url, opsi);
    if (r.redirected || r.status === 401 || r.status === 419) {
      window.location.href = '/login';
      throw new Error('sesi habis');
    }
    return r.json();
  }

  async function kirim(url) {
    const d = await panggil(url, { method: 'POST', headers: { 'X-CSRF-TOKEN': token } });
    if (d.layar === 'selesai') { tampilTerimaKasih(d); return; }
    tampil(d);
  }

  function tampilTerimaKasih(d) {
    terimaKasih = true;
    sBotol.textContent = d.botol;
    sPoin.textContent  = d.poin;
    sTotal.textContent = d.poin_akun;
    
    // ✅ MATIKAN KAMERA PYTHON DENGAN BENAR
    const videoStream = document.getElementById('videoStream');
    if (kameraNyala && videoStream) {
        videoStream.src = "";
        kameraNyala = false;
    }
    
    document.querySelectorAll('.layar').forEach(el => el.classList.remove('aktif'));
    document.getElementById('selesai').classList.add('aktif');
    
    document.getElementById('ilustrasiMesin').style.display = 'block';
    document.getElementById('layarScan').style.display = 'none';

    let sisa = 5;
    hitung.textContent = sisa;
    clearInterval(timer);
    timer = setInterval(() => {
      sisa--; hitung.textContent = sisa;
      if (sisa <= 0) kembali();
    }, 1000);
  }
  
  function kembali() {
    clearInterval(timer);
    window.location.href = '/';
  }

  async function batalkan() {
    await panggil('/batal', { method: 'POST', headers: { 'X-CSRF-TOKEN': token } });
    kembali();
  }

  async function segarkan() {
    if (terimaKasih) return;
    tampil(await panggil('/data'));
  }

  // Jalankan saat pertama kali dibuka
  segarkan().catch(() => {});
  setInterval(() => segarkan().catch(() => {}), 3000);
</script>
</body>
</html>
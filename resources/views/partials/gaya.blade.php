<style>
  * { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, 'Segoe UI', sans-serif; }
  body { background: #226b52; min-height: 100vh; display: flex; overflow: hidden; }

  /* ===== KIRI ===== */
  .kiri { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 18px; padding: 24px; }
  .lencana { color: #fff; text-align: center; letter-spacing: .5px; }
  .lencana b { display: block; font-size: 20px; }
  .lencana span { font-size: 13px; opacity: .8; }
  .kartu {
    width: min(400px, 90%); aspect-ratio: 400 / 520; border-radius: 44px; overflow: hidden;
    box-shadow: 0 18px 40px rgba(0,0,0,.28); background: #d9eef5;
  }
  .kartu svg { width: 100%; height: 100%; display: block; }
  .botol-jatuh { animation: jatuh 2.4s ease-in infinite; }
  @keyframes jatuh {
    0%   { transform: translateY(-40px); opacity: 0; }
    15%  { opacity: 1; }
    70%  { transform: translateY(0); opacity: 1; }
    100% { transform: translateY(8px); opacity: 0; }
  }
  .mesin-goyang { animation: goyang 4s ease-in-out infinite; transform-origin: 200px 480px; }
  @keyframes goyang { 0%,100% { transform: rotate(-.6deg); } 50% { transform: rotate(.6deg); } }
  @media (prefers-reduced-motion: reduce) { .botol-jatuh, .mesin-goyang { animation: none; } }

  /* ===== KANAN ===== */
  .kanan { width: 45%; min-width: 360px; background: #e8eeec; border-radius: 80px 0 0 80px;
           padding: 40px; display: flex; flex-direction: column; justify-content: center; gap: 20px; text-align: center; }
  h1 { color: #0f5c4d; font-size: 24px; line-height: 1.3; }
  button { padding: 16px; border-radius: 999px; font-size: 18px; cursor: pointer;
           border: 2px solid #226b52; background: #226b52; color: #fff; }
  button:hover { background: #0f5c4d; }
  button:disabled { opacity: .4; cursor: not-allowed; }
  button.garis { background: transparent; color: #226b52; }
  button.garis:hover { background: rgba(34,107,82,.08); }
  .baris { background: #fff; padding: 16px; display: flex; justify-content: space-between; font-size: 18px; text-align: left; }
  .centang { width: 84px; height: 84px; margin: 0 auto; border-radius: 50%; background: #226b52; color: #fff;
             font-size: 48px; display: grid; place-items: center; }
  .besar { font-size: 56px; font-weight: 800; color: #0f5c4d; line-height: 1; }
  .ket { color: #333; font-size: 17px; line-height: 1.5; }
  .ket.kecil { font-size: 14px; color: #666; }
  .layar { display: none; flex-direction: column; gap: 20px; }
  .layar.aktif { display: flex; }

  @media (max-width: 800px) {
    body { flex-direction: column; overflow: auto; }
    .kanan { width: 100%; border-radius: 48px 48px 0 0; }
  }
</style>

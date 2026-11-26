<div class="kiri">

    <!-- ========================================== -->
    <!-- 1. ILUSTRASI MESIN (Tampil saat layar awal) -->
    <!-- ========================================== -->
    <div class="kartu" id="ilustrasiMesin">
      <svg viewBox="0 0 400 520" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi mesin penukaran botol di kampus">
        <defs>
          <linearGradient id="langit" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#bfe3f1"/><stop offset="1" stop-color="#fdf3c9"/>
          </linearGradient>
        </defs>

        <!-- langit & gedung kampus -->
        <rect width="400" height="520" fill="url(#langit)"/>
        <circle cx="330" cy="70" r="26" fill="#fff6b0" opacity=".9"/>
        <g fill="#b5503a">
          <rect x="-10" y="170" width="120" height="130"/>
          <rect x="300" y="150" width="110" height="150"/>
        </g>
        <g fill="#8e3b2b">
          <polygon points="-10,170 50,130 110,170"/>
          <polygon points="300,150 355,112 410,150"/>
        </g>
        <g fill="#f3e3b8">
          <rect x="15" y="195" width="18" height="26"/><rect x="55" y="195" width="18" height="26"/>
          <rect x="15" y="240" width="18" height="26"/><rect x="55" y="240" width="18" height="26"/>
          <rect x="325" y="178" width="18" height="26"/><rect x="365" y="178" width="18" height="26"/>
          <rect x="325" y="225" width="18" height="26"/><rect x="365" y="225" width="18" height="26"/>
        </g>

        <!-- bukit & rumput -->
        <ellipse cx="90"  cy="330" rx="210" ry="70" fill="#8fc46a"/>
        <ellipse cx="330" cy="340" rx="200" ry="70" fill="#7ab55c"/>
        <rect y="360" width="400" height="160" fill="#8fc46a"/>
        <path d="M0 440 Q200 410 400 440 L400 520 L0 520Z" fill="#6aa850"/>

        <!-- pohon kecil -->
        <g>
          <rect x="30" y="330" width="8" height="40" fill="#7a5230"/>
          <circle cx="34" cy="322" r="26" fill="#4e9a4a"/>
          <circle cx="20" cy="334" r="16" fill="#5aa955"/>
        </g>

        <!-- MESIN -->
        <g class="mesin-goyang">
          <!-- bayangan -->
          <ellipse cx="200" cy="486" rx="110" ry="12" fill="#000" opacity=".15"/>

          <!-- badan kuning -->
          <rect x="110" y="90" width="180" height="390" rx="28" fill="#f4b82c"/>
          <rect x="118" y="98" width="164" height="374" rx="22" fill="#f9cb4d"/>

          <!-- wajah lucu di atas -->
          <rect x="150" y="70" width="100" height="36" rx="18" fill="#f4b82c"/>
          <circle cx="178" cy="86" r="5" fill="#3b2a18"/>
          <circle cx="222" cy="86" r="5" fill="#3b2a18"/>
          <path d="M192 94 Q200 101 208 94" stroke="#3b2a18" stroke-width="3" fill="none" stroke-linecap="round"/>
          <circle cx="168" cy="95" r="4" fill="#f08a6a" opacity=".7"/>
          <circle cx="232" cy="95" r="4" fill="#f08a6a" opacity=".7"/>

          <!-- papan judul -->
          <rect x="130" y="116" width="140" height="30" rx="8" fill="#1f6f55"/>
          <text x="200" y="128" text-anchor="middle" font-size="8.5" font-weight="700" fill="#fff">PROGRAM EKOLITERASI</text>
          <text x="200" y="140" text-anchor="middle" font-size="8.5" font-weight="700" fill="#fff">MAHASISWA USD</text>

          <!-- layar -->
          <rect x="130" y="156" width="140" height="86" rx="10" fill="#1c2b33"/>
          <rect x="136" y="162" width="128" height="74" rx="6" fill="#bfe3f1"/>
          <path d="M136 220 Q170 190 200 205 T264 195 L264 236 L136 236Z" fill="#7ab55c"/>
          <path d="M136 228 Q200 214 264 226 L264 236 L136 236Z" fill="#4a5560"/>
          <circle cx="170" cy="213" r="7" fill="#2f7a4f"/>
          <rect x="166" y="213" width="8" height="9" fill="#2f7a4f"/>

          <!-- lubang botol -->
          <rect x="140" y="256" width="120" height="40" rx="8" fill="#9fd3ea"/>
          <rect x="148" y="268" width="104" height="10" rx="5" fill="#2a4b5c"/>
          <text x="200" y="290" text-anchor="middle" font-size="7.5" font-weight="700" fill="#2a4b5c">MASUKKAN BOTOL DI SINI</text>

          <!-- botol jatuh -->
          <g class="botol-jatuh">
            <rect x="193" y="232" width="14" height="6" rx="2" fill="#1a1a8c"/>
            <rect x="190" y="238" width="20" height="26" rx="6" fill="#7fc5e8" stroke="#1a1a8c" stroke-width="2"/>
          </g>

          <!-- lencana emas -->
          <circle cx="258" cy="326" r="20" fill="#e8892b" stroke="#f5c518" stroke-width="4"/>
          <text x="258" y="330" text-anchor="middle" font-size="9" font-weight="700" fill="#fff">USD</text>

          <!-- panel hijau bawah -->
          <rect x="118" y="352" width="164" height="30" rx="6" fill="#fff" opacity=".85"/>
          <text x="200" y="372" text-anchor="middle" font-size="10" font-weight="700" fill="#226b52">BY : UNIVERSITAS SANATA DHARMA</text>
          <rect x="118" y="392" width="164" height="80" rx="14" fill="#2f7a4f"/>
          <text x="200" y="420" text-anchor="middle" font-size="16" font-weight="800" fill="#fff9d6" font-style="italic">Let's Save</text>
          <text x="200" y="444" text-anchor="middle" font-size="20" font-weight="800" fill="#fff9d6" font-style="italic">Our Earth</text>
          <text x="200" y="462" text-anchor="middle" font-size="8" fill="#d6f0d6">USD ECO-CAMPUS</text>

          <!-- daun di kaki mesin -->
          <g fill="#4e9a4a">
            <ellipse cx="128" cy="470" rx="9" ry="16" transform="rotate(-25 128 470)"/>
            <ellipse cx="146" cy="474" rx="8" ry="14" transform="rotate(15 146 474)"/>
            <ellipse cx="272" cy="470" rx="9" ry="16" transform="rotate(25 272 470)"/>
            <ellipse cx="254" cy="474" rx="8" ry="14" transform="rotate(-15 254 474)"/>
          </g>
        </g>

        <!-- tong sampah lucu -->
        <g>
          <rect x="316" y="400" width="52" height="64" rx="8" fill="#6c7a82"/>
          <rect x="310" y="394" width="64" height="12" rx="5" fill="#85949c"/>
          <circle cx="330" cy="428" r="3.5" fill="#222"/>
          <circle cx="354" cy="428" r="3.5" fill="#222"/>
          <path d="M335 440 Q342 447 349 440" stroke="#222" stroke-width="2.5" fill="none" stroke-linecap="round"/>
          <circle cx="324" cy="438" r="3.5" fill="#f08a6a" opacity=".7"/>
          <circle cx="360" cy="438" r="3.5" fill="#f08a6a" opacity=".7"/>
        </g>

        <!-- orang kecil kiri -->
        <g>
          <circle cx="62" cy="410" r="9" fill="#f1c9a5"/>
          <rect x="52" y="419" width="20" height="36" rx="6" fill="#2d3e50"/>
          <rect x="54" y="455" width="7" height="20" fill="#1f2a36"/>
          <rect x="63" y="455" width="7" height="20" fill="#1f2a36"/>
        </g>
      </svg>
    </div>

    <!-- ========================================== -->
    <!-- 2. LAYAR SCAN DARI PYTHON (Tampil saat layar botol) -->
    <!-- ========================================== -->
    <div class="kartu" id="layarScan" style="display: none; position: relative; overflow: hidden; background: #111; align-items: center; justify-content: center; flex-direction: column; color: white;">

        <!-- Gambar diambil dari Python Flask (src diisi lewat JavaScript di mesin.blade.php) -->
        <img id="videoStream" alt="" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top:0; left:0;">

    </div>
</div>

<style>
  /* Styling Tambahan untuk Scan */
  #ilustrasiMesin, #layarScan {
    transition: opacity 0.4s ease-in-out;
  }

  /* Kotak kamera: persegi panjang (landscape 4:3), lebih besar */
  #layarScan {
    width: 92% !important;
    max-width: 760px !important;
    height: auto !important;
    min-height: 0 !important;
    max-height: none !important;
    aspect-ratio: 4 / 3 !important;
  }<div class="kiri">
    <div class="lencana"><b>UNIVERSITAS SANATA DHARMA</b><span>Yogyakarta</span></div>

    <!-- ========================================== -->
    <!-- 1. ILUSTRASI MESIN (Tampil saat layar awal) -->
    <!-- ========================================== -->
    <div class="kartu" id="ilustrasiMesin">
      <svg viewBox="0 0 400 520" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi mesin penukaran botol di kampus">
        <defs>
          <linearGradient id="langit" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#bfe3f1"/><stop offset="1" stop-color="#fdf3c9"/>
          </linearGradient>
        </defs>

        <!-- langit & gedung kampus -->
        <rect width="400" height="520" fill="url(#langit)"/>
        <circle cx="330" cy="70" r="26" fill="#fff6b0" opacity=".9"/>
        <g fill="#b5503a">
          <rect x="-10" y="170" width="120" height="130"/>
          <rect x="300" y="150" width="110" height="150"/>
        </g>
        <g fill="#8e3b2b">
          <polygon points="-10,170 50,130 110,170"/>
          <polygon points="300,150 355,112 410,150"/>
        </g>
        <g fill="#f3e3b8">
          <rect x="15" y="195" width="18" height="26"/><rect x="55" y="195" width="18" height="26"/>
          <rect x="15" y="240" width="18" height="26"/><rect x="55" y="240" width="18" height="26"/>
          <rect x="325" y="178" width="18" height="26"/><rect x="365" y="178" width="18" height="26"/>
          <rect x="325" y="225" width="18" height="26"/><rect x="365" y="225" width="18" height="26"/>
        </g>

        <!-- bukit & rumput -->
        <ellipse cx="90"  cy="330" rx="210" ry="70" fill="#8fc46a"/>
        <ellipse cx="330" cy="340" rx="200" ry="70" fill="#7ab55c"/>
        <rect y="360" width="400" height="160" fill="#8fc46a"/>
        <path d="M0 440 Q200 410 400 440 L400 520 L0 520Z" fill="#6aa850"/>

        <!-- pohon kecil -->
        <g>
          <rect x="30" y="330" width="8" height="40" fill="#7a5230"/>
          <circle cx="34" cy="322" r="26" fill="#4e9a4a"/>
          <circle cx="20" cy="334" r="16" fill="#5aa955"/>
        </g>

        <!-- MESIN -->
        <g class="mesin-goyang">
          <!-- bayangan -->
          <ellipse cx="200" cy="486" rx="110" ry="12" fill="#000" opacity=".15"/>

          <!-- badan kuning -->
          <rect x="110" y="90" width="180" height="390" rx="28" fill="#f4b82c"/>
          <rect x="118" y="98" width="164" height="374" rx="22" fill="#f9cb4d"/>

          <!-- wajah lucu di atas -->
          <rect x="150" y="70" width="100" height="36" rx="18" fill="#f4b82c"/>
          <circle cx="178" cy="86" r="5" fill="#3b2a18"/>
          <circle cx="222" cy="86" r="5" fill="#3b2a18"/>
          <path d="M192 94 Q200 101 208 94" stroke="#3b2a18" stroke-width="3" fill="none" stroke-linecap="round"/>
          <circle cx="168" cy="95" r="4" fill="#f08a6a" opacity=".7"/>
          <circle cx="232" cy="95" r="4" fill="#f08a6a" opacity=".7"/>

          <!-- papan judul -->
          <rect x="130" y="116" width="140" height="30" rx="8" fill="#1f6f55"/>
          <text x="200" y="128" text-anchor="middle" font-size="8.5" font-weight="700" fill="#fff">PROGRAM EKOLITERASI</text>
          <text x="200" y="140" text-anchor="middle" font-size="8.5" font-weight="700" fill="#fff">MAHASISWA USD</text>

          <!-- layar -->
          <rect x="130" y="156" width="140" height="86" rx="10" fill="#1c2b33"/>
          <rect x="136" y="162" width="128" height="74" rx="6" fill="#bfe3f1"/>
          <path d="M136 220 Q170 190 200 205 T264 195 L264 236 L136 236Z" fill="#7ab55c"/>
          <path d="M136 228 Q200 214 264 226 L264 236 L136 236Z" fill="#4a5560"/>
          <circle cx="170" cy="213" r="7" fill="#2f7a4f"/>
          <rect x="166" y="213" width="8" height="9" fill="#2f7a4f"/>

          <!-- lubang botol -->
          <rect x="140" y="256" width="120" height="40" rx="8" fill="#9fd3ea"/>
          <rect x="148" y="268" width="104" height="10" rx="5" fill="#2a4b5c"/>
          <text x="200" y="290" text-anchor="middle" font-size="7.5" font-weight="700" fill="#2a4b5c">MASUKKAN BOTOL DI SINI</text>

          <!-- botol jatuh -->
          <g class="botol-jatuh">
            <rect x="193" y="232" width="14" height="6" rx="2" fill="#1a1a8c"/>
            <rect x="190" y="238" width="20" height="26" rx="6" fill="#7fc5e8" stroke="#1a1a8c" stroke-width="2"/>
          </g>

          <!-- lencana emas -->
          <circle cx="258" cy="326" r="20" fill="#e8892b" stroke="#f5c518" stroke-width="4"/>
          <text x="258" y="330" text-anchor="middle" font-size="9" font-weight="700" fill="#fff">USD</text>

          <!-- panel hijau bawah -->
          <rect x="118" y="352" width="164" height="30" rx="6" fill="#fff" opacity=".85"/>
          <text x="200" y="372" text-anchor="middle" font-size="10" font-weight="700" fill="#226b52">BY : UNIVERSITAS SANATA DHARMA</text>
          <rect x="118" y="392" width="164" height="80" rx="14" fill="#2f7a4f"/>
          <text x="200" y="420" text-anchor="middle" font-size="16" font-weight="800" fill="#fff9d6" font-style="italic">Let's Save</text>
          <text x="200" y="444" text-anchor="middle" font-size="20" font-weight="800" fill="#fff9d6" font-style="italic">Our Earth</text>
          <text x="200" y="462" text-anchor="middle" font-size="8" fill="#d6f0d6">USD ECO-CAMPUS</text>

          <!-- daun di kaki mesin -->
          <g fill="#4e9a4a">
            <ellipse cx="128" cy="470" rx="9" ry="16" transform="rotate(-25 128 470)"/>
            <ellipse cx="146" cy="474" rx="8" ry="14" transform="rotate(15 146 474)"/>
            <ellipse cx="272" cy="470" rx="9" ry="16" transform="rotate(25 272 470)"/>
            <ellipse cx="254" cy="474" rx="8" ry="14" transform="rotate(-15 254 474)"/>
          </g>
        </g>

        <!-- tong sampah lucu -->
        <g>
          <rect x="316" y="400" width="52" height="64" rx="8" fill="#6c7a82"/>
          <rect x="310" y="394" width="64" height="12" rx="5" fill="#85949c"/>
          <circle cx="330" cy="428" r="3.5" fill="#222"/>
          <circle cx="354" cy="428" r="3.5" fill="#222"/>
          <path d="M335 440 Q342 447 349 440" stroke="#222" stroke-width="2.5" fill="none" stroke-linecap="round"/>
          <circle cx="324" cy="438" r="3.5" fill="#f08a6a" opacity=".7"/>
          <circle cx="360" cy="438" r="3.5" fill="#f08a6a" opacity=".7"/>
        </g>

        <!-- orang kecil kiri -->
        <g>
          <circle cx="62" cy="410" r="9" fill="#f1c9a5"/>
          <rect x="52" y="419" width="20" height="36" rx="6" fill="#2d3e50"/>
          <rect x="54" y="455" width="7" height="20" fill="#1f2a36"/>
          <rect x="63" y="455" width="7" height="20" fill="#1f2a36"/>
        </g>
      </svg>
    </div>

    <!-- ========================================== -->
    <!-- 2. LAYAR SCAN DARI PYTHON (Tampil saat layar botol) -->
    <!-- ========================================== -->
    <div class="kartu" id="layarScan" style="display: none; position: relative; overflow: hidden; background: #111; align-items: center; justify-content: center; flex-direction: column; color: white;">

        <!-- Gambar diambil dari Python Flask (src diisi lewat JavaScript di mesin.blade.php) -->
        <img id="videoStream" alt="" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top:0; left:0;">

    </div>
</div>

<style>
  /* Styling Tambahan untuk Scan */
  #ilustrasiMesin, #layarScan {
    transition: opacity 0.4s ease-in-out;
  }

  /* Kotak kamera: persegi panjang (landscape 4:3), lebih besar */
  #layarScan {
    width: 92% !important;
    max-width: 760px !important;
    height: auto !important;
    min-height: 0 !important;
    max-height: none !important;
    aspect-ratio: 4 / 3 !important;
  }
</style>
</style>
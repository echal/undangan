<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $event->title }} — Ramadhan Undigi</title>
  <meta name="description" content="Undangan {{ $event->title }} — {{ $event->event_date->translatedFormat('d F Y') }}. {{ $event->location }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    :root {
      --green:       #1a6b45;
      --green-mid:   #2d8f5e;
      --green-light: #e8f5ee;
      --gold:        #c8973a;
      --gold-light:  #fdf3e0;
      --cream:       #fdfaf4;
      --text:        #1c2b22;
      --muted:       #6b7c72;
      --border:      #d4e8db;
    }

    body {
      font-family: 'Nunito', sans-serif;
      background: var(--cream);
      color: var(--text);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ─────────────────────────────
       FLOATING STARS (decorative)
    ───────────────────────────── */
    .stars-wrap {
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 0;
      overflow: hidden;
    }
    .star {
      position: absolute;
      background: var(--gold);
      border-radius: 50%;
      opacity: 0;
      animation: twinkle ease-in-out infinite;
    }
    @keyframes twinkle {
      0%, 100% { opacity: 0;    transform: scale(0.6); }
      50%       { opacity: 0.55; transform: scale(1); }
    }

    /* ─────────────────────────────
       HERO
    ───────────────────────────── */
    .hero {
      min-height: 100vh;
      background: linear-gradient(175deg, #0d3d25 0%, #1a6b45 45%, #1e7a4f 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 4rem 1.5rem 6rem;
      position: relative;
      overflow: hidden;
    }

    /* subtle geometric pattern overlay */
    .hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image:
        repeating-linear-gradient(45deg, rgba(200,151,58,0.04) 0px, rgba(200,151,58,0.04) 1px, transparent 1px, transparent 28px),
        repeating-linear-gradient(-45deg, rgba(200,151,58,0.04) 0px, rgba(200,151,58,0.04) 1px, transparent 1px, transparent 28px);
      z-index: 0;
    }
    .hero > * { position: relative; z-index: 1; }

    /* gold crescent top ornament */
    .hero-crescent {
      font-size: 3.5rem;
      margin-bottom: 0.5rem;
      filter: drop-shadow(0 0 12px rgba(200,151,58,0.6));
      animation: float 4s ease-in-out infinite;
    }
    @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }

    .hero-bismillah {
      font-family: 'Amiri', serif;
      font-size: clamp(1.3rem, 4vw, 2rem);
      color: var(--gold);
      letter-spacing: 0.05em;
      margin-bottom: 1.25rem;
      text-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    .hero-label {
      font-size: 0.68rem;
      letter-spacing: 0.3em;
      text-transform: uppercase;
      color: rgba(255,255,255,0.6);
      margin-bottom: 1.5rem;
      font-weight: 300;
    }

    .hero-title {
      font-family: 'Amiri', serif;
      font-size: clamp(2.2rem, 7vw, 4rem);
      color: #ffffff;
      line-height: 1.2;
      margin-bottom: 0.5rem;
      text-shadow: 0 2px 12px rgba(0,0,0,0.4);
    }

    .hero-host {
      font-size: 1rem;
      color: rgba(255,255,255,0.75);
      font-weight: 300;
      margin-bottom: 0.3rem;
    }
    .hero-host strong {
      color: var(--gold);
      font-weight: 700;
    }

    /* gold ornament line */
    .hero-divider {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin: 1.5rem auto;
      width: fit-content;
    }
    .hero-divider-line {
      width: 60px;
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }
    .hero-divider-gem {
      width: 8px;
      height: 8px;
      background: var(--gold);
      transform: rotate(45deg);
      border-radius: 2px;
    }

    .hero-date {
      font-size: 0.9rem;
      color: rgba(255,255,255,0.65);
      letter-spacing: 0.1em;
      font-weight: 300;
    }

    .scroll-down {
      position: absolute;
      bottom: 2.5rem;
      left: 50%;
      transform: translateX(-50%);
      color: rgba(255,255,255,0.4);
      font-size: 1.5rem;
      animation: bounce 2s ease-in-out infinite;
    }
    @keyframes bounce { 0%,100% { transform: translateX(-50%) translateY(0); } 50% { transform: translateX(-50%) translateY(7px); } }

    /* ─────────────────────────────
       SECTIONS
    ───────────────────────────── */
    .content { position: relative; z-index: 1; }

    .section {
      max-width: 660px;
      margin: 0 auto;
      padding: 4rem 1.5rem;
    }

    .section-card {
      background: #fff;
      border-radius: 20px;
      padding: 2.5rem 2rem;
      box-shadow: 0 4px 28px rgba(26,107,69,0.08);
      border: 1px solid var(--border);
      position: relative;
      overflow: hidden;
    }

    /* decorative corner gold accent */
    .section-card::before {
      content: '';
      position: absolute;
      top: 0; right: 0;
      width: 80px; height: 80px;
      background: linear-gradient(225deg, var(--gold-light) 0%, transparent 70%);
      border-radius: 0 20px 0 0;
    }

    .section-icon {
      font-size: 2rem;
      margin-bottom: 0.75rem;
      display: block;
    }

    .section-label {
      font-size: 0.62rem;
      letter-spacing: 0.25em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 0.5rem;
      font-weight: 700;
    }

    .section-title {
      font-family: 'Amiri', serif;
      font-size: 1.8rem;
      color: var(--green);
      margin-bottom: 1.25rem;
      line-height: 1.2;
    }

    .section-body {
      font-size: 0.9rem;
      color: var(--muted);
      line-height: 1.9;
    }

    .section-body strong { color: var(--text); }

    /* ayat / quote box */
    .quote-box {
      background: var(--green-light);
      border-left: 4px solid var(--green);
      border-radius: 0 12px 12px 0;
      padding: 1.25rem 1.5rem;
      margin: 1.5rem 0;
    }
    .quote-arabic {
      font-family: 'Amiri', serif;
      font-size: 1.5rem;
      color: var(--green);
      text-align: right;
      line-height: 2;
      margin-bottom: 0.75rem;
    }
    .quote-trans {
      font-size: 0.82rem;
      color: var(--muted);
      line-height: 1.7;
      font-style: italic;
    }
    .quote-source {
      font-size: 0.72rem;
      color: var(--gold);
      font-weight: 700;
      margin-top: 0.5rem;
    }

    /* ─────────────────────────────
       COUNTDOWN
    ───────────────────────────── */
    .countdown {
      display: flex;
      justify-content: center;
      gap: 0.75rem;
      margin-top: 2rem;
    }
    .count-box {
      text-align: center;
      background: linear-gradient(160deg, var(--green) 0%, var(--green-mid) 100%);
      border-radius: 14px;
      padding: 1rem 1.2rem;
      min-width: 68px;
      box-shadow: 0 6px 16px rgba(26,107,69,0.25);
    }
    .count-num {
      font-family: 'Amiri', serif;
      font-size: 2.2rem;
      font-weight: 700;
      color: #fff;
      display: block;
      line-height: 1;
    }
    .count-label {
      font-size: 0.58rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: rgba(255,255,255,0.7);
      margin-top: 0.3rem;
      display: block;
    }

    /* ─────────────────────────────
       DETAIL INFO ROWS
    ───────────────────────────── */
    .info-row {
      display: flex;
      align-items: flex-start;
      gap: 0.85rem;
      padding: 0.85rem 0;
      border-bottom: 1px solid var(--border);
    }
    .info-row:last-child { border-bottom: none; }
    .info-icon {
      width: 36px;
      height: 36px;
      background: var(--green-light);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      flex-shrink: 0;
    }
    .info-label { font-size: 0.7rem; color: var(--muted); margin-bottom: 0.2rem; }
    .info-value { font-size: 0.9rem; color: var(--text); font-weight: 600; line-height: 1.5; }
    .info-link {
      color: var(--green);
      font-weight: 700;
      text-decoration: none;
      font-size: 0.85rem;
    }
    .info-link:hover { color: var(--gold); }

    /* description box */
    .desc-box {
      background: var(--gold-light);
      border-radius: 12px;
      padding: 1rem 1.25rem;
      margin-top: 1rem;
      font-size: 0.88rem;
      color: #6b4a14;
      line-height: 1.8;
      border: 1px solid #eadabc;
    }

    /* ─────────────────────────────
       RSVP FORM
    ───────────────────────────── */
    .form-group { margin-bottom: 1.25rem; }
    label {
      display: block;
      font-size: 0.78rem;
      color: var(--muted);
      margin-bottom: 0.4rem;
      font-weight: 600;
      letter-spacing: 0.04em;
    }
    input, select, textarea {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 0.75rem 1rem;
      font-size: 0.9rem;
      font-family: 'Nunito', sans-serif;
      color: var(--text);
      background: #fff;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    input:focus, select:focus, textarea:focus {
      outline: none;
      border-color: var(--green);
      box-shadow: 0 0 0 3px rgba(26,107,69,0.1);
    }
    .btn-primary {
      display: block;
      width: 100%;
      padding: 0.9rem;
      background: linear-gradient(135deg, var(--green) 0%, var(--green-mid) 100%);
      color: #fff;
      border: none;
      border-radius: 10px;
      font-size: 0.9rem;
      font-weight: 700;
      letter-spacing: 0.05em;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 6px 18px rgba(26,107,69,0.3);
      font-family: 'Nunito', sans-serif;
    }
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 24px rgba(26,107,69,0.4);
    }

    /* ─────────────────────────────
       WISH CARDS
    ───────────────────────────── */
    .wish-card {
      background: var(--green-light);
      border-radius: 12px;
      padding: 1.1rem 1.25rem;
      margin-bottom: 0.85rem;
      border-left: 3px solid var(--green);
    }
    .wish-name {
      font-weight: 700;
      font-size: 0.85rem;
      color: var(--green);
      margin-bottom: 0.3rem;
    }
    .wish-msg {
      font-size: 0.85rem;
      color: var(--muted);
      line-height: 1.7;
    }

    /* ─────────────────────────────
       FLASH
    ───────────────────────────── */
    .flash {
      padding: 0.9rem 1rem;
      border-radius: 10px;
      margin-bottom: 1.5rem;
      font-size: 0.85rem;
    }
    .flash-success {
      background: var(--green-light);
      border: 1px solid #a8d8bc;
      color: var(--green);
    }

    /* ─────────────────────────────
       FOOTER
    ───────────────────────────── */
    footer {
      text-align: center;
      padding: 2.5rem 1rem;
      font-size: 0.75rem;
      color: var(--muted);
      border-top: 1px solid var(--border);
      background: #fff;
    }
    footer strong { color: var(--green); }
  </style>
</head>
<body>

{{-- ── Floating Stars ──────────────────────────────────── --}}
<div class="stars-wrap" aria-hidden="true">
  @for ($i = 0; $i < 22; $i++)
    <div class="star" style="
      left: {{ rand(0, 100) }}%;
      top:  {{ rand(0, 100) }}%;
      width:  {{ rand(2, 5) }}px;
      height: {{ rand(2, 5) }}px;
      animation-duration: {{ rand(2, 6) }}s;
      animation-delay:    {{ rand(0, 8) }}s;
    "></div>
  @endfor
</div>

{{-- ── HERO ─────────────────────────────────────────────── --}}
<section class="hero">
  <div class="hero-crescent">☪️</div>

  <p class="hero-bismillah">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم</p>

  <p class="hero-label">Undangan {{ ucfirst(str_replace('_', ' ', $event->event_type ?? 'buka puasa')) }}</p>

  <h1 class="hero-title">{{ $event->title }}</h1>

  @if ($event->bride_name)
    <p class="hero-host" style="margin-top:0.75rem;">
      Diselenggarakan oleh<br>
      <strong>{{ $event->bride_name }}</strong>
    </p>
  @endif

  <div class="hero-divider">
    <div class="hero-divider-line"></div>
    <div class="hero-divider-gem"></div>
    <div class="hero-divider-line"></div>
  </div>

  <p class="hero-date">{{ $event->event_date->translatedFormat('l, d F Y') }}</p>

  <div class="scroll-down">↓</div>
</section>

{{-- ── CONTENT ─────────────────────────────────────────── --}}
<div class="content">

  {{-- Ayat / Quote --}}
  <div class="section">
    <div class="section-card">
      <span class="section-icon">📖</span>
      <p class="section-label">Firman Allah SWT</p>
      <div class="quote-box">
        <p class="quote-arabic">شَهْرُ رَمَضَانَ الَّذِي أُنزِلَ فِيهِ الْقُرْآنُ هُدًى لِّلنَّاسِ</p>
        <p class="quote-trans">
          "Bulan Ramadan adalah (bulan) yang di dalamnya diturunkan Al-Qur'an sebagai petunjuk bagi manusia..."
        </p>
        <p class="quote-source">QS. Al-Baqarah: 185</p>
      </div>
      <p class="section-body" style="text-align:center;margin-top:1rem;">
        Dengan penuh syukur dan kerendahan hati, kami mengundang Bapak / Ibu / Saudara/i untuk hadir bersama kami.
      </p>
    </div>
  </div>

  {{-- Detail Acara --}}
  <div class="section" style="padding-top:0;">
    <div class="section-card">
      <span class="section-icon">🌙</span>
      <p class="section-label">Detail Acara</p>
      <h2 class="section-title">{{ $event->title }}</h2>

      <div>
        <div class="info-row">
          <div class="info-icon">📅</div>
          <div>
            <p class="info-label">Tanggal & Waktu</p>
            <p class="info-value">{{ $event->event_date->translatedFormat('l, d F Y') }}</p>
            <p class="info-value" style="font-weight:400;color:var(--muted);">Pukul {{ $event->event_date->format('H:i') }} WIB</p>
          </div>
        </div>

        <div class="info-row">
          <div class="info-icon">📍</div>
          <div>
            <p class="info-label">Lokasi</p>
            <p class="info-value">{{ $event->location }}</p>
            @if ($event->maps_link)
              <a href="{{ $event->maps_link }}" target="_blank" rel="noopener" class="info-link" style="margin-top:0.35rem;display:inline-block;">
                🗺 Petunjuk Arah →
              </a>
            @endif
          </div>
        </div>

        @php $data = $event->event_data ?? []; @endphp
        @if (!empty($data['description']))
          <div class="info-row">
            <div class="info-icon">📝</div>
            <div>
              <p class="info-label">Keterangan</p>
              <p class="info-value" style="font-weight:400;">{{ $data['description'] }}</p>
            </div>
          </div>
        @endif
      </div>

      {{-- Countdown --}}
      <div class="countdown" id="countdown">
        <div class="count-box"><span class="count-num" id="cd-days">--</span><span class="count-label">Hari</span></div>
        <div class="count-box"><span class="count-num" id="cd-hours">--</span><span class="count-label">Jam</span></div>
        <div class="count-box"><span class="count-num" id="cd-mins">--</span><span class="count-label">Menit</span></div>
        <div class="count-box"><span class="count-num" id="cd-secs">--</span><span class="count-label">Detik</span></div>
      </div>
    </div>
  </div>

  {{-- RSVP --}}
  @if ($event->rsvp_enabled)
  <div class="section" style="padding-top:0;">
    <div class="section-card">
      <span class="section-icon">✉️</span>
      <p class="section-label">Konfirmasi Kehadiran</p>
      <h2 class="section-title">Apakah kamu hadir?</h2>

      @if (session('rsvp_success'))
        <div class="flash flash-success">{{ session('rsvp_success') }}</div>
      @endif

      <form action="{{ route('invitation.rsvp', $event->slug) }}" method="POST">
        @csrf
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" required placeholder="Nama lengkap kamu" />
        </div>
        <div class="form-group">
          <label>Nomor WhatsApp <span style="font-weight:300;">(opsional)</span></label>
          <input type="text" name="phone" placeholder="+62..." />
        </div>
        <div class="form-group">
          <label>Kehadiran</label>
          <select name="rsvp_status" required>
            <option value="hadir">☑️ Hadir — Insyaallah</option>
            <option value="tidak_hadir">❌ Tidak Hadir</option>
            <option value="pending">🤔 Belum Pasti</option>
          </select>
        </div>
        <button type="submit" class="btn-primary">☪️ Kirim Konfirmasi</button>
      </form>
    </div>
  </div>
  @endif

  {{-- Ucapan & Doa --}}
  <div class="section" style="padding-top:0;">
    <div class="section-card">
      <span class="section-icon">🤲</span>
      <p class="section-label">Ucapan & Doa</p>
      <h2 class="section-title">Tuliskan Pesanmu</h2>

      @if (session('wish_success'))
        <div class="flash flash-success">{{ session('wish_success') }}</div>
      @endif

      <form action="{{ route('invitation.wish', $event->slug) }}" method="POST" style="margin-bottom:2rem;">
        @csrf
        <div class="form-group">
          <label>Nama</label>
          <input type="text" name="guest_name" required placeholder="Nama kamu" />
        </div>
        <div class="form-group">
          <label>Pesan & Doa</label>
          <textarea name="message" rows="3" required placeholder="Ucapkan selamat atau tuliskan doa terbaik kamu..."></textarea>
        </div>
        <button type="submit" class="btn-primary">🤲 Kirim Ucapan</button>
      </form>

      @forelse ($event->wishes as $wish)
        <div class="wish-card">
          <p class="wish-name">{{ $wish->guest_name }}</p>
          <p class="wish-msg">{{ $wish->message }}</p>
        </div>
      @empty
        <p style="color:var(--muted);font-size:0.85rem;text-align:center;padding:1.5rem 0;">
          ☪️ Belum ada ucapan. Jadilah yang pertama berdoa!
        </p>
      @endforelse
    </div>
  </div>

</div>{{-- end content --}}

<footer>
  Dibuat dengan 🤲 menggunakan <strong>UNDIGI</strong> &middot; Ramadhan Mubarak
</footer>

<script>
  // ── Countdown ────────────────────────────────────
  const cdTarget = new Date('{{ $event->event_date->toIso8601String() }}').getTime();

  function updateCountdown() {
    const diff = cdTarget - Date.now();
    if (diff <= 0) {
      document.getElementById('countdown').innerHTML =
        '<p style="color:var(--gold);font-size:0.9rem;text-align:center;padding:1rem 0;">Acara sudah berlangsung — Barakallahu fiikum 🤲</p>';
      return;
    }
    document.getElementById('cd-days').textContent  = String(Math.floor(diff / 86400000)).padStart(2, '0');
    document.getElementById('cd-hours').textContent = String(Math.floor((diff % 86400000) / 3600000)).padStart(2, '0');
    document.getElementById('cd-mins').textContent  = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
    document.getElementById('cd-secs').textContent  = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
  }

  updateCountdown();
  setInterval(updateCountdown, 1000);
</script>

</body>
</html>

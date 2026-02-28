<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $event->bride_name }} & {{ $event->groom_name }} — Undangan Pernikahan</title>
  <meta name="description" content="Undangan pernikahan {{ $event->bride_name }} & {{ $event->groom_name }}, {{ $event->event_date->translatedFormat('d F Y') }}." />
  @include('partials.og-meta-event')
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Cormorant+Garamond:ital,wght@0,500;0,700;1,400;1,600&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    :root {
      --sakura-pink: #f2a7bb;
      --sakura-dark: #c0536e;
      --sakura-light: #fff0f3;
      --sakura-bg: #fffbfc;
      --text: #3a1f28;
      --muted: #9e7080;
    }
    body {
      font-family: 'Lato', sans-serif;
      background: var(--sakura-bg);
      color: var(--text);
      min-height: 100vh;
    }

    /* ── Petals (decorative) ── */
    .petals {
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      pointer-events: none;
      overflow: hidden;
      z-index: 0;
    }
    .petal {
      position: absolute;
      top: -10%;
      width: 10px;
      height: 14px;
      background: radial-gradient(ellipse, #f9c5d0 60%, #f2a7bb 100%);
      border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
      opacity: 0.7;
      animation: fall linear infinite;
    }
    @keyframes fall {
      0%   { transform: translateY(-5vh) rotate(0deg); opacity: 0.8; }
      100% { transform: translateY(110vh) rotate(360deg); opacity: 0; }
    }

    /* ── Hero ── */
    .hero {
      min-height: 100vh;
      background: linear-gradient(160deg, #fff0f3 0%, #fff5f7 50%, #fce8ed 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 3rem 1.5rem 5rem;
      position: relative;
      overflow: hidden;
    }
    .hero-ornament {
      font-size: 3rem;
      margin-bottom: 1rem;
      opacity: 0.5;
    }
    .hero-label {
      font-size: 0.7rem;
      letter-spacing: 0.3em;
      text-transform: uppercase;
      color: var(--sakura-dark);
      margin-bottom: 1.5rem;
      font-weight: 300;
    }
    .hero-names {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2.8rem, 9vw, 5.5rem);
      color: var(--text);
      line-height: 1.1;
      margin-bottom: 0.5rem;
    }
    .hero-names .amp {
      font-style: italic;
      font-weight: 400;
      color: var(--sakura-dark);
      font-size: 0.6em;
      display: block;
      margin: 0.3rem 0;
    }
    .hero-divider {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin: 1.5rem auto;
      width: fit-content;
    }
    .hero-divider span { display: block; width: 48px; height: 1px; background: var(--sakura-pink); }
    .hero-divider-icon { color: var(--sakura-dark); font-size: 1rem; }
    .hero-date {
      font-size: 0.85rem;
      color: var(--muted);
      letter-spacing: 0.12em;
      font-weight: 300;
    }
    .scroll-down {
      position: absolute;
      bottom: 2rem;
      left: 50%;
      transform: translateX(-50%);
      animation: pulse 2s ease-in-out infinite;
      color: var(--sakura-pink);
      font-size: 1.4rem;
    }
    @keyframes pulse { 0%,100% { opacity: 0.4; } 50% { opacity: 1; } }

    /* ── Content wrapper ── */
    .content { position: relative; z-index: 1; }
    .section {
      max-width: 660px;
      margin: 0 auto;
      padding: 4rem 1.5rem;
    }
    .section-inner {
      background: #fff;
      border-radius: 16px;
      padding: 2.5rem 2rem;
      box-shadow: 0 4px 24px rgba(194, 83, 110, 0.07);
      border: 1px solid #fce8ed;
    }
    .section-label {
      font-size: 0.65rem;
      letter-spacing: 0.25em;
      text-transform: uppercase;
      color: var(--sakura-dark);
      margin-bottom: 0.75rem;
    }
    .section-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.75rem;
      color: var(--text);
      margin-bottom: 1.25rem;
    }
    .section-body { font-size: 0.9rem; color: var(--muted); line-height: 1.9; }

    /* ── Countdown ── */
    .countdown {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-top: 2rem;
    }
    .count-box {
      text-align: center;
      background: var(--sakura-light);
      border-radius: 12px;
      padding: 1rem 1.25rem;
      min-width: 64px;
    }
    .count-num {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--sakura-dark);
      display: block;
      line-height: 1;
    }
    .count-label { font-size: 0.6rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--muted); margin-top: 0.25rem; display: block; }

    /* ── Forms ── */
    .form-group { margin-bottom: 1.25rem; }
    label { display: block; font-size: 0.78rem; color: var(--muted); margin-bottom: 0.4rem; letter-spacing: 0.05em; }
    input, select, textarea {
      width: 100%;
      border: 1px solid #fcd5de;
      border-radius: 8px;
      padding: 0.7rem 1rem;
      font-size: 0.9rem;
      font-family: 'Lato', sans-serif;
      color: var(--text);
      background: #fffbfc;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    input:focus, select:focus, textarea:focus {
      outline: none;
      border-color: var(--sakura-dark);
      box-shadow: 0 0 0 3px rgba(192, 83, 110, 0.1);
    }
    .btn-primary {
      display: block;
      width: 100%;
      padding: 0.9rem;
      background: linear-gradient(135deg, #e8758f, #c0536e);
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 0.9rem;
      font-weight: 700;
      letter-spacing: 0.05em;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 6px 16px rgba(192, 83, 110, 0.3);
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(192, 83, 110, 0.4); }

    /* ── Wishes ── */
    .wish-card {
      background: var(--sakura-light);
      border-radius: 10px;
      padding: 1.1rem 1.25rem;
      margin-bottom: 0.85rem;
      border-left: 3px solid var(--sakura-pink);
    }
    .wish-name { font-weight: 700; font-size: 0.85rem; color: var(--text); margin-bottom: 0.3rem; }
    .wish-msg { font-size: 0.85rem; color: var(--muted); line-height: 1.7; }

    /* ── Flash ── */
    .flash { padding: 0.85rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.85rem; }
    .flash-success { background: #fff0f3; border: 1px solid #fcd5de; color: #9e2a47; }

    /* ── Footer ── */
    footer {
      text-align: center;
      padding: 2.5rem 1rem;
      font-size: 0.78rem;
      color: var(--sakura-pink);
      border-top: 1px solid #fce8ed;
    }
  </style>
</head>
<body>

<!-- Petals -->
<div class="petals" aria-hidden="true">
  @for ($i = 0; $i < 14; $i++)
    <div class="petal" style="
      left: {{ rand(0, 100) }}%;
      animation-duration: {{ rand(6, 14) }}s;
      animation-delay: {{ rand(0, 10) }}s;
      width: {{ rand(8, 14) }}px;
      height: {{ rand(10, 18) }}px;
      opacity: {{ rand(3, 8) / 10 }};
    "></div>
  @endfor
</div>

<!-- Hero -->
<section class="hero">
  <div class="hero-ornament">🌸</div>
  <p class="hero-label">Undangan Pernikahan</p>
  <h1 class="hero-names">
    {{ $event->bride_name }}
    <span class="amp">& {{ $event->groom_name }}</span>
  </h1>
  <div class="hero-divider">
    <span></span>
    <span class="hero-divider-icon">💕</span>
    <span></span>
  </div>
  <p class="hero-date">{{ $event->event_date->translatedFormat('l, d F Y') }}</p>
  <div class="scroll-down">🌸</div>
</section>

<div class="content">

  <!-- Detail Acara -->
  <div class="section">
    <div class="section-inner">
      <p class="section-label">Detail Acara</p>
      <h2 class="section-title">{{ $event->title }}</h2>
      <div class="section-body">
        <p>🗓 {{ $event->event_date->translatedFormat('l, d F Y') }} · Pukul {{ $event->event_date->format('H:i') }} WIB</p>
        <p style="margin-top:0.6rem;">📍 {{ $event->location }}</p>
        @if ($event->maps_link)
          <p style="margin-top:1rem;">
            <a href="{{ $event->maps_link }}" target="_blank" style="color:var(--sakura-dark);font-weight:700;text-decoration:none;">
              🗺 Petunjuk Arah →
            </a>
          </p>
        @endif
      </div>

      <div class="countdown" id="countdown">
        <div class="count-box"><span class="count-num" id="cd-days">--</span><span class="count-label">Hari</span></div>
        <div class="count-box"><span class="count-num" id="cd-hours">--</span><span class="count-label">Jam</span></div>
        <div class="count-box"><span class="count-num" id="cd-mins">--</span><span class="count-label">Menit</span></div>
        <div class="count-box"><span class="count-num" id="cd-secs">--</span><span class="count-label">Detik</span></div>
      </div>
    </div>
  </div>

  <!-- RSVP -->
  <div class="section">
    <div class="section-inner">
      <p class="section-label">Konfirmasi Kehadiran</p>
      <h2 class="section-title">Apakah kamu hadir?</h2>

      @if (session('rsvp_success'))
        <div class="flash flash-success">{{ session('rsvp_success') }}</div>
      @endif

      <form action="{{ route('invitation.rsvp', $event->slug) }}" method="POST">
        @csrf
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" required placeholder="Nama kamu" />
        </div>
        <div class="form-group">
          <label>Nomor WhatsApp (opsional)</label>
          <input type="text" name="phone" placeholder="+62..." />
        </div>
        <div class="form-group">
          <label>Kehadiran</label>
          <select name="rsvp_status" required>
            <option value="hadir">🎉 Hadir</option>
            <option value="tidak_hadir">😢 Tidak Hadir</option>
            <option value="pending">🤔 Belum Pasti</option>
          </select>
        </div>
        <button type="submit" class="btn-primary">💌 Kirim Konfirmasi</button>
      </form>
    </div>
  </div>

  <!-- Ucapan -->
  <div class="section">
    <div class="section-inner">
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
          <label>Pesan</label>
          <textarea name="message" rows="3" required placeholder="Ucapan terbaikmu..."></textarea>
        </div>
        <button type="submit" class="btn-primary">🌸 Kirim Ucapan</button>
      </form>

      @forelse ($event->wishes as $wish)
        <div class="wish-card">
          <p class="wish-name">{{ $wish->guest_name }}</p>
          <p class="wish-msg">{{ $wish->message }}</p>
        </div>
      @empty
        <p style="color:var(--sakura-pink);font-size:0.85rem;text-align:center;">Belum ada ucapan. Jadilah yang pertama! 🌸</p>
      @endforelse
    </div>
  </div>

</div>

<footer>
  Dibuat dengan 🌸 menggunakan <strong>UNDIGI</strong>
</footer>

<script>
  const target = new Date('{{ $event->event_date->toIso8601String() }}').getTime();
  function tick() {
    const diff = target - Date.now();
    if (diff <= 0) {
      document.getElementById('countdown').innerHTML = '<p style="color:var(--sakura-dark);font-size:0.9rem;text-align:center;">Acara sudah berlangsung 🎉</p>';
      return;
    }
    document.getElementById('cd-days').textContent  = String(Math.floor(diff / 86400000)).padStart(2,'0');
    document.getElementById('cd-hours').textContent = String(Math.floor((diff % 86400000) / 3600000)).padStart(2,'0');
    document.getElementById('cd-mins').textContent  = String(Math.floor((diff % 3600000) / 60000)).padStart(2,'0');
    document.getElementById('cd-secs').textContent  = String(Math.floor((diff % 60000) / 1000)).padStart(2,'0');
  }
  tick(); setInterval(tick, 1000);
</script>

</body>
</html>

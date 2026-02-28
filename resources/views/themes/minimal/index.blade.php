<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $event->bride_name }} & {{ $event->groom_name }} — Undangan Pernikahan</title>
  <meta name="description" content="Undangan pernikahan {{ $event->bride_name }} & {{ $event->groom_name }}, {{ $event->event_date->translatedFormat('d F Y') }}." />
  @include('partials.og-meta-event')
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,600;1,400&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Inter', sans-serif;
      background: #fafafa;
      color: #1a1a1a;
      min-height: 100vh;
    }

    /* ── Hero ── */
    .hero {
      min-height: 100vh;
      background: #ffffff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 3rem 1.5rem;
      border-bottom: 1px solid #e5e5e5;
      position: relative;
    }
    .hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, #f9f9f9 0%, #ffffff 100%);
      z-index: 0;
    }
    .hero > * { position: relative; z-index: 1; }
    .hero-label {
      font-size: 0.7rem;
      letter-spacing: 0.25em;
      text-transform: uppercase;
      color: #888;
      margin-bottom: 1.5rem;
    }
    .hero-names {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.5rem, 8vw, 5rem);
      font-weight: 600;
      line-height: 1.1;
      color: #111;
      margin-bottom: 0.5rem;
    }
    .hero-names em {
      font-style: italic;
      font-weight: 400;
      color: #555;
    }
    .divider {
      width: 48px;
      height: 1px;
      background: #ccc;
      margin: 1.5rem auto;
    }
    .hero-date {
      font-size: 0.9rem;
      color: #666;
      letter-spacing: 0.1em;
    }
    .scroll-hint {
      position: absolute;
      bottom: 2rem;
      left: 50%;
      transform: translateX(-50%);
      animation: bounce 2s infinite;
      color: #aaa;
      font-size: 1.5rem;
    }
    @keyframes bounce { 0%,100% { transform: translateX(-50%) translateY(0); } 50% { transform: translateX(-50%) translateY(6px); } }

    /* ── Sections ── */
    .section {
      max-width: 640px;
      margin: 0 auto;
      padding: 4rem 1.5rem;
      border-bottom: 1px solid #e5e5e5;
    }
    .section:last-child { border-bottom: none; }
    .section-label {
      font-size: 0.65rem;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: #aaa;
      margin-bottom: 1rem;
    }
    .section-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.6rem;
      color: #111;
      margin-bottom: 1rem;
    }
    .section-body {
      font-size: 0.9rem;
      color: #555;
      line-height: 1.8;
    }

    /* ── Countdown ── */
    .countdown {
      display: flex;
      justify-content: center;
      gap: 1.5rem;
      margin-top: 2rem;
    }
    .count-box { text-align: center; }
    .count-num {
      font-size: 2rem;
      font-weight: 600;
      color: #111;
      display: block;
    }
    .count-label { font-size: 0.65rem; letter-spacing: 0.15em; text-transform: uppercase; color: #aaa; }

    /* ── RSVP ── */
    .form-group { margin-bottom: 1.25rem; }
    label { display: block; font-size: 0.78rem; color: #666; margin-bottom: 0.4rem; letter-spacing: 0.05em; }
    input, select, textarea {
      width: 100%;
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 0.65rem 0.85rem;
      font-size: 0.9rem;
      font-family: 'Inter', sans-serif;
      color: #111;
      background: #fff;
      transition: border-color 0.2s;
    }
    input:focus, select:focus, textarea:focus { outline: none; border-color: #111; }
    .btn-primary {
      display: block;
      width: 100%;
      padding: 0.85rem;
      background: #111;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-size: 0.9rem;
      font-weight: 600;
      letter-spacing: 0.05em;
      cursor: pointer;
      transition: background 0.2s;
    }
    .btn-primary:hover { background: #333; }

    /* ── Wishes ── */
    .wish-card {
      border: 1px solid #eee;
      border-radius: 6px;
      padding: 1.2rem;
      margin-bottom: 1rem;
    }
    .wish-name { font-weight: 600; font-size: 0.85rem; color: #111; margin-bottom: 0.35rem; }
    .wish-msg { font-size: 0.85rem; color: #666; line-height: 1.6; }

    /* ── Flash ── */
    .flash { padding: 0.85rem 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.85rem; }
    .flash-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
  </style>
</head>
<body>

<!-- Hero -->
<section class="hero">
  <p class="hero-label">Undangan Pernikahan</p>
  <h1 class="hero-names">
    {{ $event->bride_name }}<br>
    <em>& {{ $event->groom_name }}</em>
  </h1>
  <div class="divider"></div>
  <p class="hero-date">{{ $event->event_date->translatedFormat('l, d F Y') }}</p>
  <div class="scroll-hint">↓</div>
</section>

<!-- Detail Acara -->
<div class="section">
  <p class="section-label">Detail Acara</p>
  <h2 class="section-title">{{ $event->title }}</h2>
  <div class="section-body">
    <p>📅 {{ $event->event_date->translatedFormat('l, d F Y · H:i') }} WIB</p>
    <p style="margin-top:0.5rem;">📍 {{ $event->location }}</p>
    @if ($event->maps_link)
      <p style="margin-top:0.75rem;"><a href="{{ $event->maps_link }}" target="_blank" style="color:#111;font-weight:600;">Lihat di Google Maps →</a></p>
    @endif
  </div>

  <!-- Countdown -->
  <div class="countdown" id="countdown">
    <div class="count-box"><span class="count-num" id="cd-days">--</span><span class="count-label">Hari</span></div>
    <div class="count-box"><span class="count-num" id="cd-hours">--</span><span class="count-label">Jam</span></div>
    <div class="count-box"><span class="count-num" id="cd-mins">--</span><span class="count-label">Menit</span></div>
    <div class="count-box"><span class="count-num" id="cd-secs">--</span><span class="count-label">Detik</span></div>
  </div>
</div>

<!-- RSVP -->
<div class="section">
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
        <option value="hadir">Hadir</option>
        <option value="tidak_hadir">Tidak Hadir</option>
        <option value="pending">Belum Pasti</option>
      </select>
    </div>
    <button type="submit" class="btn-primary">Kirim Konfirmasi</button>
  </form>
</div>

<!-- Ucapan -->
<div class="section">
  <p class="section-label">Ucapan & Doa</p>
  <h2 class="section-title">Tuliskan Pesanmu</h2>

  @if (session('wish_success'))
    <div class="flash flash-success">{{ session('wish_success') }}</div>
  @endif

  <form action="{{ route('invitation.wish', $event->slug) }}" method="POST" style="margin-bottom:2.5rem;">
    @csrf
    <div class="form-group">
      <label>Nama</label>
      <input type="text" name="guest_name" required placeholder="Nama kamu" />
    </div>
    <div class="form-group">
      <label>Pesan</label>
      <textarea name="message" rows="3" required placeholder="Tuliskan ucapan terbaikmu..."></textarea>
    </div>
    <button type="submit" class="btn-primary">Kirim Ucapan</button>
  </form>

  @forelse ($event->wishes as $wish)
    <div class="wish-card">
      <p class="wish-name">{{ $wish->guest_name }}</p>
      <p class="wish-msg">{{ $wish->message }}</p>
    </div>
  @empty
    <p style="color:#aaa;font-size:0.85rem;text-align:center;">Belum ada ucapan. Jadilah yang pertama!</p>
  @endforelse
</div>

<footer style="text-align:center;padding:2rem 1rem;font-size:0.75rem;color:#ccc;border-top:1px solid #eee;">
  Dibuat dengan ❤ menggunakan <strong style="color:#999;">UNDIGI</strong>
</footer>

<script>
  // Countdown
  const target = new Date('{{ $event->event_date->toIso8601String() }}').getTime();
  function tick() {
    const diff = target - Date.now();
    if (diff <= 0) {
      document.getElementById('countdown').innerHTML = '<p style="color:#aaa;font-size:0.85rem;">Acara sudah berlangsung 🎉</p>';
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

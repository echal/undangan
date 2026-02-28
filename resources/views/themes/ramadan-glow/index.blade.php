<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $event->title }}</title>
  <meta name="description" content="{{ $event->title }} — {{ $event->event_date->translatedFormat('d F Y') }}. {{ $event->location }}">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    :root {
      --gold:       #c8960c;
      --gold-light: #f5e6b2;
      --gold-pale:  #fdf8e8;
      --amber:      #b45309;
      --teal:       #0f766e;
      --teal-light: #ccfbf1;
      --green:      #166534;
      --dark:       #1c1410;
      --text:       #3b2a14;
      --muted:      #78614a;
      --border:     #e8d9b0;
      --bg:         #fffbf0;
      --cream:      #fdf6e3;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ── ORNAMENT ── */
    .ornament {
      display: flex; align-items: center; gap: 12px;
      justify-content: center; margin: 20px 0;
      color: var(--gold); font-size: 16px; letter-spacing: 8px;
    }
    .ornament::before, .ornament::after {
      content: ''; flex: 1; max-width: 80px; height: 1px;
      background: linear-gradient(to right, transparent, var(--gold));
    }
    .ornament::after { background: linear-gradient(to left, transparent, var(--gold)); }

    /* ── HERO ── */
    @keyframes heroFadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .hero {
      position: relative;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      overflow: hidden;
      background: linear-gradient(160deg, #1c1410 0%, #2d1f0e 50%, #1a2a20 100%);
    }
    .hero-bg {
      position: absolute; inset: 0;
      background-size: cover;
      background-position: center;
      opacity: 0.3;
    }
    .hero::before {
      content: '☽';
      position: absolute;
      top: 30px; right: 30px;
      font-size: 60px;
      color: rgba(200,150,12,0.15);
      line-height: 1;
    }
    .hero-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(180deg, rgba(28,20,16,0.3) 0%, rgba(28,20,16,0.75) 100%);
    }
    .hero-content {
      position: relative; z-index: 2;
      padding: 40px 24px;
      animation: heroFadeIn 1.2s ease both;
    }
    .hero-tag {
      font-size: 11px; font-weight: 600;
      letter-spacing: 4px; text-transform: uppercase;
      color: var(--gold-light); margin-bottom: 16px;
    }
    .hero-moon { font-size: 2.5rem; margin-bottom: 12px; display: block; }
    .hero-title {
      font-family: 'Amiri', serif;
      font-size: clamp(2rem, 7vw, 3.6rem);
      color: #fff; line-height: 1.2; margin-bottom: 10px;
    }
    .hero-subtitle {
      font-size: 14px; color: var(--gold-light); opacity: 0.9;
      margin-bottom: 18px; line-height: 1.7;
    }
    .hero-date-badge {
      display: inline-block;
      background: rgba(200,150,12,0.2);
      border: 1px solid rgba(200,150,12,0.4);
      color: var(--gold-light);
      padding: 8px 24px; border-radius: 50px;
      font-size: 14px; font-weight: 500; letter-spacing: 0.5px;
    }
    .scroll-hint {
      position: absolute; bottom: 28px; left: 50%;
      transform: translateX(-50%);
      animation: bounce 2s infinite; z-index: 2;
    }
    @keyframes bounce {
      0%, 100% { transform: translateX(-50%) translateY(0); }
      50% { transform: translateX(-50%) translateY(8px); }
    }

    /* ── SECTIONS ── */
    .section-inner {
      max-width: 640px; margin: 0 auto;
      padding: 56px 24px; text-align: center;
    }
    .section-label {
      display: inline-block; font-size: 10px; font-weight: 700;
      letter-spacing: 4px; text-transform: uppercase;
      color: var(--gold); margin-bottom: 8px;
    }
    .section-title {
      font-family: 'Amiri', serif;
      font-size: clamp(1.6rem, 5vw, 2.2rem);
      color: var(--text); margin-bottom: 6px; line-height: 1.3;
    }
    .section-subtitle {
      font-size: 14px; color: var(--muted); line-height: 1.7; margin-bottom: 4px;
    }

    /* ── COUNTDOWN ── */
    .countdown-section { background: var(--cream); }
    .countdown-grid {
      display: flex; justify-content: center;
      gap: 12px; margin-top: 28px; flex-wrap: wrap;
    }
    .countdown-box {
      background: #fff; border: 1px solid var(--border);
      border-radius: 14px; padding: 18px 20px; min-width: 72px;
      box-shadow: 0 2px 12px rgba(200,150,12,0.08);
    }
    .countdown-num {
      font-family: 'Amiri', serif; font-size: 2.2rem;
      font-weight: 700; color: var(--gold); line-height: 1;
    }
    .countdown-label {
      font-size: 10px; font-weight: 600; letter-spacing: 2px;
      text-transform: uppercase; color: var(--muted); margin-top: 6px;
    }
    .countdown-passed { font-size: 16px; color: var(--gold); margin-top: 24px; font-style: italic; }

    /* ── HOST / KELUARGA PENYELENGGARA ── */
    .host-section { background: linear-gradient(160deg, #1c1410 0%, #2d1f0e 100%); }
    .host-section .section-label { color: var(--gold-light); }
    .host-section .section-title { color: #fff; }
    .host-section .section-subtitle { color: rgba(255,255,255,0.65); }
    .host-card {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 24px;
      margin-top: 32px;
    }
    @media (min-width: 540px) {
      .host-card { flex-direction: row; text-align: left; }
    }
    .host-photo-wrap {
      flex-shrink: 0;
      width: 180px;
      height: 135px; /* 4:3 ratio */
      border-radius: 16px;
      overflow: hidden;
      border: 3px solid rgba(200,150,12,0.5);
      box-shadow: 0 8px 30px rgba(0,0,0,0.4);
      position: relative;
    }
    .host-photo-wrap img {
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    .host-photo-wrap:hover img { transform: scale(1.04); }
    /* Gold shimmer border on hover */
    .host-photo-wrap::after {
      content: '';
      position: absolute; inset: 0;
      border-radius: 13px;
      border: 2px solid rgba(200,150,12,0);
      transition: border-color 0.3s;
    }
    .host-photo-wrap:hover::after { border-color: rgba(200,150,12,0.6); }
    .host-info { flex: 1; }
    .host-label {
      font-size: 10px; font-weight: 700;
      letter-spacing: 3px; text-transform: uppercase;
      color: var(--gold); margin-bottom: 8px;
    }
    .host-name {
      font-family: 'Amiri', serif;
      font-size: clamp(1.4rem, 4vw, 1.9rem);
      color: #fff; line-height: 1.3; margin-bottom: 10px;
    }
    .host-desc {
      font-size: 14px; color: rgba(255,255,255,0.65);
      line-height: 1.7;
    }
    .host-bismillah {
      font-family: 'Amiri', serif;
      font-size: 1rem; font-style: italic;
      color: var(--gold-light); opacity: 0.8;
      margin-top: 12px;
    }

    /* ── INFO CARDS ── */
    .info-section { background: var(--bg); }
    .info-card {
      background: #fff; border: 1px solid var(--border);
      border-radius: 16px; padding: 22px 24px;
      text-align: left; display: flex; gap: 16px;
      align-items: flex-start;
      box-shadow: 0 2px 10px rgba(0,0,0,0.04);
      margin-top: 14px;
    }
    .info-icon { font-size: 1.5rem; flex-shrink: 0; margin-top: 2px; }
    .info-label {
      font-size: 10px; font-weight: 700; letter-spacing: 2px;
      text-transform: uppercase; color: var(--gold); margin-bottom: 4px;
    }
    .info-value { font-size: 15px; font-weight: 500; color: var(--text); line-height: 1.5; }
    .info-value a { color: var(--teal); text-decoration: none; }
    .info-value a:hover { text-decoration: underline; }

    /* ── GALLERY ── */
    .gallery-section { background: var(--cream); }
    .gallery-grid {
      display: grid; grid-template-columns: repeat(2, 1fr);
      gap: 8px; margin-top: 28px;
    }
    @media (min-width: 480px) { .gallery-grid { grid-template-columns: repeat(3, 1fr); } }
    .gallery-item {
      aspect-ratio: 1; overflow: hidden; border-radius: 10px;
      cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .gallery-item img {
      width: 100%; height: 100%; object-fit: cover;
      transition: transform 0.4s ease;
    }
    .gallery-item:hover img { transform: scale(1.06); }

    /* ── LIGHTBOX ── */
    .lightbox-overlay {
      position: fixed; inset: 0; z-index: 9999;
      background: rgba(0,0,0,0.93);
      display: flex; align-items: center; justify-content: center;
      padding: 20px;
    }
    .lightbox-img {
      max-width: 100%; max-height: 90vh;
      border-radius: 8px; object-fit: contain;
      box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }
    .lightbox-close {
      position: fixed; top: 18px; right: 20px;
      width: 40px; height: 40px;
      background: rgba(255,255,255,0.12); border: none; border-radius: 50%;
      color: #fff; font-size: 20px; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.2s; z-index: 10000;
    }
    .lightbox-close:hover { background: rgba(255,255,255,0.25); }
    .lightbox-nav {
      position: fixed; top: 50%; transform: translateY(-50%);
      width: 44px; height: 44px;
      background: rgba(255,255,255,0.12); border: none; border-radius: 50%;
      color: #fff; font-size: 22px; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.2s; z-index: 10000;
    }
    .lightbox-nav:hover { background: rgba(255,255,255,0.25); }
    .lightbox-nav.prev { left: 16px; }
    .lightbox-nav.next { right: 16px; }
    .lightbox-counter {
      position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
      color: rgba(255,255,255,0.6); font-size: 13px; z-index: 10000;
    }

    /* ── RSVP ── */
    .rsvp-section { background: linear-gradient(160deg, #1a2a20 0%, #1c1410 100%); }
    .rsvp-section .section-label { color: var(--gold-light); }
    .rsvp-section .section-title { color: #fff; }
    .rsvp-section .section-subtitle { color: rgba(255,255,255,0.6); }
    .rsvp-box {
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(200,150,12,0.3);
      border-radius: 20px; padding: 28px 24px; margin-top: 28px;
    }
    .form-group { margin-bottom: 16px; }
    .form-label {
      display: block; font-size: 11px; font-weight: 600;
      letter-spacing: 1.5px; text-transform: uppercase;
      color: var(--gold-light); margin-bottom: 6px;
    }
    .form-input {
      width: 100%; padding: 12px 16px;
      border: 1px solid rgba(200,150,12,0.3);
      border-radius: 10px; font-size: 14px;
      font-family: 'Poppins', sans-serif;
      color: #fff; background: rgba(255,255,255,0.06);
      transition: border-color 0.2s; outline: none;
    }
    .form-input:focus { border-color: var(--gold); }
    .form-input::placeholder { color: rgba(255,255,255,0.35); }
    .rsvp-radio-group { display: flex; gap: 10px; flex-wrap: wrap; }
    .rsvp-radio-label {
      display: flex; align-items: center; gap: 6px;
      padding: 8px 16px; border: 1px solid rgba(200,150,12,0.3);
      border-radius: 50px; cursor: pointer; font-size: 13px;
      color: rgba(255,255,255,0.8); transition: all 0.2s;
    }
    .rsvp-radio-label:has(input:checked) {
      border-color: var(--gold); background: rgba(200,150,12,0.2);
      color: var(--gold-light);
    }
    .rsvp-radio-label input { display: none; }
    .btn-primary {
      width: 100%; padding: 14px;
      background: linear-gradient(135deg, var(--gold), var(--amber));
      color: #fff; border: none; border-radius: 10px;
      font-size: 15px; font-weight: 600;
      font-family: 'Poppins', sans-serif;
      cursor: pointer; letter-spacing: 0.5px;
      transition: opacity 0.2s;
    }
    .btn-primary:hover { opacity: 0.88; }
    .alert-success {
      padding: 14px 18px;
      background: rgba(20,83,45,0.3);
      border: 1px solid rgba(34,197,94,0.3);
      border-radius: 10px; color: #86efac;
      font-size: 14px; margin-bottom: 20px;
    }

    /* ── WISHES ── */
    .wishes-section { background: var(--bg); }
    .wish-form {
      background: var(--cream); border: 1px solid var(--border);
      border-radius: 16px; padding: 24px 20px;
      margin-top: 24px; text-align: left;
    }
    .wish-form .form-label { color: var(--muted); }
    .wish-form .form-input {
      background: #fff; color: var(--text);
      border: 1px solid var(--border);
    }
    .wish-form .form-input:focus { border-color: var(--gold); }
    .wish-form .form-input::placeholder { color: #c5b49a; }
    .wish-form .btn-primary { background: linear-gradient(135deg, var(--teal), var(--green)); }
    .wish-cards { display: flex; flex-direction: column; gap: 14px; margin-top: 28px; }
    .wish-card {
      background: #fff; border: 1px solid var(--border);
      border-radius: 14px; padding: 18px 20px;
      text-align: left; position: relative;
    }
    .wish-card::before {
      content: '☽'; position: absolute;
      top: 8px; right: 14px;
      font-size: 1.4rem; color: var(--gold-light);
    }
    .wish-name { font-weight: 600; font-size: 14px; color: var(--gold); margin-bottom: 4px; }
    .wish-message { font-size: 14px; color: var(--muted); line-height: 1.6; }

    /* ── FOOTER ── */
    .footer {
      background: var(--dark); color: rgba(255,255,255,0.4);
      text-align: center; padding: 28px 24px;
      font-size: 12px; letter-spacing: 1px;
    }
    .footer strong { color: rgba(255,255,255,0.75); }
  </style>
</head>
<body>

@php
  $data        = $event->event_data ?? [];
  $eventDate   = $event->event_date;
  $hostName    = $event->bride_name ?? null;
  $description = $data['description'] ?? null;
  $hostPhoto   = $data['host_photo']  ?? null;
  $appUrl      = rtrim(config('app.url'), '/');
@endphp

{{-- ══════════════════════════════════════
     HERO — full-screen with banner_image background + fade-in animation
══════════════════════════════════════ --}}
<section class="hero">
  @if ($event->banner_image)
    <div class="hero-bg" style="background-image: url('{{ $appUrl }}/storage/{{ str_replace('\\', '/', $event->banner_image) }}')"></div>
  @endif
  <div class="hero-overlay"></div>

  <div class="hero-content">
    <p class="hero-tag">— Undangan Buka Puasa Bersama —</p>
    <span class="hero-moon">🌙</span>
    <h1 class="hero-title">{{ $event->title }}</h1>
    @if ($hostName)
      <p class="hero-subtitle">Dengan hormat, kami mengundang kehadiran Anda<br>dalam acara yang diselenggarakan oleh<br><strong style="color:var(--gold-light);">{{ $hostName }}</strong></p>
    @endif
    <div class="hero-date-badge">{{ $eventDate->translatedFormat('l, d F Y') }}</div>
  </div>

  <div class="scroll-hint">
    <svg width="24" height="24" fill="none" stroke="rgba(200,150,12,0.7)" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
    </svg>
  </div>
</section>

{{-- ══════════════════════════════════════
     COUNTDOWN — Alpine.js countdown timer
══════════════════════════════════════ --}}
<section class="countdown-section">
  <div class="section-inner">
    <span class="section-label">Menghitung Waktu</span>
    <h2 class="section-title">Segera Hadir</h2>
    <div class="ornament">☽</div>

    <div x-data="{
      days: 0, hours: 0, minutes: 0, seconds: 0, passed: false,
      init() {
        const target = new Date('{{ $eventDate->toIso8601String() }}').getTime();
        const tick = () => {
          const diff = target - Date.now();
          if (diff <= 0) { this.passed = true; return; }
          this.days    = Math.floor(diff / 86400000);
          this.hours   = Math.floor((diff % 86400000) / 3600000);
          this.minutes = Math.floor((diff % 3600000)  / 60000);
          this.seconds = Math.floor((diff % 60000)    / 1000);
          setTimeout(tick, 1000);
        };
        tick();
      }
    }" x-init="init()">
      <template x-if="!passed">
        <div class="countdown-grid">
          <div class="countdown-box"><div class="countdown-num" x-text="days"></div><div class="countdown-label">Hari</div></div>
          <div class="countdown-box"><div class="countdown-num" x-text="hours"></div><div class="countdown-label">Jam</div></div>
          <div class="countdown-box"><div class="countdown-num" x-text="minutes"></div><div class="countdown-label">Menit</div></div>
          <div class="countdown-box"><div class="countdown-num" x-text="seconds"></div><div class="countdown-label">Detik</div></div>
        </div>
      </template>
      <template x-if="passed">
        <p class="countdown-passed">Alhamdulillah, acara telah berlangsung ✨</p>
      </template>
    </div>
  </div>
</section>

{{-- ══════════════════════════════════════
     KELUARGA PENYELENGGARA (conditional — hanya jika host_photo ada)
══════════════════════════════════════ --}}
@if ($hostPhoto || $hostName)
<section class="host-section">
  <div class="section-inner">
    <span class="section-label">Dari Keluarga</span>
    <h2 class="section-title">Penyelenggara</h2>
    <div class="ornament">☽</div>

    <div class="host-card">

      {{-- Foto keluarga --}}
      @if ($hostPhoto)
        <div class="host-photo-wrap">
          <img src="{{ $appUrl }}/storage/{{ str_replace('\\', '/', $hostPhoto) }}"
               alt="Foto Keluarga {{ $hostName }}"
               loading="eager">
        </div>
      @endif

      {{-- Nama & keterangan --}}
      <div class="host-info">
        @if ($hostName)
          <p class="host-label">Mengundang Anda</p>
          <p class="host-name">{{ $hostName }}</p>
        @endif
        @if ($description)
          <p class="host-desc">{{ $description }}</p>
        @else
          <p class="host-desc">Dengan penuh kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan berbagi berkah bersama kami.</p>
        @endif
        <p class="host-bismillah">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>
      </div>

    </div>
  </div>
</section>
@endif

{{-- ══════════════════════════════════════
     DETAIL ACARA — date, time, location, description
══════════════════════════════════════ --}}
<section class="info-section">
  <div class="section-inner">
    <span class="section-label">Informasi</span>
    <h2 class="section-title">Detail Acara</h2>
    <div class="ornament">☽</div>

    {{-- Tampilkan description di sini hanya jika tidak ada host_photo (sudah tampil di section Keluarga) --}}
    @if ($description && ! $hostPhoto && ! $hostName)
      <p class="section-subtitle" style="margin-bottom:20px;">{{ $description }}</p>
    @endif

    <div class="info-card">
      <div class="info-icon">📅</div>
      <div>
        <p class="info-label">Tanggal & Waktu</p>
        <p class="info-value">{{ $eventDate->translatedFormat('l, d F Y') }}</p>
        <p class="info-value" style="font-weight:400;font-size:13px;color:var(--muted);">Pukul {{ $eventDate->format('H:i') }} WIB</p>
      </div>
    </div>

    <div class="info-card">
      <div class="info-icon">📍</div>
      <div>
        <p class="info-label">Lokasi</p>
        <p class="info-value">{{ $event->location }}</p>
        @if ($event->maps_link)
          <p class="info-value" style="margin-top:6px;">
            <a href="{{ $event->maps_link }}" target="_blank" rel="noopener">Lihat di Google Maps →</a>
          </p>
        @endif
      </div>
    </div>

  </div>
</section>

{{-- ══════════════════════════════════════
     GALERI (conditional) + LIGHTBOX — Alpine.js fullscreen modal
══════════════════════════════════════ --}}
@if (! empty($event->gallery_images))
@php $galleryUrls = array_map(fn($img) => $appUrl . '/storage/' . str_replace('\\', '/', $img), $event->gallery_images); @endphp
<section class="gallery-section"
  x-data="{
    open: false,
    current: 0,
    images: {{ json_encode(array_values($galleryUrls)) }},
    show(idx) { this.current = idx; this.open = true; },
    prev() { this.current = (this.current - 1 + this.images.length) % this.images.length; },
    next() { this.current = (this.current + 1) % this.images.length; },
  }"
  @keydown.escape.window="open = false"
  @keydown.arrow-left.window="open && prev()"
  @keydown.arrow-right.window="open && next()"
>
  <div class="section-inner">
    <span class="section-label">Momen</span>
    <h2 class="section-title">Galeri Foto</h2>
    <div class="ornament">☽</div>

    {{-- Responsive grid: 2 cols mobile, 3 cols tablet+ --}}
    <div class="gallery-grid">
      @foreach ($galleryUrls as $idx => $url)
        <div class="gallery-item" @click="show({{ $idx }})">
          <img src="{{ $url }}" alt="Galeri {{ $idx + 1 }}" loading="lazy">
        </div>
      @endforeach
    </div>
  </div>

  {{-- Lightbox modal: dark overlay, centered image, nav + close + ESC --}}
  <div class="lightbox-overlay"
       x-show="open"
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       @click.self="open = false"
       style="display:none;"
  >
    <button class="lightbox-close" @click="open = false" aria-label="Tutup">&#10005;</button>
    <button class="lightbox-nav prev" @click.stop="prev()" aria-label="Sebelumnya">&#8249;</button>
    <img :src="images[current]" :alt="'Foto ' + (current + 1)" class="lightbox-img"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
    <button class="lightbox-nav next" @click.stop="next()" aria-label="Berikutnya">&#8250;</button>
    <div class="lightbox-counter" x-text="(current + 1) + ' / ' + images.length"></div>
  </div>

</section>
@endif

{{-- ══════════════════════════════════════
     RSVP (conditional)
══════════════════════════════════════ --}}
@if ($event->rsvp_enabled)
<section class="rsvp-section">
  <div class="section-inner">
    <span class="section-label">Konfirmasi</span>
    <h2 class="section-title">RSVP Kehadiran</h2>
    <p class="section-subtitle">Mohon konfirmasi kehadiran Anda sebelum hari-H</p>

    @if (session('rsvp_success'))
      <div class="rsvp-box">
        <div class="alert-success">{{ session('rsvp_success') }}</div>
      </div>
    @else
      <form action="{{ route('invitation.rsvp', $event->slug) }}" method="POST" class="rsvp-box">
        @csrf
        <div class="form-group">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="name" class="form-input" placeholder="Masukkan nama Anda" required>
        </div>
        <div class="form-group">
          <label class="form-label">Nomor WhatsApp</label>
          <input type="text" name="phone" class="form-input" placeholder="08xxxxxxxxxx (opsional)">
        </div>
        <div class="form-group">
          <label class="form-label">Konfirmasi Kehadiran</label>
          <div class="rsvp-radio-group">
            <label class="rsvp-radio-label"><input type="radio" name="rsvp_status" value="hadir" required> 🎉 Hadir</label>
            <label class="rsvp-radio-label"><input type="radio" name="rsvp_status" value="tidak_hadir"> 😔 Tidak Hadir</label>
            <label class="rsvp-radio-label"><input type="radio" name="rsvp_status" value="pending"> 🤔 Masih Ragu</label>
          </div>
        </div>
        <button type="submit" class="btn-primary">Kirim Konfirmasi</button>
      </form>
    @endif
  </div>
</section>
@endif

{{-- ══════════════════════════════════════
     UCAPAN & DOA
══════════════════════════════════════ --}}
<section class="wishes-section">
  <div class="section-inner">
    <span class="section-label">Ucapan & Doa</span>
    <h2 class="section-title">Sampaikan Pesan</h2>
    <p class="section-subtitle">Setiap doa dan ucapan adalah semangat bagi kami</p>

    @if (session('wish_success'))
      <div style="padding:14px 18px;background:#ecfdf5;border:1px solid #a7f3d0;border-radius:10px;color:#065f46;font-size:14px;margin-top:20px;">
        {{ session('wish_success') }}
      </div>
    @endif

    <form action="{{ route('invitation.wish', $event->slug) }}" method="POST" class="wish-form">
      @csrf
      <div class="form-group">
        <label class="form-label">Nama Anda</label>
        <input type="text" name="guest_name" class="form-input" placeholder="Nama pengirim ucapan" required>
      </div>
      <div class="form-group">
        <label class="form-label">Ucapan & Doa</label>
        <textarea name="message" rows="3" class="form-input" placeholder="Tuliskan doa dan harapan terbaik..." required style="resize:vertical;"></textarea>
      </div>
      <button type="submit" class="btn-primary">Kirim Ucapan 🌙</button>
    </form>

    @if ($event->wishes->count() > 0)
      <div class="wish-cards">
        @foreach ($event->wishes as $wish)
          <div class="wish-card">
            <p class="wish-name">{{ $wish->guest_name }}</p>
            <p class="wish-message">{{ $wish->message }}</p>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>

{{-- ══════════════════════════════════════
     FOOTER
══════════════════════════════════════ --}}
<footer class="footer">
  <p>🌙 <strong>{{ $event->title }}</strong></p>
  <p style="margin-top:6px;">{{ $eventDate->translatedFormat('d F Y') }} · {{ $event->location }}</p>
  <p style="margin-top:8px;">Dibuat dengan Undangan Digital</p>
</footer>

{{-- ══════════════════════════════════════
     BACKGROUND MUSIC PLAYER
     Floating button bottom-right
     Alpine.js — fade in/out
══════════════════════════════════════ --}}
@php
    $musicUrl = null;
    if ($event->music_id && $event->music) {
        $musicUrl = $event->music->url;
    } elseif ($event->background_music) {
        $musicUrl = rtrim(config('app.url'), '/') . '/storage/' . ltrim($event->background_music, '/');
    }
@endphp
@if($musicUrl)
<style>
  .music-btn {
    position: fixed;
    bottom: 28px;
    right: 24px;
    z-index: 9999;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #c8960c, #e6b430);
    color: #1c1410;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    box-shadow: 0 4px 18px rgba(0,0,0,0.30), 0 0 0 4px rgba(200,150,12,0.20);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    -webkit-tap-highlight-color: transparent;
    outline: none;
  }
  .music-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 24px rgba(0,0,0,0.36), 0 0 0 6px rgba(200,150,12,0.28);
  }
  @keyframes musicPulse {
    0%   { box-shadow: 0 4px 18px rgba(0,0,0,0.30), 0 0 0 4px rgba(200,150,12,0.30); }
    50%  { box-shadow: 0 4px 18px rgba(0,0,0,0.30), 0 0 0 12px rgba(200,150,12,0.06); }
    100% { box-shadow: 0 4px 18px rgba(0,0,0,0.30), 0 0 0 4px rgba(200,150,12,0.30); }
  }
  .music-btn.playing { animation: musicPulse 2s ease-in-out infinite; }
  @keyframes musicSpin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
  }
  .music-icon.playing { display: inline-block; animation: musicSpin 4s linear infinite; }
  @media (max-width: 480px) {
    .music-btn { bottom: 20px; right: 16px; width: 46px; height: 46px; font-size: 1.2rem; }
  }
</style>

<div x-data="musicPlayer()" x-init="init()">
  <audio x-ref="audio" loop preload="none">
    <source src="{{ $musicUrl }}" type="audio/mpeg">
  </audio>
  <button
    @click="toggle()"
    class="music-btn"
    :class="{ 'playing': isPlaying }"
    :title="isPlaying ? 'Pause Musik' : 'Putar Musik'"
    aria-label="Toggle background music"
  >
    <span class="music-icon" :class="{ 'playing': isPlaying }">🎵</span>
  </button>
</div>

<script>
  function musicPlayer() {
    return {
      isPlaying: false,
      fadeDuration: 800,
      fadeSteps: 20,
      _fadeTimer: null,
      init() { this.$refs.audio.volume = 0; },
      toggle() { this.isPlaying ? this.pause() : this.play(); },
      play() {
        const audio = this.$refs.audio;
        clearInterval(this._fadeTimer);
        audio.volume = 0;
        audio.play().then(() => {
          this.isPlaying = true;
          let step = 0;
          const stepSize = 1 / this.fadeSteps;
          const stepInterval = this.fadeDuration / this.fadeSteps;
          this._fadeTimer = setInterval(() => {
            step++;
            audio.volume = Math.min(1, parseFloat((step * stepSize).toFixed(2)));
            if (step >= this.fadeSteps) clearInterval(this._fadeTimer);
          }, stepInterval);
        }).catch(() => { this.isPlaying = false; });
      },
      pause() {
        const audio = this.$refs.audio;
        clearInterval(this._fadeTimer);
        let currentVol = audio.volume;
        const steps = this.fadeSteps;
        const stepSize = currentVol / steps;
        const stepInterval = this.fadeDuration / steps;
        let step = 0;
        this._fadeTimer = setInterval(() => {
          step++;
          audio.volume = Math.max(0, parseFloat((currentVol - step * stepSize).toFixed(2)));
          if (step >= steps) {
            clearInterval(this._fadeTimer);
            audio.pause();
            this.isPlaying = false;
          }
        }, stepInterval);
      },
    };
  }
</script>
@endif

</body>
</html>

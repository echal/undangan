<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $event->title }}</title>
  <meta name="description" content="Undangan Pernikahan {{ $event->bride_name }} & {{ $event->groom_name }} — {{ $event->event_date->translatedFormat('d F Y') }}">
  @include('partials.og-meta-event')
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    :root {
      --rose:       #c9748f;
      --rose-light: #f7e8ed;
      --rose-pale:  #fdf0f3;
      --cream:      #fdf6f0;
      --cream-dark: #f5ede4;
      --gold:       #b8935a;
      --gold-light: #f9f0e3;
      --text:       #3d2b2b;
      --muted:      #8a6e6e;
      --border:     #e8d5d5;
    }

    body {
      font-family: 'Lato', sans-serif;
      background: var(--cream);
      color: var(--text);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ── ORNAMENT DIVIDER ── */
    .ornament {
      display: flex;
      align-items: center;
      gap: 12px;
      justify-content: center;
      margin: 24px 0;
      color: var(--gold);
      font-size: 18px;
      letter-spacing: 6px;
    }
    .ornament::before, .ornament::after {
      content: '';
      flex: 1;
      max-width: 80px;
      height: 1px;
      background: linear-gradient(to right, transparent, var(--gold));
    }
    .ornament::after { background: linear-gradient(to left, transparent, var(--gold)); }

    /* ── HERO ── */
    .hero {
      position: relative;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      overflow: hidden;
      background: var(--text);
    }
    .hero-bg {
      position: absolute;
      inset: 0;
      background-size: cover;
      background-position: center;
      opacity: 0.35;
    }
    .hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(61,43,43,0.4) 0%, rgba(61,43,43,0.7) 100%);
    }
    .hero-content {
      position: relative;
      z-index: 2;
      padding: 60px 24px;
      max-width: 520px;
    }
    .hero-tag {
      font-family: 'Lato', sans-serif;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 4px;
      text-transform: uppercase;
      color: rgba(255,255,255,0.7);
      margin-bottom: 28px;
    }
    .hero-names {
      font-family: 'Playfair Display', serif;
      font-size: clamp(3rem, 10vw, 5.5rem);
      font-weight: 400;
      color: #fff;
      line-height: 1.05;
    }
    .hero-and {
      font-family: 'Cormorant Garamond', serif;
      font-style: italic;
      font-size: clamp(1.8rem, 6vw, 3rem);
      color: #e8c8a0;
      display: block;
      margin: 8px 0;
    }
    .hero-date {
      margin-top: 28px;
      font-size: 13px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: rgba(255,255,255,0.75);
    }
    .scroll-hint {
      position: absolute;
      bottom: 32px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 2;
      animation: bounce 2s infinite;
    }
    @keyframes bounce {
      0%, 100% { transform: translateX(-50%) translateY(0); }
      50%       { transform: translateX(-50%) translateY(8px); }
    }

    /* ── SECTION COMMON ── */
    section { padding: 72px 24px; }
    .section-inner { max-width: 700px; margin: 0 auto; }
    .section-label {
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 4px;
      text-transform: uppercase;
      color: var(--rose);
      display: block;
      margin-bottom: 10px;
      text-align: center;
    }
    .section-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.6rem, 5vw, 2.4rem);
      font-weight: 400;
      text-align: center;
      color: var(--text);
      line-height: 1.3;
      margin-bottom: 8px;
    }
    .section-subtitle {
      font-family: 'Cormorant Garamond', serif;
      font-style: italic;
      font-size: 1.1rem;
      color: var(--muted);
      text-align: center;
    }

    /* ── COUNTDOWN ── */
    .countdown-section { background: var(--rose-pale); }
    .countdown-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
      max-width: 400px;
      margin: 32px auto 0;
    }
    .countdown-box {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 16px 8px;
      text-align: center;
    }
    .countdown-num {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      font-weight: 700;
      color: var(--rose);
      line-height: 1;
    }
    .countdown-label {
      font-size: 10px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--muted);
      margin-top: 6px;
    }
    .countdown-passed {
      font-family: 'Cormorant Garamond', serif;
      font-style: italic;
      font-size: 1.2rem;
      color: var(--muted);
      text-align: center;
      margin-top: 20px;
    }

    /* ── AKAD & RESEPSI ── */
    .ceremony-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 16px;
      margin-top: 32px;
    }
    @media (min-width: 540px) {
      .ceremony-grid { grid-template-columns: 1fr 1fr; }
    }
    .ceremony-card {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 28px 24px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .ceremony-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--rose), var(--gold));
    }
    .ceremony-icon { font-size: 2rem; margin-bottom: 12px; }
    .ceremony-type {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--rose);
      margin-bottom: 8px;
    }
    .ceremony-date {
      font-family: 'Playfair Display', serif;
      font-size: 1.2rem;
      color: var(--text);
      margin-bottom: 6px;
    }
    .ceremony-time {
      font-size: 1rem;
      font-weight: 600;
      color: var(--gold);
      margin-bottom: 12px;
    }
    .ceremony-location {
      font-size: 0.85rem;
      color: var(--muted);
      line-height: 1.5;
    }

    /* ── PARENTS ── */
    .parents-section { background: var(--gold-light); }
    .parents-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 16px;
      margin-top: 24px;
    }
    @media (min-width: 540px) { .parents-grid { grid-template-columns: 1fr 1fr; } }
    .parents-card {
      background: #fff;
      border: 1px solid #e8d9c0;
      border-radius: 12px;
      padding: 20px;
      text-align: center;
    }
    .parents-label {
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 8px;
    }
    .parents-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.1rem;
      color: var(--text);
      line-height: 1.5;
    }

    /* ── HERO FADE-IN ── */
    @keyframes heroFadeIn {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .hero-content { animation: heroFadeIn 1.2s ease both; }

    /* ── GALLERY ── */
    .gallery-section { background: var(--cream-dark); }
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 8px;
      margin-top: 28px;
    }
    @media (min-width: 480px) { .gallery-grid { grid-template-columns: repeat(3, 1fr); } }
    .gallery-item {
      aspect-ratio: 1;
      overflow: hidden;
      border-radius: 10px;
      cursor: pointer;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease, box-shadow 0.4s ease;
    }
    .gallery-item:hover img {
      transform: scale(1.06);
      box-shadow: 0 8px 24px rgba(0,0,0,0.18);
    }

    /* ── LIGHTBOX ── */
    .lightbox-overlay {
      position: fixed;
      inset: 0;
      z-index: 9999;
      background: rgba(0,0,0,0.92);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .lightbox-img {
      max-width: 100%;
      max-height: 90vh;
      border-radius: 8px;
      object-fit: contain;
      box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }
    .lightbox-close {
      position: fixed;
      top: 18px; right: 20px;
      width: 40px; height: 40px;
      background: rgba(255,255,255,0.12);
      border: none;
      border-radius: 50%;
      color: #fff;
      font-size: 20px;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.2s;
      z-index: 10000;
    }
    .lightbox-close:hover { background: rgba(255,255,255,0.25); }
    .lightbox-nav {
      position: fixed;
      top: 50%; transform: translateY(-50%);
      width: 44px; height: 44px;
      background: rgba(255,255,255,0.12);
      border: none;
      border-radius: 50%;
      color: #fff;
      font-size: 20px;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.2s;
      z-index: 10000;
    }
    .lightbox-nav:hover { background: rgba(255,255,255,0.25); }
    .lightbox-nav.prev { left: 16px; }
    .lightbox-nav.next { right: 16px; }
    .lightbox-counter {
      position: fixed;
      bottom: 20px; left: 50%; transform: translateX(-50%);
      color: rgba(255,255,255,0.6);
      font-size: 13px;
      z-index: 10000;
    }

    /* ── MAPS ── */
    .maps-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 12px 28px;
      background: var(--rose);
      color: #fff;
      border-radius: 50px;
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
      letter-spacing: 0.5px;
      margin-top: 24px;
      transition: background 0.2s;
    }
    .maps-btn:hover { background: #b5617a; }

    /* ── RSVP ── */
    .rsvp-section { background: var(--rose-pale); }
    .rsvp-form {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 32px 28px;
      margin-top: 32px;
    }
    .form-group { margin-bottom: 18px; }
    .form-label {
      display: block;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 6px;
    }
    .form-input {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid var(--border);
      border-radius: 10px;
      font-size: 14px;
      font-family: 'Lato', sans-serif;
      color: var(--text);
      background: #fafafa;
      transition: border-color 0.2s;
      outline: none;
    }
    .form-input:focus { border-color: var(--rose); background: #fff; }
    .rsvp-radio-group {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }
    .rsvp-radio-label {
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      border: 1px solid var(--border);
      border-radius: 50px;
      cursor: pointer;
      font-size: 13px;
      transition: all 0.2s;
    }
    .rsvp-radio-label:has(input:checked) {
      border-color: var(--rose);
      background: var(--rose-light);
      color: var(--rose);
    }
    .rsvp-radio-label input { display: none; }
    .btn-primary {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, var(--rose), var(--gold));
      color: #fff;
      border: none;
      border-radius: 10px;
      font-size: 15px;
      font-weight: 600;
      font-family: 'Lato', sans-serif;
      cursor: pointer;
      letter-spacing: 0.5px;
      transition: opacity 0.2s;
    }
    .btn-primary:hover { opacity: 0.9; }
    .alert-success {
      padding: 14px 18px;
      background: #ecfdf5;
      border: 1px solid #a7f3d0;
      border-radius: 10px;
      color: #065f46;
      font-size: 14px;
      margin-bottom: 20px;
    }

    /* ── WISHES ── */
    .wishes-section { background: #fff; }
    .wish-cards {
      display: flex;
      flex-direction: column;
      gap: 14px;
      margin-top: 28px;
    }
    .wish-card {
      background: var(--cream);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 18px 20px;
      position: relative;
    }
    .wish-card::before {
      content: '"';
      position: absolute;
      top: 8px; left: 14px;
      font-family: 'Playfair Display', serif;
      font-size: 3rem;
      color: var(--rose-light);
      line-height: 1;
    }
    .wish-name {
      font-weight: 700;
      font-size: 14px;
      color: var(--rose);
      margin-bottom: 4px;
    }
    .wish-message {
      font-size: 14px;
      color: var(--muted);
      line-height: 1.6;
      padding-left: 4px;
    }
    .wish-form {
      background: var(--rose-pale);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 24px 20px;
      margin-top: 24px;
    }

    /* ── FOOTER ── */
    .footer {
      background: var(--text);
      color: rgba(255,255,255,0.5);
      text-align: center;
      padding: 28px 24px;
      font-size: 12px;
      letter-spacing: 1px;
    }
    .footer strong { color: rgba(255,255,255,0.8); }
  </style>
</head>
<body>

@php
  $data       = $event->event_data ?? [];
  $eventDate  = $event->event_date;
  $brideName  = $event->bride_name ?? 'Mempelai Wanita';
  $groomName  = $event->groom_name ?? 'Mempelai Pria';

  $receptionDate = null;
  if (! empty($data['reception_date'])) {
      try { $receptionDate = \Carbon\Carbon::parse($data['reception_date']); } catch (\Throwable $e) {}
  }

  $brideParents = $data['bride_parents'] ?? null;
  $groomParents = $data['groom_parents'] ?? null;
@endphp

{{-- ══════════════════════════════════════
     HERO
══════════════════════════════════════ --}}
<section id="hero" class="hero">
  @if ($event->banner_image)
    <div class="hero-bg" style="background-image: url('{{ rtrim(config('app.url'), '/') }}/storage/{{ str_replace('\\', '/', $event->banner_image) }}')"></div>
  @endif
  <div class="hero-overlay"></div>

  <div class="hero-content">
    <p class="hero-tag">— Undangan Pernikahan —</p>
    <h1 class="hero-names">
      {{ $brideName }}
      <span class="hero-and">&amp;</span>
      {{ $groomName }}
    </h1>
    <p class="hero-date">{{ $eventDate->translatedFormat('l, d F Y') }}</p>
  </div>

  <div class="scroll-hint">
    <svg width="24" height="24" fill="none" stroke="rgba(255,255,255,0.6)" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
    </svg>
  </div>
</section>

{{-- ══════════════════════════════════════
     COUNTDOWN
══════════════════════════════════════ --}}
<section id="detail" class="countdown-section">
  <div class="section-inner">
    <span class="section-label">Save the Date</span>
    <h2 class="section-title">Menghitung Hari</h2>
    <p class="section-subtitle">Bahagianya kami menantikan kehadiran Anda</p>

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
        <p class="countdown-passed">Alhamdulillah, hari bahagia telah berlangsung ✨</p>
      </template>
    </div>
  </div>
</section>

{{-- ══════════════════════════════════════
     AKAD & RESEPSI
══════════════════════════════════════ --}}
<section id="location" class="detail-section">
  <div class="section-inner">
    <span class="section-label">Acara</span>
    <h2 class="section-title">Akad & Resepsi</h2>
    <div class="ornament">✦</div>

    <div class="ceremony-grid">

      {{-- Akad --}}
      <div class="ceremony-card">
        <div class="ceremony-icon">💍</div>
        <p class="ceremony-type">Akad Nikah</p>
        <p class="ceremony-date">{{ $eventDate->translatedFormat('l, d F Y') }}</p>
        <p class="ceremony-time">{{ $eventDate->format('H:i') }} WIB</p>
        <p class="ceremony-location">{{ $event->location }}</p>
      </div>

      {{-- Resepsi --}}
      @if ($receptionDate)
        <div class="ceremony-card">
          <div class="ceremony-icon">🎊</div>
          <p class="ceremony-type">Resepsi</p>
          <p class="ceremony-date">{{ $receptionDate->translatedFormat('l, d F Y') }}</p>
          <p class="ceremony-time">{{ $receptionDate->format('H:i') }} WIB</p>
          <p class="ceremony-location">{{ $event->location }}</p>
        </div>
      @endif

    </div>

    @if ($event->maps_link)
      <div style="text-align:center;">
        <a href="{{ $event->maps_link }}" target="_blank" rel="noopener" class="maps-btn">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
          Lihat di Google Maps
        </a>
      </div>
    @endif
  </div>
</section>

{{-- ══════════════════════════════════════
     ORANG TUA (conditional)
══════════════════════════════════════ --}}
@if ($brideParents || $groomParents)
<section class="parents-section">
  <div class="section-inner">
    <span class="section-label">Putra-Putri dari</span>
    <h2 class="section-title">Keluarga Kami</h2>
    <div class="ornament">✦</div>

    <div class="parents-grid">
      @if ($brideParents)
        <div class="parents-card">
          <p class="parents-label">Keluarga Mempelai Wanita</p>
          <p class="parents-name">{{ $brideParents }}</p>
        </div>
      @endif
      @if ($groomParents)
        <div class="parents-card">
          <p class="parents-label">Keluarga Mempelai Pria</p>
          <p class="parents-name">{{ $groomParents }}</p>
        </div>
      @endif
    </div>
  </div>
</section>
@endif

{{-- ══════════════════════════════════════
     GALERI (conditional) + LIGHTBOX
══════════════════════════════════════ --}}
@if (! empty($event->gallery_images))
@php $galleryUrls = array_map(fn($img) => rtrim(config('app.url'), '/') . '/storage/' . str_replace('\\', '/', $img), $event->gallery_images); @endphp
<section id="gallery" class="gallery-section"
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
    <div class="ornament">✦</div>

    <div class="gallery-grid">
      @foreach ($galleryUrls as $idx => $url)
        <div class="gallery-item" @click="show({{ $idx }})">
          <img src="{{ $url }}" alt="Galeri {{ $idx + 1 }}" loading="lazy">
        </div>
      @endforeach
    </div>
  </div>

  {{-- Lightbox modal --}}
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

    <img :src="images[current]"
         :alt="'Foto ' + (current + 1)"
         class="lightbox-img"
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
<section id="rsvp" class="rsvp-section">
  <div class="section-inner">
    <span class="section-label">Konfirmasi</span>
    <h2 class="section-title">RSVP Kehadiran</h2>
    <p class="section-subtitle">Mohon konfirmasi kehadiran Anda sebelum hari-H</p>

    @if (session('rsvp_success'))
      <div class="rsvp-form">
        <div class="alert-success">{{ session('rsvp_success') }}</div>
      </div>
    @else
      <form action="{{ route('invitation.rsvp', $event->slug) }}" method="POST" class="rsvp-form">
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
    <h2 class="section-title">Sampaikan Harapan</h2>
    <p class="section-subtitle">Setiap doa tulus adalah hadiah terindah bagi kami</p>

    @if (session('wish_success'))
      <div class="alert-success" style="margin-top:20px;">{{ session('wish_success') }}</div>
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
      <button type="submit" class="btn-primary">Kirim Ucapan 💌</button>
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
  <p>Dibuat dengan ❤ untuk <strong>{{ $brideName }} &amp; {{ $groomName }}</strong></p>
  <p style="margin-top:6px;">Undangan Digital · {{ $eventDate->format('Y') }}</p>
</footer>

{{-- ══════════════════════════════════════
     BOTTOM NAVIGATION + MUSIC
     Home | Detail | Galeri | Lokasi | Musik
══════════════════════════════════════ --}}
<x-bottom-nav :event="$event" theme="wedding" />

</body>
</html>

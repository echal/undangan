<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $event->title }}</title>
  <meta name="description" content="{{ $event->title }} — {{ $event->event_date->translatedFormat('d F Y') }}. {{ $event->location }}">
  @include('partials.og-meta-event')
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    :root {
      --blue:       #2563eb;
      --blue-light: #eff6ff;
      --blue-mid:   #3b82f6;
      --bg:         #f8fafc;
      --white:      #ffffff;
      --dark:       #0f172a;
      --muted:      #64748b;
      --border:     #e2e8f0;
      --green:      #16a34a;
      --amber:      #d97706;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--dark);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ── HEADER BAR ── */
    .header-bar {
      position: sticky;
      top: 0;
      z-index: 50;
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(8px);
      border-bottom: 1px solid var(--border);
      padding: 14px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .header-title {
      font-weight: 700;
      font-size: 15px;
      color: var(--dark);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 60%;
    }
    .header-badge {
      background: var(--blue-light);
      color: var(--blue);
      font-size: 11px;
      font-weight: 600;
      padding: 4px 12px;
      border-radius: 50px;
      white-space: nowrap;
    }

    /* ── HERO ── */
    @keyframes heroFadeIn {
      from { opacity: 0; transform: translateY(14px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .hero {
      background: linear-gradient(135deg, var(--dark) 0%, #1e3a5f 100%);
      padding: 80px 24px 70px;
      position: relative;
      overflow: hidden;
    }
    .hero-banner-bg {
      position: absolute; inset: 0;
      background-size: cover;
      background-position: center;
      opacity: 0.18;
    }
    .hero::before {
      content: '';
      position: absolute;
      top: -60px; right: -60px;
      width: 300px; height: 300px;
      border-radius: 50%;
      background: var(--blue);
      opacity: 0.08;
    }
    .hero::after {
      content: '';
      position: absolute;
      bottom: -80px; left: -40px;
      width: 200px; height: 200px;
      border-radius: 50%;
      background: var(--blue-mid);
      opacity: 0.06;
    }
    .hero-inner { max-width: 700px; margin: 0 auto; position: relative; z-index: 1; animation: heroFadeIn 0.9s ease both; }
    .hero-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(37,99,235,0.2);
      color: #93c5fd;
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 2px;
      text-transform: uppercase;
      padding: 6px 14px;
      border-radius: 50px;
      margin-bottom: 24px;
    }
    .hero-title {
      font-size: clamp(2rem, 6vw, 3.5rem);
      font-weight: 800;
      color: #fff;
      line-height: 1.15;
      margin-bottom: 16px;
    }
    .hero-desc {
      font-size: 1rem;
      color: rgba(255,255,255,0.65);
      line-height: 1.7;
      max-width: 520px;
      margin-bottom: 32px;
    }
    .hero-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .hero-meta-item {
      display: flex;
      align-items: center;
      gap: 8px;
      color: rgba(255,255,255,0.8);
      font-size: 14px;
    }
    .hero-meta-icon {
      width: 32px; height: 32px;
      background: rgba(255,255,255,0.1);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 15px;
    }

    /* ── FEATURES ROW ── */
    .features-row {
      background: var(--white);
      border-bottom: 1px solid var(--border);
      padding: 20px 24px;
    }
    .features-inner {
      max-width: 800px;
      margin: 0 auto;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      align-items: center;
    }
    .feature-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 14px;
      border-radius: 50px;
      font-size: 13px;
      font-weight: 600;
    }
    .feature-badge.green { background: #dcfce7; color: #15803d; }
    .feature-badge.amber { background: #fef3c7; color: #92400e; }
    .livestream-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 18px;
      background: var(--blue);
      color: #fff;
      border-radius: 50px;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      transition: background 0.2s;
    }
    .livestream-btn:hover { background: #1d4ed8; }

    /* ── SECTION COMMON ── */
    section { padding: 64px 24px; }
    .section-inner { max-width: 800px; margin: 0 auto; }
    .section-header { margin-bottom: 36px; }
    .section-label {
      display: block;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--blue);
      margin-bottom: 8px;
    }
    .section-title {
      font-size: clamp(1.5rem, 4vw, 2rem);
      font-weight: 700;
      color: var(--dark);
      line-height: 1.3;
    }
    .section-divider {
      width: 48px;
      height: 3px;
      background: var(--blue);
      border-radius: 2px;
      margin-top: 12px;
    }

    /* ── SPEAKERS ── */
    .speakers-section { background: var(--white); }
    .speakers-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }
    .speaker-card {
      border: 1px solid var(--border);
      border-radius: 16px;
      overflow: hidden;
      background: var(--bg);
      transition: box-shadow 0.2s;
    }
    .speaker-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
    .speaker-photo-wrap {
      aspect-ratio: 3/4;
      overflow: hidden;
      background: linear-gradient(135deg, #dbeafe, #eff6ff);
      position: relative;
    }
    .speaker-photo-wrap img {
      width: 100%; height: 100%;
      object-fit: cover;
    }
    .speaker-photo-placeholder {
      width: 100%; height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 4rem;
      color: #bfdbfe;
    }
    .speaker-body { padding: 16px; }
    .speaker-role-badge {
      display: inline-block;
      background: var(--blue-light);
      color: var(--blue);
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      padding: 3px 10px;
      border-radius: 50px;
      margin-bottom: 8px;
    }
    .speaker-name {
      font-weight: 700;
      font-size: 15px;
      color: var(--dark);
      margin-bottom: 4px;
      line-height: 1.3;
    }
    .speaker-title-text {
      font-size: 13px;
      color: var(--muted);
      line-height: 1.4;
    }

    /* ── INFO CARDS ── */
    .info-section { background: var(--bg); }
    .info-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 14px;
    }
    @media (min-width: 560px) { .info-grid { grid-template-columns: 1fr 1fr; } }
    .info-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 20px;
      display: flex;
      align-items: flex-start;
      gap: 14px;
    }
    .info-icon {
      width: 40px; height: 40px;
      min-width: 40px;
      background: var(--blue-light);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }
    .info-label {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 4px;
    }
    .info-value {
      font-size: 14px;
      font-weight: 600;
      color: var(--dark);
      line-height: 1.5;
    }
    .info-value a {
      color: var(--blue);
      text-decoration: none;
      font-weight: 600;
    }
    .info-value a:hover { text-decoration: underline; }

    /* ── GALLERY ── */
    .gallery-section { background: var(--white); }
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 8px;
      margin-top: 20px;
    }
    @media (min-width: 480px) { .gallery-grid { grid-template-columns: repeat(3, 1fr); } }
    .gallery-item {
      aspect-ratio: 1;
      border-radius: 10px;
      overflow: hidden;
      cursor: pointer;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
      transition: box-shadow 0.3s;
    }
    .gallery-item:hover { box-shadow: 0 6px 20px rgba(37,99,235,0.15); }
    .gallery-item img {
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform 0.35s ease;
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
    .rsvp-section { background: var(--blue-light); }
    .rsvp-box {
      background: var(--white);
      border: 1px solid #bfdbfe;
      border-radius: 20px;
      padding: 32px 28px;
    }
    .form-group { margin-bottom: 18px; }
    .form-label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 0.5px;
      color: var(--muted);
      margin-bottom: 6px;
    }
    .form-input {
      width: 100%;
      padding: 11px 14px;
      border: 1px solid var(--border);
      border-radius: 10px;
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      color: var(--dark);
      background: var(--bg);
      outline: none;
      transition: border-color 0.2s;
    }
    .form-input:focus { border-color: var(--blue); background: #fff; }
    .rsvp-radio-group { display: flex; gap: 8px; flex-wrap: wrap; }
    .rsvp-radio-label {
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 8px 14px;
      border: 1px solid var(--border);
      border-radius: 50px;
      cursor: pointer;
      font-size: 13px;
      transition: all 0.2s;
    }
    .rsvp-radio-label:has(input:checked) {
      border-color: var(--blue);
      background: var(--blue-light);
      color: var(--blue);
      font-weight: 600;
    }
    .rsvp-radio-label input { display: none; }
    .btn-primary {
      width: 100%;
      padding: 13px;
      background: var(--blue);
      color: #fff;
      border: none;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 600;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      transition: background 0.2s;
    }
    .btn-primary:hover { background: #1d4ed8; }
    .alert-success {
      padding: 12px 16px;
      background: #dcfce7;
      border: 1px solid #86efac;
      border-radius: 10px;
      color: #166534;
      font-size: 13px;
      margin-bottom: 18px;
    }

    /* ── PARTICIPANTS ── */
    .participants-section { background: var(--bg); }
    .participants-list {
      display: grid;
      grid-template-columns: 1fr;
      gap: 10px;
      margin-top: 20px;
    }
    @media (min-width: 480px) { .participants-list { grid-template-columns: 1fr 1fr; } }
    .participant-item {
      display: flex;
      align-items: center;
      gap: 12px;
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 12px 16px;
    }
    .participant-avatar {
      width: 40px; height: 40px;
      min-width: 40px;
      background: var(--blue);
      color: #fff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 15px;
    }
    .participant-name {
      font-weight: 600;
      font-size: 14px;
      color: var(--dark);
    }
    .participant-phone {
      font-size: 12px;
      color: var(--muted);
    }

    /* ── WISHES ── */
    .wishes-section { background: var(--white); }
    .wish-form {
      background: var(--bg);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 24px 20px;
      margin-top: 24px;
    }
    .wish-cards {
      display: flex;
      flex-direction: column;
      gap: 12px;
      margin-top: 24px;
    }
    .wish-card {
      background: var(--bg);
      border: 1px solid var(--border);
      border-left: 3px solid var(--blue);
      border-radius: 12px;
      padding: 16px 18px;
    }
    .wish-name {
      font-weight: 700;
      font-size: 13px;
      color: var(--blue);
      margin-bottom: 5px;
    }
    .wish-message {
      font-size: 14px;
      color: var(--muted);
      line-height: 1.6;
    }

    /* ── FOOTER ── */
    .footer {
      background: var(--dark);
      color: rgba(255,255,255,0.45);
      text-align: center;
      padding: 28px 24px;
      font-size: 12px;
    }
    .footer strong { color: rgba(255,255,255,0.75); }
  </style>
</head>
<body>

@php
  $data      = $event->event_data ?? [];
  $eventDate = $event->event_date;

  $endDate = null;
  if (! empty($data['end_date'])) {
      try { $endDate = \Carbon\Carbon::parse($data['end_date']); } catch (\Throwable $e) {}
  }

  $description    = $data['description']     ?? null;
  $sertifikat     = ($data['sertifikat']     ?? '0') === '1';
  $biayaSukarela  = ($data['biaya_sukarela'] ?? '0') === '1';
  $livestreamLink = $data['livestream_link'] ?? null;
  $pesertaPublik  = ($data['peserta_publik'] ?? '0') === '1';

  // Speaker data
  $sp1Name  = $data['speaker1_name']  ?? null;
  $sp1Title = $data['speaker1_title'] ?? null;
  $sp1Role  = $data['speaker1_role']  ?? 'Pemateri';
  $sp1Photo = $data['speaker1_photo'] ?? null;
  $sp2Name  = $data['speaker2_name']  ?? null;
  $sp2Title = $data['speaker2_title'] ?? null;
  $sp2Role  = $data['speaker2_role']  ?? 'Pemateri';
  $sp2Photo = $data['speaker2_photo'] ?? null;
  $mcName   = $data['mc_name']        ?? null;
  $mcTitle  = $data['mc_title']       ?? null;
  $mcPhoto  = $data['mc_photo']       ?? null;

  $hasSpeaker1 = (bool) $sp1Name;
  $hasSpeaker2 = (bool) $sp2Name;
  $hasMc       = (bool) $mcName;
  $hasSpeakers = $hasSpeaker1 || $hasSpeaker2 || $hasMc;

  function speakerUrlModern(string $path): string {
      return rtrim(config('app.url'), '/') . '/storage/' . ltrim(str_replace('\\', '/', $path), '/');
  }
@endphp

{{-- ══════════════════════════════════════
     HEADER BAR
══════════════════════════════════════ --}}
<header class="header-bar">
  <span class="header-title">{{ $event->title }}</span>
  <span class="header-badge">🎓 Workshop</span>
</header>

{{-- ══════════════════════════════════════
     HERO
══════════════════════════════════════ --}}
<div id="hero" class="hero">
  @if ($event->banner_image)
    <div class="hero-banner-bg" style="background-image: url('{{ rtrim(config('app.url'), '/') }}/storage/{{ str_replace('\\', '/', $event->banner_image) }}')"></div>
  @endif
  <div class="hero-inner">
    <div class="hero-eyebrow">🎓 Workshop &amp; Seminar</div>
    <h1 class="hero-title">{{ $event->title }}</h1>

    @if ($description)
      <p class="hero-desc">{{ $description }}</p>
    @endif

    <div class="hero-meta">
      <div class="hero-meta-item">
        <div class="hero-meta-icon">📅</div>
        <div>
          <div style="font-size:11px;color:rgba(255,255,255,0.5);margin-bottom:2px;">Tanggal</div>
          {{ $eventDate->translatedFormat('d F Y') }}
        </div>
      </div>
      <div class="hero-meta-item">
        <div class="hero-meta-icon">⏰</div>
        <div>
          <div style="font-size:11px;color:rgba(255,255,255,0.5);margin-bottom:2px;">Pukul</div>
          {{ $eventDate->format('H:i') }} WIB
        </div>
      </div>
      <div class="hero-meta-item">
        <div class="hero-meta-icon">📍</div>
        <div>
          <div style="font-size:11px;color:rgba(255,255,255,0.5);margin-bottom:2px;">Lokasi</div>
          {{ $event->location }}
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════
     FEATURES ROW (conditional badges)
══════════════════════════════════════ --}}
@if ($sertifikat || $biayaSukarela || $livestreamLink)
<div class="features-row">
  <div class="features-inner">
    @if ($sertifikat)
      <span class="feature-badge green">✓ Bersertifikat</span>
    @endif
    @if ($biayaSukarela)
      <span class="feature-badge amber">💛 Biaya Sukarela</span>
    @endif
    @if ($livestreamLink)
      <a href="{{ $livestreamLink }}" target="_blank" rel="noopener" class="livestream-btn">
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
          <path d="M21 3L3 10.53v.98l6.84 2.65L12.48 21h.98L21 3z"/>
        </svg>
        Tonton Live Stream
      </a>
    @endif
  </div>
</div>
@endif

{{-- ══════════════════════════════════════
     SPEAKERS (conditional)
══════════════════════════════════════ --}}
@if ($hasSpeakers)
<section id="detail" class="speakers-section">
  <div class="section-inner">
    <div class="section-header">
      <span class="section-label">Narasumber</span>
      <h2 class="section-title">Tim Pemateri &amp; MC</h2>
      <div class="section-divider"></div>
    </div>

    <div class="speakers-grid">

      {{-- Pemateri 1 --}}
      @if ($hasSpeaker1)
        <div class="speaker-card">
          <div class="speaker-photo-wrap">
            @if ($sp1Photo)
              <img src="{{ speakerUrlModern($sp1Photo) }}" alt="{{ $sp1Name }}" loading="lazy">
            @else
              <div class="speaker-photo-placeholder">👤</div>
            @endif
          </div>
          <div class="speaker-body">
            <span class="speaker-role-badge">{{ $sp1Role }}</span>
            <p class="speaker-name">{{ $sp1Name }}</p>
            @if ($sp1Title)
              <p class="speaker-title-text">{{ $sp1Title }}</p>
            @endif
          </div>
        </div>
      @endif

      {{-- Pemateri 2 --}}
      @if ($hasSpeaker2)
        <div class="speaker-card">
          <div class="speaker-photo-wrap">
            @if ($sp2Photo)
              <img src="{{ speakerUrlModern($sp2Photo) }}" alt="{{ $sp2Name }}" loading="lazy">
            @else
              <div class="speaker-photo-placeholder">👤</div>
            @endif
          </div>
          <div class="speaker-body">
            <span class="speaker-role-badge">{{ $sp2Role }}</span>
            <p class="speaker-name">{{ $sp2Name }}</p>
            @if ($sp2Title)
              <p class="speaker-title-text">{{ $sp2Title }}</p>
            @endif
          </div>
        </div>
      @endif

      {{-- MC --}}
      @if ($hasMc)
        <div class="speaker-card">
          <div class="speaker-photo-wrap">
            @if ($mcPhoto)
              <img src="{{ speakerUrlModern($mcPhoto) }}" alt="{{ $mcName }}" loading="lazy">
            @else
              <div class="speaker-photo-placeholder">🎙️</div>
            @endif
          </div>
          <div class="speaker-body">
            <span class="speaker-role-badge" style="background:#fef3c7;color:#92400e;">MC</span>
            <p class="speaker-name">{{ $mcName }}</p>
            @if ($mcTitle)
              <p class="speaker-title-text">{{ $mcTitle }}</p>
            @endif
          </div>
        </div>
      @endif

    </div>
  </div>
</section>
@endif

{{-- ══════════════════════════════════════
     INFO CARDS
══════════════════════════════════════ --}}
<section id="location" class="info-section">
  <div class="section-inner">
    <div class="section-header">
      <span class="section-label">Informasi</span>
      <h2 class="section-title">Detail Acara</h2>
      <div class="section-divider"></div>
    </div>

    <div class="info-grid">
      <div class="info-card">
        <div class="info-icon">📅</div>
        <div>
          <p class="info-label">{{ $endDate ? 'Tanggal Mulai' : 'Tanggal & Waktu' }}</p>
          <p class="info-value">{{ $eventDate->translatedFormat('l, d F Y') }}</p>
          <p class="info-value" style="font-weight:400;font-size:13px;color:var(--muted);">Pukul {{ $eventDate->format('H:i') }} WIB</p>
        </div>
      </div>

      @if ($endDate)
        <div class="info-card">
          <div class="info-icon">🏁</div>
          <div>
            <p class="info-label">Tanggal Selesai</p>
            <p class="info-value">{{ $endDate->translatedFormat('l, d F Y') }}</p>
            <p class="info-value" style="font-weight:400;font-size:13px;color:var(--muted);">Pukul {{ $endDate->format('H:i') }} WIB</p>
          </div>
        </div>
      @endif

      <div class="info-card">
        <div class="info-icon">📍</div>
        <div>
          <p class="info-label">Lokasi</p>
          <p class="info-value">{{ $event->location }}</p>
          @if ($event->maps_link)
            <p class="info-value" style="margin-top:4px;">
              <a href="{{ $event->maps_link }}" target="_blank" rel="noopener">Lihat di Maps →</a>
            </p>
          @endif
        </div>
      </div>

      @if ($sertifikat)
        <div class="info-card">
          <div class="info-icon">🏅</div>
          <div>
            <p class="info-label">Sertifikat</p>
            <p class="info-value">Peserta mendapat sertifikat keikutsertaan</p>
          </div>
        </div>
      @endif

      @if ($biayaSukarela)
        <div class="info-card">
          <div class="info-icon">💛</div>
          <div>
            <p class="info-label">Biaya</p>
            <p class="info-value">Terdapat biaya sukarela setelah kegiatan</p>
          </div>
        </div>
      @endif
    </div>
  </div>
</section>

{{-- ══════════════════════════════════════
     GALLERY (conditional) + LIGHTBOX
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
    <div class="section-header">
      <span class="section-label">Dokumentasi</span>
      <h2 class="section-title">Galeri Foto</h2>
      <div class="section-divider"></div>
    </div>
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
<section id="rsvp" class="rsvp-section">
  <div class="section-inner">
    <div class="section-header">
      <span class="section-label">Pendaftaran</span>
      <h2 class="section-title">Daftar Hadir</h2>
      <div class="section-divider"></div>
    </div>

    @if (session('rsvp_success'))
      <div class="rsvp-box">
        <div class="alert-success">{{ session('rsvp_success') }}</div>
      </div>
    @else
      <form action="{{ route('invitation.rsvp', $event->slug) }}" method="POST" class="rsvp-box">
        @csrf
        <div class="form-group">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="name" class="form-input" placeholder="Nama Anda" required>
        </div>
        <div class="form-group">
          <label class="form-label">Nomor WhatsApp</label>
          <input type="text" name="phone" class="form-input" placeholder="08xxxxxxxxxx (opsional)">
        </div>
        <div class="form-group">
          <label class="form-label">Kehadiran</label>
          <div class="rsvp-radio-group">
            <label class="rsvp-radio-label"><input type="radio" name="rsvp_status" value="hadir" required> ✅ Hadir</label>
            <label class="rsvp-radio-label"><input type="radio" name="rsvp_status" value="tidak_hadir"> ❌ Tidak Hadir</label>
            <label class="rsvp-radio-label"><input type="radio" name="rsvp_status" value="pending"> ⏳ Belum Pasti</label>
          </div>
        </div>
        <button type="submit" class="btn-primary">Konfirmasi Kehadiran</button>
      </form>
    @endif
  </div>
</section>
@endif

{{-- ══════════════════════════════════════
     DAFTAR PESERTA (conditional)
══════════════════════════════════════ --}}
@if ($pesertaPublik)
  @php $attendees = $event->guests->where('rsvp_status', 'hadir'); @endphp
  @if ($attendees->count() > 0)
    <section class="participants-section">
      <div class="section-inner">
        <div class="section-header">
          <span class="section-label">Peserta Terdaftar</span>
          <h2 class="section-title">{{ $attendees->count() }} Peserta Hadir</h2>
          <div class="section-divider"></div>
        </div>

        <div class="participants-list">
          @foreach ($attendees as $guest)
            <div class="participant-item">
              <div class="participant-avatar">
                {{ mb_strtoupper(mb_substr($guest->name, 0, 1)) }}
              </div>
              <div>
                <p class="participant-name">{{ $guest->name }}</p>
                @if ($guest->phone)
                  <p class="participant-phone">
                    {{ substr($guest->phone, 0, 4) }}****{{ substr($guest->phone, -3) }}
                  </p>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif
@endif

{{-- ══════════════════════════════════════
     UCAPAN
══════════════════════════════════════ --}}
<section class="wishes-section">
  <div class="section-inner">
    <div class="section-header">
      <span class="section-label">Interaksi</span>
      <h2 class="section-title">Kesan & Pesan</h2>
      <div class="section-divider"></div>
    </div>

    @if (session('wish_success'))
      <div class="alert-success">{{ session('wish_success') }}</div>
    @endif

    <form action="{{ route('invitation.wish', $event->slug) }}" method="POST" class="wish-form">
      @csrf
      <div class="form-group">
        <label class="form-label">Nama Anda</label>
        <input type="text" name="guest_name" class="form-input" placeholder="Nama Anda" required>
      </div>
      <div class="form-group">
        <label class="form-label">Pesan / Kesan</label>
        <textarea name="message" rows="3" class="form-input" placeholder="Bagikan kesan atau pertanyaan..." required style="resize:vertical;"></textarea>
      </div>
      <button type="submit" class="btn-primary">Kirim Pesan</button>
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
  <p><strong>{{ $event->title }}</strong></p>
  <p style="margin-top:4px;">{{ $eventDate->translatedFormat('d F Y') }} · {{ $event->location }}</p>
  <p style="margin-top:8px;">Dibuat dengan Undangan Digital</p>
</footer>

{{-- ══════════════════════════════════════
     BOTTOM NAVIGATION + MUSIC
     Home | Detail | Galeri | Lokasi | Musik
══════════════════════════════════════ --}}
<x-bottom-nav :event="$event" theme="workshop" />

</body>
</html>

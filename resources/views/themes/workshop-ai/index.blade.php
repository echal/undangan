<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $event->title }} — Workshop Digital AI</title>
  <meta name="description" content="{{ $event->title }} — {{ $event->event_date->translatedFormat('d F Y') }}. {{ $event->location }}" />
  @include('partials.og-meta-event')
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    :root {
      --navy:         #0a0e1a;
      --navy-card:    #0f1526;
      --navy-card2:   #121929;
      --blue:         #00b4ff;
      --cyan:         #00e5ff;
      --blue-dim:     rgba(0, 180, 255, 0.10);
      --blue-border:  rgba(0, 180, 255, 0.18);
      --text:         #e2e8f0;
      --muted:        #7a8ba8;
      --white:        #ffffff;
    }

    body {
      font-family: 'Space Grotesk', sans-serif;
      background: var(--navy);
      color: var(--text);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ─── GRID BACKGROUND OVERLAY ──────────────────── */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(0,180,255,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0,180,255,0.025) 1px, transparent 1px);
      background-size: 40px 40px;
      pointer-events: none;
      z-index: 0;
    }

    /* ─── HERO ─────────────────────────────────────── */
    .hero {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 5rem 1.5rem 6rem;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }

    /* Radial glow behind title */
    .hero::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -55%);
      width: 700px;
      height: 450px;
      background: radial-gradient(ellipse at center, rgba(0,180,255,0.10) 0%, transparent 70%);
      pointer-events: none;
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: var(--blue-dim);
      border: 1px solid var(--blue-border);
      border-radius: 999px;
      padding: 0.45rem 1.1rem;
      font-size: 0.68rem;
      font-weight: 600;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--blue);
      margin-bottom: 2.25rem;
    }
    .hero-badge::before { content: '◈'; font-size: 0.8rem; }

    .hero-title {
      font-size: clamp(2.2rem, 7vw, 4.5rem);
      font-weight: 700;
      line-height: 1.1;
      color: var(--white);
      margin-bottom: 1.5rem;
      animation: pulse-glow 3s ease-in-out infinite;
    }
    @keyframes pulse-glow {
      0%, 100% { text-shadow: 0 0 20px rgba(0,180,255,0.3), 0 0 60px rgba(0,229,255,0.08); }
      50%       { text-shadow: 0 0 40px rgba(0,180,255,0.55), 0 0 90px rgba(0,229,255,0.2); }
    }

    .hero-speaker {
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--blue);
      margin-bottom: 0.25rem;
    }
    .hero-speaker-title {
      font-size: 0.85rem;
      color: var(--muted);
      font-weight: 400;
    }

    .hero-divider {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin: 2rem auto;
      width: fit-content;
    }
    .hero-divider-line {
      width: 80px;
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--blue), transparent);
    }
    .hero-divider-dot {
      width: 6px;
      height: 6px;
      background: var(--cyan);
      border-radius: 50%;
      box-shadow: 0 0 8px var(--cyan);
    }

    .hero-date {
      font-size: 0.88rem;
      color: var(--muted);
      letter-spacing: 0.06em;
    }

    .scroll-indicator {
      position: absolute;
      bottom: 2.5rem;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.3rem;
      color: rgba(0,180,255,0.4);
      font-size: 0.65rem;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      animation: bounce 2.5s ease-in-out infinite;
    }
    .scroll-indicator svg { width: 16px; height: 16px; }
    @keyframes bounce {
      0%, 100% { transform: translateX(-50%) translateY(0); opacity: 0.5; }
      50%       { transform: translateX(-50%) translateY(8px); opacity: 1; }
    }

    /* ─── CONTENT / SECTIONS ────────────────────────── */
    .content { position: relative; z-index: 1; }

    .section {
      max-width: 720px;
      margin: 0 auto;
      padding: 0 1.5rem 3rem;
    }

    .card {
      background: var(--navy-card);
      border: 1px solid var(--blue-border);
      border-radius: 20px;
      padding: 2.25rem 2rem;
      position: relative;
      overflow: hidden;
    }
    /* Blue top-edge accent */
    .card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--blue), var(--cyan), var(--blue));
    }

    .section-label {
      font-size: 0.62rem;
      letter-spacing: 0.3em;
      text-transform: uppercase;
      color: var(--blue);
      font-weight: 600;
      margin-bottom: 0.4rem;
    }

    .section-title {
      font-size: 1.45rem;
      font-weight: 700;
      color: var(--white);
      margin-bottom: 1.5rem;
      line-height: 1.25;
    }

    /* ─── INFO ROWS ─────────────────────────────────── */
    .info-row {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      padding: 0.9rem 0;
      border-bottom: 1px solid rgba(255,255,255,0.04);
    }
    .info-row:last-child { border-bottom: none; }
    .info-icon {
      width: 40px;
      height: 40px;
      background: var(--blue-dim);
      border: 1px solid var(--blue-border);
      border-radius: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      flex-shrink: 0;
    }
    .info-label { font-size: 0.68rem; color: var(--muted); margin-bottom: 0.2rem; letter-spacing: 0.04em; text-transform: uppercase; }
    .info-value { font-size: 0.93rem; color: var(--text); font-weight: 600; line-height: 1.5; }
    .info-sub   { font-size: 0.8rem; color: var(--muted); margin-top: 0.1rem; }
    .info-link {
      color: var(--blue);
      text-decoration: none;
      font-size: 0.82rem;
      font-weight: 600;
      margin-top: 0.3rem;
      display: inline-block;
      transition: color 0.2s;
    }
    .info-link:hover { color: var(--cyan); }

    /* ─── BADGES ────────────────────────────────────── */
    .badge-row {
      display: flex;
      flex-wrap: wrap;
      gap: 0.65rem;
      margin-bottom: 1.25rem;
    }
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      border-radius: 999px;
      padding: 0.4rem 0.9rem;
      font-size: 0.78rem;
      font-weight: 600;
    }
    .badge-sertifikat {
      background: rgba(0,229,255,0.09);
      border: 1px solid rgba(0,229,255,0.28);
      color: var(--cyan);
    }

    /* ─── LIVESTREAM BUTTON ─────────────────────────── */
    .livestream-wrap { margin-top: 1.5rem; }
    .livestream-label { font-size: 0.68rem; color: var(--muted); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.65rem; }
    .btn-livestream {
      display: inline-flex;
      align-items: center;
      gap: 0.6rem;
      padding: 0.85rem 1.75rem;
      background: linear-gradient(135deg, var(--blue), var(--cyan));
      color: var(--navy);
      font-family: 'Space Grotesk', sans-serif;
      font-size: 0.88rem;
      font-weight: 700;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      text-decoration: none;
      transition: transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 6px 22px rgba(0,180,255,0.28);
      letter-spacing: 0.03em;
    }
    .btn-livestream:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(0,180,255,0.48);
    }

    /* ─── BIAYA SUKARELA NOTICE ─────────────────────── */
    .notice-sukarela {
      display: flex;
      gap: 0.85rem;
      align-items: flex-start;
      background: rgba(0,180,255,0.06);
      border: 1px solid rgba(0,180,255,0.18);
      border-left: 3px solid var(--blue);
      border-radius: 12px;
      padding: 1rem 1.2rem;
      font-size: 0.88rem;
      color: #93c5fd;
      line-height: 1.7;
      margin-top: 1.25rem;
    }
    .notice-icon { font-size: 1.1rem; flex-shrink: 0; margin-top: 0.1rem; }

    /* ─── DESCRIPTION ───────────────────────────────── */
    .desc-box {
      background: rgba(255,255,255,0.025);
      border: 1px solid rgba(255,255,255,0.06);
      border-radius: 12px;
      padding: 1.25rem 1.5rem;
      font-size: 0.9rem;
      color: var(--muted);
      line-height: 1.9;
      white-space: pre-line;
    }

    /* ─── GALLERY ────────────────────────────────────── */
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      gap: 0.75rem;
      margin-top: 0.5rem;
    }
    .gallery-grid img {
      width: 100%;
      height: 140px;
      object-fit: cover;
      border-radius: 10px;
      border: 1px solid var(--blue-border);
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .gallery-grid img:hover {
      transform: scale(1.03);
      box-shadow: 0 4px 20px rgba(0,180,255,0.22);
    }

    /* ─── FORMS ──────────────────────────────────────── */
    .form-group { margin-bottom: 1.2rem; }
    .form-label {
      display: block;
      font-size: 0.75rem;
      color: var(--muted);
      margin-bottom: 0.4rem;
      font-weight: 600;
      letter-spacing: 0.05em;
      text-transform: uppercase;
    }
    .form-input, .form-select, .form-textarea {
      width: 100%;
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 10px;
      padding: 0.75rem 1rem;
      font-size: 0.9rem;
      font-family: 'Space Grotesk', sans-serif;
      color: var(--text);
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
      outline: none;
      border-color: var(--blue);
      box-shadow: 0 0 0 3px rgba(0,180,255,0.12);
    }
    .form-input::placeholder, .form-textarea::placeholder { color: rgba(122,139,168,0.5); }
    .form-select option { background: #0f1526; color: var(--text); }

    .btn-primary {
      display: block;
      width: 100%;
      padding: 0.9rem;
      background: linear-gradient(135deg, var(--blue), var(--cyan));
      color: var(--navy);
      border: none;
      border-radius: 10px;
      font-size: 0.9rem;
      font-weight: 700;
      letter-spacing: 0.04em;
      cursor: pointer;
      font-family: 'Space Grotesk', sans-serif;
      transition: transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 6px 22px rgba(0,180,255,0.28);
    }
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(0,180,255,0.45);
    }

    /* ─── FLASH MESSAGES ─────────────────────────────── */
    .flash {
      padding: 0.9rem 1rem;
      border-radius: 10px;
      margin-bottom: 1.5rem;
      font-size: 0.85rem;
      font-weight: 500;
    }
    .flash-success {
      background: rgba(0,229,255,0.07);
      border: 1px solid rgba(0,229,255,0.22);
      color: var(--cyan);
    }

    /* ─── PARTICIPANT LIST ───────────────────────────── */
    .participant-count-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      background: var(--blue-dim);
      border: 1px solid var(--blue-border);
      border-radius: 999px;
      padding: 0.3rem 0.85rem;
      font-size: 0.78rem;
      font-weight: 600;
      color: var(--blue);
      margin-bottom: 1.25rem;
    }
    .participant-list { margin-top: 0.25rem; }
    .participant-item {
      display: flex;
      align-items: center;
      gap: 0.9rem;
      padding: 0.75rem 0;
      border-bottom: 1px solid rgba(255,255,255,0.04);
    }
    .participant-item:last-child { border-bottom: none; }
    .participant-avatar {
      width: 38px;
      height: 38px;
      background: linear-gradient(135deg, var(--blue), var(--cyan));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.88rem;
      font-weight: 700;
      color: var(--navy);
      flex-shrink: 0;
    }
    .participant-name { font-size: 0.9rem; font-weight: 600; color: var(--text); }
    .participant-phone { font-size: 0.75rem; color: var(--muted); margin-top: 0.1rem; }
    .empty-state {
      text-align: center;
      padding: 2rem 0;
      color: var(--muted);
      font-size: 0.85rem;
    }
    .empty-state-icon { font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.5; }

    /* ─── WISH CARDS ─────────────────────────────────── */
    .wishes-list { margin-top: 0.5rem; }
    .wish-card {
      background: rgba(255,255,255,0.025);
      border: 1px solid rgba(255,255,255,0.06);
      border-left: 3px solid var(--blue);
      border-radius: 12px;
      padding: 1.1rem 1.25rem;
      margin-bottom: 0.85rem;
    }
    .wish-name { font-weight: 700; font-size: 0.85rem; color: var(--blue); margin-bottom: 0.3rem; }
    .wish-msg  { font-size: 0.85rem; color: var(--muted); line-height: 1.75; }

    /* ─── FOOTER ─────────────────────────────────────── */
    footer {
      text-align: center;
      padding: 2.5rem 1rem;
      font-size: 0.72rem;
      color: rgba(122,139,168,0.55);
      border-top: 1px solid rgba(255,255,255,0.04);
      position: relative;
      z-index: 1;
      letter-spacing: 0.06em;
    }
    footer strong { color: var(--blue); }

    /* ─── SPEAKER CARDS ─────────────────────────────── */
    .speakers-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 1.25rem;
      margin-top: 0.25rem;
    }
    .speaker-card {
      background: rgba(255,255,255,0.03);
      border: 1px solid var(--blue-border);
      border-radius: 16px;
      overflow: hidden;
      text-align: center;
      transition: transform 0.2s, box-shadow 0.2s;
      position: relative;
    }
    .speaker-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 32px rgba(0,180,255,0.15);
    }
    .speaker-card-photo {
      width: 100%;
      aspect-ratio: 3 / 4;
      object-fit: cover;
      object-position: top;
      display: block;
      background: rgba(0,180,255,0.05);
    }
    .speaker-card-photo-placeholder {
      width: 100%;
      aspect-ratio: 3 / 4;
      background: linear-gradient(160deg, rgba(0,180,255,0.08), rgba(0,229,255,0.04));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3.5rem;
      color: rgba(0,180,255,0.3);
    }
    .speaker-card-body {
      padding: 1rem 0.85rem 1.1rem;
    }
    .speaker-card-role {
      display: inline-block;
      font-size: 0.62rem;
      font-weight: 700;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--blue);
      background: var(--blue-dim);
      border: 1px solid var(--blue-border);
      border-radius: 999px;
      padding: 0.2rem 0.65rem;
      margin-bottom: 0.6rem;
    }
    .speaker-card-name {
      font-size: 0.92rem;
      font-weight: 700;
      color: var(--white);
      line-height: 1.35;
      margin-bottom: 0.25rem;
    }
    .speaker-card-title {
      font-size: 0.78rem;
      color: var(--muted);
      line-height: 1.5;
    }

    /* ─── RESPONSIVE ─────────────────────────────────── */
    @media (max-width: 600px) {
      .card { padding: 1.5rem 1.25rem; }
      .hero-title { font-size: 2rem; }
      .gallery-grid { grid-template-columns: repeat(2, 1fr); }
      .speakers-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
    }
  </style>
</head>
<body>

@php
  $data = $event->event_data ?? [];
  // Helper: convert storage path to accessible URL (works on XAMPP subdirectory installs)
  function speakerUrl(string $path): string {
      return rtrim(config('app.url'), '/') . '/storage/' . ltrim($path, '/');
  }
@endphp

{{-- ── HERO ─────────────────────────────────────────────── --}}
<section class="hero">
  <div class="hero-badge">Workshop &amp; Training</div>

  <h1 class="hero-title">{{ $event->title }}</h1>

  @if ($event->bride_name)
    <p class="hero-speaker">{{ $event->bride_name }}</p>
    @if (!empty($data['speaker_title']))
      <p class="hero-speaker-title">{{ $data['speaker_title'] }}</p>
    @endif
  @endif

  <div class="hero-divider">
    <div class="hero-divider-line"></div>
    <div class="hero-divider-dot"></div>
    <div class="hero-divider-line"></div>
  </div>

  <p class="hero-date">{{ $event->event_date->translatedFormat('l, d F Y · H:i') }} WIB</p>

  <div class="scroll-indicator">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <path d="M12 5v14M5 12l7 7 7-7"/>
    </svg>
    Scroll
  </div>
</section>

{{-- ── CONTENT ──────────────────────────────────────────── --}}
<div class="content">

  {{-- INFO ACARA --}}
  <div class="section">
    <div class="card">
      <p class="section-label">Detail Acara</p>
      <h2 class="section-title">Informasi Workshop</h2>

      {{-- Badges --}}
      @if (!empty($data['sertifikat']) && $data['sertifikat'] == '1')
        <div class="badge-row">
          <span class="badge badge-sertifikat">&#10003; Bersertifikat</span>
        </div>
      @endif

      {{-- Info rows --}}
      <div>
        {{-- Tanggal Mulai --}}
        <div class="info-row">
          <div class="info-icon">&#128197;</div>
          <div>
            <p class="info-label">Mulai</p>
            <p class="info-value">{{ $event->event_date->translatedFormat('l, d F Y') }}</p>
            <p class="info-sub">Pukul {{ $event->event_date->format('H:i') }} WIB</p>
          </div>
        </div>

        {{-- Tanggal Selesai --}}
        @if (!empty($data['end_date']))
          <div class="info-row">
            <div class="info-icon">&#128198;</div>
            <div>
              <p class="info-label">Selesai</p>
              @php
                try {
                  $endDate = \Illuminate\Support\Carbon::parse($data['end_date']);
                  $isSameDay = $endDate->isSameDay($event->event_date);
                } catch (\Exception $e) {
                  $endDate = null;
                  $isSameDay = false;
                }
              @endphp
              @if ($endDate)
                @if (!$isSameDay)
                  <p class="info-value">{{ $endDate->translatedFormat('l, d F Y') }}</p>
                @endif
                <p class="{{ $isSameDay ? 'info-value' : 'info-sub' }}">Pukul {{ $endDate->format('H:i') }} WIB</p>
              @else
                <p class="info-value">{{ $data['end_date'] }}</p>
              @endif
            </div>
          </div>
        @endif

        {{-- Lokasi --}}
        <div class="info-row">
          <div class="info-icon">&#128205;</div>
          <div>
            <p class="info-label">Lokasi</p>
            <p class="info-value">{{ $event->location }}</p>
            @if ($event->maps_link)
              <a href="{{ $event->maps_link }}" target="_blank" rel="noopener" class="info-link">
                Lihat di Google Maps &rarr;
              </a>
            @endif
          </div>
        </div>
      </div>

      {{-- Livestream --}}
      @if (!empty($data['livestream_link']))
        <div class="livestream-wrap">
          <p class="livestream-label">Live Stream</p>
          <a href="{{ $data['livestream_link'] }}" target="_blank" rel="noopener" class="btn-livestream">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <path d="M8 5v14l11-7z"/>
            </svg>
            Join Live Stream
          </a>
        </div>
      @endif

      {{-- Biaya sukarela notice --}}
      @if (!empty($data['biaya_sukarela']) && $data['biaya_sukarela'] == '1')
        <div class="notice-sukarela">
          <span class="notice-icon">&#8505;</span>
          <span>Workshop ini memiliki <strong>biaya sukarela</strong> setelah kegiatan selesai. Tidak ada nominal yang ditentukan — sesuai kemampuan dan keikhlasan.</span>
        </div>
      @endif
    </div>
  </div>

  {{-- DESKRIPSI --}}
  @if (!empty($data['description']))
    <div class="section">
      <div class="card">
        <p class="section-label">Tentang Workshop</p>
        <h2 class="section-title">Deskripsi</h2>
        <div class="desc-box">{{ $data['description'] }}</div>
      </div>
    </div>
  @endif

  {{-- TIM PEMATERI & MC --}}
  @php
    $hasSpeaker1 = !empty($data['speaker1_name']) || !empty($data['speaker1_photo']);
    $hasSpeaker2 = !empty($data['speaker2_name']) || !empty($data['speaker2_photo']);
    $hasMc       = !empty($data['mc_name'])       || !empty($data['mc_photo']);
  @endphp
  @if ($hasSpeaker1 || $hasSpeaker2 || $hasMc)
    <div class="section">
      <div class="card">
        <p class="section-label">Tim Pemateri</p>
        <h2 class="section-title">Narasumber &amp; MC</h2>

        <div class="speakers-grid">

          {{-- Pemateri 1 --}}
          @if ($hasSpeaker1)
            <div class="speaker-card">
              @if (!empty($data['speaker1_photo']))
                <img src="{{ speakerUrl($data['speaker1_photo']) }}"
                     alt="{{ $data['speaker1_name'] ?? 'Pemateri' }}"
                     class="speaker-card-photo" loading="lazy" />
              @else
                <div class="speaker-card-photo-placeholder">&#128100;</div>
              @endif
              <div class="speaker-card-body">
                <span class="speaker-card-role">{{ $data['speaker1_role'] ?? 'Pakar' }}</span>
                @if (!empty($data['speaker1_name']))
                  <p class="speaker-card-name">{{ $data['speaker1_name'] }}</p>
                @endif
                @if (!empty($data['speaker1_title']))
                  <p class="speaker-card-title">{{ $data['speaker1_title'] }}</p>
                @endif
              </div>
            </div>
          @endif

          {{-- Pemateri 2 --}}
          @if ($hasSpeaker2)
            <div class="speaker-card">
              @if (!empty($data['speaker2_photo']))
                <img src="{{ speakerUrl($data['speaker2_photo']) }}"
                     alt="{{ $data['speaker2_name'] ?? 'Pemateri 2' }}"
                     class="speaker-card-photo" loading="lazy" />
              @else
                <div class="speaker-card-photo-placeholder">&#128100;</div>
              @endif
              <div class="speaker-card-body">
                <span class="speaker-card-role">{{ $data['speaker2_role'] ?? 'Pemateri' }}</span>
                @if (!empty($data['speaker2_name']))
                  <p class="speaker-card-name">{{ $data['speaker2_name'] }}</p>
                @endif
                @if (!empty($data['speaker2_title']))
                  <p class="speaker-card-title">{{ $data['speaker2_title'] }}</p>
                @endif
              </div>
            </div>
          @endif

          {{-- MC / Pembawa Acara --}}
          @if ($hasMc)
            <div class="speaker-card">
              @if (!empty($data['mc_photo']))
                <img src="{{ speakerUrl($data['mc_photo']) }}"
                     alt="{{ $data['mc_name'] ?? 'MC' }}"
                     class="speaker-card-photo" loading="lazy" />
              @else
                <div class="speaker-card-photo-placeholder">&#127908;</div>
              @endif
              <div class="speaker-card-body">
                <span class="speaker-card-role">Pembawa Acara</span>
                @if (!empty($data['mc_name']))
                  <p class="speaker-card-name">{{ $data['mc_name'] }}</p>
                @endif
                @if (!empty($data['mc_title']))
                  <p class="speaker-card-title">{{ $data['mc_title'] }}</p>
                @endif
              </div>
            </div>
          @endif

        </div>
      </div>
    </div>
  @endif

  {{-- GALERI --}}
  @if (!empty($event->gallery_images) && count($event->gallery_images) > 0)
    <div class="section">
      <div class="card">
        <p class="section-label">Galeri</p>
        <h2 class="section-title">Foto Kegiatan</h2>
        <div class="gallery-grid">
          @foreach ($event->gallery_images as $img)
            <img src="{{ speakerUrl($img) }}" alt="Galeri {{ $event->title }}" loading="lazy" />
          @endforeach
        </div>
      </div>
    </div>
  @endif

  {{-- RSVP --}}
  @if ($event->rsvp_enabled)
    <div class="section">
      <div class="card">
        <p class="section-label">Konfirmasi Kehadiran</p>
        <h2 class="section-title">Daftar Sekarang</h2>

        @if (session('rsvp_success'))
          <div class="flash flash-success">&#10003; {{ session('rsvp_success') }}</div>
        @endif
        @if ($errors->has('name') || $errors->has('rsvp_status'))
          <div class="flash" style="background:rgba(255,80,80,0.07);border:1px solid rgba(255,80,80,0.2);color:#fca5a5;margin-bottom:1.25rem;">
            @foreach ($errors->all() as $err) <span>{{ $err }}</span> @endforeach
          </div>
        @endif

        <form action="{{ route('invitation.rsvp', $event->slug) }}" method="POST">
          @csrf
          <div class="form-group">
            <label class="form-label">Nama Lengkap *</label>
            <input type="text" name="name" class="form-input" required
                   placeholder="Nama lengkap kamu" value="{{ old('name') }}" />
          </div>
          <div class="form-group">
            <label class="form-label">Nomor WhatsApp <span style="font-weight:300;letter-spacing:0;">(opsional)</span></label>
            <input type="text" name="phone" class="form-input"
                   placeholder="+62..." value="{{ old('phone') }}" />
          </div>
          <div class="form-group">
            <label class="form-label">Konfirmasi Kehadiran *</label>
            <select name="rsvp_status" class="form-select" required>
              <option value="hadir" {{ old('rsvp_status') == 'hadir' ? 'selected' : '' }}>&#10003; Hadir</option>
              <option value="tidak_hadir" {{ old('rsvp_status') == 'tidak_hadir' ? 'selected' : '' }}>&#10007; Tidak Hadir</option>
              <option value="pending" {{ old('rsvp_status') == 'pending' ? 'selected' : '' }}>? Belum Pasti</option>
            </select>
          </div>
          <button type="submit" class="btn-primary">Daftar Sekarang &rarr;</button>
        </form>
      </div>
    </div>
  @endif

  {{-- DAFTAR PESERTA --}}
  @if (!empty($data['peserta_publik']) && $data['peserta_publik'] == '1')
    @php $attendees = $event->guests->where('rsvp_status', 'hadir'); @endphp
    <div class="section">
      <div class="card">
        <p class="section-label">Peserta Terdaftar</p>
        <h2 class="section-title">Daftar Peserta</h2>

        <div class="participant-count-badge">
          &#128101; {{ $attendees->count() }} peserta hadir
        </div>

        @if ($attendees->count() > 0)
          <div class="participant-list">
            @foreach ($attendees as $guest)
              <div class="participant-item">
                <div class="participant-avatar">
                  {{ mb_strtoupper(mb_substr($guest->name, 0, 1)) }}
                </div>
                <div>
                  <p class="participant-name">{{ $guest->name }}</p>
                  @if ($guest->phone && strlen($guest->phone) > 6)
                    <p class="participant-phone">
                      {{ substr($guest->phone, 0, 4) }}****{{ substr($guest->phone, -3) }}
                    </p>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="empty-state">
            <div class="empty-state-icon">&#128101;</div>
            <p>Belum ada peserta yang terdaftar.</p>
            <p style="margin-top:0.25rem;font-size:0.78rem;">Jadilah yang pertama mendaftar!</p>
          </div>
        @endif
      </div>
    </div>
  @endif

  {{-- UCAPAN & PESAN --}}
  <div class="section">
    <div class="card">
      <p class="section-label">Pesan &amp; Ucapan</p>
      <h2 class="section-title">Tuliskan Pesanmu</h2>

      @if (session('wish_success'))
        <div class="flash flash-success">&#10003; {{ session('wish_success') }}</div>
      @endif

      <form action="{{ route('invitation.wish', $event->slug) }}" method="POST" style="margin-bottom:2rem;">
        @csrf
        <div class="form-group">
          <label class="form-label">Nama</label>
          <input type="text" name="guest_name" class="form-input" required
                 placeholder="Nama kamu" value="{{ old('guest_name') }}" />
        </div>
        <div class="form-group">
          <label class="form-label">Pesan / Pertanyaan</label>
          <textarea name="message" rows="3" class="form-textarea" required
                    placeholder="Tuliskan kesan, pertanyaan, atau ucapan semangat...">{{ old('message') }}</textarea>
        </div>
        <button type="submit" class="btn-primary">Kirim Pesan &rarr;</button>
      </form>

      <div class="wishes-list">
        @forelse ($event->wishes as $wish)
          <div class="wish-card">
            <p class="wish-name">{{ $wish->guest_name }}</p>
            <p class="wish-msg">{{ $wish->message }}</p>
          </div>
        @empty
          <div class="empty-state">
            <div class="empty-state-icon">&#128172;</div>
            <p>Belum ada pesan. Jadilah yang pertama!</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>

</div>{{-- end content --}}

<footer>
  Dibuat menggunakan <strong>UNDIGI</strong> &mdash; Digital Invitation Platform
</footer>

</body>
</html>

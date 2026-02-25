@extends('layouts.invitation')
@section('theme', 'corporate')

@push('fonts')
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
@endpush

@push('styles')
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    :root {
      --navy:         #1e3a5f;
      --navy-dark:    #0a1628;
      --navy-light:   #eff6ff;
      --blue:         #3b82f6;
      --amber:        #d97706;
      --amber-light:  #fef3c7;
      --bg:           #f1f5f9;
      --white:        #ffffff;
      --dark:         #0f172a;
      --muted:        #64748b;
      --border:       #e2e8f0;
      --green:        #16a34a;
    }

    body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--dark); min-height:100vh; overflow-x:hidden; }

    /* ── HEADER BAR ── */
    .header-bar {
      position:sticky; top:0; z-index:50;
      background:rgba(10,22,40,0.97); backdrop-filter:blur(8px);
      border-bottom:2px solid var(--amber);
      padding:12px 24px;
      display:flex; align-items:center; justify-content:space-between; gap:12px;
    }
    .header-logo { display:flex; align-items:center; gap:10px; min-width:0; }
    .header-logo-icon { width:34px; height:34px; min-width:34px; background:var(--amber); border-radius:7px; display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0; }
    .header-title { font-weight:700; font-size:14px; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .header-badge { background:rgba(217,119,6,0.15); color:var(--amber); font-size:11px; font-weight:700; padding:4px 12px; border-radius:50px; white-space:nowrap; border:1px solid rgba(217,119,6,0.35); flex-shrink:0; }

    /* ── HERO ── */
    @keyframes heroFadeIn { from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);} }
    .hero {
      background:linear-gradient(135deg, var(--navy-dark) 0%, var(--navy) 100%);
      padding:84px 24px 72px; position:relative; overflow:hidden;
    }
    .hero-banner-bg { position:absolute; inset:0; background-size:cover; background-position:center; opacity:0.14; }
    .hero::before { content:''; position:absolute; top:-80px; right:-80px; width:320px; height:320px; border-radius:50%; background:var(--amber); opacity:0.06; }
    .hero::after  { content:''; position:absolute; bottom:-60px; left:-50px; width:240px; height:240px; border-radius:50%; background:var(--blue); opacity:0.07; }
    /* Amber accent stripe */
    .hero-accent { position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(to right, var(--amber), transparent); }
    .hero-inner { max-width:700px; margin:0 auto; position:relative; z-index:1; animation:heroFadeIn 0.9s ease both; }
    .hero-eyebrow { display:inline-flex; align-items:center; gap:6px; background:rgba(217,119,6,0.18); color:#fcd34d; font-size:11px; font-weight:700; letter-spacing:2px; text-transform:uppercase; padding:6px 14px; border-radius:50px; margin-bottom:24px; border:1px solid rgba(217,119,6,0.3); }
    .hero-title { font-size:clamp(2rem,5.5vw,3.4rem); font-weight:800; color:#fff; line-height:1.15; margin-bottom:14px; }
    .hero-subtitle { font-size:.95rem; color:rgba(255,255,255,.6); line-height:1.7; max-width:520px; margin-bottom:32px; }
    .hero-meta { display:flex; flex-wrap:wrap; gap:18px; }
    .hero-meta-item { display:flex; align-items:center; gap:8px; color:rgba(255,255,255,.82); font-size:14px; }
    .hero-meta-icon { width:32px; height:32px; background:rgba(255,255,255,.10); border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:15px; }

    /* ── FEATURES ROW ── */
    .features-row { background:var(--navy-dark); border-bottom:1px solid rgba(255,255,255,0.08); padding:18px 24px; }
    .features-inner { max-width:800px; margin:0 auto; display:flex; flex-wrap:wrap; gap:10px; align-items:center; }
    .feature-badge { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:50px; font-size:13px; font-weight:600; }
    .feature-badge.green { background:rgba(22,163,74,0.15); color:#86efac; border:1px solid rgba(22,163,74,0.3); }
    .feature-badge.amber { background:rgba(217,119,6,0.15); color:#fcd34d; border:1px solid rgba(217,119,6,0.3); }
    .livestream-btn { display:inline-flex; align-items:center; gap:6px; padding:8px 18px; background:var(--amber); color:#fff; border-radius:50px; font-size:13px; font-weight:600; text-decoration:none; transition:background .2s; }
    .livestream-btn:hover { background:#b45309; }

    /* ── SECTION COMMON ── */
    section { padding:64px 24px; }
    .section-inner { max-width:800px; margin:0 auto; }
    .section-header { margin-bottom:36px; }
    .section-label { display:block; font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:var(--amber); margin-bottom:8px; }
    .section-title { font-size:clamp(1.4rem,4vw,2rem); font-weight:700; color:var(--dark); line-height:1.3; }
    .section-divider { width:48px; height:3px; background:linear-gradient(to right, var(--amber), var(--navy)); border-radius:2px; margin-top:12px; }

    /* ── SPEAKERS ── */
    .speakers-section { background:var(--white); }
    .speakers-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:20px; }
    .speaker-card { border:1px solid var(--border); border-radius:16px; overflow:hidden; background:var(--bg); transition:box-shadow .2s,transform .2s; }
    .speaker-card:hover { box-shadow:0 10px 28px rgba(30,58,95,0.12); transform:translateY(-2px); }
    .speaker-photo-wrap { aspect-ratio:3/4; overflow:hidden; background:linear-gradient(135deg,#dbeafe,#eff6ff); }
    .speaker-photo-wrap img { width:100%; height:100%; object-fit:cover; }
    .speaker-photo-placeholder { width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:4rem; color:#93c5fd; }
    .speaker-body { padding:16px; }
    .speaker-role-badge { display:inline-block; background:var(--navy-light); color:var(--navy); font-size:10px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; padding:3px 10px; border-radius:50px; margin-bottom:8px; }
    .speaker-name { font-weight:700; font-size:15px; color:var(--dark); margin-bottom:4px; line-height:1.3; }
    .speaker-title-text { font-size:13px; color:var(--muted); line-height:1.4; }

    /* ── INFO CARDS ── */
    .info-section { background:var(--bg); }
    .info-grid { display:grid; grid-template-columns:1fr; gap:14px; }
    @media (min-width:560px) { .info-grid { grid-template-columns:1fr 1fr; } }
    .info-card { background:var(--white); border:1px solid var(--border); border-top:3px solid var(--amber); border-radius:14px; padding:20px; display:flex; align-items:flex-start; gap:14px; transition:box-shadow .2s; }
    .info-card:hover { box-shadow:0 4px 16px rgba(0,0,0,.06); }
    .info-icon { width:40px; height:40px; min-width:40px; background:var(--amber-light); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; }
    .info-label { font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--muted); margin-bottom:4px; }
    .info-value { font-size:14px; font-weight:600; color:var(--dark); line-height:1.5; }
    .info-value a { color:var(--navy); text-decoration:none; font-weight:600; }
    .info-value a:hover { text-decoration:underline; color:var(--amber); }

    /* ── GALLERY ── */
    .gallery-section { background:var(--white); }
    .gallery-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:10px; margin-top:20px; }
    @media (min-width:480px) { .gallery-grid { grid-template-columns:repeat(3,1fr); } }
    .gallery-item { aspect-ratio:1; border-radius:12px; overflow:hidden; cursor:pointer; box-shadow:0 2px 8px rgba(0,0,0,.06); transition:box-shadow .3s,transform .3s; }
    .gallery-item:hover { box-shadow:0 8px 24px rgba(30,58,95,0.18); transform:scale(1.02); }
    .gallery-item img { width:100%; height:100%; object-fit:cover; transition:transform .35s ease; }
    .gallery-item:hover img { transform:scale(1.06); }

    /* ── LIGHTBOX ── */
    .lightbox-overlay { position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.93); display:flex; align-items:center; justify-content:center; padding:20px; }
    .lightbox-img { max-width:100%; max-height:90vh; border-radius:8px; object-fit:contain; box-shadow:0 20px 60px rgba(0,0,0,.5); }
    .lightbox-close,.lightbox-nav { position:fixed; background:rgba(255,255,255,0.12); border:none; border-radius:50%; color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background .2s; z-index:10000; }
    .lightbox-close { top:18px; right:20px; width:40px; height:40px; font-size:20px; }
    .lightbox-close:hover,.lightbox-nav:hover { background:rgba(255,255,255,.25); }
    .lightbox-nav { top:50%; transform:translateY(-50%); width:44px; height:44px; font-size:22px; }
    .lightbox-nav.prev { left:16px; }
    .lightbox-nav.next { right:16px; }
    .lightbox-counter { position:fixed; bottom:20px; left:50%; transform:translateX(-50%); color:rgba(255,255,255,.6); font-size:13px; z-index:10000; }

    /* ── RSVP ── */
    .rsvp-section { background:linear-gradient(135deg, var(--navy-dark) 0%, var(--navy) 100%); }
    .rsvp-box { background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.12); border-radius:20px; padding:32px 28px; }
    .form-group { margin-bottom:18px; }
    .form-label { display:block; font-size:12px; font-weight:600; letter-spacing:.5px; color:rgba(255,255,255,.6); margin-bottom:6px; }
    .form-input { width:100%; padding:11px 14px; border:1px solid rgba(255,255,255,.15); border-radius:10px; font-size:14px; font-family:'Inter',sans-serif; color:#fff; background:rgba(255,255,255,.08); outline:none; transition:border-color .2s; }
    .form-input:focus { border-color:var(--amber); background:rgba(255,255,255,.12); }
    .form-input::placeholder { color:rgba(255,255,255,.35); }
    .rsvp-radio-group { display:flex; gap:8px; flex-wrap:wrap; }
    .rsvp-radio-label { display:flex; align-items:center; gap:6px; padding:8px 14px; border:1px solid rgba(255,255,255,.15); border-radius:50px; cursor:pointer; font-size:13px; color:rgba(255,255,255,.7); transition:all .2s; }
    .rsvp-radio-label:has(input:checked) { border-color:var(--amber); background:rgba(217,119,6,.2); color:var(--amber); font-weight:600; }
    .rsvp-radio-label input { display:none; }
    .btn-primary { width:100%; padding:13px; background:var(--amber); color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; transition:background .2s; }
    .btn-primary:hover { background:#b45309; }
    /* rsvp section-header color override */
    .rsvp-section .section-label { color:var(--amber); }
    .rsvp-section .section-title { color:#fff; }
    .rsvp-section .section-divider { background:var(--amber); }
    .alert-success { padding:12px 16px; background:#dcfce7; border:1px solid #86efac; border-radius:10px; color:#166534; font-size:13px; margin-bottom:18px; }

    /* ── PARTICIPANTS ── */
    .participants-section { background:var(--bg); }
    .participants-list { display:grid; grid-template-columns:1fr; gap:10px; margin-top:20px; }
    @media (min-width:480px) { .participants-list { grid-template-columns:1fr 1fr; } }
    .participant-item { display:flex; align-items:center; gap:12px; background:var(--white); border:1px solid var(--border); border-radius:12px; padding:12px 16px; }
    .participant-avatar { width:40px; height:40px; min-width:40px; background:var(--navy); color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:15px; }
    .participant-name { font-weight:600; font-size:14px; color:var(--dark); }
    .participant-phone { font-size:12px; color:var(--muted); }

    /* ── WISHES ── */
    .wishes-section { background:var(--white); }
    .wish-form { background:var(--bg); border:1px solid var(--border); border-radius:16px; padding:24px 20px; margin-top:24px; }
    .wish-cards { display:flex; flex-direction:column; gap:12px; margin-top:24px; }
    .wish-card { background:var(--bg); border:1px solid var(--border); border-left:3px solid var(--amber); border-radius:12px; padding:16px 18px; }
    .wish-name { font-weight:700; font-size:13px; color:var(--navy); margin-bottom:5px; }
    .wish-message { font-size:14px; color:var(--muted); line-height:1.6; }

    /* ── FOOTER ── */
    .footer { background:var(--navy-dark); color:rgba(255,255,255,.45); text-align:center; padding:28px 24px; font-size:12px; border-top:2px solid var(--amber); }
    .footer strong { color:rgba(255,255,255,.8); }

    /* music-btn removed — handled by bottom-nav component */
</style>
@endpush

@section('content')
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

  $typeLabel = match($event->event_type) {
      'kegiatan_kantor' => 'Kegiatan Kantor',
      'rapat'           => 'Rapat Korporat',
      'pelatihan'       => 'Pelatihan',
      default           => 'Korporat',
  };
  $typeIcon = match($event->event_type) {
      'kegiatan_kantor' => '🏛️',
      'rapat'           => '👔',
      'pelatihan'       => '📋',
      default           => '👔',
  };

  function speakerUrlCorp(string $path): string {
      return rtrim(config('app.url'), '/') . '/storage/' . ltrim(str_replace('\\', '/', $path), '/');
  }
@endphp

<header class="header-bar">
  <div class="header-logo">
    <div class="header-logo-icon">{{ $typeIcon }}</div>
    <span class="header-title">{{ $event->title }}</span>
  </div>
  <span class="header-badge">{{ $typeIcon }} {{ $typeLabel }}</span>
</header>

<div class="hero" id="hero">
  @if ($event->banner_image)
    <div class="hero-banner-bg" style="background-image:url('{{ rtrim(config('app.url'),'/') }}/storage/{{ str_replace('\\','/',$event->banner_image) }}')"></div>
  @endif
  <div class="hero-accent"></div>
  <div class="hero-inner">
    <div class="hero-eyebrow">{{ $typeIcon }} {{ $typeLabel }}</div>
    <h1 class="hero-title">{{ $event->title }}</h1>
    @if ($description) <p class="hero-subtitle">{{ $description }}</p> @endif
    <div class="hero-meta">
      <div class="hero-meta-item">
        <div class="hero-meta-icon">📅</div>
        <div><div style="font-size:11px;color:rgba(255,255,255,.5);margin-bottom:2px;">Tanggal</div>{{ $eventDate->translatedFormat('d F Y') }}</div>
      </div>
      <div class="hero-meta-item">
        <div class="hero-meta-icon">⏰</div>
        <div><div style="font-size:11px;color:rgba(255,255,255,.5);margin-bottom:2px;">Pukul</div>{{ $eventDate->format('H:i') }} WIB</div>
      </div>
      <div class="hero-meta-item">
        <div class="hero-meta-icon">📍</div>
        <div><div style="font-size:11px;color:rgba(255,255,255,.5);margin-bottom:2px;">Lokasi</div>{{ $event->location }}</div>
      </div>
    </div>
  </div>
</div>

@if ($sertifikat || $biayaSukarela || $livestreamLink)
<div class="features-row">
  <div class="features-inner">
    @if ($sertifikat) <span class="feature-badge green">✓ Bersertifikat</span> @endif
    @if ($biayaSukarela) <span class="feature-badge amber">💛 Biaya Sukarela</span> @endif
    @if ($livestreamLink)
      <a href="{{ $livestreamLink }}" target="_blank" rel="noopener" class="livestream-btn">
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M21 3L3 10.53v.98l6.84 2.65L12.48 21h.98L21 3z"/></svg>
        Tonton Live Stream
      </a>
    @endif
  </div>
</div>
@endif

@if ($hasSpeakers)
<section class="speakers-section">
  <div class="section-inner">
    <div class="section-header">
      <span class="section-label">Narasumber</span>
      <h2 class="section-title">Tim Pemateri &amp; MC</h2>
      <div class="section-divider"></div>
    </div>
    <div class="speakers-grid">
      @if ($hasSpeaker1)
        <div class="speaker-card">
          <div class="speaker-photo-wrap">
            @if ($sp1Photo) <img src="{{ speakerUrlCorp($sp1Photo) }}" alt="{{ $sp1Name }}" loading="lazy">
            @else <div class="speaker-photo-placeholder">👤</div> @endif
          </div>
          <div class="speaker-body">
            <span class="speaker-role-badge">{{ $sp1Role }}</span>
            <p class="speaker-name">{{ $sp1Name }}</p>
            @if ($sp1Title) <p class="speaker-title-text">{{ $sp1Title }}</p> @endif
          </div>
        </div>
      @endif
      @if ($hasSpeaker2)
        <div class="speaker-card">
          <div class="speaker-photo-wrap">
            @if ($sp2Photo) <img src="{{ speakerUrlCorp($sp2Photo) }}" alt="{{ $sp2Name }}" loading="lazy">
            @else <div class="speaker-photo-placeholder">👤</div> @endif
          </div>
          <div class="speaker-body">
            <span class="speaker-role-badge">{{ $sp2Role }}</span>
            <p class="speaker-name">{{ $sp2Name }}</p>
            @if ($sp2Title) <p class="speaker-title-text">{{ $sp2Title }}</p> @endif
          </div>
        </div>
      @endif
      @if ($hasMc)
        <div class="speaker-card">
          <div class="speaker-photo-wrap">
            @if ($mcPhoto) <img src="{{ speakerUrlCorp($mcPhoto) }}" alt="{{ $mcName }}" loading="lazy">
            @else <div class="speaker-photo-placeholder">🎙️</div> @endif
          </div>
          <div class="speaker-body">
            <span class="speaker-role-badge" style="background:var(--amber-light);color:#92400e;">MC</span>
            <p class="speaker-name">{{ $mcName }}</p>
            @if ($mcTitle) <p class="speaker-title-text">{{ $mcTitle }}</p> @endif
          </div>
        </div>
      @endif
    </div>
  </div>
</section>
@endif

<section class="info-section" id="detail">
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
            <p class="info-label">Selesai</p>
            <p class="info-value">{{ $endDate->translatedFormat('l, d F Y') }}</p>
            <p class="info-value" style="font-weight:400;font-size:13px;color:var(--muted);">Pukul {{ $endDate->format('H:i') }} WIB</p>
          </div>
        </div>
      @endif
      @if ($sertifikat)
        <div class="info-card"><div class="info-icon">🏅</div><div><p class="info-label">Sertifikat</p><p class="info-value">Peserta mendapat sertifikat keikutsertaan</p></div></div>
      @endif
      @if ($biayaSukarela)
        <div class="info-card"><div class="info-icon">💛</div><div><p class="info-label">Biaya</p><p class="info-value">Terdapat biaya sukarela setelah kegiatan</p></div></div>
      @endif
    </div>
  </div>
</section>

{{-- SECTION LOKASI (dipisah untuk #location anchor) --}}
<section class="info-section" id="location">
  <div class="section-inner">
    <div class="section-header">
      <span class="section-label">Tempat</span>
      <h2 class="section-title">Lokasi Acara</h2>
      <div class="section-divider"></div>
    </div>
    <div class="info-grid">
      <div class="info-card">
        <div class="info-icon">📍</div>
        <div>
          <p class="info-label">Alamat</p>
          <p class="info-value">{{ $event->location }}</p>
          @if ($event->maps_link)
            <p class="info-value" style="margin-top:8px;">
              <a href="{{ $event->maps_link }}" target="_blank" rel="noopener"
                 style="display:inline-flex;align-items:center;gap:5px;background:var(--amber);color:#fff;padding:7px 14px;border-radius:8px;font-size:13px;text-decoration:none;font-weight:600;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                Buka di Google Maps
              </a>
            </p>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

@if (! empty($event->gallery_images))
@php $galleryUrls = array_map(fn($img) => rtrim(config('app.url'),'/').'/storage/'.str_replace('\\','/',$img), $event->gallery_images); @endphp
<section class="gallery-section" id="gallery"
  x-data="{ open:false,current:0,images:{{ json_encode(array_values($galleryUrls)) }},show(i){this.current=i;this.open=true;},prev(){this.current=(this.current-1+this.images.length)%this.images.length;},next(){this.current=(this.current+1)%this.images.length;} }"
  @keydown.escape.window="open=false" @keydown.arrow-left.window="open&&prev()" @keydown.arrow-right.window="open&&next()">
  <div class="section-inner">
    <div class="section-header">
      <span class="section-label">Dokumentasi</span>
      <h2 class="section-title">Galeri Foto</h2>
      <div class="section-divider"></div>
    </div>
    <div class="gallery-grid">
      @foreach ($galleryUrls as $idx => $url)
        <div class="gallery-item" @click="show({{ $idx }})"><img src="{{ $url }}" alt="Galeri {{ $idx+1 }}" loading="lazy"></div>
      @endforeach
    </div>
  </div>
  <div class="lightbox-overlay" x-show="open" style="display:none;"
       x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
       @click.self="open=false">
    <button class="lightbox-close" @click="open=false">&#10005;</button>
    <button class="lightbox-nav prev" @click.stop="prev()">&#8249;</button>
    <img :src="images[current]" :alt="'Foto '+(current+1)" class="lightbox-img"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
    <button class="lightbox-nav next" @click.stop="next()">&#8250;</button>
    <div class="lightbox-counter" x-text="(current+1)+' / '+images.length"></div>
  </div>
</section>
@endif

@if ($event->rsvp_enabled)
<section class="rsvp-section" id="rsvp">
  <div class="section-inner">
    <div class="section-header">
      <span class="section-label">Pendaftaran</span>
      <h2 class="section-title">Konfirmasi Kehadiran</h2>
      <div class="section-divider"></div>
    </div>
    @if (session('rsvp_success'))
      <div class="rsvp-box"><div class="alert-success">{{ session('rsvp_success') }}</div></div>
    @else
      <form action="{{ route('invitation.rsvp', $event->slug) }}" method="POST" class="rsvp-box">
        @csrf
        <div class="form-group"><label class="form-label">Nama Lengkap</label><input type="text" name="name" class="form-input" placeholder="Nama Anda" required></div>
        <div class="form-group"><label class="form-label">Nomor WhatsApp</label><input type="text" name="phone" class="form-input" placeholder="08xxxxxxxxxx (opsional)"></div>
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

@if ($pesertaPublik)
  @php $attendees = $event->guests->where('rsvp_status','hadir'); @endphp
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
              <div class="participant-avatar">{{ mb_strtoupper(mb_substr($guest->name,0,1)) }}</div>
              <div>
                <p class="participant-name">{{ $guest->name }}</p>
                @if ($guest->phone)<p class="participant-phone">{{ substr($guest->phone,0,4) }}****{{ substr($guest->phone,-3) }}</p>@endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif
@endif

<section class="wishes-section">
  <div class="section-inner">
    <div class="section-header">
      <span class="section-label">Interaksi</span>
      <h2 class="section-title">Kesan &amp; Pesan</h2>
      <div class="section-divider"></div>
    </div>
    @if (session('wish_success'))<div class="alert-success">{{ session('wish_success') }}</div>@endif
    <form action="{{ route('invitation.wish', $event->slug) }}" method="POST" class="wish-form">
      @csrf
      <div class="form-group"><label class="form-label">Nama Anda</label><input type="text" name="guest_name" class="form-input" placeholder="Nama Anda" required></div>
      <div class="form-group"><label class="form-label">Pesan / Kesan</label><textarea name="message" rows="3" class="form-input" placeholder="Bagikan kesan atau pertanyaan..." required style="resize:vertical;"></textarea></div>
      <button type="submit" class="btn-primary">Kirim Pesan</button>
    </form>
    @if ($event->wishes->count() > 0)
      <div class="wish-cards">
        @foreach ($event->wishes as $wish)
          <div class="wish-card"><p class="wish-name">{{ $wish->guest_name }}</p><p class="wish-message">{{ $wish->message }}</p></div>
        @endforeach
      </div>
    @endif
  </div>
</section>

@endsection

@section('footer')
<footer class="footer">
  <p><strong>{{ $event->title }}</strong></p>
  <p style="margin-top:4px;">{{ $event->event_date->translatedFormat('d F Y') }} · {{ $event->location }}</p>
  <p style="margin-top:8px;">Dibuat dengan Undangan Digital</p>
</footer>
@endsection

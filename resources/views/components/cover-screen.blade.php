@props(['event', 'theme' => 'government'])

@php
  $hasMusic  = !empty($event->background_music);
  $bannerUrl = $event->banner_image
    ? rtrim(config('app.url'),'/') . '/storage/' . str_replace('\\', '/', $event->banner_image)
    : null;

  $coverBg = $bannerUrl
    ? "url('{$bannerUrl}') center/cover no-repeat"
    : match($theme) {
        'corporate' => '#0a1628',
        'executive' => '#111827',
        default     => '#134e4a',
      };
@endphp

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,400&display=swap" rel="stylesheet" />

<style>
  /* ── COVER SCREEN ── */
  #cover-screen {
    position: fixed;
    inset: 0;
    z-index: 99999;
    background: {{ $coverBg }};
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    transition: opacity .8s ease;
  }

  .cover-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.55);
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
  }

  .cover-content {
    position: relative;
    z-index: 1;
    color: #fff;
    max-width: 400px;
    width: 90%;
    padding: 0 16px;
    padding-bottom: max(0px, env(safe-area-inset-bottom, 0px));
    animation: coverFadeUp 1.2s ease both;
  }

  .cover-small {
    letter-spacing: 2px;
    font-size: 13px;
    opacity: .8;
    text-transform: uppercase;
    margin: 0 0 10px;
  }

  .cover-title {
    font-size: clamp(20px, 5.5vw, 28px);
    font-weight: 600;
    line-height: 1.3;
    margin: 0 0 20px;
    text-shadow: 0 2px 10px rgba(0,0,0,.4);
  }

  .cover-to {
    margin: 20px 0 6px;
    font-size: 14px;
    opacity: .75;
  }

  .cover-name {
    font-size: clamp(22px, 6vw, 28px);
    font-family: 'Playfair Display', Georgia, serif;
    font-style: italic;
    font-weight: 400;
    margin: 0 0 14px;
    text-shadow: 0 1px 6px rgba(0,0,0,.3);
  }

  .cover-desc {
    font-size: 13px;
    opacity: .8;
    line-height: 1.7;
    margin: 0 auto 30px;
    max-width: 300px;
  }

  .cover-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #c8b28a;
    border: none;
    padding: 14px 28px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
    transition: transform .3s ease, box-shadow .3s ease;
    -webkit-tap-highlight-color: transparent;
    outline: none;
    font-family: -apple-system, BlinkMacSystemFont, 'Inter', sans-serif;
  }
  .cover-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,.3);
  }
  .cover-button:active { transform: scale(.97); }
  .cover-button svg {
    width: 18px; height: 18px; flex-shrink: 0;
    animation: cover-env-bounce 2s ease-in-out infinite;
  }
  .cover-button:hover svg { animation: none; }

  @keyframes coverFadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes cover-env-bounce {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-3px); }
  }

  /* ── BODY SCROLL LOCK ── */
  body.lock-scroll { overflow: hidden; }

  /* ── BOTTOM NAV: hidden by default, shown after cover closes ── */
  #bottom-nav {
    opacity: 0;
    pointer-events: none;
    transition: opacity .4s ease;
  }
  #bottom-nav.nav-visible {
    opacity: 1;
    pointer-events: auto;
  }
  /* Override media query agar bottom nav tetap bisa muncul di mobile */
  @media (max-width: 767px) {
    #bottom-nav.nav-visible { display: flex !important; }
  }
</style>

{{-- COVER SCREEN — position:fixed, tidak menutupi DOM konten --}}
<div id="cover-screen">
  <div class="cover-overlay"></div>

  <div class="cover-content">
    <p class="cover-small">WE INVITED YOU TO</p>
    <h1 class="cover-title">{{ $event->title }}</h1>

    <p class="cover-to">Kepada</p>
    <h2 class="cover-name" id="cover-guest-name">Bapak/Ibu</h2>

    <p class="cover-desc">
      Tanpa Mengurangi Rasa Hormat,
      Kami Mengundang Bapak/Ibu/Saudara/i
      untuk Hadir di Acara Kami.
    </p>

    <button id="open-invitation" class="cover-button">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
      </svg>
      Buka Undangan
    </button>
  </div>
</div>
{{-- KONTEN UTAMA DIMULAI DI BAWAH INI (tidak dibungkus, tidak disembunyikan) --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

  var cover  = document.getElementById('cover-screen');
  var btn    = document.getElementById('open-invitation');
  var nav    = document.getElementById('bottom-nav');
  var audio  = document.getElementById('bn-audio');

  if (!cover || !btn) return;

  // Nama tamu dari ?to=NamaTamu
  var params    = new URLSearchParams(window.location.search);
  var guestName = params.get('to');
  if (guestName) {
    var nameEl = document.getElementById('cover-guest-name');
    if (nameEl) nameEl.textContent = decodeURIComponent(guestName);
  }

  // Lock scroll saat cover tampil
  document.body.classList.add('lock-scroll');

  btn.addEventListener('click', function () {

    // 1. Buka scroll
    document.body.classList.remove('lock-scroll');

    // 2. Fade out cover — pakai opacity+pointerEvents, BUKAN display:none
    cover.style.opacity = '0';
    cover.style.pointerEvents = 'none';

    // 3. Hapus dari DOM setelah animasi selesai
    setTimeout(function () {
      if (cover && cover.parentNode) cover.remove();
    }, 850);

    // 4. Tampilkan bottom nav
    if (nav) {
      setTimeout(function () {
        nav.classList.add('nav-visible');
      }, 350);
    }

    // 5. Play musik dengan safe fade in
    if (audio) {
      try {
        audio.volume = 0;
        audio.play().catch(function () {});

        var fade = setInterval(function () {
          if (audio.volume < 1) {
            audio.volume = Math.min(1, parseFloat((audio.volume + 0.1).toFixed(2)));
          } else {
            clearInterval(fade);
          }
        }, 50);

        // Sinkronisasi state Alpine.js bottomNav
        if (nav && nav._x_dataStack && nav._x_dataStack[0]) {
          nav._x_dataStack[0].musicPlaying = true;
        }
      } catch (e) {}
    }

  });

});
</script>

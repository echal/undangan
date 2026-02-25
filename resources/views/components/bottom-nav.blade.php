@props(['event', 'theme' => 'government'])

@php
  $hasGallery = !empty($event->gallery_images);

  // Musik: prioritaskan relasi music_id (library terpusat), fallback ke background_music lama
  $hasMusic  = false;
  $musicUrl  = null;
  if ($event->music_id && $event->music) {
      $hasMusic = true;
      $musicUrl = $event->music->url;
  } elseif ($event->background_music) {
      // Backward compat: undangan lama yang masih pakai path langsung
      $hasMusic = true;
      $musicUrl = rtrim(config('app.url'), '/') . '/storage/' . str_replace('\\', '/', $event->background_music);
  }

  $isExec     = $theme === 'executive';
  $themeSlug  = $theme === 'corporate' ? 'corp' : ($theme === 'executive' ? 'exec' : 'govt');
@endphp

<style>
  #bottom-nav {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 2px;
    background: {{ $isExec ? 'rgba(31,41,55,0.96)' : 'rgba(255,255,255,0.93)' }};
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-radius: 999px;
    padding: 8px 10px;
    box-shadow: 0 8px 32px rgba(0,0,0,{{ $isExec ? '0.55' : '0.13' }}), 0 2px 8px rgba(0,0,0,0.07){{ $isExec ? '' : ', inset 0 1px 0 rgba(255,255,255,0.9)' }};
    border: 1px solid {{ $isExec ? 'rgba(212,175,55,0.25)' : 'rgba(255,255,255,0.7)' }};
  }
  @media (min-width: 768px) {
    #bottom-nav { display: none !important; }
  }
  .bn-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    border: none;
    background: transparent;
    padding: 6px 11px;
    border-radius: 999px;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.34,1.56,0.64,1);
    min-width: 46px;
    -webkit-tap-highlight-color: transparent;
    outline: none;
    position: relative;
  }
  .bn-btn:active { transform: scale(0.9) !important; }
  .bn-btn svg {
    width: 22px;
    height: 22px;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }
  .bn-label {
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 0.4px;
    text-transform: uppercase;
    line-height: 1;
    transition: color 0.2s ease;
    font-family: -apple-system, BlinkMacSystemFont, 'Inter', sans-serif;
  }
  .bn-inactive {
    color: {{ $isExec ? '#6b7280' : '#9ca3af' }};
  }
  .bn-active-govt { color: #0f766e; transform: scale(1.12); }
  .bn-active-corp { color: #d97706; transform: scale(1.12); }
  .bn-active-exec { color: #d4af37; transform: scale(1.12); }

  /* Music pulse animation */
  @keyframes bn-pulse {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.55; }
  }
  .bn-music-playing { animation: bn-pulse 1.5s ease-in-out infinite; }

  /* Divider between nav and music */
  .bn-divider {
    width: 1px;
    height: 28px;
    background: {{ $isExec ? 'rgba(212,175,55,0.18)' : 'rgba(0,0,0,0.08)' }};
    margin: 0 2px;
    flex-shrink: 0;
  }

  /* Safe area + footer clearance */
  body {
    padding-bottom: calc(90px + env(safe-area-inset-bottom, 0px)) !important;
  }
</style>

<nav id="bottom-nav" x-data="bottomNav()" x-init="initNav()">

  {{-- HOME --}}
  <button
    onclick="bnScrollTo('hero')"
    :class="active==='hero' ? 'bn-active-{{ $themeSlug }}' : 'bn-inactive'"
    class="bn-btn"
    title="Home"
    aria-label="Ke atas"
  >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
    </svg>
    <span class="bn-label">Home</span>
  </button>

  {{-- DETAIL --}}
  <button
    onclick="bnScrollTo('detail')"
    :class="active==='detail' ? 'bn-active-{{ $themeSlug }}' : 'bn-inactive'"
    class="bn-btn"
    title="Detail Acara"
    aria-label="Detail acara"
  >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
    </svg>
    <span class="bn-label">Detail</span>
  </button>

  {{-- GALERI (conditional) --}}
  @if($hasGallery)
  <button
    onclick="bnScrollTo('gallery')"
    :class="active==='gallery' ? 'bn-active-{{ $themeSlug }}' : 'bn-inactive'"
    class="bn-btn"
    title="Galeri Foto"
    aria-label="Galeri foto"
  >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
    </svg>
    <span class="bn-label">Galeri</span>
  </button>
  @endif

  {{-- LOKASI — sekarang scroll ke #location --}}
  <button
    onclick="bnScrollTo('location')"
    :class="active==='location' ? 'bn-active-{{ $themeSlug }}' : 'bn-inactive'"
    class="bn-btn"
    title="Lokasi"
    aria-label="Lokasi acara"
  >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
    </svg>
    <span class="bn-label">Lokasi</span>
  </button>

  {{-- MUSIK (conditional) --}}
  @if($hasMusic)
  <div class="bn-divider"></div>
  <button
    @click="toggleMusic()"
    :class="musicPlaying
      ? 'bn-active-{{ $themeSlug }} bn-music-playing'
      : 'bn-inactive'"
    class="bn-btn"
    title="Musik"
    aria-label="Toggle musik"
  >
    {{-- Note icon (saat tidak playing) --}}
    <svg x-show="!musicPlaying" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a1.803 1.803 0 1 1-.99-3.467l2.31-.66a2.25 2.25 0 0 0 1.632-2.163Zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a1.803 1.803 0 0 1-.99-3.467l2.31-.66A2.25 2.25 0 0 0 9 15.553Z" />
    </svg>
    {{-- Pause icon (saat playing) --}}
    <svg x-show="musicPlaying" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
    </svg>
    <span class="bn-label" x-text="musicPlaying ? 'Pause' : 'Musik'">Musik</span>
  </button>
  @endif

</nav>

@if($hasMusic)
<audio id="bn-audio" loop preload="none">
  <source src="{{ $musicUrl }}" type="audio/mpeg">
</audio>
@endif

<script>
function bottomNav() {
  return {
    active: 'hero',
    musicPlaying: false,
    _fadeTimer: null,
    _observer: null,

    initNav() {
      const self = this;

      // Observe semua section yang relevan
      const ids = ['hero', 'detail', 'gallery', 'location', 'rsvp'];
      self._observer = new IntersectionObserver((entries) => {
        // Ambil entry yang paling banyak visible
        let best = null;
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            if (!best || entry.intersectionRatio > best.intersectionRatio) {
              best = entry;
            }
          }
        });
        if (best) self.active = best.target.id;
      }, {
        threshold: 0.5,
        rootMargin: '0px 0px -20% 0px'
      });

      ids.forEach(id => {
        const el = document.getElementById(id);
        if (el) self._observer.observe(el);
      });
    },

    destroy() {
      if (this._observer) {
        this._observer.disconnect();
        this._observer = null;
      }
      if (this._fadeTimer) {
        clearInterval(this._fadeTimer);
        this._fadeTimer = null;
      }
    },

    toggleMusic() {
      const audio = document.getElementById('bn-audio');
      if (!audio) return;

      // Clear pending fade sebelum toggle
      if (this._fadeTimer) {
        clearInterval(this._fadeTimer);
        this._fadeTimer = null;
      }

      if (this.musicPlaying) {
        this._fadeOut(audio);
      } else {
        this._fadeIn(audio);
      }
    },

    _fadeIn(audio) {
      // Guard: sudah siap?
      if (audio.readyState === 0) audio.load();

      audio.volume = 0;
      audio.play().then(() => {
        this.musicPlaying = true;
        this._fadeTimer = setInterval(() => {
          if (audio.volume < 0.9) {
            audio.volume = Math.min(1, parseFloat((audio.volume + 0.1).toFixed(2)));
          } else {
            audio.volume = 1;
            clearInterval(this._fadeTimer);
            this._fadeTimer = null;
          }
        }, 50);
      }).catch(() => {
        this.musicPlaying = false;
      });
    },

    _fadeOut(audio) {
      this._fadeTimer = setInterval(() => {
        if (audio.volume > 0.1) {
          audio.volume = Math.max(0, parseFloat((audio.volume - 0.1).toFixed(2)));
        } else {
          audio.volume = 0;
          audio.pause();
          clearInterval(this._fadeTimer);
          this._fadeTimer = null;
          this.musicPlaying = false;
        }
      }, 50);
    }
  }
}

function bnScrollTo(id) {
  const el = document.getElementById(id);
  if (el) {
    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
}
</script>

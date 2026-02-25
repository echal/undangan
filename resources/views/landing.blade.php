<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>UNDIGI — Platform Undangan Digital Modern</title>
  <meta name="description" content="Buat undangan digital elegan untuk pernikahan, workshop, & acara kantor. Modern, mudah, siap bagikan dalam hitungan menit." />
  <link rel="icon" href="{{ config('app.url') }}/images/logo/undigi-logo.png" type="image/png" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans:  ['Inter', 'system-ui', 'sans-serif'],
            serif: ['Playfair Display', 'Georgia', 'serif'],
          },
        }
      }
    }
  </script>
  <style>
    :root {
      --rose:   #f43f5e;
      --violet: #8b5cf6;
      --indigo: #6366f1;
    }

    html { scroll-behavior: smooth; }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: #f8fafc; }
    ::-webkit-scrollbar-thumb { background: #e11d48; border-radius: 3px; }

    /* ── NOISE TEXTURE overlay ── */
    .noise::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 0;
    }

    /* ── Gradient text ── */
    .text-gradient {
      background: linear-gradient(135deg, #f43f5e 0%, #8b5cf6 60%, #6366f1 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .text-gradient-gold {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* ── Hero ── */
    .hero-bg {
      background: radial-gradient(ellipse 80% 60% at 50% -10%, rgba(244,63,94,.12) 0%, transparent 60%),
                  radial-gradient(ellipse 60% 50% at 90% 50%, rgba(139,92,246,.10) 0%, transparent 55%),
                  #ffffff;
    }

    /* ── Glassmorphism card ── */
    .glass {
      background: rgba(255,255,255,0.7);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255,255,255,0.8);
    }

    /* ── Navbar ── */
    #navbar {
      background: rgba(255,255,255,0);
      transition: background 0.3s ease, box-shadow 0.3s ease, padding 0.3s ease;
    }
    #navbar.scrolled {
      background: rgba(255,255,255,0.92);
      backdrop-filter: blur(20px);
      box-shadow: 0 1px 0 rgba(0,0,0,0.06), 0 4px 20px rgba(0,0,0,0.04);
    }

    /* ── CTA Button ── */
    .btn-primary {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 14px 28px;
      border-radius: 50px;
      background: linear-gradient(135deg, #f43f5e, #8b5cf6);
      color: #fff;
      font-weight: 700;
      font-size: 0.9rem;
      text-decoration: none;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
      box-shadow: 0 8px 24px rgba(244,63,94,0.35), 0 2px 8px rgba(0,0,0,0.08);
      position: relative;
      overflow: hidden;
    }
    .btn-primary::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(to right, transparent, rgba(255,255,255,.15), transparent);
      transform: translateX(-100%);
      transition: transform 0.5s ease;
    }
    .btn-primary:hover::after { transform: translateX(100%); }
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 14px 32px rgba(139,92,246,0.40), 0 2px 8px rgba(0,0,0,0.1);
    }

    .btn-outline {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 13px 28px;
      border-radius: 50px;
      background: transparent;
      color: #374151;
      font-weight: 600;
      font-size: 0.9rem;
      text-decoration: none;
      border: 1.5px solid #e5e7eb;
      transition: all 0.25s ease;
    }
    .btn-outline:hover {
      border-color: #f43f5e;
      color: #f43f5e;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(244,63,94,0.1);
    }

    /* ── Reveal animation ── */
    .reveal {
      opacity: 0;
      transform: translateY(28px);
      transition: opacity 0.65s cubic-bezier(0.22,1,0.36,1), transform 0.65s cubic-bezier(0.22,1,0.36,1);
    }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    /* ── Feature card ── */
    .feature-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    /* ── Pricing card ── */
    .pricing-popular {
      background: linear-gradient(145deg, #1e1b4b, #2d1b69);
      color: white;
    }

    /* ── FAQ ── */
    .faq-content { max-height: 0; overflow: hidden; transition: max-height 0.35s ease; }
    .faq-content.open { max-height: 400px; }
    .faq-icon { transition: transform 0.3s ease; }
    .faq-icon.open { transform: rotate(45deg); }

    /* ── Float animation ── */
    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      33%       { transform: translateY(-10px) rotate(1deg); }
      66%       { transform: translateY(-5px) rotate(-1deg); }
    }
    .animate-float { animation: float 5s ease-in-out infinite; }

    /* ── Marquee ── */
    @keyframes marquee {
      from { transform: translateX(0); }
      to   { transform: translateX(-50%); }
    }
    .marquee-track {
      display: flex;
      width: max-content;
      animation: marquee 28s linear infinite;
    }
    .marquee-track:hover { animation-play-state: paused; }

    /* ── Badge pill ── */
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 5px 14px;
      border-radius: 50px;
      font-size: 0.75rem;
      font-weight: 600;
    }

    /* ── Mobile Sticky CTA ── */
    @media (max-width: 767px) {
      .mobile-sticky {
        display: block;
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(12px);
        padding: 12px 16px;
        box-shadow: 0 -4px 24px rgba(0,0,0,0.1);
        z-index: 90;
      }
      body { padding-bottom: 72px; }
    }
    @media (min-width: 768px) {
      .mobile-sticky { display: none; }
    }

    /* ── Mockup phone ── */
    .phone-mockup {
      background: linear-gradient(160deg, #fff1f2 0%, #fdf4ff 50%, #ede9fe 100%);
      border: 8px solid white;
      box-shadow:
        0 0 0 1px rgba(0,0,0,0.05),
        0 32px 80px rgba(244,63,94,0.18),
        0 8px 20px rgba(0,0,0,0.08);
    }

    /* ── Step connector ── */
    .step-line::after {
      content: '';
      position: absolute;
      top: 22px;
      left: calc(50% + 24px);
      width: calc(100% - 48px);
      height: 2px;
      background: linear-gradient(to right, #fda4af, #e9d5ff);
    }
    @media (max-width: 767px) { .step-line::after { display: none; } }
  </style>
</head>
<body class="font-sans text-gray-800 antialiased overflow-x-hidden">

<!-- ╔══════════════════════════════════════╗ -->
<!-- ║           NAVBAR                     ║ -->
<!-- ╚══════════════════════════════════════╝ -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 py-4">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between">

      <!-- Logo -->
      <a href="{{ route('landing') }}" class="flex-shrink-0">
        <img src="{{ config('app.url') }}/images/logo/undigi-logo.png"
             alt="UNDIGI"
             style="height:52px; width:auto; max-width:180px; object-fit:contain;"
             onerror="this.style.display='none'" />
      </a>

      <!-- Desktop Nav -->
      <div class="hidden lg:flex items-center gap-7">
        {{-- <a href="#fitur"    class="text-sm font-medium text-gray-600 hover:text-rose-600 transition">Fitur</a> --}}
        {{-- <a href="#cara"     class="text-sm font-medium text-gray-600 hover:text-rose-600 transition">Cara Kerja</a> --}}
        <a href="#tema"     class="text-sm font-medium text-gray-600 hover:text-rose-600 transition">Tema</a>
        {{-- <a href="#harga"    class="text-sm font-medium text-gray-600 hover:text-rose-600 transition">Harga</a> --}}
        {{-- <a href="#faq"      class="text-sm font-medium text-gray-600 hover:text-rose-600 transition">FAQ</a> --}}
      </div>

      <!-- Desktop CTA -->
      <div class="hidden lg:flex items-center gap-3">
        <a href="{{ route('login') }}"
           class="text-sm font-medium text-gray-600 hover:text-rose-600 transition px-4 py-2 rounded-full">
          Masuk
        </a>
        <a href="{{ route('register') }}"
           class="btn-primary text-sm !py-2.5 !px-5">
          Mulai Gratis
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
          </svg>
        </a>
      </div>

      <!-- Mobile menu button -->
      <button id="menu-btn" class="lg:hidden p-2 rounded-xl text-gray-600 hover:bg-gray-100 transition" aria-label="Menu">
        <svg id="icon-menu" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>

    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden hidden mt-4 pb-4 border-t border-gray-100">
      <div class="flex flex-col gap-1 pt-4">
        {{-- <a href="#fitur" class="text-sm font-medium text-gray-600 hover:text-rose-600 px-3 py-2.5 rounded-xl hover:bg-rose-50 transition">Fitur</a> --}}
        {{-- <a href="#cara"  class="text-sm font-medium text-gray-600 hover:text-rose-600 px-3 py-2.5 rounded-xl hover:bg-rose-50 transition">Cara Kerja</a> --}}
        <a href="#tema"  class="text-sm font-medium text-gray-600 hover:text-rose-600 px-3 py-2.5 rounded-xl hover:bg-rose-50 transition">Tema</a>
        {{-- <a href="#harga" class="text-sm font-medium text-gray-600 hover:text-rose-600 px-3 py-2.5 rounded-xl hover:bg-rose-50 transition">Harga</a> --}}
        {{-- <a href="#faq"   class="text-sm font-medium text-gray-600 hover:text-rose-600 px-3 py-2.5 rounded-xl hover:bg-rose-50 transition">FAQ</a> --}}
        <div class="flex gap-2 mt-3">
          <a href="{{ route('login') }}"    class="flex-1 text-center text-sm font-medium text-gray-700 border border-gray-200 px-4 py-2.5 rounded-full hover:border-rose-300 transition">Masuk</a>
          <a href="{{ route('register') }}" class="flex-1 text-center text-sm font-semibold text-white bg-gradient-to-r from-rose-500 to-violet-600 px-4 py-2.5 rounded-full shadow-sm">Daftar</a>
        </div>
      </div>
    </div>

  </div>
</nav>


<!-- ╔══════════════════════════════════════╗ -->
<!-- ║             HERO                     ║ -->
<!-- ╚══════════════════════════════════════╝ -->
<section class="hero-bg noise relative min-h-screen flex items-center pt-28 pb-20 overflow-hidden">

  <!-- Decorative blobs -->
  <div class="absolute top-20 right-0 w-96 h-96 bg-violet-100 rounded-full opacity-40 blur-3xl pointer-events-none"></div>
  <div class="absolute bottom-10 left-0 w-80 h-80 bg-rose-100 rounded-full opacity-50 blur-3xl pointer-events-none"></div>

  <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">

      <!-- LEFT: Copy -->
      <div class="text-center lg:text-left">

        <div class="inline-flex items-center gap-2 badge bg-rose-50 border border-rose-100 text-rose-600 mb-7">
          <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
          Platform Undangan Digital #1 Indonesia
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-[1.12] tracking-tight text-gray-900 mb-6">
          Undangan Digital
          <span class="text-gradient font-serif italic block mt-1">Elegan & Modern</span>
          untuk Semua Acara
        </h1>

        <p class="text-gray-500 text-lg leading-relaxed mb-8 max-w-md mx-auto lg:mx-0">
          Pernikahan, workshop, rapat dinas, atau pelatihan — buat undangan profesional dan bagikan dalam <strong class="text-gray-700">hitungan menit</strong>, tanpa keahlian desain.
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start mb-10">
          <a href="{{ route('register') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Undangan Gratis
          </a>
          <a href="#tema" class="btn-outline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Lihat Tema
          </a>
        </div>

        <!-- Stats -->
        <div class="flex items-center gap-6 justify-center lg:justify-start">
          <div>
            <p class="text-2xl font-extrabold text-gray-900">1.000+</p>
            <p class="text-xs text-gray-400 mt-0.5">Undangan dibuat</p>
          </div>
          <div class="w-px h-10 bg-gray-200"></div>
          <div>
            <p class="text-2xl font-extrabold text-gray-900">7 Tema</p>
            <p class="text-xs text-gray-400 mt-0.5">Siap pakai</p>
          </div>
          <div class="w-px h-10 bg-gray-200"></div>
          <div>
            <p class="text-2xl font-extrabold text-gray-900">4.9 ★</p>
            <p class="text-xs text-gray-400 mt-0.5">Rating pengguna</p>
          </div>
        </div>

      </div>

      <!-- RIGHT: Mockup -->
      <div class="flex justify-center lg:justify-end">
        <div class="relative animate-float">

          <!-- Main phone card -->
          <div class="phone-mockup rounded-[2.5rem] w-64 sm:w-72 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-br from-rose-400 via-pink-500 to-purple-500 h-52 flex flex-col items-center justify-center relative overflow-hidden">
              <div class="absolute inset-0 opacity-20"
                   style="background-image: radial-gradient(circle at 20% 80%, rgba(255,255,255,0.6) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255,255,255,0.4) 0%, transparent 40%);"></div>
              <p class="text-white/70 text-xs tracking-widest uppercase mb-1 relative z-10">Undangan Pernikahan</p>
              <p class="text-white text-2xl font-bold relative z-10" style="font-family: 'Playfair Display', serif;">Rizky & Ayu</p>
              <p class="text-white/70 text-xs mt-1 relative z-10">Sabtu, 12 April 2026</p>
              <div class="mt-3 flex items-center gap-1.5 relative z-10">
                <span class="text-white/90 text-xs">📍</span>
                <span class="text-white/80 text-xs">Ballroom Grand Hyatt, Jakarta</span>
              </div>
            </div>
            <!-- Body -->
            <div class="bg-white px-5 py-5">
              <p class="text-xs text-gray-400 text-center mb-3 font-medium">Hitung Mundur</p>
              <div class="flex justify-center gap-2 mb-5">
                <div class="bg-rose-50 border border-rose-100 rounded-xl px-2.5 py-2 text-center">
                  <p class="text-lg font-extrabold text-rose-600 leading-none">47</p>
                  <p class="text-xs text-gray-400 mt-1">Hari</p>
                </div>
                <div class="bg-rose-50 border border-rose-100 rounded-xl px-2.5 py-2 text-center">
                  <p class="text-lg font-extrabold text-rose-600 leading-none">08</p>
                  <p class="text-xs text-gray-400 mt-1">Jam</p>
                </div>
                <div class="bg-rose-50 border border-rose-100 rounded-xl px-2.5 py-2 text-center">
                  <p class="text-lg font-extrabold text-rose-600 leading-none">24</p>
                  <p class="text-xs text-gray-400 mt-1">Menit</p>
                </div>
              </div>
              <button class="w-full bg-gradient-to-r from-rose-500 to-purple-500 text-white text-sm font-semibold py-3 rounded-2xl">
                💌 Konfirmasi Kehadiran
              </button>
            </div>
          </div>

          <!-- Floating badge: RSVP -->
          <div class="absolute -top-3 -right-5 glass rounded-2xl shadow-lg px-3.5 py-2.5 flex items-center gap-2.5 border border-white/60">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-sm">🎉</div>
            <div>
              <p class="text-xs font-bold text-gray-800 leading-none">RSVP Baru!</p>
              <p class="text-xs text-gray-400 mt-0.5">+32 konfirmasi hari ini</p>
            </div>
          </div>

          <!-- Floating badge: Share -->
          <div class="absolute -bottom-5 -left-5 glass rounded-2xl shadow-lg px-3.5 py-2.5 flex items-center gap-2.5 border border-white/60">
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-sm">🔗</div>
            <div>
              <p class="text-xs font-bold text-gray-800 leading-none">Link Dibagikan</p>
              <p class="text-xs text-gray-400 mt-0.5">248× klik hari ini</p>
            </div>
          </div>

          <!-- Floating badge: Music -->
          <div class="absolute top-1/2 -left-8 glass rounded-xl shadow-md px-3 py-2 flex items-center gap-2 border border-white/60">
            <div class="text-base">🎵</div>
            <div class="w-16 h-1 bg-gray-100 rounded-full overflow-hidden">
              <div class="h-full w-3/5 bg-gradient-to-r from-rose-400 to-violet-400 rounded-full"></div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>


<!-- ╔══════════════════════════════════════╗ -->
<!-- ║         MARQUEE LOGOS                ║ -->
<!-- ╚══════════════════════════════════════╝ -->
<div class="py-6 bg-gray-50 border-y border-gray-100 overflow-hidden">
  <p class="text-center text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4">Cocok untuk berbagai acara</p>
  <div class="relative overflow-hidden">
    <div class="marquee-track">
      @foreach (array_merge([
        ['icon' => '💍', 'label' => 'Pernikahan'],
        ['icon' => '🎓', 'label' => 'Wisuda'],
        ['icon' => '💼', 'label' => 'Rapat Dinas'],
        ['icon' => '🌙', 'label' => 'Buka Puasa'],
        ['icon' => '🖥️', 'label' => 'Workshop AI'],
        ['icon' => '🏛️', 'label' => 'Acara Instansi'],
        ['icon' => '📊', 'label' => 'Pelatihan'],
        ['icon' => '🤝', 'label' => 'Seminar'],
        ['icon' => '💍', 'label' => 'Pernikahan'],
        ['icon' => '🎓', 'label' => 'Wisuda'],
        ['icon' => '💼', 'label' => 'Rapat Dinas'],
        ['icon' => '🌙', 'label' => 'Buka Puasa'],
        ['icon' => '🖥️', 'label' => 'Workshop AI'],
        ['icon' => '🏛️', 'label' => 'Acara Instansi'],
        ['icon' => '📊', 'label' => 'Pelatihan'],
        ['icon' => '🤝', 'label' => 'Seminar'],
      ], []) as $item)
      <div class="flex items-center gap-2.5 bg-white rounded-full border border-gray-200 px-5 py-2.5 mx-2 whitespace-nowrap shadow-sm">
        <span class="text-base">{{ $item['icon'] }}</span>
        <span class="text-sm font-medium text-gray-600">{{ $item['label'] }}</span>
      </div>
      @endforeach
    </div>
  </div>
</div>


{{-- FEATURES — hidden sementara
<!-- ╔══════════════════════════════════════╗ -->
<!-- ║         FEATURES                     ║ -->
<!-- ╚══════════════════════════════════════╝ -->
<section id="fitur" class="py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center mb-16 reveal">
      <span class="badge bg-indigo-50 border border-indigo-100 text-indigo-600 mb-4">Kenapa UNDIGI?</span>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-2 mb-4">Semua yang Kamu Butuhkan,<br/><span class="text-gradient">Dalam Satu Platform</span></h2>
      <p class="text-gray-500 max-w-xl mx-auto">Dirancang agar siapa pun bisa membuat undangan profesional tanpa keahlian desain.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

      @php
      $features = [
        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>', 'color' => 'rose', 'bg' => 'bg-rose-50', 'ic' => 'text-rose-600', 'border' => 'border-rose-100', 'title' => 'Responsive di Semua Perangkat', 'desc' => 'Tampil sempurna di HP, tablet, dan desktop. Tamu undangan bisa buka dari mana saja tanpa hambatan.'],
        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>', 'color' => 'violet', 'bg' => 'bg-violet-50', 'ic' => 'text-violet-600', 'border' => 'border-violet-100', 'title' => 'RSVP Konfirmasi Digital', 'desc' => 'Tamu konfirmasi kehadiran langsung dari undangan. Semua data tersimpan rapi dan bisa diunduh sebagai Excel.'],
        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>', 'color' => 'indigo', 'bg' => 'bg-indigo-50', 'ic' => 'text-indigo-600', 'border' => 'border-indigo-100', 'title' => 'Musik Latar Romantis', 'desc' => 'Pilih dari koleksi musik pilihan yang sudah dikurasi admin. Putar otomatis saat undangan dibuka.'],
        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>', 'color' => 'emerald', 'bg' => 'bg-emerald-50', 'ic' => 'text-emerald-600', 'border' => 'border-emerald-100', 'title' => 'Integrasi Google Maps', 'desc' => 'Tampilkan lokasi acara dengan link Google Maps langsung di undangan. Tamu tidak perlu repot mencari.'],
        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>', 'color' => 'amber', 'bg' => 'bg-amber-50', 'ic' => 'text-amber-600', 'border' => 'border-amber-100', 'title' => 'Hitung Mundur & Kalender', 'desc' => 'Countdown otomatis ke hari H. Tamu bisa langsung tambahkan acara ke Google Calendar / iPhone Calendar.'],
        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>', 'color' => 'pink', 'bg' => 'bg-pink-50', 'ic' => 'text-pink-600', 'border' => 'border-pink-100', 'title' => 'Ucapan & Doa dari Tamu', 'desc' => 'Kolom ucapan interaktif. Semua pesan tersimpan dan bisa dibaca kapan saja sebagai kenangan indah.'],
      ];
      @endphp

      @foreach ($features as $i => $f)
      <div class="reveal feature-card bg-gradient-to-br from-white to-gray-50/50 border {{ $f['border'] }} rounded-2xl p-6 group" style="transition-delay: {{ $i * 60 }}ms">
        <div class="w-12 h-12 {{ $f['bg'] }} rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-6 h-6 {{ $f['ic'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $f['icon'] !!}</svg>
        </div>
        <h3 class="font-bold text-gray-900 mb-2 text-[0.95rem]">{{ $f['title'] }}</h3>
        <p class="text-sm text-gray-500 leading-relaxed">{{ $f['desc'] }}</p>
      </div>
      @endforeach

    </div>
  </div>
</section>


<!-- ╔══════════════════════════════════════╗ -->
<!-- ║         HOW IT WORKS                 ║ -->
<!-- ╚══════════════════════════════════════╝ -->
<section id="cara" class="py-24 bg-gradient-to-b from-slate-50 to-white">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center mb-16 reveal">
      <span class="badge bg-violet-50 border border-violet-100 text-violet-600 mb-4">Cara Kerja</span>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-2 mb-4">3 Langkah Mudah,<br/><span class="text-gradient">Undangan Siap Sebar</span></h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-6">

      @php
      $steps = [
        ['no' => '01', 'icon' => '📝', 'title' => 'Daftar & Isi Data', 'desc' => 'Buat akun gratis, isi data acara: nama, tanggal, lokasi, dan pilih paket yang sesuai kebutuhanmu.', 'color' => 'from-rose-400 to-pink-500'],
        ['no' => '02', 'icon' => '🎨', 'title' => 'Pilih Tema', 'desc' => 'Pilih tema yang paling cocok — pernikahan elegan, workshop profesional, atau acara instansi formal.', 'color' => 'from-violet-400 to-indigo-500'],
        ['no' => '03', 'icon' => '🚀', 'title' => 'Publikasikan & Bagikan', 'desc' => 'Satu klik publikasikan. Salin link dan bagikan via WhatsApp, Instagram, atau email. Selesai!', 'color' => 'from-indigo-400 to-blue-500'],
      ];
      @endphp

      @foreach ($steps as $i => $step)
      <div class="reveal text-center relative" style="transition-delay: {{ $i * 80 }}ms">
        @if (!$loop->last)
        <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-gradient-to-r from-gray-200 to-gray-100 z-0"></div>
        @endif
        <div class="relative z-10">
          <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br {{ $step['color'] }} shadow-lg shadow-rose-100 mb-5 text-3xl">
            {{ $step['icon'] }}
          </div>
          <div class="absolute top-0 right-1/2 translate-x-8 -translate-y-1 bg-white text-gray-500 text-xs font-bold w-6 h-6 rounded-full border-2 border-gray-100 flex items-center justify-center shadow-sm">
            {{ $i + 1 }}
          </div>
          <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $step['title'] }}</h3>
          <p class="text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">{{ $step['desc'] }}</p>
        </div>
      </div>
      @endforeach

    </div>

    <div class="text-center mt-12 reveal">
      <a href="{{ route('register') }}" class="btn-primary mx-auto">
        Mulai Sekarang — Gratis
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
        </svg>
      </a>
    </div>

  </div>
</section>
--}}


<!-- ╔══════════════════════════════════════╗ -->
<!-- ║         TEMA PREVIEW                 ║ -->
<!-- ╚══════════════════════════════════════╝ -->
<section id="tema" class="py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center mb-14 reveal">
      <span class="badge bg-rose-50 border border-rose-100 text-rose-600 mb-4">Koleksi Tema</span>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-2 mb-4">Tema untuk<br/><span class="text-gradient">Setiap Acara</span></h2>
      <p class="text-gray-500 max-w-lg mx-auto">Dari pernikahan mewah hingga rapat instansi. Semua tema dirancang profesional dan siap pakai.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

      @php
      $themes = [
        ['name' => 'Sakura Elegance',     'type' => 'Pernikahan',    'emoji' => '🌸', 'bg' => 'from-pink-100 to-rose-50',         'text' => 'text-rose-700',   'badge' => 'bg-rose-100 text-rose-600',      'desc' => 'Tema pernikahan yang lembut dan romantis dengan nuansa bunga sakura.'],
        ['name' => 'Ramadhan Glow',       'type' => 'Buka Puasa',    'emoji' => '🌙', 'bg' => 'from-amber-50 to-orange-50',       'text' => 'text-amber-700',  'badge' => 'bg-amber-100 text-amber-700',    'desc' => 'Nuansa kehangatan Ramadan yang elegan untuk acara buka puasa bersama.'],
        ['name' => 'Workshop AI',         'type' => 'Workshop',      'emoji' => '🤖', 'bg' => 'from-blue-50 to-indigo-50',        'text' => 'text-indigo-700', 'badge' => 'bg-indigo-100 text-indigo-700',  'desc' => 'Tema modern futuristik untuk workshop teknologi dan seminar AI.'],
        ['name' => 'Government Clean',    'type' => 'Instansi',      'emoji' => '🏛️', 'bg' => 'from-slate-50 to-gray-50',         'text' => 'text-slate-700',  'badge' => 'bg-slate-100 text-slate-700',    'desc' => 'Desain formal bersih untuk undangan rapat dinas dan acara pemerintahan.'],
        ['name' => 'Corporate Modern',    'type' => 'Perusahaan',    'emoji' => '💼', 'bg' => 'from-sky-50 to-blue-50',           'text' => 'text-sky-700',    'badge' => 'bg-sky-100 text-sky-700',        'desc' => 'Tampilan profesional korporat untuk meeting dan acara perusahaan.'],
        ['name' => 'Executive Dark',      'type' => 'Premium',       'emoji' => '✨', 'bg' => 'from-gray-800 to-slate-900',       'text' => 'text-gray-100',   'badge' => 'bg-gray-700 text-gray-300',      'desc' => 'Tema gelap premium yang eksklusif untuk acara eksekutif dan VIP.'],
      ];
      @endphp

      @foreach ($themes as $i => $t)
      <div class="reveal group relative bg-gradient-to-br {{ $t['bg'] }} rounded-2xl overflow-hidden border border-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1" style="transition-delay: {{ $i * 60 }}ms">
        <div class="p-7">
          <div class="text-4xl mb-4">{{ $t['emoji'] }}</div>
          <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $t['badge'] }} mb-3 inline-block">{{ $t['type'] }}</span>
          <h3 class="font-bold {{ $t['text'] }} text-lg mb-2">{{ $t['name'] }}</h3>
          <p class="text-sm {{ str_contains($t['bg'], 'gray-800') ? 'text-gray-400' : 'text-gray-500' }} leading-relaxed">{{ $t['desc'] }}</p>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-400 to-violet-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
      </div>
      @endforeach

    </div>

    <div class="text-center mt-10 reveal">
      <p class="text-sm text-gray-400 mb-4">Tema baru ditambahkan secara berkala</p>
      <a href="{{ route('register') }}" class="btn-outline mx-auto inline-flex">
        Jelajahi Semua Tema
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
        </svg>
      </a>
    </div>

  </div>
</section>


{{-- PRICING — hidden sementara, aktifkan kembali jika sudah siap
<!-- ╔══════════════════════════════════════╗ -->
<!-- ║         PRICING                      ║ -->
<!-- ╚══════════════════════════════════════╝ -->
<section id="harga" class="py-24 bg-gradient-to-b from-slate-50 to-white">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center mb-14 reveal">
      <span class="badge bg-emerald-50 border border-emerald-100 text-emerald-600 mb-4">Harga</span>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-2 mb-4">Harga Transparan,<br/><span class="text-gradient">Tanpa Biaya Tersembunyi</span></h2>
      <p class="text-gray-500 max-w-md mx-auto">Pilih paket yang sesuai kebutuhanmu. Semua paket sudah termasuk semua fitur.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      <!-- Basic -->
      <div class="reveal bg-white border border-gray-200 rounded-2xl p-7 hover:border-rose-200 hover:shadow-lg transition-all duration-300">
        <div class="mb-6">
          <p class="text-sm font-semibold text-gray-400 uppercase tracking-wide mb-2">Starter</p>
          <div class="flex items-end gap-1">
            <p class="text-4xl font-extrabold text-gray-900">Gratis</p>
          </div>
          <p class="text-sm text-gray-400 mt-2">Untuk mencoba platform</p>
        </div>
        <ul class="space-y-3 mb-8">
          @foreach (['1 undangan aktif', '3 hari aktif', 'Semua fitur dasar', 'Template standar'] as $item)
          <li class="flex items-center gap-2.5 text-sm text-gray-600">
            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            {{ $item }}
          </li>
          @endforeach
        </ul>
        <a href="{{ route('register') }}" class="block text-center py-3 rounded-xl border-2 border-gray-200 text-sm font-semibold text-gray-700 hover:border-rose-400 hover:text-rose-600 transition-all duration-200">
          Mulai Gratis
        </a>
      </div>

      <!-- Pro — Most Popular -->
      <div class="reveal pricing-popular rounded-2xl p-7 relative overflow-hidden shadow-2xl shadow-violet-900/30 scale-[1.02]">
        <div class="absolute top-4 right-4">
          <span class="text-xs font-bold bg-gradient-to-r from-rose-400 to-pink-400 text-white px-3 py-1 rounded-full">Terpopuler</span>
        </div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/5 rounded-full"></div>
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/5 rounded-full"></div>
        <div class="mb-6 relative z-10">
          <p class="text-sm font-semibold text-violet-300 uppercase tracking-wide mb-2">Pro</p>
          <div class="flex items-end gap-1">
            <p class="text-lg font-medium text-white/60 line-through">Rp 150k</p>
          </div>
          <div class="flex items-end gap-1">
            <p class="text-4xl font-extrabold text-white">Rp 99k</p>
            <p class="text-white/60 text-sm mb-1">/ acara</p>
          </div>
          <p class="text-sm text-white/50 mt-2">Paling banyak dipilih</p>
        </div>
        <ul class="space-y-3 mb-8 relative z-10">
          @foreach (['1 undangan premium', '30 hari aktif', 'RSVP unlimited', 'Musik latar', 'Export Excel tamu', 'Cover screen interaktif', 'Semua 7 tema'] as $item)
          <li class="flex items-center gap-2.5 text-sm text-white/80">
            <svg class="w-4 h-4 text-rose-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            {{ $item }}
          </li>
          @endforeach
        </ul>
        <a href="{{ route('register') }}" class="relative z-10 block text-center py-3 rounded-xl bg-gradient-to-r from-rose-500 to-pink-500 text-white text-sm font-bold shadow-lg shadow-rose-500/30 hover:shadow-rose-500/50 hover:-translate-y-0.5 transition-all duration-200">
          Pilih Paket Pro
        </a>
      </div>

      <!-- Enterprise -->
      <div class="reveal bg-white border border-gray-200 rounded-2xl p-7 hover:border-indigo-200 hover:shadow-lg transition-all duration-300">
        <div class="mb-6">
          <p class="text-sm font-semibold text-gray-400 uppercase tracking-wide mb-2">Enterprise</p>
          <div class="flex items-end gap-1">
            <p class="text-4xl font-extrabold text-gray-900">Custom</p>
          </div>
          <p class="text-sm text-gray-400 mt-2">Untuk instansi & perusahaan</p>
        </div>
        <ul class="space-y-3 mb-8">
          @foreach (['Undangan tak terbatas', 'Durasi custom', 'Subdomain khusus', 'Laporan & analitik', 'Priority support', 'Custom branding'] as $item)
          <li class="flex items-center gap-2.5 text-sm text-gray-600">
            <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            {{ $item }}
          </li>
          @endforeach
        </ul>
        <a href="{{ route('register') }}" class="block text-center py-3 rounded-xl border-2 border-indigo-200 text-sm font-semibold text-indigo-700 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all duration-200">
          Hubungi Kami
        </a>
      </div>

    </div>
  </div>
</section>
--}}


{{-- TESTIMONIALS — hidden sementara
<!-- ╔══════════════════════════════════════╗ -->
<!-- ║         TESTIMONIALS                 ║ -->
<!-- ╚══════════════════════════════════════╝ -->
<section class="py-24 bg-white">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center mb-14 reveal">
      <span class="badge bg-pink-50 border border-pink-100 text-pink-600 mb-4">Testimoni</span>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-2 mb-4">Dipercaya<br/><span class="text-gradient">Ribuan Pengguna</span></h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      @php
      $testimonials = [
        ['name' => 'Anisa R.', 'role' => 'Pengantin Wanita, Jakarta', 'avatar' => 'AR', 'color' => 'bg-rose-100 text-rose-700', 'stars' => 5, 'text' => 'Luar biasa! Undangan digital saya terlihat sangat elegan dan profesional. Tamu-tamu saya banyak yang tanya pakai platform apa 😍'],
        ['name' => 'Budi S.', 'role' => 'Staf IT, Dinas Pendidikan', 'avatar' => 'BS', 'color' => 'bg-indigo-100 text-indigo-700', 'stars' => 5, 'text' => 'Kami pakai tema Government Clean untuk undangan rapat dinas. Tampilannya formal dan bersih banget. Rekomendasi untuk instansi!'],
        ['name' => 'Dika P.', 'role' => 'Penyelenggara Workshop', 'avatar' => 'DP', 'color' => 'bg-violet-100 text-violet-700', 'stars' => 5, 'text' => 'Fitur RSVP dan export Excel-nya sangat membantu untuk rekap peserta workshop. Tidak perlu form Google lagi!'],
      ];
      @endphp

      @foreach ($testimonials as $i => $t)
      <div class="reveal bg-gradient-to-br from-gray-50 to-white border border-gray-100 rounded-2xl p-7 hover:shadow-lg transition-all duration-300" style="transition-delay: {{ $i * 80 }}ms">
        <div class="flex text-amber-400 mb-4">
          @for ($s = 0; $s < $t['stars']; $s++)
          <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          @endfor
        </div>
        <p class="text-gray-700 text-sm leading-relaxed mb-6 italic">"{{ $t['text'] }}"</p>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full {{ $t['color'] }} flex items-center justify-center text-sm font-bold">{{ $t['avatar'] }}</div>
          <div>
            <p class="font-semibold text-gray-900 text-sm">{{ $t['name'] }}</p>
            <p class="text-xs text-gray-400">{{ $t['role'] }}</p>
          </div>
        </div>
      </div>
      @endforeach

    </div>
  </div>
</section>
--}}


{{-- FAQ — hidden sementara
<!-- ╔══════════════════════════════════════╗ -->
<!-- ║         FAQ                          ║ -->
<!-- ╚══════════════════════════════════════╝ -->
<section id="faq" class="py-24 bg-gradient-to-b from-slate-50 to-white">
  <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center mb-14 reveal">
      <span class="badge bg-gray-100 border border-gray-200 text-gray-600 mb-4">FAQ</span>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-2 mb-4">Pertanyaan<br/><span class="text-gradient">yang Sering Diajukan</span></h2>
    </div>

    @php
    $faqs = [
      ['q' => 'Apakah UNDIGI benar-benar gratis?', 'a' => 'Ya! Anda bisa mencoba platform kami secara gratis. Paket gratis memberikan akses ke fitur dasar untuk 1 undangan dengan durasi terbatas. Untuk fitur lengkap dan durasi lebih lama, tersedia paket Pro dengan harga terjangkau.'],
      ['q' => 'Apakah saya perlu keahlian desain?', 'a' => 'Sama sekali tidak. UNDIGI menyediakan tema siap pakai yang dirancang oleh desainer profesional. Anda hanya perlu mengisi informasi acara dan pilih tema yang sesuai.'],
      ['q' => 'Berapa lama undangan saya aktif?', 'a' => 'Durasi aktif tergantung paket yang dipilih. Paket gratis aktif selama 3 hari, paket Pro selama 30 hari, dan paket Enterprise bisa disesuaikan kebutuhan.'],
      ['q' => 'Bisakah tamu RSVP dari undangan?', 'a' => 'Ya! Semua paket sudah termasuk fitur RSVP digital. Tamu bisa konfirmasi kehadiran langsung dari halaman undangan. Data RSVP tersimpan otomatis dan bisa diunduh sebagai file Excel.'],
      ['q' => 'Apakah tersedia musik latar?', 'a' => 'Ya, admin platform sudah mengkurasi koleksi musik yang bisa Anda pilih untuk mengiringi undangan. Musik akan otomatis diputar saat tamu membuka undangan.'],
      ['q' => 'Bagaimana cara membagikan undangan?', 'a' => 'Setelah dipublikasikan, Anda mendapatkan link unik yang bisa langsung disalin dan dibagikan via WhatsApp, Instagram, email, atau media sosial lainnya.'],
    ];
    @endphp

    <div class="space-y-3">
      @foreach ($faqs as $i => $faq)
      <div class="reveal bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm" style="transition-delay: {{ $i * 50 }}ms">
        <button
          onclick="toggleFaq({{ $i }})"
          class="w-full flex items-center justify-between px-6 py-5 text-left hover:bg-gray-50 transition-colors duration-200 gap-4">
          <span class="font-semibold text-gray-900 text-sm sm:text-base">{{ $faq['q'] }}</span>
          <svg id="faq-icon-{{ $i }}" class="faq-icon w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
        </button>
        <div id="faq-{{ $i }}" class="faq-content">
          <div class="px-6 pb-5">
            <p class="text-sm text-gray-500 leading-relaxed border-t border-gray-100 pt-4">{{ $faq['a'] }}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>

  </div>
</section>
--}}


<!-- ╔══════════════════════════════════════╗ -->
<!-- ║         CTA SECTION                  ║ -->
<!-- ╚══════════════════════════════════════╝ -->
<section class="py-24 relative overflow-hidden">
  <div class="absolute inset-0 bg-gradient-to-br from-rose-500 via-pink-500 to-violet-600"></div>
  <div class="absolute inset-0 opacity-20"
       style="background-image: radial-gradient(circle at 20% 80%, rgba(255,255,255,0.4) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255,255,255,0.3) 0%, transparent 40%);"></div>
  <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

    <div class="reveal">
      <h2 class="text-3xl sm:text-5xl font-extrabold text-white leading-tight mb-6">
        Siap Buat Undangan<br/>Digital yang Memukau?
      </h2>
      <p class="text-white/75 text-lg mb-10 max-w-xl mx-auto leading-relaxed">
        Bergabung dengan ribuan pengguna yang sudah membuat undangan elegan bersama UNDIGI. Daftar gratis, tidak perlu kartu kredit.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('register') }}"
           class="inline-flex items-center justify-center gap-2 bg-white text-rose-600 font-bold text-sm px-8 py-4 rounded-full shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
          </svg>
          Daftar Sekarang — Gratis
        </a>
        <a href="{{ route('login') }}"
           class="inline-flex items-center justify-center gap-2 bg-white/15 text-white font-semibold text-sm px-8 py-4 rounded-full border border-white/30 hover:bg-white/25 transition-all duration-300">
          Sudah punya akun? Masuk
        </a>
      </div>
    </div>

  </div>
</section>


<!-- ╔══════════════════════════════════════╗ -->
<!-- ║         FOOTER                       ║ -->
<!-- ╚══════════════════════════════════════╝ -->
<footer class="bg-gray-950 text-gray-400 pt-16 pb-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-14">

      <!-- Brand -->
      <div class="md:col-span-2">
        <img src="{{ config('app.url') }}/images/logo/undigi-logo.png"
             alt="UNDIGI"
             style="height:44px; width:auto; object-fit:contain; filter: brightness(0) invert(1); opacity:0.9;"
             onerror="this.style.display='none'" />
        <p class="text-sm leading-relaxed mt-5 max-w-xs text-gray-500">
          Platform undangan digital modern untuk pernikahan, workshop, rapat instansi, dan berbagai acara lainnya.
        </p>
        <div class="flex items-center gap-3 mt-5">
          <a href="#" class="w-8 h-8 bg-gray-800 hover:bg-rose-600 rounded-lg flex items-center justify-center transition-colors duration-200" aria-label="Instagram">
            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
          </a>
          <a href="#" class="w-8 h-8 bg-gray-800 hover:bg-green-600 rounded-lg flex items-center justify-center transition-colors duration-200" aria-label="WhatsApp">
            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          </a>
        </div>
      </div>

      <!-- Links -->
      <div>
        <p class="text-white font-semibold text-sm mb-5">Platform</p>
        <ul class="space-y-3 text-sm">
          {{-- <li><a href="#fitur"  class="hover:text-white transition-colors duration-200">Fitur</a></li> --}}
          <li><a href="#tema"   class="hover:text-white transition-colors duration-200">Tema</a></li>
          {{-- <li><a href="#harga"  class="hover:text-white transition-colors duration-200">Harga</a></li> --}}
          {{-- <li><a href="#faq"    class="hover:text-white transition-colors duration-200">FAQ</a></li> --}}
        </ul>
      </div>

      <div>
        <p class="text-white font-semibold text-sm mb-5">Akun</p>
        <ul class="space-y-3 text-sm">
          <li><a href="{{ route('login') }}"    class="hover:text-white transition-colors duration-200">Masuk</a></li>
          <li><a href="{{ route('register') }}" class="hover:text-white transition-colors duration-200">Daftar Gratis</a></li>
        </ul>
      </div>

    </div>

    <div class="border-t border-gray-800 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
      <p class="text-sm text-gray-600">&copy; {{ date('Y') }} UNDIGI. Dibuat dengan ❤️ di Indonesia.</p>
      <p class="text-xs text-gray-700">Platform Undangan Digital Modern</p>
    </div>

  </div>
</footer>


<!-- ╔══════════════════════════════════════╗ -->
<!-- ║         MOBILE STICKY CTA            ║ -->
<!-- ╚══════════════════════════════════════╝ -->
<div class="mobile-sticky">
  <a href="{{ route('register') }}"
     class="block w-full text-center py-3.5 rounded-2xl bg-gradient-to-r from-rose-500 to-violet-600 text-white font-bold text-sm shadow-lg">
    Mulai Gratis Sekarang →
  </a>
</div>


<script>
(function () {
  'use strict';

  // ── Navbar scroll effect ──
  var navbar = document.getElementById('navbar');
  function handleScroll() {
    if (window.scrollY > 20) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  }
  window.addEventListener('scroll', handleScroll, { passive: true });

  // ── Mobile menu ──
  var menuBtn    = document.getElementById('menu-btn');
  var mobileMenu = document.getElementById('mobile-menu');
  var iconMenu   = document.getElementById('icon-menu');
  var iconClose  = document.getElementById('icon-close');
  var isMenuOpen = false;

  menuBtn.addEventListener('click', function () {
    isMenuOpen = !isMenuOpen;
    mobileMenu.classList.toggle('hidden', !isMenuOpen);
    iconMenu.classList.toggle('hidden', isMenuOpen);
    iconClose.classList.toggle('hidden', !isMenuOpen);
  });

  // Close menu on link click
  mobileMenu.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      isMenuOpen = false;
      mobileMenu.classList.add('hidden');
      iconMenu.classList.remove('hidden');
      iconClose.classList.add('hidden');
    });
  });

  // ── Scroll reveal ──
  function reveal() {
    var els = document.querySelectorAll('.reveal');
    var windowH = window.innerHeight;
    els.forEach(function (el) {
      var top = el.getBoundingClientRect().top;
      if (top < windowH - 60) {
        el.classList.add('visible');
      }
    });
  }
  window.addEventListener('scroll', reveal, { passive: true });
  reveal();

  // ── FAQ toggle ──
  window.toggleFaq = function (i) {
    var content = document.getElementById('faq-' + i);
    var icon    = document.getElementById('faq-icon-' + i);
    var isOpen  = content.classList.contains('open');

    // Close all
    document.querySelectorAll('.faq-content').forEach(function (el) { el.classList.remove('open'); });
    document.querySelectorAll('.faq-icon').forEach(function (el) { el.classList.remove('open'); });

    // Open clicked (if it was closed)
    if (!isOpen) {
      content.classList.add('open');
      icon.classList.add('open');
    }
  };

})();
</script>
</body>
</html>

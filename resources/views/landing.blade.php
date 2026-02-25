<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>UNDIGI — Undangan Digital Elegan untuk Pernikahanmu</title>
  <meta name="description" content="Buat undangan digital pernikahan yang elegan, modern, dan siap dibagikan ke WhatsApp & Instagram dalam hitungan menit. Mulai gratis sekarang!" />
  <meta property="og:title" content="UNDIGI — Undangan Digital Elegan untuk Pernikahanmu" />
  <meta property="og:description" content="Praktis, modern, dan siap dibagikan ke WhatsApp & Instagram. Buat undangan digitalmu sekarang!" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://undigi.id" />
  <meta property="og:image" content="https://undigi.id/og-image.jpg" />
  <link rel="icon" href="{{ asset('images/logo/undigi-logo.png') }}" type="image/png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'system-ui', 'sans-serif'],
            serif: ['Georgia', 'serif'],
          },
          colors: {
            rose: { 50:'#fff1f2',100:'#ffe4e6',200:'#fecdd3',300:'#fda4af',400:'#fb7185',500:'#f43f5e',600:'#e11d48',700:'#be123c',800:'#9f1239',900:'#881337' },
            purple: { 50:'#faf5ff',100:'#f3e8ff',200:'#e9d5ff',300:'#d8b4fe',400:'#c084fc',500:'#a855f7',600:'#9333ea',700:'#7e22ce',800:'#6b21a8',900:'#581c87' },
          },
          animation: {
            'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
            'float': 'float 3s ease-in-out infinite',
          },
          keyframes: {
            fadeInUp: { '0%':{ opacity:'0', transform:'translateY(20px)' }, '100%':{ opacity:'1', transform:'translateY(0)' } },
            float: { '0%,100%':{ transform:'translateY(0)' }, '50%':{ transform:'translateY(-8px)' } },
          },
        }
      }
    }
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    html { scroll-behavior: smooth; }
    .gradient-text { background: linear-gradient(135deg, #e11d48, #9333ea); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .hero-gradient { background: linear-gradient(135deg, #fff1f2 0%, #faf5ff 50%, #ede9fe 100%); }
    .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    .navbar-solid { background: rgba(255,255,255,0.95) !important; backdrop-filter: blur(12px); box-shadow: 0 1px 20px rgba(0,0,0,0.08); }
    .reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    .faq-content { max-height: 0; overflow: hidden; transition: max-height 0.35s ease; }
    .faq-content.open { max-height: 300px; }
    .theme-card:hover .theme-overlay { opacity: 1; }
    .theme-overlay { opacity: 0; transition: opacity 0.3s ease; }

    /* ── Theme Pill Filter ── */
    .theme-pill {
      background: #fff;
      color: #6b7280;
      border: 1.5px solid #e5e7eb;
      box-shadow: 0 1px 3px rgba(0,0,0,.06);
    }
    .theme-pill:hover {
      border-color: #a5b4fc;
      color: #4f46e5;
      transform: translateY(-1px);
      box-shadow: 0 4px 10px rgba(99,102,241,.12);
    }
    .theme-pill.active {
      background: linear-gradient(135deg, #6366f1, #8b5cf6);
      color: #fff;
      border-color: transparent;
      box-shadow: 0 6px 16px rgba(99,102,241,.30);
      transform: translateY(-1px);
    }

    /* ── Theme card item fade transition ── */
    .theme-card-item {
      transition: opacity 0.25s ease, transform 0.25s ease;
    }
    .theme-card-item.hiding {
      opacity: 0;
      transform: scale(0.96);
      pointer-events: none;
    }
    .mockup-card { background: linear-gradient(145deg, #ffffff, #fdf2f8); border: 1px solid #fce7f3; }
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: #e11d48; border-radius: 3px; }

    /* ── CTA Premium ── */
    .cta-primary {
      position: relative;
      overflow: hidden;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 14px 32px;
      border-radius: 50px;
      background: linear-gradient(135deg, #e11d48, #9333ea);
      color: #fff;
      font-weight: 700;
      font-size: 0.95rem;
      text-decoration: none;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 10px 25px rgba(225, 29, 72, 0.35);
    }
    .cta-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 18px 40px rgba(147, 51, 234, 0.45);
    }

    /* ── Ripple ── */
    .ripple {
      position: absolute;
      width: 100px;
      height: 100px;
      background: rgba(255,255,255,0.45);
      border-radius: 50%;
      transform: scale(0);
      animation: ripple-effect 0.6s linear;
      pointer-events: none;
    }
    @keyframes ripple-effect {
      from { transform: scale(0); opacity: 1; }
      to   { transform: scale(4); opacity: 0; }
    }

    /* ── Sticky Mobile CTA ── */
    .sticky-cta { display: none; }
    @media (max-width: 768px) {
      .sticky-cta {
        display: block;
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: rgba(255,255,255,0.97);
        padding: 12px 16px;
        text-align: center;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.10);
        backdrop-filter: blur(8px);
        z-index: 100;
      }
      .sticky-cta a {
        display: block;
        background: linear-gradient(135deg, #e11d48, #9333ea);
        color: #fff;
        padding: 14px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
        box-shadow: 0 8px 20px rgba(225, 29, 72, 0.35);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
      }
      .sticky-cta a:active { transform: scale(0.98); }
      /* Beri ruang agar konten tidak tertutup sticky bar */
      body { padding-bottom: 76px; }
    }
  </style>
</head>
<body class="font-sans text-gray-800 antialiased">

<!-- ======================== NAVBAR ======================== -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 py-4">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between">
      <!-- Logo -->
      <a href="{{ route('landing') }}" class="flex items-center">
        <img src="{{ asset('images/logo/undigi-logo.png') }}"
             alt="UNDIGI"
             style="height:70px; width:auto; max-width:220px; object-fit:contain; display:block;">
      </a>

      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center gap-8">
        <a href="#fitur" class="text-sm font-medium text-gray-600 hover:text-rose-600 transition">Fitur</a>
        <a href="#tema" class="text-sm font-medium text-gray-600 hover:text-rose-600 transition">Tema</a>
        <a href="#harga" class="text-sm font-medium text-gray-600 hover:text-rose-600 transition">Harga</a>
        <a href="#faq" class="text-sm font-medium text-gray-600 hover:text-rose-600 transition">FAQ</a>
      </div>

      <!-- CTA Buttons -->
      <div class="hidden md:flex items-center gap-3">
        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-rose-600 transition px-4 py-2">Masuk</a>
        <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-gradient-to-r from-rose-500 to-purple-600 px-5 py-2.5 rounded-full hover:shadow-lg hover:shadow-rose-200 transition-all duration-300">
          Daftar Gratis
        </a>
      </div>

      <!-- Mobile Hamburger -->
      <button id="menu-btn" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition" aria-label="Menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden mt-4 pb-4 border-t border-gray-100">
      <div class="flex flex-col gap-3 pt-4">
        <a href="#fitur" class="text-sm font-medium text-gray-600 hover:text-rose-600 transition py-1">Fitur</a>
        <a href="#tema" class="text-sm font-medium text-gray-600 hover:text-rose-600 transition py-1">Tema</a>
        <a href="#harga" class="text-sm font-medium text-gray-600 hover:text-rose-600 transition py-1">Harga</a>
        <a href="#faq" class="text-sm font-medium text-gray-600 hover:text-rose-600 transition py-1">FAQ</a>
        <div class="flex gap-3 pt-2">
          <a href="{{ route('login') }}" class="flex-1 text-center text-sm font-medium text-gray-600 border border-gray-200 px-4 py-2.5 rounded-full hover:border-rose-300 transition">Masuk</a>
          <a href="{{ route('register') }}" class="flex-1 text-center text-sm font-semibold text-white bg-gradient-to-r from-rose-500 to-purple-600 px-4 py-2.5 rounded-full">Daftar</a>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- ======================== HERO ======================== -->
<section class="hero-gradient min-h-screen flex items-center pt-24 pb-16 overflow-hidden">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

      <!-- Text Content -->
      <div class="text-center lg:text-left">
        <div class="inline-flex items-center gap-2 bg-rose-50 border border-rose-100 text-rose-600 text-xs font-semibold px-4 py-2 rounded-full mb-6">
          <span class="w-2 h-2 bg-rose-500 rounded-full animate-pulse"></span>
          Lebih dari 1.000 pasangan sudah mempercayai kami
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight text-gray-900 mb-6">
          Buat Undangan Digital
          <span class="gradient-text block">Elegan dalam</span>
          Hitungan Menit
        </h1>
        <p class="text-lg text-gray-500 mb-8 leading-relaxed max-w-lg mx-auto lg:mx-0">
          Praktis, modern, dan siap dibagikan ke WhatsApp & Instagram. Tidak perlu keahlian desain.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
          <a href="{{ route('register') }}" class="cta-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Undangan Sekarang
          </a>
          <a href="#tema"
             class="inline-flex items-center justify-center gap-2 bg-white text-gray-700 font-semibold px-8 py-4 rounded-full border border-gray-200 hover:border-rose-300 hover:text-rose-600 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Lihat Demo
          </a>
        </div>
        <!-- Stats -->
        <div class="flex items-center gap-8 mt-10 justify-center lg:justify-start">
          <div class="text-center lg:text-left">
            <p class="text-2xl font-bold text-gray-900">1K+</p>
            <p class="text-xs text-gray-500">Pasangan</p>
          </div>
          <div class="w-px h-10 bg-gray-200"></div>
          <div class="text-center lg:text-left">
            <p class="text-2xl font-bold text-gray-900">20+</p>
            <p class="text-xs text-gray-500">Tema Cantik</p>
          </div>
          <div class="w-px h-10 bg-gray-200"></div>
          <div class="text-center lg:text-left">
            <p class="text-2xl font-bold text-gray-900">4.9★</p>
            <p class="text-xs text-gray-500">Rating</p>
          </div>
        </div>
      </div>

      <!-- Hero Mockup -->
      <div class="relative flex justify-center lg:justify-end animate-float">
        <div class="relative">
          <!-- Main Card -->
          <div class="mockup-card rounded-3xl shadow-2xl shadow-rose-100 p-1 w-72 sm:w-80">
            <div class="bg-gradient-to-b from-rose-50 to-purple-50 rounded-2xl overflow-hidden">
              <!-- Phone Header -->
              <div class="bg-gradient-to-r from-rose-400 to-purple-500 h-48 flex items-center justify-center relative">
                <div class="text-center text-white">
                  <p class="text-xs opacity-75 tracking-widest uppercase mb-1">Undangan Pernikahan</p>
                  <p class="text-2xl font-bold" style="font-family: Georgia, serif;">Rizky & Ayu</p>
                  <p class="text-xs opacity-75 mt-1">12 Maret 2026</p>
                </div>
                <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><text y=\"50\" font-size=\"80\" opacity=\"0.5\">🌸</text></svg>'); background-size: 60px; background-repeat: repeat;"></div>
              </div>
              <!-- Card Body -->
              <div class="p-5">
                <div class="text-center mb-4">
                  <p class="text-xs text-gray-500 mb-1">Hitung Mundur</p>
                  <div class="flex justify-center gap-2">
                    <div class="bg-white rounded-lg px-2 py-1 shadow-sm">
                      <p class="text-lg font-bold text-rose-600">12</p>
                      <p class="text-xs text-gray-400">Hari</p>
                    </div>
                    <div class="bg-white rounded-lg px-2 py-1 shadow-sm">
                      <p class="text-lg font-bold text-rose-600">04</p>
                      <p class="text-xs text-gray-400">Jam</p>
                    </div>
                    <div class="bg-white rounded-lg px-2 py-1 shadow-sm">
                      <p class="text-lg font-bold text-rose-600">30</p>
                      <p class="text-xs text-gray-400">Menit</p>
                    </div>
                  </div>
                </div>
                <div class="bg-rose-500 text-white text-center text-sm font-semibold py-2.5 rounded-xl">
                  ✉️ Konfirmasi Kehadiran
                </div>
              </div>
            </div>
          </div>
          <!-- Floating Badge -->
          <div class="absolute -top-4 -right-4 bg-white rounded-2xl shadow-lg px-4 py-3 flex items-center gap-2">
            <span class="text-xl">🎉</span>
            <div>
              <p class="text-xs font-bold text-gray-800">RSVP Masuk!</p>
              <p class="text-xs text-gray-400">+24 tamu baru</p>
            </div>
          </div>
          <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl shadow-lg px-4 py-3 flex items-center gap-2">
            <span class="text-xl">🔗</span>
            <div>
              <p class="text-xs font-bold text-gray-800">Link Dibagikan</p>
              <p class="text-xs text-gray-400">120× klik hari ini</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ======================== FEATURES ======================== -->
<section id="fitur" class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14 reveal">
      <p class="text-sm font-semibold text-rose-500 tracking-widest uppercase mb-3">Kenapa UNDIGI?</p>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">Semua yang Kamu Butuhkan</h2>
      <p class="text-gray-500 max-w-xl mx-auto">Fitur lengkap dirancang khusus untuk membuat undangan digitalmu tampil memukau dan mudah digunakan.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

      <!-- Feature 1 -->
      <div class="reveal card-hover bg-gradient-to-br from-rose-50 to-white border border-rose-100 rounded-2xl p-6">
        <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
        </div>
        <h3 class="font-bold text-gray-900 mb-2">Responsive Design</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Tampilan sempurna di semua perangkat — HP, tablet, maupun desktop tanpa perlu konfigurasi tambahan.</p>
      </div>

      <!-- Feature 2 -->
      <div class="reveal card-hover bg-gradient-to-br from-purple-50 to-white border border-purple-100 rounded-2xl p-6">
        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
        </div>
        <h3 class="font-bold text-gray-900 mb-2">Multi Theme Layout</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Pilih dari puluhan tema cantik — elegan, modern, rustic, hingga minimalis sesuai selera.</p>
      </div>

      <!-- Feature 3 -->
      <div class="reveal card-hover bg-gradient-to-br from-rose-50 to-white border border-rose-100 rounded-2xl p-6">
        <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
        </div>
        <h3 class="font-bold text-gray-900 mb-2">QR & RSVP System</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Tamu konfirmasi kehadiran online. QR code otomatis untuk check-in di lokasi acara.</p>
      </div>

      <!-- Feature 4 -->
      <div class="reveal card-hover bg-gradient-to-br from-purple-50 to-white border border-purple-100 rounded-2xl p-6">
        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
        </div>
        <h3 class="font-bold text-gray-900 mb-2">Custom Domain</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Gunakan domain sendiri seperti <em>rizky-ayu.com</em> untuk kesan yang lebih personal dan profesional.</p>
      </div>

      <!-- Feature 5 -->
      <div class="reveal card-hover bg-gradient-to-br from-rose-50 to-white border border-rose-100 rounded-2xl p-6">
        <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
        </div>
        <h3 class="font-bold text-gray-900 mb-2">Background Music</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Tambahkan lagu romantis sebagai latar belakang untuk menciptakan suasana yang lebih berkesan.</p>
      </div>

      <!-- Feature 6 -->
      <div class="reveal card-hover bg-gradient-to-br from-purple-50 to-white border border-purple-100 rounded-2xl p-6">
        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h3 class="font-bold text-gray-900 mb-2">Countdown Timer</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Hitung mundur otomatis menuju hari H — membangun antisipasi dan semangat para tamu undangan.</p>
      </div>

    </div>
  </div>
</section>

<!-- ======================== THEMES ======================== -->
<section id="tema" class="py-20 bg-gradient-to-br from-purple-50 via-white to-rose-50">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Section Header -->
    <div class="text-center mb-10 reveal">
      <p class="text-sm font-semibold text-purple-500 tracking-widest uppercase mb-3">Koleksi Tema</p>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">Temukan Desain untuk Acaramu</h2>
      <p class="text-gray-500 max-w-xl mx-auto">Tema modern untuk semua jenis acara — pernikahan, kegiatan kantor, workshop, dan lebih banyak lagi.</p>
    </div>

    <!-- ── Filter Jenis Acara (Pill Cards) ── -->
    <div class="reveal mb-10">
      <div id="theme-filter-pills" class="flex flex-wrap justify-center gap-2.5">
        <button
          data-filter="all"
          class="theme-pill active flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 cursor-pointer select-none"
          onclick="filterThemes('all', this)"
        >
          <span>✨</span> Semua Acara
        </button>
        <button
          data-filter="pernikahan"
          class="theme-pill flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 cursor-pointer select-none"
          onclick="filterThemes('pernikahan', this)"
        >
          <span>💒</span> Pernikahan
        </button>
        <button
          data-filter="buka_puasa"
          class="theme-pill flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 cursor-pointer select-none"
          onclick="filterThemes('buka_puasa', this)"
        >
          <span>🌙</span> Buka Puasa
        </button>
        <button
          data-filter="workshop"
          class="theme-pill flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 cursor-pointer select-none"
          onclick="filterThemes('workshop', this)"
        >
          <span>🎓</span> Workshop
        </button>
        <button
          data-filter="kantor"
          class="theme-pill flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 cursor-pointer select-none"
          onclick="filterThemes('kantor', this)"
        >
          <span>🏛️</span> Kegiatan Kantor
        </button>
      </div>
    </div>

    <!-- ── Grid Tema ── -->
    <div id="theme-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

      <!-- Card: Wedding Elegant -->
      <div class="theme-card-item reveal" data-categories="pernikahan all">
        <div class="group relative rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
          <!-- Thumbnail -->
          <div class="aspect-[4/3] relative overflow-hidden" style="background: linear-gradient(135deg,#fdfaf6 0%,#f5ecd5 60%,#e8d5a3 100%);">
            <div class="w-full h-full flex flex-col items-center justify-center gap-3 p-6">
              <div class="text-5xl leading-none">💍</div>
              <div class="text-center">
                <p class="text-xs tracking-[3px] text-amber-700/60 uppercase font-bold mb-1">Pernikahan</p>
                <p class="text-lg font-bold text-amber-900" style="font-family: Georgia, serif;">Wedding Elegant</p>
                <div class="mx-auto mt-2 w-10 h-px" style="background: linear-gradient(to right, transparent, #b45309, transparent);"></div>
              </div>
            </div>
            <!-- Hover overlay -->
            <div class="theme-overlay absolute inset-0 bg-gradient-to-t from-amber-900/80 via-amber-900/20 to-transparent flex items-end justify-center gap-3 pb-5 px-4">
              <a href="{{ route('register', ['theme' => 'minimal']) }}" class="flex-1 text-center bg-white text-amber-800 font-semibold text-sm py-2.5 rounded-xl hover:bg-amber-50 transition">
                Gunakan
              </a>
              <a href="{{ route('register', ['theme' => 'minimal']) }}" class="flex-1 text-center border border-white/50 text-white font-semibold text-sm py-2.5 rounded-xl hover:bg-white/10 transition">
                Preview
              </a>
            </div>
          </div>
          <!-- Card Footer -->
          <div class="px-4 py-3.5 flex items-center justify-between">
            <div>
              <p class="text-sm font-bold text-gray-800">Wedding Elegant</p>
              <p class="text-xs text-gray-400 mt-0.5">Romantis & Mewah</p>
            </div>
            <span class="text-xs bg-amber-100 text-amber-700 font-semibold px-2.5 py-1 rounded-full">Populer</span>
          </div>
        </div>
      </div>

      <!-- Card: Sakura -->
      <div class="theme-card-item reveal" data-categories="pernikahan all" style="transition-delay: 0.05s;">
        <div class="group relative rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
          <div class="aspect-[4/3] relative overflow-hidden" style="background: linear-gradient(135deg,#fdf2f8 0%,#fce7f3 60%,#fbcfe8 100%);">
            <div class="w-full h-full flex flex-col items-center justify-center gap-3 p-6">
              <div class="text-5xl leading-none">🌸</div>
              <div class="text-center">
                <p class="text-xs tracking-[3px] text-pink-500/70 uppercase font-bold mb-1">Pernikahan</p>
                <p class="text-lg font-bold text-pink-800" style="font-family: Georgia, serif;">Sakura Bloom</p>
                <div class="flex justify-center gap-1 mt-2">
                  <div class="w-4 h-1 rounded-full bg-pink-300 opacity-70"></div>
                  <div class="w-6 h-1 rounded-full bg-pink-400 opacity-50"></div>
                  <div class="w-3 h-1 rounded-full bg-pink-300 opacity-40"></div>
                </div>
              </div>
            </div>
            <div class="theme-overlay absolute inset-0 bg-gradient-to-t from-pink-900/80 via-pink-900/20 to-transparent flex items-end justify-center gap-3 pb-5 px-4">
              <a href="{{ route('register', ['theme' => 'sakura']) }}" class="flex-1 text-center bg-white text-pink-700 font-semibold text-sm py-2.5 rounded-xl hover:bg-pink-50 transition">Gunakan</a>
              <a href="{{ route('register', ['theme' => 'sakura']) }}" class="flex-1 text-center border border-white/50 text-white font-semibold text-sm py-2.5 rounded-xl hover:bg-white/10 transition">Preview</a>
            </div>
          </div>
          <div class="px-4 py-3.5 flex items-center justify-between">
            <div>
              <p class="text-sm font-bold text-gray-800">Sakura Bloom</p>
              <p class="text-xs text-gray-400 mt-0.5">Soft & Feminin</p>
            </div>
            <span class="text-xs bg-pink-100 text-pink-700 font-semibold px-2.5 py-1 rounded-full">Baru</span>
          </div>
        </div>
      </div>

      <!-- Card: Ramadan Glow -->
      <div class="theme-card-item reveal" data-categories="buka_puasa all" style="transition-delay: 0.10s;">
        <div class="group relative rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
          <div class="aspect-[4/3] relative overflow-hidden" style="background: linear-gradient(135deg,#0f172a 0%,#1e1b4b 60%,#312e81 100%);">
            <div class="w-full h-full flex flex-col items-center justify-center gap-3 p-6">
              <div class="text-5xl leading-none">🌙</div>
              <div class="text-center">
                <p class="text-xs tracking-[3px] text-amber-400/70 uppercase font-bold mb-1">Buka Puasa</p>
                <p class="text-lg font-bold text-amber-300" style="font-family: Georgia, serif;">Ramadan Glow</p>
                <div class="flex justify-center gap-1 mt-2">
                  <div class="w-1 h-1 rounded-full bg-amber-400 opacity-80"></div>
                  <div class="w-1 h-1 rounded-full bg-amber-400 opacity-50"></div>
                  <div class="w-1 h-1 rounded-full bg-amber-400 opacity-30"></div>
                </div>
              </div>
            </div>
            <div class="theme-overlay absolute inset-0 bg-gradient-to-t from-indigo-950/90 via-indigo-950/30 to-transparent flex items-end justify-center gap-3 pb-5 px-4">
              <a href="{{ route('register', ['theme' => 'ramadhan']) }}" class="flex-1 text-center bg-amber-400 text-indigo-900 font-semibold text-sm py-2.5 rounded-xl hover:bg-amber-300 transition">Gunakan</a>
              <a href="{{ route('register', ['theme' => 'ramadhan']) }}" class="flex-1 text-center border border-white/30 text-white font-semibold text-sm py-2.5 rounded-xl hover:bg-white/10 transition">Preview</a>
            </div>
          </div>
          <div class="px-4 py-3.5 flex items-center justify-between">
            <div>
              <p class="text-sm font-bold text-gray-800">Ramadan Glow</p>
              <p class="text-xs text-gray-400 mt-0.5">Sakral & Elegan</p>
            </div>
            <span class="text-xs bg-indigo-100 text-indigo-700 font-semibold px-2.5 py-1 rounded-full">Populer</span>
          </div>
        </div>
      </div>

      <!-- Card: Workshop Modern -->
      <div class="theme-card-item reveal" data-categories="workshop all" style="transition-delay: 0.15s;">
        <div class="group relative rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
          <div class="aspect-[4/3] relative overflow-hidden" style="background: linear-gradient(135deg,#f0fdf4 0%,#dcfce7 60%,#bbf7d0 100%);">
            <div class="w-full h-full flex flex-col items-center justify-center gap-3 p-6">
              <div class="text-5xl leading-none">🎓</div>
              <div class="text-center">
                <p class="text-xs tracking-[3px] text-green-600/70 uppercase font-bold mb-1">Workshop</p>
                <p class="text-lg font-bold text-green-800">Workshop Modern</p>
                <div class="grid grid-cols-4 gap-1 mt-3 px-4">
                  <div class="h-1 rounded bg-green-400 opacity-60"></div>
                  <div class="h-1 rounded bg-green-500 opacity-40"></div>
                  <div class="h-1 rounded bg-green-400 opacity-50"></div>
                  <div class="h-1 rounded bg-green-300 opacity-30"></div>
                </div>
              </div>
            </div>
            <div class="theme-overlay absolute inset-0 bg-gradient-to-t from-green-900/80 via-green-900/20 to-transparent flex items-end justify-center gap-3 pb-5 px-4">
              <a href="{{ route('register', ['theme' => 'workshop-ai']) }}" class="flex-1 text-center bg-white text-green-700 font-semibold text-sm py-2.5 rounded-xl hover:bg-green-50 transition">Gunakan</a>
              <a href="{{ route('register', ['theme' => 'workshop-ai']) }}" class="flex-1 text-center border border-white/50 text-white font-semibold text-sm py-2.5 rounded-xl hover:bg-white/10 transition">Preview</a>
            </div>
          </div>
          <div class="px-4 py-3.5 flex items-center justify-between">
            <div>
              <p class="text-sm font-bold text-gray-800">Workshop Modern</p>
              <p class="text-xs text-gray-400 mt-0.5">Profesional & Bersih</p>
            </div>
            <span class="text-xs bg-green-100 text-green-700 font-semibold px-2.5 py-1 rounded-full">Gratis</span>
          </div>
        </div>
      </div>

      <!-- Card: Government Clean -->
      <div class="theme-card-item reveal" data-categories="kantor all" style="transition-delay: 0.20s;">
        <div class="group relative rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
          <div class="aspect-[4/3] relative overflow-hidden" style="background: linear-gradient(135deg,#f0fdfa 0%,#ccfbf1 60%,#99f6e4 100%);">
            <div class="w-full h-full flex flex-col items-center justify-center gap-3 p-6">
              <div class="text-5xl leading-none">🏛️</div>
              <div class="text-center">
                <p class="text-xs tracking-[3px] text-teal-600/70 uppercase font-bold mb-1">Kegiatan Kantor</p>
                <p class="text-lg font-bold text-teal-800">Government Clean</p>
                <div class="mt-3 px-4">
                  <div class="h-0.5 rounded" style="background: linear-gradient(to right, #0f766e, #14b8a6); margin-bottom:6px;"></div>
                  <div class="flex gap-1">
                    <div class="flex-1 h-1 rounded bg-teal-400 opacity-40"></div>
                    <div class="flex-2 h-1 rounded bg-teal-500 opacity-30"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="theme-overlay absolute inset-0 bg-gradient-to-t from-teal-900/80 via-teal-900/20 to-transparent flex items-end justify-center gap-3 pb-5 px-4">
              <a href="{{ route('register', ['theme' => 'government-clean']) }}" class="flex-1 text-center bg-white text-teal-700 font-semibold text-sm py-2.5 rounded-xl hover:bg-teal-50 transition">Gunakan</a>
              <a href="{{ route('register', ['theme' => 'government-clean']) }}" class="flex-1 text-center border border-white/50 text-white font-semibold text-sm py-2.5 rounded-xl hover:bg-white/10 transition">Preview</a>
            </div>
          </div>
          <div class="px-4 py-3.5 flex items-center justify-between">
            <div>
              <p class="text-sm font-bold text-gray-800">Government Clean</p>
              <p class="text-xs text-gray-400 mt-0.5">Resmi & Terpercaya</p>
            </div>
            <span class="text-xs bg-teal-100 text-teal-700 font-semibold px-2.5 py-1 rounded-full">Populer</span>
          </div>
        </div>
      </div>

      <!-- Card: Executive Dark -->
      <div class="theme-card-item reveal" data-categories="kantor workshop all" style="transition-delay: 0.25s;">
        <div class="group relative rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
          <div class="aspect-[4/3] relative overflow-hidden" style="background: linear-gradient(135deg,#0f1923 0%,#1a2332 60%,#243044 100%);">
            <div class="w-full h-full flex flex-col items-center justify-center gap-3 p-6">
              <div class="text-5xl leading-none">📋</div>
              <div class="text-center">
                <p class="text-xs tracking-[3px] text-amber-400/70 uppercase font-bold mb-1">Pelatihan / Rapat</p>
                <p class="text-lg font-bold text-amber-300">Executive Dark</p>
                <div class="mt-3 px-4">
                  <div class="h-px rounded" style="background: linear-gradient(to right, #d4af37, transparent); margin-bottom:6px;"></div>
                  <div class="flex gap-1">
                    <div class="flex-1 h-1 rounded bg-amber-500 opacity-50"></div>
                    <div class="flex-2 h-1 rounded bg-amber-400 opacity-30"></div>
                    <div class="flex-1 h-1 rounded bg-amber-500 opacity-20"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="theme-overlay absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-950/30 to-transparent flex items-end justify-center gap-3 pb-5 px-4">
              <a href="{{ route('register', ['theme' => 'executive-dark']) }}" class="flex-1 text-center bg-amber-400 text-gray-900 font-semibold text-sm py-2.5 rounded-xl hover:bg-amber-300 transition">Gunakan</a>
              <a href="{{ route('register', ['theme' => 'executive-dark']) }}" class="flex-1 text-center border border-white/30 text-white font-semibold text-sm py-2.5 rounded-xl hover:bg-white/10 transition">Preview</a>
            </div>
          </div>
          <div class="px-4 py-3.5 flex items-center justify-between">
            <div>
              <p class="text-sm font-bold text-gray-800">Executive Dark</p>
              <p class="text-xs text-gray-400 mt-0.5">Premium & Eksklusif</p>
            </div>
            <span class="text-xs bg-gray-100 text-gray-700 font-semibold px-2.5 py-1 rounded-full">Premium</span>
          </div>
        </div>
      </div>

    </div>

    <!-- Empty state (shown by JS when no cards match filter) -->
    <div id="theme-empty" class="hidden py-16 text-center">
      <div class="text-4xl mb-3">🎨</div>
      <p class="text-gray-500 font-medium">Belum ada tema untuk kategori ini.</p>
      <p class="text-sm text-gray-400 mt-1">Segera hadir — daftar sekarang untuk mendapat notifikasi.</p>
    </div>

    <!-- CTA -->
    <div class="text-center mt-12 reveal">
      <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-purple-600 hover:text-purple-700 transition">
        Lihat semua tema &amp; mulai buat undangan
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </a>
    </div>

  </div>
</section>

<!-- ======================== HOW IT WORKS ======================== -->
<section class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14 reveal">
      <p class="text-sm font-semibold text-rose-500 tracking-widest uppercase mb-3">Cara Kerja</p>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">Selesai dalam 3 Langkah</h2>
      <p class="text-gray-500 max-w-xl mx-auto">Tidak perlu desainer. Tidak perlu coding. Cukup ikuti langkah berikut.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
      <!-- Connector Line -->
      <div class="hidden md:block absolute top-16 left-1/4 right-1/4 h-0.5 bg-gradient-to-r from-rose-200 via-purple-200 to-rose-200 z-0"></div>

      <!-- Step 1 -->
      <div class="reveal text-center relative z-10">
        <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-rose-200">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"/></svg>
        </div>
        <div class="bg-rose-50 text-rose-600 text-xs font-bold w-7 h-7 rounded-full flex items-center justify-center mx-auto mb-3 border-2 border-white shadow">1</div>
        <h3 class="font-bold text-gray-900 text-lg mb-2">Pilih Tema</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Jelajahi koleksi tema cantik dan pilih yang paling cocok dengan konsep pernikahanmu.</p>
      </div>

      <!-- Step 2 -->
      <div class="reveal text-center relative z-10" style="transition-delay: 0.15s;">
        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-purple-200">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        </div>
        <div class="bg-purple-50 text-purple-600 text-xs font-bold w-7 h-7 rounded-full flex items-center justify-center mx-auto mb-3 border-2 border-white shadow">2</div>
        <h3 class="font-bold text-gray-900 text-lg mb-2">Isi Data</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Masukkan informasi pernikahan — nama mempelai, tanggal, lokasi, dan detail acara lainnya.</p>
      </div>

      <!-- Step 3 -->
      <div class="reveal text-center relative z-10" style="transition-delay: 0.3s;">
        <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-rose-200">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
        </div>
        <div class="bg-rose-50 text-rose-600 text-xs font-bold w-7 h-7 rounded-full flex items-center justify-center mx-auto mb-3 border-2 border-white shadow">3</div>
        <h3 class="font-bold text-gray-900 text-lg mb-2">Bagikan Link</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Salin link undangan dan bagikan ke WhatsApp, Instagram, atau media sosial lainnya.</p>
      </div>
    </div>
  </div>
</section>

<!-- ======================== PRICING ======================== -->
<section id="harga" class="py-20 bg-gradient-to-br from-rose-50 via-white to-purple-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14 reveal">
      <p class="text-sm font-semibold text-rose-500 tracking-widest uppercase mb-3">Harga Paket</p>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">Harga Transparan, Tanpa Kejutan</h2>
      <p class="text-gray-500 max-w-xl mx-auto">Pilih paket yang sesuai kebutuhan. Semua sudah termasuk fitur lengkap tanpa biaya tersembunyi.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">

      <!-- Basic -->
      <div class="reveal card-hover bg-white border border-gray-200 rounded-2xl p-8 flex flex-col">
        <div class="mb-6">
          <p class="text-sm font-semibold text-gray-500 uppercase tracking-widest mb-2">Basic</p>
          <div class="flex items-end gap-1 mb-1">
            <span class="text-4xl font-extrabold text-gray-900">Rp 99K</span>
          </div>
          <p class="text-sm text-gray-400">Aktif 30 hari</p>
        </div>
        <ul class="space-y-3 mb-8 flex-1">
          <li class="flex items-center gap-3 text-sm text-gray-600"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>1 Undangan Digital</li>
          <li class="flex items-center gap-3 text-sm text-gray-600"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>5 Pilihan Tema</li>
          <li class="flex items-center gap-3 text-sm text-gray-600"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>RSVP Online</li>
          <li class="flex items-center gap-3 text-sm text-gray-600"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Countdown Timer</li>
          <li class="flex items-center gap-3 text-sm text-gray-300"><svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Background Music</li>
          <li class="flex items-center gap-3 text-sm text-gray-300"><svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Custom Domain</li>
        </ul>
        <a href="{{ route('register') }}" class="block text-center font-semibold text-rose-600 bg-rose-50 border border-rose-200 px-6 py-3 rounded-xl hover:bg-rose-100 transition">
          Pilih Basic
        </a>
      </div>

      <!-- Premium (Highlight) -->
      <div class="reveal card-hover relative bg-gradient-to-br from-rose-500 to-purple-600 rounded-2xl p-8 flex flex-col shadow-2xl shadow-rose-200 scale-105">
        <div class="absolute -top-4 left-1/2 -translate-x-1/2">
          <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-4 py-1.5 rounded-full shadow-md">⭐ Paling Populer</span>
        </div>
        <div class="mb-6">
          <p class="text-sm font-semibold text-rose-200 uppercase tracking-widest mb-2">Premium</p>
          <div class="flex items-end gap-1 mb-1">
            <span class="text-4xl font-extrabold text-white">Rp 199K</span>
          </div>
          <p class="text-sm text-rose-200">Aktif 90 hari</p>
        </div>
        <ul class="space-y-3 mb-8 flex-1">
          <li class="flex items-center gap-3 text-sm text-white"><svg class="w-5 h-5 text-yellow-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>1 Undangan Digital</li>
          <li class="flex items-center gap-3 text-sm text-white"><svg class="w-5 h-5 text-yellow-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>20+ Pilihan Tema</li>
          <li class="flex items-center gap-3 text-sm text-white"><svg class="w-5 h-5 text-yellow-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>RSVP Online</li>
          <li class="flex items-center gap-3 text-sm text-white"><svg class="w-5 h-5 text-yellow-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Countdown Timer</li>
          <li class="flex items-center gap-3 text-sm text-white"><svg class="w-5 h-5 text-yellow-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Background Music</li>
          <li class="flex items-center gap-3 text-sm text-white/60"><svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Custom Domain</li>
        </ul>
        <a href="{{ route('register') }}" class="block text-center font-semibold text-rose-600 bg-white px-6 py-3 rounded-xl hover:bg-rose-50 transition shadow-lg">
          Pilih Premium
        </a>
      </div>

      <!-- Exclusive -->
      <div class="reveal card-hover bg-white border border-gray-200 rounded-2xl p-8 flex flex-col">
        <div class="mb-6">
          <p class="text-sm font-semibold text-gray-500 uppercase tracking-widest mb-2">Exclusive</p>
          <div class="flex items-end gap-1 mb-1">
            <span class="text-4xl font-extrabold text-gray-900">Rp 349K</span>
          </div>
          <p class="text-sm text-gray-400">Aktif 180 hari</p>
        </div>
        <ul class="space-y-3 mb-8 flex-1">
          <li class="flex items-center gap-3 text-sm text-gray-600"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>1 Undangan Digital</li>
          <li class="flex items-center gap-3 text-sm text-gray-600"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Semua Tema (termasuk Eksklusif)</li>
          <li class="flex items-center gap-3 text-sm text-gray-600"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>RSVP Online</li>
          <li class="flex items-center gap-3 text-sm text-gray-600"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Countdown Timer</li>
          <li class="flex items-center gap-3 text-sm text-gray-600"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Background Music</li>
          <li class="flex items-center gap-3 text-sm text-gray-600"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Custom Domain</li>
        </ul>
        <a href="{{ route('register') }}" class="block text-center font-semibold text-rose-600 bg-rose-50 border border-rose-200 px-6 py-3 rounded-xl hover:bg-rose-100 transition">
          Pilih Exclusive
        </a>
      </div>

    </div>
  </div>
</section>

<!-- ======================== TESTIMONIALS ======================== -->
<section class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14 reveal">
      <p class="text-sm font-semibold text-purple-500 tracking-widest uppercase mb-3">Testimoni</p>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">Kata Mereka yang Sudah Pakai UNDIGI</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      <!-- Testi 1 -->
      <div class="reveal card-hover bg-gradient-to-br from-rose-50 to-white border border-rose-100 rounded-2xl p-6">
        <div class="flex items-center gap-1 mb-4">
          <span class="text-yellow-400 text-lg">★★★★★</span>
        </div>
        <p class="text-sm text-gray-600 leading-relaxed mb-5 italic">
          "Undangan kami jadi cantik banget! Banyak tamu yang tanya bikin di mana. Prosesnya cepat, hasilnya profesional."
        </p>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-rose-300 to-pink-400 flex items-center justify-center text-white font-bold text-sm">RA</div>
          <div>
            <p class="text-sm font-semibold text-gray-800">Rizky & Ayu</p>
            <p class="text-xs text-gray-400">Jakarta — Maret 2025</p>
          </div>
        </div>
      </div>

      <!-- Testi 2 -->
      <div class="reveal card-hover bg-gradient-to-br from-purple-50 to-white border border-purple-100 rounded-2xl p-6">
        <div class="flex items-center gap-1 mb-4">
          <span class="text-yellow-400 text-lg">★★★★★</span>
        </div>
        <p class="text-sm text-gray-600 leading-relaxed mb-5 italic">
          "Sangat mudah digunakan. Dalam 15 menit undangan sudah jadi dan langsung bisa dibagikan via WhatsApp. Recommended!"
        </p>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-300 to-indigo-400 flex items-center justify-center text-white font-bold text-sm">DM</div>
          <div>
            <p class="text-sm font-semibold text-gray-800">Dika & Mita</p>
            <p class="text-xs text-gray-400">Surabaya — Januari 2025</p>
          </div>
        </div>
      </div>

      <!-- Testi 3 -->
      <div class="reveal card-hover bg-gradient-to-br from-rose-50 to-white border border-rose-100 rounded-2xl p-6">
        <div class="flex items-center gap-1 mb-4">
          <span class="text-yellow-400 text-lg">★★★★★</span>
        </div>
        <p class="text-sm text-gray-600 leading-relaxed mb-5 italic">
          "Fitur RSVP onlinenya keren! Tidak perlu lagi repot rekap kehadiran manual. Harga juga sangat terjangkau."
        </p>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-300 to-orange-400 flex items-center justify-center text-white font-bold text-sm">FS</div>
          <div>
            <p class="text-sm font-semibold text-gray-800">Fajar & Sari</p>
            <p class="text-xs text-gray-400">Bandung — Februari 2025</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ======================== FAQ ======================== -->
<section id="faq" class="py-20 bg-gradient-to-br from-purple-50 via-white to-rose-50">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14 reveal">
      <p class="text-sm font-semibold text-rose-500 tracking-widest uppercase mb-3">FAQ</p>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">Pertanyaan yang Sering Diajukan</h2>
    </div>

    <div class="space-y-3">

      <div class="reveal bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <button class="faq-btn w-full flex items-center justify-between px-6 py-4 text-left" onclick="toggleFaq(this)">
          <span class="font-semibold text-gray-800 text-sm">Apakah bisa mencoba gratis sebelum membeli?</span>
          <svg class="faq-arrow w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div class="faq-content px-6 pb-4">
          <p class="text-sm text-gray-500 leading-relaxed">Ya! Kamu bisa mendaftar dan mulai membuat draft undangan secara gratis. Pembayaran hanya diperlukan saat kamu ingin mempublikasikan undangan.</p>
        </div>
      </div>

      <div class="reveal bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <button class="faq-btn w-full flex items-center justify-between px-6 py-4 text-left" onclick="toggleFaq(this)">
          <span class="font-semibold text-gray-800 text-sm">Berapa lama undangan aktif setelah dipublikasikan?</span>
          <svg class="faq-arrow w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div class="faq-content px-6 pb-4">
          <p class="text-sm text-gray-500 leading-relaxed">Tergantung paket yang dipilih: Basic aktif 30 hari, Premium 90 hari, dan Exclusive 180 hari sejak tanggal publikasi.</p>
        </div>
      </div>

      <div class="reveal bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <button class="faq-btn w-full flex items-center justify-between px-6 py-4 text-left" onclick="toggleFaq(this)">
          <span class="font-semibold text-gray-800 text-sm">Bagaimana cara membagikan link undangan?</span>
          <svg class="faq-arrow w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div class="faq-content px-6 pb-4">
          <p class="text-sm text-gray-500 leading-relaxed">Setelah undangan dipublikasikan, kamu akan mendapatkan link unik yang bisa langsung disalin dan dibagikan melalui WhatsApp, Instagram, SMS, atau media sosial lainnya.</p>
        </div>
      </div>

      <div class="reveal bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <button class="faq-btn w-full flex items-center justify-between px-6 py-4 text-left" onclick="toggleFaq(this)">
          <span class="font-semibold text-gray-800 text-sm">Bisakah saya mengedit undangan setelah dipublikasikan?</span>
          <svg class="faq-arrow w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div class="faq-content px-6 pb-4">
          <p class="text-sm text-gray-500 leading-relaxed">Ya, kamu masih bisa mengubah detail undangan kapan saja selama masa aktif berlangsung. Perubahan akan langsung terlihat di halaman undangan.</p>
        </div>
      </div>

      <div class="reveal bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <button class="faq-btn w-full flex items-center justify-between px-6 py-4 text-left" onclick="toggleFaq(this)">
          <span class="font-semibold text-gray-800 text-sm">Apakah ada batasan jumlah tamu yang bisa konfirmasi?</span>
          <svg class="faq-arrow w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div class="faq-content px-6 pb-4">
          <p class="text-sm text-gray-500 leading-relaxed">Tidak ada batasan! Semua paket mendukung jumlah RSVP tamu yang tidak terbatas. Tamu bisa mengisi konfirmasi kehadiran kapan saja.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ======================== FINAL CTA ======================== -->
<section class="py-24 bg-gradient-to-r from-rose-500 via-pink-500 to-purple-600 relative overflow-hidden">
  <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 25% 50%, white 1px, transparent 1px), radial-gradient(circle at 75% 50%, white 1px, transparent 1px); background-size: 40px 40px;"></div>
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
    <div class="reveal">
      <p class="text-rose-200 text-sm font-semibold tracking-widest uppercase mb-4">Mulai Sekarang</p>
      <h2 class="text-3xl sm:text-5xl font-extrabold text-white leading-tight mb-6">
        Siap Membuat Undangan Digital Impianmu?
      </h2>
      <p class="text-rose-100 text-lg mb-8">
        Bergabung bersama ribuan pasangan yang sudah mempercayakan undangan digital mereka kepada UNDIGI.
      </p>
      <a href="{{ route('register') }}" class="cta-primary" style="background: white; color: #e11d48; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
        Mulai Sekarang Gratis
      </a>
      <p class="text-rose-200 text-sm mt-4">Tidak perlu kartu kredit. Setup dalam 5 menit.</p>
    </div>
  </div>
</section>

<!-- ======================== FOOTER ======================== -->
<footer class="bg-gray-900 text-gray-400 pt-16 pb-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">

      <!-- Brand -->
      <div class="sm:col-span-2 lg:col-span-1">
        <div class="flex items-center gap-2 mb-4">
          <span class="text-2xl">💍</span>
          <span class="font-extrabold text-xl text-white tracking-tight">UNDIGI</span>
        </div>
        <p class="text-sm leading-relaxed mb-5">Platform undangan digital pernikahan modern. Elegan, praktis, dan terjangkau untuk pasangan Indonesia.</p>
        <!-- Social Icons -->
        <div class="flex items-center gap-3">
          <a href="#" aria-label="Instagram" class="w-9 h-9 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-rose-600 transition">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
          </a>
          <a href="#" aria-label="TikTok" class="w-9 h-9 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-rose-600 transition">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.16 8.16 0 004.77 1.52V6.76a4.85 4.85 0 01-1-.07z"/></svg>
          </a>
          <a href="#" aria-label="WhatsApp" class="w-9 h-9 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-green-600 transition">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          </a>
        </div>
      </div>

      <!-- Quick Links -->
      <div>
        <h3 class="text-white font-semibold text-sm mb-4">Produk</h3>
        <ul class="space-y-2.5 text-sm">
          <li><a href="#fitur" class="hover:text-white transition">Fitur</a></li>
          <li><a href="#tema" class="hover:text-white transition">Tema</a></li>
          <li><a href="#harga" class="hover:text-white transition">Harga</a></li>
          <li><a href="#faq" class="hover:text-white transition">FAQ</a></li>
        </ul>
      </div>

      <!-- Account -->
      <div>
        <h3 class="text-white font-semibold text-sm mb-4">Akun</h3>
        <ul class="space-y-2.5 text-sm">
          <li><a href="{{ route('register') }}" class="hover:text-white transition">Daftar Gratis</a></li>
          <li><a href="{{ route('login') }}" class="hover:text-white transition">Masuk</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div>
        <h3 class="text-white font-semibold text-sm mb-4">Kontak</h3>
        <ul class="space-y-2.5 text-sm">
          <li class="flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            hello@undigi.id
          </li>
          <li class="flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            +62 812-3456-7890
          </li>
        </ul>
      </div>

    </div>

    <div class="border-t border-gray-800 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
      <p>&copy; 2025 UNDIGI. Semua hak dilindungi.</p>
      <div class="flex gap-4">
        <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
        <a href="#" class="hover:text-white transition">Kebijakan Privasi</a>
      </div>
    </div>
  </div>
</footer>

<!-- ======================== STICKY CTA MOBILE ======================== -->
<div class="sticky-cta">
  <a href="{{ route('register') }}">🎉 Daftar Gratis Sekarang</a>
</div>

<!-- ======================== SCRIPTS ======================== -->
<script>
  // Navbar solid on scroll
  const navbar = document.getElementById('navbar');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 20) {
      navbar.classList.add('navbar-solid');
    } else {
      navbar.classList.remove('navbar-solid');
    }
  });

  // Mobile menu toggle
  const menuBtn = document.getElementById('menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  menuBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });

  // Close mobile menu on link click
  mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
  });

  // Scroll reveal
  const reveals = document.querySelectorAll('.reveal');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, { threshold: 0.1 });
  reveals.forEach(el => observer.observe(el));

  // Ripple effect on .cta-primary
  document.querySelectorAll('.cta-primary').forEach(btn => {
    btn.addEventListener('click', function(e) {
      const ripple = document.createElement('span');
      ripple.classList.add('ripple');
      const rect = this.getBoundingClientRect();
      ripple.style.left = (e.clientX - rect.left - 50) + 'px';
      ripple.style.top  = (e.clientY - rect.top  - 50) + 'px';
      this.appendChild(ripple);
      setTimeout(() => ripple.remove(), 650);
    });
  });

  // ── Theme Filter ──
  function filterThemes(category, btn) {
    // Update active pill
    document.querySelectorAll('.theme-pill').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');

    const cards = document.querySelectorAll('.theme-card-item');
    let visibleCount = 0;

    cards.forEach(card => {
      const cats = (card.dataset.categories || '').split(' ');
      const matches = category === 'all' || cats.includes(category);
      if (matches) {
        card.classList.remove('hiding');
        card.style.display = '';
        visibleCount++;
      } else {
        card.classList.add('hiding');
        // hide after transition
        setTimeout(() => {
          if (card.classList.contains('hiding')) card.style.display = 'none';
        }, 270);
      }
    });

    const emptyState = document.getElementById('theme-empty');
    if (emptyState) {
      emptyState.classList.toggle('hidden', visibleCount > 0);
    }
  }

  // FAQ accordion
  function toggleFaq(btn) {
    const content = btn.nextElementSibling;
    const arrow = btn.querySelector('.faq-arrow');
    const isOpen = content.classList.contains('open');

    // Close all
    document.querySelectorAll('.faq-content').forEach(c => c.classList.remove('open'));
    document.querySelectorAll('.faq-arrow').forEach(a => a.style.transform = '');

    if (!isOpen) {
      content.classList.add('open');
      arrow.style.transform = 'rotate(180deg)';
    }
  }
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan {{ $event->bride_name }} & {{ $event->groom_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&display=swap');
        .font-playfair { font-family: 'Playfair Display', serif; }
        .font-lato { font-family: 'Lato', sans-serif; }
    </style>
</head>
<body class="font-lato bg-stone-50 text-stone-800 antialiased">

    {{-- ============================================================ --}}
    {{-- HERO / COVER                                                  --}}
    {{-- ============================================================ --}}
    <section class="relative min-h-screen flex flex-col items-center justify-center text-center overflow-hidden bg-stone-900">

        {{-- Background cover image --}}
        @if ($event->cover_image)
            <img src="{{ asset('storage/' . $event->cover_image) }}"
                 alt="Cover"
                 class="absolute inset-0 w-full h-full object-cover opacity-40">
        @else
            <div class="absolute inset-0 bg-gradient-to-b from-stone-700 to-stone-900"></div>
        @endif

        <div class="relative z-10 px-6 py-16 max-w-md mx-auto">
            <p class="text-stone-300 text-sm tracking-[0.3em] uppercase mb-6">Undangan Pernikahan</p>

            <h1 class="font-playfair text-white text-5xl leading-tight mb-2">
                {{ $event->bride_name }}
            </h1>
            <p class="text-stone-300 text-2xl font-playfair italic mb-2">&amp;</p>
            <h1 class="font-playfair text-white text-5xl leading-tight mb-8">
                {{ $event->groom_name }}
            </h1>

            <div class="w-16 h-px bg-stone-400 mx-auto mb-6"></div>

            <p class="text-stone-200 text-sm tracking-widest uppercase">
                {{ $event->event_date->translatedFormat('l, d F Y') }}
            </p>
            <p class="text-stone-300 text-sm mt-1">
                Pukul {{ $event->event_date->format('H:i') }} WIB
            </p>

            {{-- Scroll hint --}}
            <div class="mt-12 animate-bounce">
                <svg class="w-6 h-6 text-stone-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- TANGGAL & HITUNG MUNDUR                                       --}}
    {{-- ============================================================ --}}
    <section class="py-16 px-6 bg-white text-center">
        <p class="text-xs tracking-[0.3em] uppercase text-stone-400 mb-4">Hari Bahagia Kami</p>
        <h2 class="font-playfair text-3xl text-stone-800 mb-2">
            {{ $event->event_date->translatedFormat('d F Y') }}
        </h2>
        <p class="text-stone-500 text-sm mb-8">Pukul {{ $event->event_date->format('H:i') }} WIB</p>

        {{-- Countdown --}}
        <div id="countdown" class="grid grid-cols-4 gap-3 max-w-xs mx-auto">
            @foreach (['hari' => 'days', 'jam' => 'hours', 'menit' => 'minutes', 'detik' => 'seconds'] as $label => $unit)
                <div class="bg-stone-100 rounded-xl p-3">
                    <p id="cd-{{ $unit }}" class="text-2xl font-bold text-stone-800">00</p>
                    <p class="text-xs text-stone-500 mt-1">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- LOKASI                                                        --}}
    {{-- ============================================================ --}}
    <section class="py-16 px-6 bg-stone-50 text-center">
        <p class="text-xs tracking-[0.3em] uppercase text-stone-400 mb-4">Lokasi Acara</p>
        <h2 class="font-playfair text-2xl text-stone-800 mb-4">Tempat & Waktu</h2>
        <div class="w-12 h-px bg-stone-300 mx-auto mb-6"></div>

        <div class="max-w-sm mx-auto">
            <p class="text-stone-600 leading-relaxed whitespace-pre-line">{{ $event->location }}</p>

            @if ($event->maps_link)
                <a href="{{ $event->maps_link }}" target="_blank" rel="noopener noreferrer"
                   class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-stone-800 text-white text-sm font-medium rounded-full hover:bg-stone-700 transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    Buka Google Maps
                </a>
            @endif
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- RSVP                                                          --}}
    {{-- ============================================================ --}}
    <section class="py-16 px-6 bg-white" id="rsvp">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <p class="text-xs tracking-[0.3em] uppercase text-stone-400 mb-2">Konfirmasi Kehadiran</p>
                <h2 class="font-playfair text-2xl text-stone-800">RSVP</h2>
                <div class="w-12 h-px bg-stone-300 mx-auto mt-4"></div>
            </div>

            {{-- Notifikasi sukses RSVP --}}
            @if (session('rsvp_success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm text-center">
                    {{ session('rsvp_success') }}
                </div>
            @endif

            <form action="{{ route('invitation.rsvp', $event->slug) }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full border border-stone-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-stone-400 bg-stone-50"
                           placeholder="Masukkan nama Anda">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1">Nomor WhatsApp <span class="text-stone-400">(opsional)</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           class="w-full border border-stone-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-stone-400 bg-stone-50"
                           placeholder="08xxxxxxxxxx">
                    @error('phone')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-2">Konfirmasi Kehadiran</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach (['hadir' => 'Hadir', 'tidak_hadir' => 'Tidak Hadir', 'pending' => 'Belum Pasti'] as $val => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="rsvp_status" value="{{ $val }}"
                                       class="sr-only peer"
                                       {{ old('rsvp_status', 'pending') === $val ? 'checked' : '' }}>
                                <div class="text-center border border-stone-200 rounded-xl py-3 text-xs font-medium text-stone-600
                                            peer-checked:bg-stone-800 peer-checked:text-white peer-checked:border-stone-800
                                            hover:bg-stone-50 transition">
                                    {{ $label }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('rsvp_status')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-3 bg-stone-800 text-white text-sm font-medium rounded-xl hover:bg-stone-700 transition">
                    Kirim Konfirmasi
                </button>
            </form>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- UCAPAN & DOA                                                  --}}
    {{-- ============================================================ --}}
    <section class="py-16 px-6 bg-stone-50" id="ucapan">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <p class="text-xs tracking-[0.3em] uppercase text-stone-400 mb-2">Kirimkan Doa Terbaik</p>
                <h2 class="font-playfair text-2xl text-stone-800">Ucapan & Doa</h2>
                <div class="w-12 h-px bg-stone-300 mx-auto mt-4"></div>
            </div>

            {{-- Notifikasi sukses ucapan --}}
            @if (session('wish_success'))
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm text-center">
                    {{ session('wish_success') }}
                </div>
            @endif

            {{-- Form Ucapan --}}
            <form action="{{ route('invitation.wish', $event->slug) }}" method="POST" class="space-y-4 mb-10">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1">Nama Anda</label>
                    <input type="text" name="guest_name" value="{{ old('guest_name') }}" required
                           class="w-full border border-stone-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-stone-400 bg-white"
                           placeholder="Nama pengirim ucapan">
                    @error('guest_name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1">Pesan & Doa</label>
                    <textarea name="message" rows="3" required
                              class="w-full border border-stone-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-stone-400 bg-white resize-none"
                              placeholder="Tuliskan ucapan dan doa terbaik Anda...">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-3 bg-rose-600 text-white text-sm font-medium rounded-xl hover:bg-rose-700 transition">
                    Kirim Ucapan
                </button>
            </form>

            {{-- Daftar Ucapan --}}
            @if ($event->wishes->isNotEmpty())
                <div class="space-y-4">
                    <p class="text-xs text-center text-stone-400 tracking-widest uppercase">
                        {{ $event->wishes->count() }} Ucapan
                    </p>
                    @foreach ($event->wishes as $wish)
                        <div class="bg-white rounded-xl p-4 shadow-sm">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-full bg-stone-200 flex items-center justify-center flex-shrink-0">
                                    <span class="text-sm font-semibold text-stone-600">
                                        {{ strtoupper(substr($wish->guest_name, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-stone-800">{{ $wish->guest_name }}</p>
                                    <p class="text-sm text-stone-600 mt-1 leading-relaxed">{{ $wish->message }}</p>
                                    <p class="text-xs text-stone-400 mt-2">
                                        {{ $wish->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-stone-400 text-sm">Belum ada ucapan. Jadilah yang pertama!</p>
            @endif

        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- FOOTER                                                        --}}
    {{-- ============================================================ --}}
    <footer class="py-10 bg-stone-900 text-center">
        <p class="font-playfair text-white text-lg italic">
            {{ $event->bride_name }} &amp; {{ $event->groom_name }}
        </p>
        <p class="text-stone-500 text-xs mt-2">{{ $event->event_date->translatedFormat('d F Y') }}</p>
        <p class="text-stone-600 text-xs mt-4">Dibuat dengan ❤ menggunakan Undangan Digital</p>
    </footer>

    {{-- Countdown Script --}}
    <script>
        const eventDate = new Date("{{ $event->event_date->toIso8601String() }}");

        function updateCountdown() {
            const now  = new Date();
            const diff = eventDate - now;

            if (diff <= 0) {
                document.getElementById('countdown').innerHTML =
                    '<p class="col-span-4 text-stone-500 text-sm">Hari pernikahan telah tiba! 🎉</p>';
                return;
            }

            const days    = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours   = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById('cd-days').textContent    = String(days).padStart(2, '0');
            document.getElementById('cd-hours').textContent   = String(hours).padStart(2, '0');
            document.getElementById('cd-minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('cd-seconds').textContent = String(seconds).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>

</body>
</html>

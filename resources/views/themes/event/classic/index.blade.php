<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title }} — Pemberitahuan</title>
    <meta name="description" content="{{ Str::limit(strip_tags($announcement->body), 150) }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @php
        $design        = $announcement->design_settings ?? [];
        $primary       = $design['primary_color']    ?? '#2563eb';
        $bg            = $design['background_color'] ?? '#ffffff';
        $textClr       = $design['text_color']       ?? '#111827';
        $endTime       = $design['end_time'] ?? ($announcement->ends_at?->toISOString() ?? null);
        $showCountdown = (bool) ($design['show_countdown'] ?? true);
        $showTimeline  = (bool) ($design['show_timeline']  ?? true);
        $contact       = $design['contact']  ?? null;
        $heading       = $design['heading']  ?? $announcement->title;
        $severityColor = match($announcement->severity) { 'critical' => '#dc2626', 'warning' => '#d97706', default => $primary };
        $severityBg    = match($announcement->severity) { 'critical' => '#fef2f2', 'warning' => '#fffbeb', default => '#eff6ff' };
        $severityLabel = match($announcement->severity) { 'critical' => 'Gangguan Kritis', 'warning' => 'Gangguan Sebagian', default => 'Pemberitahuan' };
    @endphp
    <style>
        body { font-family: 'Inter', sans-serif; background-color: {{ $bg }}; color: {{ $textClr }}; }
        :root { --primary: {{ $primary }}; }
        .accent       { color: var(--primary); }
        .accent-bg    { background-color: var(--primary); }
        .accent-border { border-color: var(--primary); }
        @keyframes pulse-dot { 0%,100%{opacity:1;} 50%{opacity:0.3;} }
        .pulse-dot { animation: pulse-dot 2s ease-in-out infinite; }
        .font-mono-num { font-feature-settings: "tnum"; font-variant-numeric: tabular-nums; }
        .countdown-box {
            background: color-mix(in srgb, var(--primary) 6%, transparent);
            border: 1px solid color-mix(in srgb, var(--primary) 18%, transparent);
        }
    </style>
</head>
<body class="min-h-screen">

    {{-- Top accent strip --}}
    <div class="h-1 w-full accent-bg"></div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-10 space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <a href="{{ config('app.url') }}" class="flex items-center gap-2 text-gray-400 hover:text-gray-700 transition">
                <img src="{{ config('app.url') }}/images/logo/undigi-logo.png"
                     onerror="this.style.display='none'"
                     alt="Logo" class="h-7 w-auto">
                <span class="text-sm font-semibold text-gray-700">Undigi</span>
            </a>
            <a href="{{ config('app.url') }}" class="text-xs text-gray-400 hover:text-gray-600 transition">
                ← Kembali ke beranda
            </a>
        </div>

        {{-- Severity Banner --}}
        <div class="flex items-center gap-3 rounded-xl px-4 py-3 border"
             style="background: {{ $severityBg }}; border-color: color-mix(in srgb, {{ $severityColor }} 30%, transparent);">
            <div class="w-2 h-2 rounded-full flex-shrink-0"
                 style="background: {{ $severityColor }};"></div>
            <div class="flex-1 min-w-0">
                <span class="text-xs font-bold uppercase tracking-wide" style="color: {{ $severityColor }}">{{ $severityLabel }}</span>
                @if ($announcement->computed_status === 'published')
                <span class="ml-3 inline-flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full pulse-dot bg-green-500"></span>
                    <span class="text-xs text-gray-500">Sedang berlangsung</span>
                </span>
                @elseif ($announcement->computed_status === 'resolved')
                <span class="ml-3 text-xs text-green-600 font-medium">✓ Sudah diselesaikan</span>
                @endif
            </div>
        </div>

        {{-- Main Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            {{-- Accent top border --}}
            <div class="h-0.5 w-full accent-bg"></div>

            <div class="p-6 sm:p-8 space-y-6">

                {{-- Icon + Heading --}}
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background: color-mix(in srgb, {{ $primary }} 10%, transparent);">
                        <svg class="w-5 h-5 accent" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-bold leading-tight pt-1" style="color: {{ $textClr }}">{{ $heading }}</h1>
                </div>

                {{-- Waktu --}}
                @if ($announcement->starts_at || $announcement->ends_at)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @if ($announcement->starts_at)
                    <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-100">
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-1">Mulai</p>
                        <p class="text-sm font-semibold" style="color: {{ $textClr }}">{{ $announcement->starts_at->isoFormat('D MMM YYYY') }}</p>
                        <p class="text-xs text-gray-500">{{ $announcement->starts_at->isoFormat('HH:mm') }} WITA</p>
                    </div>
                    @endif
                    @if ($announcement->ends_at)
                    <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-100">
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-1">Estimasi Selesai</p>
                        <p class="text-sm font-semibold" style="color: {{ $textClr }}">{{ $announcement->ends_at->isoFormat('D MMM YYYY') }}</p>
                        <p class="text-xs text-gray-500">{{ $announcement->ends_at->isoFormat('HH:mm') }} WITA</p>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Countdown --}}
                @if ($showCountdown && $endTime && $announcement->computed_status === 'published')
                <div id="countdown-wrap" class="countdown-box rounded-xl px-5 py-5 text-center">
                    <p class="text-xs font-medium text-gray-400 mb-2 uppercase tracking-wide">Estimasi Selesai Dalam</p>
                    <div id="countdown-display" class="font-mono-num text-4xl font-bold accent">--:--:--</div>
                    <p id="countdown-done" class="hidden text-green-600 font-semibold text-sm mt-2">✓ Layanan Sudah Kembali Normal</p>
                </div>
                @endif

                {{-- Body --}}
                <div class="text-sm leading-relaxed whitespace-pre-wrap text-gray-600">{{ $announcement->body }}</div>

                {{-- Kontak --}}
                @if ($contact)
                <div class="flex items-center gap-2 text-sm text-gray-500 pt-2 border-t border-gray-100">
                    <svg class="w-4 h-4 flex-shrink-0 accent" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 5.25v1.5z"/>
                    </svg>
                    <span>Butuh bantuan? Hubungi: <strong style="color: {{ $textClr }}">{{ $contact }}</strong></span>
                </div>
                @endif

            </div>
        </div>

        {{-- Timeline --}}
        @if ($showTimeline && $announcement->logs->isNotEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <h2 class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-6">Timeline Update</h2>
            <div class="space-y-0">
                @foreach ($announcement->logs as $log)
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-2.5 h-2.5 rounded-full mt-0.5 flex-shrink-0 accent-bg"></div>
                        @if (!$loop->last)
                        <div class="w-px flex-1 bg-gray-100 my-1"></div>
                        @endif
                    </div>
                    <div class="pb-5 flex-1 min-w-0">
                        <p class="text-sm text-gray-700">{{ $log->message }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $log->created_at->isoFormat('D MMM YYYY, HH:mm') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <p class="text-center text-xs text-gray-300 pb-4">
            Refresh halaman untuk melihat update terbaru.
        </p>

    </div>

    @if ($showCountdown && $endTime && $announcement->computed_status === 'published')
    <script>
    (function () {
        var target  = new Date("{{ $endTime }}").getTime();
        var display = document.getElementById('countdown-display');
        var done    = document.getElementById('countdown-done');

        function tick() {
            var diff = target - Date.now();
            if (diff <= 0) {
                if (display) display.style.display = 'none';
                if (done) done.classList.remove('hidden');
                return;
            }
            var h = Math.floor(diff / 3600000);
            var m = Math.floor((diff % 3600000) / 60000);
            var s = Math.floor((diff % 60000) / 1000);
            display.textContent = String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
        }
        tick();
        setInterval(tick, 1000);
    })();
    </script>
    @endif

</body>
</html>

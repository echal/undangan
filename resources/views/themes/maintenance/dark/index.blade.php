<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title }} — Status Sistem</title>
    <meta name="description" content="{{ Str::limit(strip_tags($announcement->body), 150) }}">
    @include('partials.og-meta')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @php
        $design   = $announcement->design_settings ?? [];
        $primary  = $design['primary_color']    ?? '#6366f1';
        $bg       = $design['background_color'] ?? '#020617';
        $textClr  = $design['text_color']       ?? '#f1f5f9';
        $endTime  = (isset($design['end_time']) && is_string($design['end_time']) && strlen(trim($design['end_time'])) > 0)
            ? \Carbon\Carbon::parse($design['end_time'])->utc()->toIso8601String()
            : ($announcement->ends_at?->utc()->toIso8601String() ?? null);
        $startTime = $announcement->starts_at?->utc()->toIso8601String() ?? null;
        $showCountdown = (bool) ($design['show_countdown'] ?? true);
        $showTimeline  = (bool) ($design['show_timeline']  ?? true);
        $contact  = $design['contact'] ?? null;
        $heading  = $design['heading'] ?? $announcement->title;
        $logoRaw  = $design['logo_url'] ?? null;
        $logoUrl  = $logoRaw
            ? (str_starts_with($logoRaw, '/storage/') ? rtrim(config('app.url'), '/') . $logoRaw : $logoRaw)
            : null;
        $severityBar = match($announcement->severity) { 'critical' => '#ef4444', 'warning' => '#f59e0b', default => '#6366f1' };
        $severityLabel = match($announcement->severity) { 'critical' => 'GANGGUAN KRITIS', 'warning' => 'GANGGUAN SEBAGIAN', default => 'PEMBERITAHUAN' };
    @endphp
    <style>
        body { font-family: 'Inter', sans-serif; background-color: {{ $bg }}; color: {{ $textClr }}; }
        :root { --primary: {{ $primary }}; --severity: {{ $severityBar }}; }
        .accent { color: var(--primary); }
        .accent-bg { background-color: var(--primary); }
        .accent-border { border-color: var(--primary); }
        .severity-bar { background-color: var(--severity); }
        .severity-badge { background-color: color-mix(in srgb, var(--severity) 15%, transparent); color: var(--severity); border: 1px solid color-mix(in srgb, var(--severity) 30%, transparent); }
        @keyframes spin-slow { to { transform: rotate(360deg); } }
        .spin-slow { animation: spin-slow 6s linear infinite; }
        @keyframes pulse-dot { 0%,100%{opacity:1;} 50%{opacity:0.4;} }
        .pulse-dot { animation: pulse-dot 2s ease-in-out infinite; }
        .timeline-line { background: color-mix(in srgb, {{ $textClr }} 15%, transparent); }
        .card-bg { background: color-mix(in srgb, white 5%, transparent); border: 1px solid color-mix(in srgb, white 10%, transparent); }
        .countdown-card { background: color-mix(in srgb, var(--primary) 10%, transparent); border: 1px solid color-mix(in srgb, var(--primary) 25%, transparent); }
        .font-mono-num { font-feature-settings: "tnum"; font-variant-numeric: tabular-nums; }
        .logo-glow { filter: drop-shadow(0 0 16px color-mix(in srgb, {{ $primary }} 60%, transparent)); }
        @keyframes progress-shine { 0%{background-position:200% center;} 100%{background-position:-200% center;} }
        .progress-bar {
            background: linear-gradient(90deg, {{ $primary }}, color-mix(in srgb, {{ $primary }} 60%, white), {{ $primary }});
            background-size: 200% auto;
            animation: progress-shine 3s linear infinite;
            transition: width 1s linear;
        }
        .progress-track { background: color-mix(in srgb, white 8%, transparent); }
    </style>
</head>
<body class="min-h-screen">

    {{-- Top severity bar --}}
    <div class="h-1 severity-bar w-full"></div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-10 space-y-8">

        {{-- Logo Center --}}
        <div class="flex justify-center pt-2 pb-1">
            @if ($logoUrl)
                <img src="{{ $logoUrl }}"
                     onerror="this.src='{{ config('app.url') }}/images/logo/undigi-logo.png'"
                     alt="{{ config('app.name') }}"
                     class="logo-glow w-auto max-w-[120px] sm:max-w-[160px] max-h-16 object-contain brightness-0 invert">
            @else
                <img src="{{ config('app.url') }}/images/logo/undigi-logo.png"
                     onerror="this.style.display='none'"
                     alt="{{ config('app.name') }}"
                     class="logo-glow w-auto max-w-[120px] sm:max-w-[160px] max-h-16 object-contain brightness-0 invert">
            @endif
        </div>

        {{-- Main Card --}}
        <div class="card-bg rounded-2xl p-6 sm:p-8 space-y-6">

            {{-- Gear icon + Badge --}}
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background: color-mix(in srgb, var(--primary) 15%, transparent);">
                    <svg class="w-6 h-6 spin-slow" style="color: {{ $primary }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <span class="severity-badge text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">
                        {{ $severityLabel }}
                    </span>
                    @if ($announcement->computed_status === 'published')
                    <div class="flex items-center gap-1.5 mt-1.5">
                        <span class="w-1.5 h-1.5 rounded-full pulse-dot" style="background: #22c55e;"></span>
                        <span class="text-xs opacity-60">Sedang berlangsung</span>
                    </div>
                    @elseif ($announcement->computed_status === 'resolved')
                    <div class="flex items-center gap-1.5 mt-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                        <span class="text-xs opacity-60">Sudah diselesaikan</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Heading --}}
            <h1 class="text-2xl sm:text-3xl font-bold leading-tight">{{ $heading }}</h1>

            {{-- Waktu --}}
            @if ($announcement->starts_at || $announcement->ends_at)
            <div class="flex flex-wrap gap-x-6 gap-y-1 text-sm opacity-60">
                @if ($announcement->starts_at)
                <span>📅 Mulai: <strong class="opacity-100">{{ $announcement->starts_at->setTimezone(config('app.timezone'))->isoFormat('D MMM YYYY, HH:mm') }} WITA</strong></span>
                @endif
                @if ($announcement->ends_at)
                <span>⏰ Selesai: <strong class="opacity-100">{{ $announcement->ends_at->setTimezone(config('app.timezone'))->isoFormat('D MMM YYYY, HH:mm') }} WITA</strong></span>
                @endif
            </div>
            @endif

            {{-- Countdown --}}
            @if ($showCountdown && $endTime && in_array($announcement->computed_status, ['published', 'resolved']))
            <div id="countdown-wrap" class="countdown-card rounded-xl p-5 text-center">
                <p class="text-xs font-semibold uppercase tracking-widest opacity-50 mb-3">Estimasi Selesai Dalam</p>
                <div id="countdown-display" class="font-mono-num text-5xl sm:text-6xl font-bold tracking-tight accent" style="visibility:hidden">
                </div>
                <p id="countdown-done" class="hidden text-green-400 font-semibold mt-2">✓ Sistem Sudah Kembali Online</p>
            </div>
            {{-- Progress Bar --}}
            @if ($startTime)
            <div>
                <div class="flex justify-between text-xs opacity-40 mb-1.5">
                    <span>Progress Pemeliharaan</span>
                    <span id="progress-pct">0%</span>
                </div>
                <div class="w-full progress-track rounded-full h-1.5 overflow-hidden">
                    <div id="progress-bar" class="progress-bar h-1.5 rounded-full" style="width:0%"></div>
                </div>
            </div>
            @endif
            @endif

            {{-- Body --}}
            <div class="text-sm leading-relaxed opacity-80 space-y-2 whitespace-pre-wrap">{{ $announcement->body }}</div>

            {{-- Kontak --}}
            @if ($contact)
            <div class="flex items-center gap-2 text-sm opacity-60">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 5.25v1.5z"/>
                </svg>
                <span>Hubungi: <strong class="opacity-100">{{ $contact }}</strong></span>
            </div>
            @endif
        </div>

        {{-- Timeline --}}
        @if ($showTimeline && $announcement->logs->isNotEmpty())
        <div class="card-bg rounded-2xl p-6 sm:p-8">
            <h2 class="text-xs font-semibold uppercase tracking-widest opacity-50 mb-6">Timeline Update</h2>
            <div class="space-y-0">
                @foreach ($announcement->logs as $log)
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-2.5 h-2.5 rounded-full mt-0.5 flex-shrink-0 z-10 accent-bg"></div>
                        @if (!$loop->last)
                        <div class="w-px flex-1 timeline-line my-1"></div>
                        @endif
                    </div>
                    <div class="pb-5 flex-1 min-w-0">
                        <p class="text-sm">{{ $log->message }}</p>
                        <p class="text-xs opacity-40 mt-1 log-time" data-ts="{{ $log->created_at->utc()->timestamp }}">
                            {{ $log->created_at->utc()->timestamp }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Footer --}}
        <p class="text-center text-xs opacity-30 pb-4">
            Refresh halaman untuk melihat update terbaru.
        </p>

    </div>

    @if ($showCountdown && $endTime && in_array($announcement->computed_status, ['published', 'resolved']))
    <script>
    (function () {
        var target  = new Date("{{ $endTime }}").getTime();
        var start   = {{ $startTime ? 'new Date("'.$startTime.'").getTime()' : 'null' }};
        var display = document.getElementById('countdown-display');
        var done    = document.getElementById('countdown-done');
        var bar     = document.getElementById('progress-bar');
        var pct     = document.getElementById('progress-pct');

        // Guard: jika date invalid (NaN) sembunyikan box dan keluar
        if (isNaN(target)) {
            var wrap = document.getElementById('countdown-wrap');
            if (wrap) wrap.style.display = 'none';
            var pb = document.getElementById('progress-bar');
            if (pb) pb.closest('div').style.display = 'none';
            return;
        }

        function tick() {
            var now  = Date.now();
            var diff = target - now;

            if (bar && start && !isNaN(start)) {
                var total    = target - start;
                var elapsed  = now - start;
                var progress = total > 0 ? Math.min(100, Math.max(0, (elapsed / total) * 100)) : 0;
                bar.style.width = progress.toFixed(1) + '%';
                if (pct) pct.textContent = Math.floor(progress) + '%';
            }

            if (diff <= 0) {
                if (display) display.style.display = 'none';
                if (done) done.classList.remove('hidden');
                if (bar) bar.style.width = '100%';
                if (pct) pct.textContent = '100%';
                return;
            }
            var h = Math.floor(diff / 3600000);
            var m = Math.floor((diff % 3600000) / 60000);
            var s = Math.floor((diff % 60000) / 1000);
            display.textContent = String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
            display.style.visibility = 'visible';
        }
        tick();
        setInterval(tick, 1000);
    })();
    </script>
    @endif

    {{-- Render timeline timestamps di frontend → tidak bergantung pada PHP/server timezone --}}
    <script>
    (function () {
        var TZ = 'Asia/Makassar';
        var fmt = new Intl.DateTimeFormat('id-ID', {
            timeZone: TZ,
            day: 'numeric', month: 'short', year: 'numeric',
            hour: '2-digit', minute: '2-digit', hour12: false
        });
        document.querySelectorAll('.log-time').forEach(function (el) {
            var ts = parseInt(el.dataset.ts, 10);
            if (!isNaN(ts)) {
                el.textContent = fmt.format(new Date(ts * 1000));
            }
        });
    })();
    </script>

</body>
</html>

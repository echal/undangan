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
        $primary  = $design['primary_color']    ?? '#4f46e5';
        $bg       = $design['background_color'] ?? '#f8fafc';
        $textClr  = $design['text_color']       ?? '#0f172a';
        $endTime  = isset($design['end_time']) && $design['end_time']
            ? \Carbon\Carbon::parse($design['end_time'])->toIso8601String()
            : ($announcement->ends_at?->toIso8601String() ?? null);
        $startTime = $announcement->starts_at?->toIso8601String() ?? null;
        $showCountdown = (bool) ($design['show_countdown'] ?? true);
        $showTimeline  = (bool) ($design['show_timeline']  ?? true);
        $contact  = $design['contact'] ?? null;
        $heading  = $design['heading'] ?? $announcement->title;
        $logoRaw  = $design['logo_url'] ?? null;
        $logoUrl  = $logoRaw
            ? (str_starts_with($logoRaw, '/storage/') ? rtrim(config('app.url'), '/') . $logoRaw : $logoRaw)
            : null;
        $severityColor = match($announcement->severity) { 'critical' => '#ef4444', 'warning' => '#f59e0b', default => '#4f46e5' };
        $severityLabel = match($announcement->severity) { 'critical' => 'Gangguan Kritis', 'warning' => 'Gangguan Sebagian', default => 'Pemberitahuan' };
        $severityBg = match($announcement->severity) { 'critical' => '#fef2f2', 'warning' => '#fffbeb', default => '#eef2ff' };
    @endphp
    <style>
        body { font-family: 'Inter', sans-serif; background-color: {{ $bg }}; color: {{ $textClr }}; }
        :root { --primary: {{ $primary }}; }
        .accent { color: var(--primary); }
        .accent-bg { background-color: var(--primary); }
        @keyframes spin-slow { to { transform: rotate(360deg); } }
        .spin-slow { animation: spin-slow 8s linear infinite; }
        @keyframes pulse-dot { 0%,100%{opacity:1;} 50%{opacity:0.3;} }
        .pulse-dot { animation: pulse-dot 2s ease-in-out infinite; }
        .font-mono-num { font-feature-settings: "tnum"; font-variant-numeric: tabular-nums; }
        .logo-glow { filter: drop-shadow(0 0 12px color-mix(in srgb, {{ $primary }} 50%, transparent)); }
        @keyframes progress-shine { 0%{background-position:200% center;} 100%{background-position:-200% center;} }
        .progress-bar {
            background: linear-gradient(90deg, {{ $primary }}, color-mix(in srgb, {{ $primary }} 70%, white), {{ $primary }});
            background-size: 200% auto;
            animation: progress-shine 3s linear infinite;
            transition: width 1s linear;
        }
    </style>
</head>
<body class="min-h-screen">

    {{-- Top bar --}}
    <div class="h-1 w-full" style="background: {{ $primary }};"></div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-10 space-y-6">

        {{-- Logo Center --}}
        <div class="flex justify-center pt-2 pb-1">
            @if ($logoUrl)
                <img src="{{ $logoUrl }}"
                     onerror="this.src='{{ config('app.url') }}/images/logo/undigi-logo.png'"
                     alt="{{ config('app.name') }}"
                     class="logo-glow w-auto max-w-[120px] sm:max-w-[160px] max-h-16 object-contain">
            @else
                <img src="{{ config('app.url') }}/images/logo/undigi-logo.png"
                     onerror="this.style.display='none'"
                     alt="{{ config('app.name') }}"
                     class="logo-glow w-auto max-w-[120px] sm:max-w-[160px] max-h-16 object-contain">
            @endif
        </div>

        {{-- Severity Banner --}}
        <div class="rounded-xl border px-4 py-3 flex items-center gap-3"
             style="background: {{ $severityBg }}; border-color: color-mix(in srgb, {{ $severityColor }} 25%, transparent);">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                 style="background: color-mix(in srgb, {{ $severityColor }} 15%, transparent);">
                @if ($announcement->severity === 'critical')
                <svg class="w-4 h-4" style="color: {{ $severityColor }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
                @elseif ($announcement->severity === 'warning')
                <svg class="w-4 h-4" style="color: {{ $severityColor }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                </svg>
                @else
                <svg class="w-4 h-4" style="color: {{ $severityColor }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                </svg>
                @endif
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wide" style="color: {{ $severityColor }}">{{ $severityLabel }}</p>
                @if ($announcement->computed_status === 'published')
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full pulse-dot bg-green-500"></span>
                    <span class="text-xs text-slate-500">Sedang berlangsung</span>
                </div>
                @elseif ($announcement->computed_status === 'resolved')
                <p class="text-xs text-green-600 mt-0.5 font-medium">✓ Sudah Diselesaikan</p>
                @endif
            </div>
        </div>

        {{-- Main Card --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8 space-y-5">

            {{-- Wrench icon + Title --}}
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5"
                     style="background: color-mix(in srgb, {{ $primary }} 10%, transparent);">
                    <svg class="w-5 h-5 spin-slow" style="color: {{ $primary }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>
                    </svg>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 leading-tight">{{ $heading }}</h1>
            </div>

            {{-- Waktu --}}
            @if ($announcement->starts_at || $announcement->ends_at)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @if ($announcement->starts_at)
                <div class="bg-slate-50 rounded-lg px-4 py-3">
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wide mb-0.5">Dimulai</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $announcement->starts_at->setTimezone(config('app.timezone'))->isoFormat('D MMM YYYY') }}</p>
                    <p class="text-xs text-slate-500">{{ $announcement->starts_at->setTimezone(config('app.timezone'))->isoFormat('HH:mm') }} WITA</p>
                </div>
                @endif
                @if ($announcement->ends_at)
                <div class="bg-slate-50 rounded-lg px-4 py-3">
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wide mb-0.5">Estimasi Selesai</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $announcement->ends_at->setTimezone(config('app.timezone'))->isoFormat('D MMM YYYY') }}</p>
                    <p class="text-xs text-slate-500">{{ $announcement->ends_at->setTimezone(config('app.timezone'))->isoFormat('HH:mm') }} WITA</p>
                </div>
                @endif
            </div>
            @endif

            {{-- Countdown --}}
            @if ($showCountdown && $endTime && in_array($announcement->computed_status, ['published', 'resolved']))
            <div id="countdown-wrap" class="rounded-xl px-5 py-4 text-center"
                 style="background: color-mix(in srgb, {{ $primary }} 8%, transparent); border: 1px solid color-mix(in srgb, {{ $primary }} 20%, transparent);">
                <p class="text-xs font-medium text-slate-400 mb-2">Estimasi Selesai Dalam</p>
                <div id="countdown-display" class="font-mono-num text-4xl font-bold accent">--:--:--</div>
                <p id="countdown-done" class="hidden text-green-600 font-semibold text-sm mt-2">✓ Sistem Sudah Kembali Online</p>
            </div>
            {{-- Progress Bar --}}
            @if ($startTime)
            <div>
                <div class="flex justify-between text-xs text-slate-400 mb-1.5">
                    <span>Progress Pemeliharaan</span>
                    <span id="progress-pct">0%</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                    <div id="progress-bar" class="progress-bar h-2 rounded-full" style="width:0%"></div>
                </div>
            </div>
            @endif
            @endif

            {{-- Body --}}
            <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-wrap">{{ $announcement->body }}</div>

            {{-- Kontak --}}
            @if ($contact)
            <div class="flex items-center gap-2 text-sm text-slate-500 pt-1 border-t border-slate-100">
                <svg class="w-4 h-4 flex-shrink-0 accent" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 5.25v1.5z"/>
                </svg>
                <span>Butuh bantuan? Hubungi: <strong class="text-slate-800">{{ $contact }}</strong></span>
            </div>
            @endif
        </div>

        {{-- Timeline --}}
        @if ($showTimeline && $announcement->logs->isNotEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
            <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-6">Timeline Update</h2>
            <div class="space-y-0">
                @foreach ($announcement->logs as $log)
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-2.5 h-2.5 rounded-full mt-0.5 flex-shrink-0 accent-bg"></div>
                        @if (!$loop->last)
                        <div class="w-px flex-1 bg-slate-100 my-1"></div>
                        @endif
                    </div>
                    <div class="pb-5 flex-1 min-w-0">
                        <p class="text-sm text-slate-700">{{ $log->message }}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ $log->created_at->setTimezone(config('app.timezone'))->isoFormat('D MMM YYYY, HH:mm') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <p class="text-center text-xs text-slate-300 pb-4">
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

        function tick() {
            var now  = Date.now();
            var diff = target - now;

            // Progress bar
            if (bar && start) {
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
        }
        tick();
        setInterval(tick, 1000);
    })();
    </script>
    @endif

</body>
</html>

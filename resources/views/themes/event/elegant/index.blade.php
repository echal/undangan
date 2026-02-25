<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title }} — Pemberitahuan</title>
    <meta name="description" content="{{ Str::limit(strip_tags($announcement->body), 150) }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @php
        $design        = $announcement->design_settings ?? [];
        $primary       = $design['primary_color']    ?? '#d97706';
        $bg            = $design['background_color'] ?? '#0f0a00';
        $textClr       = $design['text_color']       ?? '#f5f0e8';
        $endTime       = $design['end_time'] ?? ($announcement->ends_at?->toISOString() ?? null);
        $showCountdown = (bool) ($design['show_countdown'] ?? true);
        $showTimeline  = (bool) ($design['show_timeline']  ?? true);
        $contact       = $design['contact']  ?? null;
        $heading       = $design['heading']  ?? $announcement->title;
        $severityColor = match($announcement->severity) { 'critical' => '#ef4444', 'warning' => '#f59e0b', default => $primary };
        $severityLabel = match($announcement->severity) { 'critical' => 'Gangguan Kritis', 'warning' => 'Gangguan Sebagian', default => 'Pemberitahuan' };
    @endphp
    <style>
        body { font-family: 'Inter', sans-serif; background-color: {{ $bg }}; color: {{ $textClr }}; }
        h1, h2 { font-family: 'Playfair Display', serif; }
        :root { --primary: {{ $primary }}; --severity: {{ $severityColor }}; }
        .gold { color: var(--primary); }
        .gold-border { border-color: var(--primary); }
        .gold-bg { background-color: var(--primary); }
        .divider {
            display: flex; align-items: center; gap: 12px;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px;
            background: linear-gradient(to right, transparent, var(--primary), transparent);
        }
        @keyframes glow-pulse {
            0%, 100% { box-shadow: 0 0 8px 0 color-mix(in srgb, var(--primary) 40%, transparent); }
            50%       { box-shadow: 0 0 20px 4px color-mix(in srgb, var(--primary) 60%, transparent); }
        }
        .glow { animation: glow-pulse 3s ease-in-out infinite; }
        @keyframes pulse-dot { 0%,100%{opacity:1;} 50%{opacity:0.3;} }
        .pulse-dot { animation: pulse-dot 2s ease-in-out infinite; }
        .font-mono-num { font-feature-settings: "tnum"; font-variant-numeric: tabular-nums; }
        .severity-badge {
            background: color-mix(in srgb, var(--severity) 15%, transparent);
            border: 1px solid color-mix(in srgb, var(--severity) 35%, transparent);
            color: var(--severity);
        }
        .card {
            background: color-mix(in srgb, var(--primary) 5%, #1a1200);
            border: 1px solid color-mix(in srgb, var(--primary) 20%, transparent);
        }
        .countdown-ring {
            background: color-mix(in srgb, var(--primary) 8%, transparent);
            border: 1px solid color-mix(in srgb, var(--primary) 25%, transparent);
        }
        .timeline-line { background: color-mix(in srgb, var(--primary) 30%, transparent); }
        .timeline-dot { background-color: var(--primary); }
    </style>
</head>
<body class="min-h-screen">

    {{-- Top accent line --}}
    <div class="h-px w-full" style="background: linear-gradient(to right, transparent, {{ $primary }}, transparent);"></div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-10 space-y-8">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <a href="{{ config('app.url') }}" class="flex items-center gap-2 opacity-60 hover:opacity-100 transition">
                <img src="{{ config('app.url') }}/images/logo/undigi-logo.png"
                     onerror="this.style.display='none'"
                     alt="Logo" class="h-7 w-auto">
                <span class="text-sm font-semibold" style="color: {{ $textClr }}">Undigi</span>
            </a>
            <a href="{{ config('app.url') }}" class="text-xs opacity-50 hover:opacity-80 transition" style="color: {{ $textClr }}">
                ← Beranda
            </a>
        </div>

        {{-- Severity Badge --}}
        <div class="flex items-center justify-center">
            <span class="severity-badge px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest">
                {{ $severityLabel }}
                @if ($announcement->computed_status === 'published')
                <span class="ml-2 inline-flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full pulse-dot" style="background: var(--severity);"></span>
                    <span class="font-normal normal-case tracking-normal">Sedang berlangsung</span>
                </span>
                @elseif ($announcement->computed_status === 'resolved')
                <span class="ml-2 font-normal normal-case tracking-normal">✓ Diselesaikan</span>
                @endif
            </span>
        </div>

        {{-- Main Card --}}
        <div class="card rounded-2xl p-8 sm:p-10 space-y-8 glow">

            {{-- Ornament + Heading --}}
            <div class="text-center space-y-4">
                <div class="flex justify-center">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center"
                         style="background: color-mix(in srgb, {{ $primary }} 15%, transparent); border: 1px solid color-mix(in srgb, {{ $primary }} 30%, transparent);">
                        <svg class="w-6 h-6 gold" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                    </div>
                </div>

                <div class="divider">
                    <span class="text-xs uppercase tracking-[0.3em] gold font-medium">Pemberitahuan Resmi</span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-bold leading-tight" style="color: {{ $textClr }}">
                    {{ $heading }}
                </h1>

                <div class="divider"></div>
            </div>

            {{-- Waktu --}}
            @if ($announcement->starts_at || $announcement->ends_at)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @if ($announcement->starts_at)
                <div class="text-center rounded-xl px-4 py-4"
                     style="background: color-mix(in srgb, {{ $primary }} 8%, transparent); border: 1px solid color-mix(in srgb, {{ $primary }} 20%, transparent);">
                    <p class="text-xs uppercase tracking-widest gold mb-2 font-medium">Dimulai</p>
                    <p class="text-lg font-semibold" style="color: {{ $textClr }}">{{ $announcement->starts_at->isoFormat('D MMM YYYY') }}</p>
                    <p class="text-sm opacity-60" style="color: {{ $textClr }}">{{ $announcement->starts_at->isoFormat('HH:mm') }} WITA</p>
                </div>
                @endif
                @if ($announcement->ends_at)
                <div class="text-center rounded-xl px-4 py-4"
                     style="background: color-mix(in srgb, {{ $primary }} 8%, transparent); border: 1px solid color-mix(in srgb, {{ $primary }} 20%, transparent);">
                    <p class="text-xs uppercase tracking-widest gold mb-2 font-medium">Estimasi Selesai</p>
                    <p class="text-lg font-semibold" style="color: {{ $textClr }}">{{ $announcement->ends_at->isoFormat('D MMM YYYY') }}</p>
                    <p class="text-sm opacity-60" style="color: {{ $textClr }}">{{ $announcement->ends_at->isoFormat('HH:mm') }} WITA</p>
                </div>
                @endif
            </div>
            @endif

            {{-- Countdown --}}
            @if ($showCountdown && $endTime && $announcement->computed_status === 'published')
            <div id="countdown-wrap" class="countdown-ring rounded-2xl px-6 py-6 text-center space-y-2">
                <p class="text-xs uppercase tracking-widest gold font-medium">Selesai Dalam</p>
                <div id="countdown-display" class="font-mono-num text-5xl font-bold gold">--:--:--</div>
                <p id="countdown-done" class="hidden text-sm font-medium" style="color: #4ade80;">✓ Layanan Sudah Kembali Normal</p>
            </div>
            @endif

            {{-- Body --}}
            <div class="text-sm leading-relaxed whitespace-pre-wrap opacity-80" style="color: {{ $textClr }}">{{ $announcement->body }}</div>

            {{-- Kontak --}}
            @if ($contact)
            <div class="pt-2 border-t" style="border-color: color-mix(in srgb, {{ $primary }} 20%, transparent);">
                <div class="flex items-center gap-2 text-sm opacity-70" style="color: {{ $textClr }}">
                    <svg class="w-4 h-4 flex-shrink-0 gold" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 5.25v1.5z"/>
                    </svg>
                    <span>Hubungi: <strong class="gold">{{ $contact }}</strong></span>
                </div>
            </div>
            @endif

        </div>

        {{-- Timeline --}}
        @if ($showTimeline && $announcement->logs->isNotEmpty())
        <div class="card rounded-2xl p-6 sm:p-8 space-y-6">
            <div class="divider">
                <span class="text-xs uppercase tracking-widest gold font-medium">Timeline Update</span>
            </div>
            <div class="space-y-0">
                @foreach ($announcement->logs as $log)
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-2 h-2 rounded-full mt-1 flex-shrink-0 timeline-dot"></div>
                        @if (!$loop->last)
                        <div class="w-px flex-1 my-1 timeline-line"></div>
                        @endif
                    </div>
                    <div class="pb-5 flex-1 min-w-0">
                        <p class="text-sm" style="color: {{ $textClr }}">{{ $log->message }}</p>
                        <p class="text-xs opacity-40 mt-1" style="color: {{ $textClr }}">{{ $log->created_at->isoFormat('D MMM YYYY, HH:mm') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <p class="text-center text-xs opacity-20 pb-4" style="color: {{ $textClr }}">
            Refresh halaman untuk melihat update terbaru.
        </p>

    </div>

    {{-- Bottom accent line --}}
    <div class="h-px w-full" style="background: linear-gradient(to right, transparent, {{ $primary }}, transparent);"></div>

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

<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title }} — Status</title>
    <meta name="description" content="{{ Str::limit($announcement->body, 150) }}">
    @include('partials.og-meta')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @media (prefers-color-scheme: dark) {
            html { color-scheme: dark; }
            body { background-color: #0f172a; color: #e2e8f0; }
        }
    </style>
</head>
<body class="min-h-full bg-slate-50 dark:bg-slate-900 text-gray-800 dark:text-gray-200">

    {{-- Top colored bar berdasarkan severity --}}
    @php
        $severity = $announcement->severity;
        $barColor = match($severity) {
            'critical' => 'bg-red-500',
            'warning'  => 'bg-amber-400',
            default    => 'bg-blue-500',
        };
        $badgeBg  = match($severity) {
            'critical' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400',
            'warning'  => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400',
            default    => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400',
        };
        $badgeLabel = match($severity) {
            'critical' => 'Gangguan Kritis',
            'warning'  => 'Gangguan Sebagian',
            default    => 'Pemberitahuan',
        };
        $statusColor = match($announcement->computed_status) {
            'published' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400',
            'resolved'  => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
            default     => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-400',
        };
        $statusLabel = match($announcement->computed_status) {
            'published' => 'Sedang Berlangsung',
            'resolved'  => 'Sudah Diselesaikan',
            default     => 'Dalam Investigasi',
        };
    @endphp
    <div class="h-1.5 {{ $barColor }} w-full"></div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-10 space-y-8">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <a href="{{ config('app.url') }}" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition">
                <img src="{{ config('app.url') }}/images/logo/undigi-logo.png"
                     onerror="this.style.display='none'"
                     alt="Logo" class="h-7 w-auto">
                <span class="font-semibold text-gray-700 dark:text-gray-300">Undigi</span>
            </a>
            <a href="{{ config('app.url') }}" class="text-sm text-gray-400 dark:text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition">
                ← Kembali ke beranda
            </a>
        </div>

        {{-- Main Card --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-5">

            {{-- Badges --}}
            <div class="flex flex-wrap gap-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badgeBg }}">
                    {{ $badgeLabel }}
                </span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusColor }}">
                    @if ($announcement->computed_status === 'published')
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                    @endif
                    {{ $statusLabel }}
                </span>
            </div>

            {{-- Title --}}
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white leading-tight">
                {{ $announcement->title }}
            </h1>

            {{-- Time --}}
            <div class="flex flex-wrap gap-x-6 gap-y-1 text-sm text-gray-400 dark:text-gray-500">
                @if ($announcement->starts_at)
                <span>Mulai: <strong class="text-gray-600 dark:text-gray-300">{{ $announcement->starts_at->isoFormat('D MMM YYYY, HH:mm') }}</strong></span>
                @endif
                @if ($announcement->ends_at)
                <span>Estimasi selesai: <strong class="text-gray-600 dark:text-gray-300">{{ $announcement->ends_at->isoFormat('D MMM YYYY, HH:mm') }}</strong></span>
                @endif
            </div>

            {{-- Countdown (jika ada ends_at dan belum resolved) --}}
            @if ($announcement->ends_at && $announcement->computed_status === 'published')
            <div id="countdown-wrap" class="flex items-center gap-3 p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700">
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Estimasi selesai dalam:
                    <strong id="countdown" class="text-gray-800 dark:text-gray-100 font-mono text-base ml-1">--:--:--</strong>
                </p>
            </div>
            @endif

            {{-- Body --}}
            <div class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed">
                {!! nl2br(e($announcement->body)) !!}
            </div>

        </div>

        {{-- Timeline --}}
        @if ($announcement->logs->isNotEmpty())
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm p-6 sm:p-8">
            <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide mb-5">Timeline Update</h2>
            <div class="space-y-0">
                @foreach ($announcement->logs as $log)
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-2.5 h-2.5 rounded-full border-2 border-indigo-400 dark:border-indigo-500 bg-white dark:bg-slate-800 mt-0.5 flex-shrink-0 z-10"></div>
                        @if (!$loop->last)
                            <div class="w-px flex-1 bg-gray-100 dark:bg-slate-700 my-1"></div>
                        @endif
                    </div>
                    <div class="pb-5 flex-1 min-w-0">
                        <p class="text-sm text-gray-700 dark:text-gray-200">{{ $log->message }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                            {{ $log->created_at->isoFormat('D MMM YYYY, HH:mm') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Footer --}}
        <p class="text-center text-xs text-gray-400 dark:text-gray-500 pb-6">
            Halaman ini diperbarui secara real-time. Refresh untuk melihat update terbaru.
        </p>

    </div>

    {{-- Countdown JS --}}
    @if ($announcement->ends_at && $announcement->computed_status === 'published')
    <script>
        (function () {
            var target = new Date("{{ $announcement->ends_at->toISOString() }}").getTime();
            var el = document.getElementById('countdown');
            var wrap = document.getElementById('countdown-wrap');

            function tick() {
                var diff = target - Date.now();
                if (diff <= 0) {
                    if (wrap) wrap.style.display = 'none';
                    return;
                }
                var h = Math.floor(diff / 3600000);
                var m = Math.floor((diff % 3600000) / 60000);
                var s = Math.floor((diff % 60000) / 1000);
                el.textContent = String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
            }

            tick();
            setInterval(tick, 1000);
        })();
    </script>
    @endif

</body>
</html>

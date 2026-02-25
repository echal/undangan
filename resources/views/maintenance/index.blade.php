<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Maintenance — UNDIGI</title>
    <link rel="icon" href="{{ config('app.url') }}/images/logo/undigi-logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
        * { font-family: 'Inter', sans-serif; }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
        .spin-slow {
            animation: spin-slow 4s linear infinite;
        }

        @media (prefers-color-scheme: dark) {
            body {
                background-color: #0f172a !important;
            }
            .maintenance-card {
                background-color: #1e293b !important;
                border-color: #334155 !important;
            }
            .card-title {
                color: #f1f5f9 !important;
            }
            .card-subtitle {
                color: #94a3b8 !important;
            }
            .card-footer {
                color: #475569 !important;
            }
            .gear-bg {
                background-color: #0f172a !important;
            }
            .gear-icon {
                color: #64748b !important;
            }
            .countdown-tile {
                background-color: #0f172a !important;
                border-color: #334155 !important;
            }
            .countdown-number {
                color: #f1f5f9 !important;
            }
            .countdown-unit {
                color: #475569 !important;
            }
            .divider {
                border-color: #334155 !important;
            }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center px-4 py-12">

    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="flex justify-center mb-8">
            <img
                src="{{ config('app.url') }}/images/logo/undigi-logo.png"
                alt="UNDIGI"
                class="h-9"
                onerror="this.style.display='none'"
            />
        </div>

        {{-- Card --}}
        <div class="maintenance-card bg-white rounded-2xl border border-slate-200 shadow-xl shadow-slate-200/60 p-8 sm:p-10 text-center">

            {{-- Gear Icon --}}
            <div class="flex justify-center mb-6">
                <div class="gear-bg w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center">
                    <svg class="spin-slow gear-icon w-9 h-9 text-slate-400"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724
                               1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724
                               1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724
                               1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724
                               1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724
                               1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724
                               1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724
                               1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608
                               2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>

            {{-- Status Badge --}}
            <div class="inline-flex items-center gap-2 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold px-4 py-1.5 rounded-full mb-5">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                Dalam Maintenance
            </div>

            {{-- Title --}}
            <h1 class="card-title text-2xl sm:text-3xl font-extrabold text-slate-900 mb-3 leading-tight">
                Sistem Sedang<br/>Maintenance
            </h1>

            {{-- Subtitle --}}
            <p class="card-subtitle text-slate-500 text-sm sm:text-base leading-relaxed mb-6 max-w-xs mx-auto">
                Kami sedang melakukan peningkatan sistem untuk memberikan pengalaman yang lebih baik. Mohon bersabar sebentar.
            </p>

            {{-- Countdown (hanya tampil jika ada maintenance_end_at) --}}
            @if($maintenanceEndAt)
            <div id="countdown-section" class="mb-6">
                <div class="divider border-t border-slate-100 mb-5"></div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-3">
                    Estimasi Selesai
                </p>
                <div class="grid grid-cols-4 gap-2">
                    <div class="countdown-tile bg-slate-50 border border-slate-200 rounded-xl py-3 px-1">
                        <p id="cd-days" class="countdown-number text-xl sm:text-2xl font-extrabold text-slate-900">--</p>
                        <p class="countdown-unit text-xs text-slate-400 mt-0.5">Hari</p>
                    </div>
                    <div class="countdown-tile bg-slate-50 border border-slate-200 rounded-xl py-3 px-1">
                        <p id="cd-hours" class="countdown-number text-xl sm:text-2xl font-extrabold text-slate-900">--</p>
                        <p class="countdown-unit text-xs text-slate-400 mt-0.5">Jam</p>
                    </div>
                    <div class="countdown-tile bg-slate-50 border border-slate-200 rounded-xl py-3 px-1">
                        <p id="cd-minutes" class="countdown-number text-xl sm:text-2xl font-extrabold text-slate-900">--</p>
                        <p class="countdown-unit text-xs text-slate-400 mt-0.5">Menit</p>
                    </div>
                    <div class="countdown-tile bg-slate-50 border border-slate-200 rounded-xl py-3 px-1">
                        <p id="cd-seconds" class="countdown-number text-xl sm:text-2xl font-extrabold text-slate-900">--</p>
                        <p class="countdown-unit text-xs text-slate-400 mt-0.5">Detik</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Divider --}}
            <div class="divider border-t border-slate-100 my-5"></div>

            {{-- Footer --}}
            <p class="card-footer text-xs text-slate-400">
                Terima kasih atas pengertiannya.
            </p>

        </div>

        {{-- Credit --}}
        <p class="text-center text-xs text-slate-400 mt-6">
            &copy; {{ date('Y') }} UNDIGI &mdash; Platform Undangan Digital
        </p>

    </div>

    @if($maintenanceEndAt)
    <script>
        (function () {
            var target = new Date("{{ $maintenanceEndAt }}").getTime();

            function pad(n) { return String(n).padStart(2, '0'); }

            function tick() {
                var now  = Date.now();
                var diff = target - now;

                if (diff <= 0) {
                    var section = document.getElementById('countdown-section');
                    if (section) section.style.display = 'none';
                    return;
                }

                var days    = Math.floor(diff / (1000 * 60 * 60 * 24));
                var hours   = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((diff % (1000 * 60)) / 1000);

                document.getElementById('cd-days').textContent    = pad(days);
                document.getElementById('cd-hours').textContent   = pad(hours);
                document.getElementById('cd-minutes').textContent = pad(minutes);
                document.getElementById('cd-seconds').textContent = pad(seconds);
            }

            tick();
            setInterval(tick, 1000);
        })();
    </script>
    @endif

</body>
</html>

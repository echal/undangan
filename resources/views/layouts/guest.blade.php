<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'UNDIGI') }}</title>
        <link rel="icon" href="{{ asset('images/logo/undigi-logo.png') }}" type="image/png" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts (Breeze assets) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* ─── Theme tokens ─── */
            :root {
                --bg:        #f0f4ff;
                --bg2:       #e8edfc;
                --card:      #ffffff;
                --card-b:    rgba(99,102,241,.10);
                --text:      #0f172a;
                --text-sub:  #64748b;
                --text-mute: #94a3b8;
                --input-bg:  #ffffff;
                --input-b:   #e2e8f0;
                --input-b-f: #6366f1;
                --input-ring:rgba(99,102,241,.18);
                --label:     #374151;
                --primary:   #6366f1;
                --primary-h: #4f46e5;
                --primary-t: #ffffff;
                --link:      #6366f1;
                --link-h:    #4338ca;
                --notice-bg: #fffbeb;
                --notice-b:  #fde68a;
                --notice-t:  #92400e;
                --notice-ic: #d97706;
                --badge-bg:  #eef2ff;
                --badge-b:   #c7d2fe;
                --badge-t:   #4338ca;
                --error:     #ef4444;
                --error-bg:  #fef2f2;
                --error-b:   #fecaca;
                --tog-bg:    #e2e8f0;
                --tog-k:     #ffffff;
                --tog-ic:    #94a3b8;
                --shadow:    0 20px 60px rgba(99,102,241,.12), 0 4px 16px rgba(0,0,0,.06);
            }
            [data-theme="dark"] {
                --bg:        #0d1117;
                --bg2:       #161b27;
                --card:      #1c2333;
                --card-b:    rgba(99,102,241,.18);
                --text:      #f1f5f9;
                --text-sub:  #94a3b8;
                --text-mute: #64748b;
                --input-bg:  #0d1117;
                --input-b:   #2d3748;
                --input-b-f: #818cf8;
                --input-ring:rgba(129,140,248,.20);
                --label:     #cbd5e1;
                --primary:   #818cf8;
                --primary-h: #6366f1;
                --primary-t: #ffffff;
                --link:      #818cf8;
                --link-h:    #a5b4fc;
                --notice-bg: #1c1a0d;
                --notice-b:  #78350f;
                --notice-t:  #fbbf24;
                --notice-ic: #f59e0b;
                --badge-bg:  #1e1b4b;
                --badge-b:   #3730a3;
                --badge-t:   #a5b4fc;
                --error:     #f87171;
                --error-bg:  #1f0808;
                --error-b:   #7f1d1d;
                --tog-bg:    #6366f1;
                --tog-k:     #ffffff;
                --tog-ic:    #ffffff;
                --shadow:    0 20px 60px rgba(0,0,0,.5), 0 4px 16px rgba(0,0,0,.3);
            }

            /* ─── Reset / Base ─── */
            *, *::before, *::after { box-sizing: border-box; }
            html { font-family: 'Inter', system-ui, sans-serif; }

            body {
                margin: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 24px 16px 48px;
                background: linear-gradient(135deg, var(--bg) 0%, var(--bg2) 100%);
                color: var(--text);
                transition: background .35s ease, color .35s ease;
            }

            /* ─── Decorative blobs ─── */
            .g-blob {
                position: fixed;
                border-radius: 50%;
                filter: blur(80px);
                pointer-events: none;
                z-index: 0;
                transition: opacity .35s;
            }
            .g-blob-1 {
                width: 380px; height: 380px;
                top: -80px; left: -100px;
                background: radial-gradient(circle, rgba(99,102,241,.18) 0%, transparent 70%);
            }
            .g-blob-2 {
                width: 300px; height: 300px;
                bottom: -60px; right: -80px;
                background: radial-gradient(circle, rgba(168,85,247,.14) 0%, transparent 70%);
            }
            [data-theme="dark"] .g-blob-1 {
                background: radial-gradient(circle, rgba(99,102,241,.12) 0%, transparent 70%);
            }
            [data-theme="dark"] .g-blob-2 {
                background: radial-gradient(circle, rgba(168,85,247,.10) 0%, transparent 70%);
            }

            /* ─── Dark mode toggle ─── */
            .theme-toggle {
                position: fixed;
                top: 16px; right: 16px;
                z-index: 100;
                display: flex;
                align-items: center;
                gap: 8px;
                background: var(--card);
                border: 1px solid var(--card-b);
                border-radius: 999px;
                padding: 6px 12px 6px 8px;
                cursor: pointer;
                box-shadow: 0 2px 8px rgba(0,0,0,.08);
                transition: background .3s, border-color .3s, box-shadow .2s;
                user-select: none;
            }
            .theme-toggle:hover { box-shadow: 0 4px 16px rgba(0,0,0,.12); }
            .toggle-track {
                width: 36px; height: 20px;
                background: var(--tog-bg);
                border-radius: 999px;
                position: relative;
                transition: background .3s;
                flex-shrink: 0;
            }
            .toggle-knob {
                position: absolute;
                top: 2px; left: 2px;
                width: 16px; height: 16px;
                border-radius: 50%;
                background: var(--tog-k);
                transition: transform .3s cubic-bezier(.34,1.56,.64,1);
                box-shadow: 0 1px 4px rgba(0,0,0,.2);
            }
            [data-theme="dark"] .toggle-knob { transform: translateX(16px); }
            .toggle-label {
                font-size: 11px;
                font-weight: 600;
                color: var(--text-sub);
                letter-spacing: .3px;
                transition: color .3s;
            }
            .toggle-icon {
                width: 14px; height: 14px;
                color: var(--tog-ic);
                flex-shrink: 0;
                transition: color .3s;
            }

            /* ─── Wrapper ─── */
            .auth-wrap {
                position: relative;
                z-index: 1;
                width: 100%;
                max-width: 440px;
            }

            /* ─── Logo + Branding ─── */
            .auth-brand {
                text-align: center;
                margin-bottom: 28px;
            }
            .auth-brand-logo-img {
                display: block;
                height: 70px;
                width: auto;
                max-width: 220px;
                object-fit: contain;
                margin: 0 auto 16px;
            }
            [data-theme="dark"] .auth-brand-logo-img {
                /* Logo PNG transparan — tambahkan drop-shadow agar terlihat di dark bg */
                filter: drop-shadow(0 0 8px rgba(129,140,248,.25));
            }
            .auth-brand p {
                font-size: 14px;
                color: var(--text-sub);
                margin: 0;
                transition: color .3s;
            }

            /* ─── Card ─── */
            .auth-card {
                background: var(--card);
                border: 1px solid var(--card-b);
                border-radius: 20px;
                padding: 32px;
                box-shadow: var(--shadow);
                transition: background .3s, border-color .3s, box-shadow .3s;
            }

            /* ─── Slot content ─── */
            .auth-card-inner { position: relative; }

            /* ─── Footer ─── */
            .auth-footer {
                text-align: center;
                margin-top: 20px;
                font-size: 12px;
                color: var(--text-mute);
                transition: color .3s;
            }
        </style>
    </head>

    <body>
        <!-- Decorative blobs -->
        <div class="g-blob g-blob-1"></div>
        <div class="g-blob g-blob-2"></div>

        <!-- Dark mode toggle -->
        <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle dark mode" title="Toggle dark/light mode">
            <!-- Sun icon (light mode) -->
            <svg id="icon-sun" class="toggle-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:block">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>
            </svg>
            <!-- Moon icon (dark mode) -->
            <svg id="icon-moon" class="toggle-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"/>
            </svg>
            <div class="toggle-track">
                <div class="toggle-knob"></div>
            </div>
            <span class="toggle-label" id="toggle-label">Light</span>
        </button>

        <!-- Main content -->
        <div class="auth-wrap">
            <!-- Brand -->
            <div class="auth-brand">
                <a href="{{ route('landing') }}" style="text-decoration:none;">
                    <img
                        src="{{ asset('images/logo/undigi-logo.png') }}"
                        alt="{{ config('app.name', 'UNDIGI') }}"
                        class="auth-brand-logo-img"
                    >
                </a>
                <p>Platform undangan digital profesional</p>
            </div>

            <!-- Card -->
            <div class="auth-card">
                <div class="auth-card-inner">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <p class="auth-footer">
                &copy; {{ date('Y') }} {{ config('app.name', 'UNDIGI') }} &mdash; All rights reserved
            </p>
        </div>

        <script>
        (function () {
            'use strict';

            // ── Apply saved theme immediately (before paint) ──
            var saved = localStorage.getItem('undigi-theme');
            var sys   = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            var theme = saved || sys;
            document.documentElement.setAttribute('data-theme', theme);
            updateToggleUI(theme);

            function updateToggleUI(t) {
                var sun   = document.getElementById('icon-sun');
                var moon  = document.getElementById('icon-moon');
                var label = document.getElementById('toggle-label');
                if (!sun) return;
                if (t === 'dark') {
                    sun.style.display  = 'none';
                    moon.style.display = 'block';
                    if (label) label.textContent = 'Dark';
                } else {
                    sun.style.display  = 'block';
                    moon.style.display = 'none';
                    if (label) label.textContent = 'Light';
                }
            }

            window.toggleTheme = function () {
                var current = document.documentElement.getAttribute('data-theme') || 'light';
                var next    = current === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', next);
                localStorage.setItem('undigi-theme', next);
                updateToggleUI(next);
            };
        })();
        </script>
    </body>
</html>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $event->title }}</title>
  <meta name="description" content="{{ $event->title }} — {{ $event->event_date->translatedFormat('d F Y') }}. {{ $event->location }}">
  @include('partials.og-meta-event')
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  @stack('fonts')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  @stack('styles')
</head>
<body>

{{-- ── COVER SCREEN (global, tampil jika enable_cover aktif) ── --}}
@if($event->enable_cover)
  @include('partials.cover', ['event' => $event, 'theme' => $__env->yieldContent('theme', 'government')])
@endif

{{-- ── KONTEN TEMA ── --}}
@yield('content')

{{-- ── EVENT TOOLS: Countdown + Save to Calendar ── --}}
{{-- Tema bisa @push('event-tools') untuk posisi custom di dalam @yield('content') --}}
{{-- Jika tidak ada yang push, render di sini sebagai fallback --}}
@stack('event-tools')
@unless($__env->yieldContent('event_tools_placed') === '1')
  @include('partials.event-tools', ['event' => $event, 'theme' => $__env->yieldContent('theme', 'government')])
@endunless

{{-- ── FOOTER TEMA (opsional, per tema) ── --}}
@yield('footer')

{{-- ── BOTTOM NAV (global) ── --}}
<x-bottom-nav :event="$event" :theme="$__env->yieldContent('theme', 'government')" />

@stack('scripts')
</body>
</html>

@php
  $etTheme = $theme ?? 'government';
  $isExec  = $etTheme === 'executive';
  $isCorp  = $etTheme === 'corporate';

  // Google Calendar URL
  $gcalStart = $event->event_date->format('Ymd\THis');
  $gcalEnd   = $event->event_date->copy()->addHours(2)->format('Ymd\THis');
  $gcalUrl   = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
             . '&text='     . rawurlencode($event->title    ?? '')
             . '&dates='    . $gcalStart . '/' . $gcalEnd
             . '&location=' . rawurlencode($event->location ?? '')
             . '&details='  . rawurlencode('Undangan: ' . ($event->title ?? ''));

  $icsUrl  = route('invitation.ics', $event->slug);
  $isoDate = $event->event_date->toIso8601String();
@endphp

<style>
  /* ── EVENT TOOLS SECTION ── */
  #event-tools-section {
    padding: 56px 24px 48px;
    @if($isExec)
    background: #1a2332;
    border-top: 1px solid rgba(212,175,55,0.18);
    @elseif($isCorp)
    background: #f1f5f9;
    border-top: 1px solid #e2e8f0;
    @else
    background: #f0fdfa;
    border-top: 1px solid rgba(20,184,166,0.2);
    @endif
  }
  .et-inner {
    max-width: 800px;
    margin: 0 auto;
  }
  .et-label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 8px;
    @if($isExec)
    color: #d4af37;
    @elseif($isCorp)
    color: #d97706;
    @else
    color: #0f766e;
    @endif
  }
  .et-title {
    font-size: clamp(1.4rem, 4vw, 1.9rem);
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 8px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    @if($isExec)
    color: #f9fafb;
    @else
    color: #0f172a;
    @endif
  }
  .et-divider {
    width: 48px;
    height: 3px;
    border-radius: 2px;
    margin-bottom: 36px;
    @if($isExec)
    background: linear-gradient(to right, #d4af37, transparent);
    @elseif($isCorp)
    background: linear-gradient(to right, #d97706, #1e3a5f);
    @else
    background: #0f766e;
    @endif
  }

  /* ── COUNTDOWN ── */
  #inv-countdown {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 40px;
  }
  @media (max-width: 360px) {
    #inv-countdown { grid-template-columns: repeat(2, 1fr); }
  }
  .et-cd-box {
    text-align: center;
    padding: 20px 8px 16px;
    border-radius: 14px;
    @if($isExec)
    background: #1f2937;
    border: 1px solid rgba(212,175,55,0.25);
    @else
    background: #ffffff;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    @endif
  }
  .et-cd-num {
    display: block;
    font-size: clamp(1.9rem, 7vw, 2.8rem);
    font-weight: 800;
    line-height: 1;
    font-variant-numeric: tabular-nums;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    @if($isExec)
    color: #d4af37;
    @elseif($isCorp)
    color: #d97706;
    @else
    color: #0f766e;
    @endif
  }
  .et-cd-label {
    display: block;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-top: 6px;
    @if($isExec)
    color: #9ca3af;
    @else
    color: #64748b;
    @endif
  }
  #inv-expired-msg {
    text-align: center;
    padding: 24px 16px;
    border-radius: 14px;
    font-size: 15px;
    font-weight: 500;
    margin-bottom: 40px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    @if($isExec)
    background: #1f2937;
    color: #9ca3af;
    border: 1px solid rgba(212,175,55,0.2);
    @else
    background: #f1f5f9;
    color: #64748b;
    border: 1px solid #e2e8f0;
    @endif
  }

  /* ── CALENDAR BUTTONS ── */
  .et-cal-heading {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 14px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    @if($isExec)
    color: #f9fafb;
    @else
    color: #0f172a;
    @endif
  }
  .et-btn-group {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }
  .et-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 20px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    transition: opacity 0.2s, transform 0.15s;
    -webkit-tap-highlight-color: transparent;
    outline: none;
  }
  .et-btn:hover  { opacity: 0.85; }
  .et-btn:active { transform: scale(0.97); }
  .et-btn svg    { width: 16px; height: 16px; flex-shrink: 0; }

  .et-btn-gcal {
    @if($isExec)
    background: #d4af37; color: #111827;
    @elseif($isCorp)
    background: #d97706; color: #ffffff;
    @else
    background: #0f766e; color: #ffffff;
    @endif
  }
  .et-btn-ics {
    @if($isExec)
    background: rgba(212,175,55,0.12);
    color: #d4af37;
    border: 1px solid rgba(212,175,55,0.3);
    @else
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
    @endif
  }
</style>

@if($event->event_date)
<section id="event-tools-section">
  <div class="et-inner">

    {{-- Section Header --}}
    <span class="et-label">Hitung Mundur</span>
    <h2 class="et-title">Waktu Menuju Acara</h2>
    <div class="et-divider"></div>

    {{-- Countdown Grid --}}
    <div id="inv-countdown">
      <div class="et-cd-box">
        <span class="et-cd-num" id="inv-cd-days">--</span>
        <span class="et-cd-label">Hari</span>
      </div>
      <div class="et-cd-box">
        <span class="et-cd-num" id="inv-cd-hours">--</span>
        <span class="et-cd-label">Jam</span>
      </div>
      <div class="et-cd-box">
        <span class="et-cd-num" id="inv-cd-mins">--</span>
        <span class="et-cd-label">Menit</span>
      </div>
      <div class="et-cd-box">
        <span class="et-cd-num" id="inv-cd-secs">--</span>
        <span class="et-cd-label">Detik</span>
      </div>
    </div>

    {{-- Expired Message (hidden by default) --}}
    <div id="inv-expired-msg" style="display:none;">
      Acara ini telah berlangsung. Terima kasih atas partisipasi Anda. 🎉
    </div>

    {{-- Calendar Buttons --}}
    <p class="et-cal-heading">Simpan ke Kalender</p>
    <div class="et-btn-group">
      <a href="{{ $gcalUrl }}" target="_blank" rel="noopener" class="et-btn et-btn-gcal">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        Google Calendar
      </a>
      <a href="{{ $icsUrl }}" class="et-btn et-btn-ics">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
        </svg>
        Download .ics
      </a>
    </div>

  </div>
</section>

<script>
(function () {
  'use strict';

  var TARGET = new Date('{{ $isoDate }}').getTime();

  var dayEl  = document.getElementById('inv-cd-days');
  var hrEl   = document.getElementById('inv-cd-hours');
  var minEl  = document.getElementById('inv-cd-mins');
  var secEl  = document.getElementById('inv-cd-secs');
  var cdWrap = document.getElementById('inv-countdown');
  var expMsg = document.getElementById('inv-expired-msg');

  // Guard: elements must exist
  if (!dayEl || !hrEl || !minEl || !secEl || !cdWrap) return;
  // Guard: date must be valid
  if (isNaN(TARGET)) return;

  var timer = null;

  function pad(n) {
    return n < 10 ? '0' + n : '' + n;
  }

  function tick() {
    var diff = TARGET - Date.now();

    if (diff <= 0) {
      // Event has passed — show expired message, hide countdown
      cdWrap.style.display = 'none';
      if (expMsg) expMsg.style.display = '';
      if (timer !== null) { clearInterval(timer); timer = null; }
      return;
    }

    var s    = Math.floor(diff / 1000);
    var days = Math.floor(s / 86400);
    var hrs  = Math.floor((s % 86400) / 3600);
    var mns  = Math.floor((s % 3600) / 60);
    var sec  = s % 60;

    dayEl.textContent = '' + days;   // days: no padding (may be > 99)
    hrEl.textContent  = pad(hrs);
    minEl.textContent = pad(mns);
    secEl.textContent = pad(sec);
  }

  // Run immediately, then every second
  tick();
  timer = setInterval(tick, 1000);

  // Cleanup on page unload — prevent memory leaks, works with bfcache on iOS
  window.addEventListener('pagehide', function () {
    if (timer !== null) { clearInterval(timer); timer = null; }
  }, { once: true });

})();
</script>
@endif

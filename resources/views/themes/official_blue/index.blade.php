@php
    $ed          = $event->event_data ?? [];
    $noticeLevel = $event->notice_level ?? ($ed['notice_level'] ?? 'normal');
    $deadline    = $ed['deadline'] ?? null;
    $noticeNum   = $ed['notice_number'] ?? null;
    $issuingUnit = $ed['issuing_unit'] ?? $event->location;
    $description = $ed['description'] ?? null;
    $ziCommit    = $ed['zi_commitment'] ?? null;
    $contact     = $ed['contact_person'] ?? null;

    $levelMap = [
        'urgent'    => ['label' => 'MENDESAK',      'bg' => '#dc2626', 'ring' => '#fca5a5', 'light' => '#fff7f7'],
        'important' => ['label' => 'PENTING',        'bg' => '#d97706', 'ring' => '#fcd34d', 'light' => '#fffbeb'],
        'normal'    => ['label' => 'PEMBERITAHUAN',  'bg' => '#1d4ed8', 'ring' => '#93c5fd', 'light' => '#eff6ff'],
    ];
    $level = $levelMap[$noticeLevel] ?? $levelMap['normal'];

    $appName  = config('app.name', 'UNDIGI');
    $appUrl   = rtrim(config('app.url'), '/');
    $bannerUrl = $event->banner_image
        ? $appUrl . '/storage/' . ltrim($event->banner_image, '/')
        : null;

    // Statistik pelaporan
    $totalTarget  = (int) $event->total_target_asn;
    $totalLapor   = $event->noticeReports->count();
    $belumLapor   = max(0, $totalTarget - $totalLapor);
    $persenLapor  = $totalTarget > 0 ? round(($totalLapor / $totalTarget) * 100) : 0;

    // Cek apakah pelaporan sudah ditutup (deadline terlewat)
    $isClosed = false;
    if ($deadline) {
        try {
            $deadlineDate = \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $deadline)->endOfDay();
            $isClosed = $deadlineDate->isPast();
        } catch (\Exception $e) {
            // Coba format lain (d/m/Y, d-m-Y, dll)
            try {
                $deadlineDate = \Illuminate\Support\Carbon::parse($deadline)->endOfDay();
                $isClosed = $deadlineDate->isPast();
            } catch (\Exception $e2) {
                $isClosed = false;
            }
        }
    }

    $ogTitle = $event->title;
    $ogDesc  = \Illuminate\Support\Str::limit(strip_tags($description ?? $event->title), 150);
    $ogImage = $bannerUrl ?? asset('images/og-default.jpg');
    $ogUrl   = url()->current();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $event->title }} — Pemberitahuan Kedinasan</title>
    <meta name="description" content="{{ $ogDesc }}" />

    <meta property="og:title"        content="{{ $ogTitle }}" />
    <meta property="og:description"  content="{{ $ogDesc }}" />
    <meta property="og:type"         content="website" />
    <meta property="og:url"          content="{{ $ogUrl }}" />
    <meta property="og:image"        content="{{ $ogImage }}" />
    <meta property="og:image:width"  content="1200" />
    <meta property="og:image:height" content="630" />
    <meta name="twitter:card"        content="summary_large_image" />
    <meta name="twitter:title"       content="{{ $ogTitle }}" />
    <meta name="twitter:description" content="{{ $ogDesc }}" />
    <meta name="twitter:image"       content="{{ $ogImage }}" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; color: #1e293b; min-height: 100vh; }

        /* ── HEADER ── */
        .header-bar {
            position: sticky; top: 0; z-index: 50;
            background: #1e3a5f;
            border-bottom: 4px solid #2563eb;
            padding: 12px 24px;
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
        }
        .header-logo { display: flex; align-items: center; gap: 10px; min-width: 0; }
        .header-icon {
            width: 36px; height: 36px; min-width: 36px;
            background: #2563eb; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }
        .header-title { font-weight: 700; font-size: 13px; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .header-subtitle { font-size: 11px; color: #93c5fd; }
        .header-badge {
            background: rgba(37,99,235,0.3); color: #93c5fd;
            border: 1px solid rgba(147,197,253,0.3);
            font-size: 10px; font-weight: 700; letter-spacing: 0.07em;
            padding: 4px 12px; border-radius: 50px; white-space: nowrap; flex-shrink: 0;
            text-transform: uppercase;
        }

        /* ── HERO ── */
        .hero {
            background: linear-gradient(135deg, #1e3a5f 0%, #1d4ed8 100%);
            padding: 56px 24px 52px; position: relative; overflow: hidden;
        }
        .hero::before { content:''; position:absolute; top:-60px; right:-60px; width:260px; height:260px; border-radius:50%; background:rgba(255,255,255,0.04); }
        .hero::after  { content:''; position:absolute; bottom:-60px; left:-40px; width:200px; height:200px; border-radius:50%; background:rgba(37,99,235,0.15); }
        .hero-inner { position:relative; z-index:1; max-width:720px; margin:0 auto; }

        /* ── CONTENT WRAPPER ── */
        .content-wrap { max-width: 720px; margin: 0 auto; padding: 28px 16px 64px; }

        /* ── CARD ── */
        .card { background:#fff; border-radius:12px; border:1px solid #e2e8f0; box-shadow:0 1px 4px rgba(0,0,0,0.06); padding:24px; }

        /* ── SECTION TITLE ── */
        .section-title {
            font-size: 11px; font-weight: 700; letter-spacing: 0.08em;
            text-transform: uppercase; color: #64748b; margin-bottom: 14px;
            display: flex; align-items: center;
        }
        .section-title::before {
            content:''; display:inline-block; width:3px; height:14px;
            background:#2563eb; border-radius:2px; margin-right:8px; flex-shrink:0;
        }

        /* ── STAT CARD ── */
        .stat-card { text-align:center; padding:20px 12px; border-radius:12px; border:1px solid #e2e8f0; }

        /* ── PROGRESS BAR ── */
        .progress-track { background:#e2e8f0; border-radius:50px; height:10px; overflow:hidden; }
        .progress-fill  { height:100%; border-radius:50px; transition:width 0.6s ease;
                          background: linear-gradient(90deg, #2563eb, #60a5fa); }

        /* ── FORM ── */
        .form-input {
            width:100%; padding:10px 14px; border-radius:8px;
            border:1px solid #cbd5e1; font-size:14px; color:#1e293b;
            background:#fff; transition:border-color 0.15s, box-shadow 0.15s;
            outline:none;
        }
        .form-input:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.12); }
        .form-label { display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px; }

        /* ── ZI BADGE ── */
        .zi-badge {
            display:inline-flex; align-items:center; gap:6px;
            background:#f0fdf4; border:1px solid #bbf7d0;
            color:#15803d; border-radius:6px; font-size:12px; font-weight:600;
            padding:6px 14px;
        }

        /* ── REPORT TABLE ── */
        .report-table { width:100%; border-collapse:collapse; font-size:13px; }
        .report-table th { background:#f8fafc; padding:10px 12px; text-align:left; font-weight:600; color:#64748b; border-bottom:2px solid #e2e8f0; }
        .report-table td { padding:10px 12px; border-bottom:1px solid #f1f5f9; color:#1e293b; }
        .report-table tr:last-child td { border-bottom:none; }
        .report-table tr:hover td { background:#f8fafc; }

        /* ── FOOTER ── */
        .footer { background:#1e3a5f; border-top:3px solid #2563eb; padding:28px 24px; text-align:center; }

        @media (max-width:640px) {
            .hero { padding:44px 16px 40px; }
            .header-bar { padding:10px 16px; }
        }
    </style>
</head>
<body>

{{-- ══════════════ HEADER ══════════════ --}}
<header class="header-bar">
    <div class="header-logo">
        <div class="header-icon">🏛</div>
        <div style="min-width:0;">
            <div class="header-title">{{ $issuingUnit }}</div>
            <div class="header-subtitle">Pemberitahuan Resmi Kedinasan</div>
        </div>
    </div>
    <div class="header-badge">Pemberitahuan Kedinasan</div>
</header>

{{-- ══════════════ HERO ══════════════ --}}
<section class="hero">
    <div class="hero-inner">
        {{-- Level badge --}}
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold text-white mb-5"
             style="background:{{ $level['bg'] }}; box-shadow:0 0 0 4px {{ $level['ring'] }}33;">
            <span class="w-2 h-2 rounded-full bg-white opacity-90 inline-block"></span>
            {{ $level['label'] }}
        </div>
        @if ($noticeNum)
        <p class="text-blue-300 text-xs font-mono mb-2 tracking-wider">{{ $noticeNum }}</p>
        @endif
        <h1 class="text-2xl sm:text-3xl font-bold text-white leading-snug mb-4">{{ $event->title }}</h1>
        <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-blue-200">
            <span>📅 Berlaku mulai: <strong class="text-white">{{ $event->event_date?->translatedFormat('d F Y') }}</strong></span>
            <span>🏢 {{ $issuingUnit }}</span>
        </div>
    </div>
</section>

{{-- ══════════════ FLASH MESSAGES ══════════════ --}}
@if (session('report_success'))
<div class="max-w-xl mx-auto mt-4 px-4">
    <div class="flex items-start gap-3 p-4 bg-green-50 border border-green-200 rounded-xl">
        <span class="text-green-500 text-xl flex-shrink-0">✅</span>
        <p class="text-sm text-green-800 font-medium">{{ session('report_success') }}</p>
    </div>
</div>
@endif

{{-- ══════════════ MAIN CONTENT ══════════════ --}}
<div class="content-wrap">

    {{-- ── DEADLINE CARD ── --}}
    @if ($deadline)
    <div class="card mb-5" style="border-left:4px solid {{ $level['bg'] }}; background:{{ $level['light'] }};">
        <p class="section-title">Batas Waktu / Deadline</p>
        <div class="flex items-center gap-3">
            <div class="text-3xl flex-shrink-0">⏰</div>
            <div>
                <p class="text-xl font-bold" style="color:{{ $level['bg'] }};">{{ $deadline }}</p>
                <p class="text-sm text-slate-500 mt-0.5">
                    @if ($noticeLevel === 'urgent') Segera ditindaklanjuti sebelum batas waktu.
                    @elseif ($noticeLevel === 'important') Harap perhatikan batas waktu yang ditetapkan.
                    @else Pastikan kewajiban diselesaikan sebelum tenggat.
                    @endif
                </p>
            </div>
        </div>
    </div>
    @endif

    {{-- ── STATISTIK PELAPORAN ── --}}
    <div class="card mb-5">
        <p class="section-title">Statistik Pelaporan ASN</p>

        <div class="grid grid-cols-3 gap-3 mb-5">
            <div class="stat-card" style="background:#eff6ff; border-color:#bfdbfe;">
                <p class="text-2xl sm:text-3xl font-bold text-blue-700">{{ $totalLapor }}</p>
                <p class="text-xs text-blue-500 font-semibold mt-1 uppercase tracking-wide">Sudah Melapor</p>
            </div>
            <div class="stat-card" style="background:#fff7ed; border-color:#fed7aa;">
                <p class="text-2xl sm:text-3xl font-bold text-orange-600">{{ $totalTarget > 0 ? $belumLapor : '—' }}</p>
                <p class="text-xs text-orange-500 font-semibold mt-1 uppercase tracking-wide">Belum Melapor</p>
            </div>
            <div class="stat-card" style="background:#f8fafc; border-color:#e2e8f0;">
                <p class="text-2xl sm:text-3xl font-bold text-slate-700">{{ $totalTarget > 0 ? $totalTarget : '—' }}</p>
                <p class="text-xs text-slate-400 font-semibold mt-1 uppercase tracking-wide">Total ASN</p>
            </div>
        </div>

        @if ($totalTarget > 0)
        <div class="mb-2 flex items-center justify-between text-xs font-semibold text-slate-500">
            <span>Progress Pelaporan</span>
            <span class="text-blue-600">{{ $persenLapor }}%</span>
        </div>
        <div class="progress-track">
            <div class="progress-fill" style="width:{{ $persenLapor }}%;"></div>
        </div>
        @endif
    </div>

    {{-- ── ISI PEMBERITAHUAN ── --}}
    @if ($description)
    <div class="card mb-5">
        <p class="section-title">Isi Pemberitahuan</p>
        <div class="text-slate-700 text-sm leading-relaxed" style="white-space:pre-line;">{!! nl2br(e($description)) !!}</div>
    </div>
    @endif

    {{-- ── DETAIL ACARA ── --}}
    <div class="card mb-5">
        <p class="section-title">Informasi Acara</p>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <dt class="text-xs text-slate-400 font-medium uppercase tracking-wide mb-0.5">Tanggal Berlaku</dt>
                <dd class="text-slate-800 font-semibold text-sm">{{ $event->event_date?->translatedFormat('l, d F Y') }}</dd>
            </div>
            <div>
                <dt class="text-xs text-slate-400 font-medium uppercase tracking-wide mb-0.5">Unit / Instansi</dt>
                <dd class="text-slate-800 font-semibold text-sm">{{ $issuingUnit }}</dd>
            </div>
            @if ($event->location && $event->location !== $issuingUnit)
            <div>
                <dt class="text-xs text-slate-400 font-medium uppercase tracking-wide mb-0.5">Lokasi</dt>
                <dd class="text-slate-800 font-semibold text-sm">{{ $event->location }}</dd>
            </div>
            @endif
            @if ($noticeNum)
            <div>
                <dt class="text-xs text-slate-400 font-medium uppercase tracking-wide mb-0.5">Nomor Surat</dt>
                <dd class="text-slate-800 font-semibold text-sm font-mono">{{ $noticeNum }}</dd>
            </div>
            @endif
            @if ($deadline)
            <div>
                <dt class="text-xs text-slate-400 font-medium uppercase tracking-wide mb-0.5">Batas Waktu</dt>
                <dd class="font-semibold text-sm" style="color:{{ $level['bg'] }};">{{ $deadline }}</dd>
            </div>
            @endif
            <div>
                <dt class="text-xs text-slate-400 font-medium uppercase tracking-wide mb-0.5">Tingkat Urgensi</dt>
                <dd>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-white"
                          style="background:{{ $level['bg'] }};">
                        {{ $level['label'] }}
                    </span>
                </dd>
            </div>
        </dl>
    </div>

    {{-- ── SURAT RESMI (PDF) ── --}}
    @if ($event->official_document)
    @php $docUrl = $appUrl . '/storage/' . ltrim($event->official_document, '/'); @endphp
    <div class="card mb-5" style="border-top:3px solid #2563eb;">
        <p class="section-title">Dokumen Resmi</p>
        <div class="flex flex-wrap gap-3">
            <a href="{{ $docUrl }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM9 13h6v1H9v-1zm0 2h6v1H9v-1zm0 2h4v1H9v-1z"/>
                </svg>
                📄 Lihat Surat Resmi
            </a>
            <a href="{{ $docUrl }}" download
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-blue-700 text-sm font-semibold rounded-lg border border-blue-200 transition-colors">
                ⬇ Unduh PDF
            </a>
        </div>
    </div>
    @endif

    {{-- ── MAPS ── --}}
    @if ($event->maps_link)
    <div class="card mb-5">
        <p class="section-title">Lokasi</p>
        <a href="{{ $event->maps_link }}" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">
            📍 Lihat di Google Maps
        </a>
    </div>
    @endif

    {{-- ── KOMITMEN ZI/WBK/WBBM ── --}}
    @if ($ziCommit)
    <div class="card mb-5" style="border-top:3px solid #16a34a;">
        <p class="section-title" style="color:#16a34a;">
            <span style="background:#16a34a; width:3px; height:14px; border-radius:2px; margin-right:8px; display:inline-block; flex-shrink:0;"></span>
            Komitmen ZI / WBK / WBBM
        </p>
        <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line mb-4">{{ $ziCommit }}</p>
        <div class="flex flex-wrap gap-2">
            <span class="zi-badge">✅ Zona Integritas</span>
            <span class="zi-badge">🏆 Menuju WBK</span>
            <span class="zi-badge">⭐ Menuju WBBM</span>
        </div>
    </div>
    @endif

    {{-- ── KONTAK ── --}}
    @if ($contact)
    <div class="card mb-5">
        <p class="section-title">Narahubung</p>
        <div class="flex items-start gap-3">
            <div class="text-2xl flex-shrink-0">👤</div>
            <div>
                <p class="text-slate-800 font-semibold text-sm">{{ $contact }}</p>
                <p class="text-slate-500 text-xs mt-0.5">Narahubung / PIC Kegiatan</p>
            </div>
        </div>
    </div>
    @endif

    {{-- ══ FORM KONFIRMASI PELAPORAN ASN ══ --}}
    <div class="card mb-5" style="border-top:4px solid {{ $isClosed ? '#94a3b8' : '#2563eb' }};">
        <p class="section-title">Konfirmasi Pelaporan ASN</p>

        @if ($isClosed)
        {{-- Pelaporan ditutup --}}
        <div class="flex items-start gap-3 p-4 bg-slate-50 border border-slate-200 rounded-xl">
            <span class="text-2xl flex-shrink-0">🔒</span>
            <div>
                <p class="font-semibold text-slate-700 text-sm">Pelaporan telah ditutup</p>
                <p class="text-xs text-slate-500 mt-0.5">
                    Batas waktu pelaporan ({{ $deadline }}) telah berakhir. Form konfirmasi tidak lagi menerima input baru.
                </p>
            </div>
        </div>
        @else
        <p class="text-sm text-slate-500 mb-5">Isi formulir berikut untuk mencatat kehadiran/konfirmasi Anda sebagai ASN yang telah memenuhi kewajiban pelaporan ini.</p>

        @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
            <ul class="text-sm text-red-700 space-y-0.5 list-disc list-inside">
                @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('invitation.report', $event->slug) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="form-label" for="rpt-nama">Nama Lengkap <span class="text-red-500">*</span></label>
                <input id="rpt-nama" type="text" name="nama"
                       value="{{ old('nama') }}"
                       placeholder="Masukkan nama lengkap sesuai data kepegawaian"
                       class="form-input @error('nama') border-red-400 @enderror"
                       required>
                @error('nama')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="rpt-nip">NIP <span class="text-red-500">*</span></label>
                <input id="rpt-nip" type="text" name="nip"
                       value="{{ old('nip') }}"
                       placeholder="Contoh: 199001012020011001"
                       class="form-input font-mono @error('nip') border-red-400 @enderror"
                       required>
                @error('nip')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="rpt-unit">Unit Kerja <span class="text-red-500">*</span></label>
                <input id="rpt-unit" type="text" name="unit_kerja"
                       value="{{ old('unit_kerja') }}"
                       placeholder="Contoh: Bidang Perencanaan, Dinas Pendidikan"
                       class="form-input @error('unit_kerja') border-red-400 @enderror"
                       required>
                @error('unit_kerja')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <button type="submit"
                    class="w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-bold text-sm rounded-xl transition-colors shadow-sm">
                ✅ Kirim Konfirmasi Pelaporan
            </button>
        </form>
        @endif
    </div>

    {{-- ══ DAFTAR ASN YANG SUDAH MELAPOR ══ --}}
    @if ($event->noticeReports->isNotEmpty())
    <div class="card mb-5">
        <div class="flex items-center justify-between mb-4">
            <p class="section-title" style="margin-bottom:0;">
                Daftar ASN yang Sudah Melapor
            </p>
            <span class="text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-200 px-2.5 py-1 rounded-full">
                {{ $totalLapor }} ASN
            </span>
        </div>
        <div class="overflow-x-auto -mx-1">
            <table class="report-table">
                <thead>
                    <tr>
                        <th style="width:36px;">#</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Unit Kerja</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($event->noticeReports as $i => $rpt)
                    <tr>
                        <td class="text-slate-400 text-center">{{ $i + 1 }}</td>
                        <td class="font-medium">{{ $rpt->nama }}</td>
                        <td class="font-mono text-slate-500 text-xs">{{ $rpt->nip }}</td>
                        <td class="text-slate-600">{{ $rpt->unit_kerja }}</td>
                        <td class="text-slate-400 text-xs whitespace-nowrap">
                            {{ $rpt->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>{{-- /content-wrap --}}

{{-- ══════════════ FOOTER ══════════════ --}}
<footer class="footer">
    <p class="text-blue-200 text-xs font-semibold uppercase tracking-widest mb-1">Pemberitahuan Resmi</p>
    <p class="text-white font-bold text-base mb-1">{{ $issuingUnit }}</p>
    <p class="text-blue-300 text-xs">Diterbitkan {{ $event->event_date?->translatedFormat('d F Y') }}</p>
    <p class="text-blue-400 text-xs mt-4">Powered by <span class="font-bold text-white">{{ $appName }}</span></p>
</footer>

</body>
</html>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.announcements.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Pengumuman</h2>
                <div class="flex items-center gap-2 mt-0.5">
                    @php
                        $sc = match($announcement->computed_status) { 'published'=>'green','resolved'=>'slate','archived'=>'gray', default=>'yellow' };
                        $sl = match($announcement->computed_status) { 'published'=>'Published','resolved'=>'Resolved','archived'=>'Archived', default=>'Draft' };
                    @endphp
                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full
                        bg-{{ $sc }}-100 text-{{ $sc }}-700 dark:bg-{{ $sc }}-900/40 dark:text-{{ $sc }}-400">
                        @if ($announcement->computed_status === 'published')
                            <span class="w-1.5 h-1.5 rounded-full bg-{{ $sc }}-500 animate-pulse"></span>
                        @endif
                        {{ $sl }}
                    </span>
                    <a href="{{ route('status.show', $announcement->slug) }}" target="_blank"
                       class="text-xs text-indigo-500 hover:text-indigo-700 dark:hover:text-indigo-300 transition font-mono">
                        /status/{{ $announcement->slug }} ↗
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-sm text-green-700 dark:text-green-400">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if ($errors->any())
            <div class="flex items-start gap-3 px-4 py-3 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-sm text-red-700 dark:text-red-400">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <div>@foreach ($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
            </div>
            @endif

            @php $ds = $announcement->design_settings ?? []; @endphp

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Form Edit --}}
                <div class="lg:col-span-2 space-y-0">
                    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST"
                          class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm divide-y divide-gray-100 dark:divide-gray-700">
                        @csrf @method('PUT')

                        {{-- Basic Info --}}
                        <div class="p-6 space-y-4">
                            <div class="flex flex-col gap-1">
                                <label for="title" class="text-sm font-medium text-gray-700 dark:text-gray-200">Judul <span class="text-red-500">*</span></label>
                                <input type="text" id="title" name="title" value="{{ old('title', $announcement->title) }}" required
                                       class="text-sm px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="body" class="text-sm font-medium text-gray-700 dark:text-gray-200">Deskripsi <span class="text-red-500">*</span></label>
                                <textarea id="body" name="body" rows="6" required
                                          class="text-sm px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition resize-none">{{ old('body', $announcement->body) }}</textarea>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="severity" class="text-sm font-medium text-gray-700 dark:text-gray-200">Tingkat Keparahan</label>
                                <select id="severity" name="severity"
                                        class="text-sm px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                    <option value="info" {{ old('severity', $announcement->severity) === 'info' ? 'selected' : '' }}>Info</option>
                                    <option value="warning" {{ old('severity', $announcement->severity) === 'warning' ? 'selected' : '' }}>Warning</option>
                                    <option value="critical" {{ old('severity', $announcement->severity) === 'critical' ? 'selected' : '' }}>Critical</option>
                                </select>
                            </div>
                        </div>

                        {{-- Theme Picker --}}
                        <div class="p-6 space-y-4">
                            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Tampilan (Theme)</h3>
                            <div class="flex flex-col gap-1">
                                <label for="theme_id" class="text-sm font-medium text-gray-600 dark:text-gray-300">Pilih Theme</label>
                                <select id="theme_id" name="theme_id"
                                        class="text-sm px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                    <option value="">— Gunakan tampilan default —</option>
                                    @if ($maintenanceThemes->isNotEmpty())
                                    <optgroup label="🛠 Maintenance Themes">
                                        @foreach ($maintenanceThemes as $t)
                                        <option value="{{ $t->id }}" {{ old('theme_id', $announcement->theme_id) == $t->id ? 'selected' : '' }}>
                                            {{ $t->name }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @endif
                                    @if ($eventThemes->isNotEmpty())
                                    <optgroup label="📅 Event Themes">
                                        @foreach ($eventThemes as $t)
                                        <option value="{{ $t->id }}" {{ old('theme_id', $announcement->theme_id) == $t->id ? 'selected' : '' }}>
                                            {{ $t->name }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @endif
                                </select>
                                @if ($announcement->theme)
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                    Theme aktif: <span class="font-medium text-indigo-500">{{ $announcement->theme->name }}</span>
                                    ({{ $announcement->theme->category }}/{{ $announcement->theme->folder }})
                                </p>
                                @endif
                            </div>
                        </div>

                        {{-- Design Settings --}}
                        <div class="p-6 space-y-5" x-data="{ open: {{ $announcement->design_settings ? 'true' : 'false' }} }">
                            <button type="button" @click="open = !open"
                                    class="flex items-center justify-between w-full text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">
                                <span>Kustomisasi Tampilan</span>
                                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" x-transition class="space-y-4">
                                {{-- Logo URL --}}
                                <div class="flex flex-col gap-1">
                                    <label for="ds_logo_url" class="text-sm font-medium text-gray-600 dark:text-gray-300">URL Logo <span class="text-gray-400 font-normal">(opsional — tampil di atas halaman)</span></label>
                                    <input type="url" id="ds_logo_url" name="design_settings[logo_url]"
                                           value="{{ old('design_settings.logo_url', $ds['logo_url'] ?? '') }}"
                                           placeholder="https://example.com/logo.png"
                                           class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                </div>

                                <div class="flex flex-col gap-1">
                                    <label for="ds_heading" class="text-sm font-medium text-gray-600 dark:text-gray-300">Heading Override <span class="text-gray-400 font-normal">(opsional)</span></label>
                                    <input type="text" id="ds_heading" name="design_settings[heading]"
                                           value="{{ old('design_settings.heading', $ds['heading'] ?? '') }}"
                                           class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                </div>

                                <div class="grid grid-cols-3 gap-4">
                                    <div class="flex flex-col gap-1">
                                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400">Warna Aksen</label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" name="design_settings[primary_color]"
                                                   value="{{ old('design_settings.primary_color', $ds['primary_color'] ?? '#6366f1') }}"
                                                   class="w-9 h-9 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer p-0.5 bg-transparent">
                                            <span class="text-xs text-gray-400 font-mono">primary</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400">Background</label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" name="design_settings[background_color]"
                                                   value="{{ old('design_settings.background_color', $ds['background_color'] ?? '#020617') }}"
                                                   class="w-9 h-9 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer p-0.5 bg-transparent">
                                            <span class="text-xs text-gray-400 font-mono">bg</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400">Teks</label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" name="design_settings[text_color]"
                                                   value="{{ old('design_settings.text_color', $ds['text_color'] ?? '#f1f5f9') }}"
                                                   class="w-9 h-9 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer p-0.5 bg-transparent">
                                            <span class="text-xs text-gray-400 font-mono">text</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-1">
                                    <label for="ds_end_time" class="text-sm font-medium text-gray-600 dark:text-gray-300">Waktu Selesai Countdown</label>
                                    <input type="datetime-local" id="ds_end_time" name="design_settings[end_time]"
                                           value="{{ old('design_settings.end_time', isset($ds['end_time']) ? \Carbon\Carbon::parse($ds['end_time'])->format('Y-m-d\TH:i') : '') }}"
                                           class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                </div>

                                <div class="flex flex-col gap-1">
                                    <label for="ds_contact" class="text-sm font-medium text-gray-600 dark:text-gray-300">Kontak Admin</label>
                                    <input type="text" id="ds_contact" name="design_settings[contact]"
                                           value="{{ old('design_settings.contact', $ds['contact'] ?? '') }}"
                                           class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                </div>

                                <div class="space-y-2">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="hidden" name="design_settings[show_countdown]" value="0">
                                        <input type="checkbox" name="design_settings[show_countdown]" value="1"
                                               {{ old('design_settings.show_countdown', $ds['show_countdown'] ?? '1') ? 'checked' : '' }}
                                               class="w-4 h-4 rounded accent-indigo-600">
                                        <span class="text-sm text-gray-700 dark:text-gray-200">Tampilkan countdown</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="hidden" name="design_settings[show_timeline]" value="0">
                                        <input type="checkbox" name="design_settings[show_timeline]" value="1"
                                               {{ old('design_settings.show_timeline', $ds['show_timeline'] ?? '1') ? 'checked' : '' }}
                                               class="w-4 h-4 rounded accent-indigo-600">
                                        <span class="text-sm text-gray-700 dark:text-gray-200">Tampilkan timeline log</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Waktu --}}
                        <div class="p-6 space-y-4">
                            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Waktu</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1">
                                    <label for="starts_at" class="text-sm font-medium text-gray-600 dark:text-gray-300">Mulai</label>
                                    <input type="datetime-local" id="starts_at" name="starts_at"
                                           value="{{ old('starts_at', $announcement->starts_at?->format('Y-m-d\TH:i')) }}"
                                           class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label for="ends_at" class="text-sm font-medium text-gray-600 dark:text-gray-300">Estimasi Selesai</label>
                                    <input type="datetime-local" id="ends_at" name="ends_at"
                                           value="{{ old('ends_at', $announcement->ends_at?->format('Y-m-d\TH:i')) }}"
                                           class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                </div>
                            </div>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="hidden" name="is_global_banner" value="0">
                                <input type="checkbox" name="is_global_banner" value="1"
                                       {{ old('is_global_banner', $announcement->is_global_banner) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded accent-indigo-600">
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-200">Banner global</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">Tampil di semua halaman saat published</p>
                                </div>
                            </label>
                        </div>

                        <div class="p-6 flex items-center justify-between gap-4">
                            <button type="button" form="form-delete-{{ $announcement->id }}"
                                    onclick="return confirm('Hapus pengumuman ini?') && document.getElementById('form-delete-{{ $announcement->id }}').submit()"
                                    class="text-sm text-red-500 hover:text-red-700 transition">
                                Hapus
                            </button>
                            <button type="submit"
                                    class="px-6 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    {{-- Form hapus — di luar form edit agar tidak nested --}}
                    <form id="form-delete-{{ $announcement->id }}"
                          action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="hidden">
                        @csrf @method('DELETE')
                    </form>
                </div>

                {{-- Sidebar: Actions + Timeline --}}
                <div class="space-y-5">

                    {{-- Status Actions --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-5 space-y-3">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Aksi</h3>

                        @if ($announcement->status === 'draft')
                        <form action="{{ route('admin.announcements.publish', $announcement) }}" method="POST">
                            @csrf @method('PUT')
                            <button type="submit"
                                    class="w-full px-4 py-2 rounded-xl bg-green-600 hover:bg-green-700 text-white text-sm font-semibold transition">
                                Publikasikan
                            </button>
                        </form>
                        @elseif ($announcement->status === 'published')
                        <form action="{{ route('admin.announcements.archive', $announcement) }}" method="POST"
                              onsubmit="return confirm('Arsipkan pengumuman ini?')">
                            @csrf @method('PUT')
                            <button type="submit"
                                    class="w-full px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold transition">
                                Arsipkan
                            </button>
                        </form>
                        @endif

                        <a href="{{ route('status.show', $announcement->slug) }}" target="_blank"
                           class="flex items-center justify-center gap-2 w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Lihat Halaman Publik
                        </a>
                    </div>

                    {{-- Timeline Log --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-5 space-y-4">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Timeline</h3>

                        <form action="{{ route('admin.announcements.log', $announcement) }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="message" placeholder="Tambah update..."
                                   class="flex-1 text-xs px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                   required>
                            <button type="submit"
                                    class="px-3 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition flex-shrink-0">
                                +
                            </button>
                        </form>

                        <div class="space-y-3 max-h-80 overflow-y-auto">
                            @forelse ($logs as $log)
                            <div class="flex gap-3">
                                <div class="flex flex-col items-center">
                                    <div class="w-2 h-2 rounded-full bg-indigo-400 dark:bg-indigo-500 mt-1 flex-shrink-0"></div>
                                    @if (!$loop->last)
                                        <div class="w-px flex-1 bg-gray-100 dark:bg-gray-700 mt-1"></div>
                                    @endif
                                </div>
                                <div class="pb-3 flex-1 min-w-0">
                                    <p class="text-xs text-gray-700 dark:text-gray-200">{{ $log->message }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                        {{ $log->creator->name ?? 'Admin' }} · {{ $log->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            @empty
                            <p class="text-xs text-gray-400 dark:text-gray-500 text-center py-2">Belum ada log</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.announcements.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Buat Pengumuman</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Pengumuman baru akan disimpan sebagai Draft</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($errors->any())
            <div class="flex items-start gap-3 px-4 py-3 mb-6 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-sm text-red-700 dark:text-red-400">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <div>@foreach ($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
            </div>
            @endif

            <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data"
                  class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm divide-y divide-gray-100 dark:divide-gray-700">
                @csrf

                {{-- Basic Info --}}
                <div class="p-6 space-y-4">
                    <div class="flex flex-col gap-1">
                        <label for="title" class="text-sm font-medium text-gray-700 dark:text-gray-200">Judul <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                               placeholder="Contoh: Gangguan Layanan — Database Down"
                               class="text-sm px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="body" class="text-sm font-medium text-gray-700 dark:text-gray-200">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea id="body" name="body" rows="5" required
                                  placeholder="Jelaskan gangguan/pengumuman secara detail..."
                                  class="text-sm px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition resize-none">{{ old('body') }}</textarea>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="severity" class="text-sm font-medium text-gray-700 dark:text-gray-200">Tingkat Keparahan <span class="text-red-500">*</span></label>
                        <select id="severity" name="severity" required
                                class="text-sm px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            <option value="info" {{ old('severity') === 'info' ? 'selected' : '' }}>Info — Pemberitahuan umum</option>
                            <option value="warning" {{ old('severity') === 'warning' ? 'selected' : '' }}>Warning — Gangguan sebagian</option>
                            <option value="critical" {{ old('severity') === 'critical' ? 'selected' : '' }}>Critical — Sistem tidak dapat diakses</option>
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
                                <option value="{{ $t->id }}" {{ old('theme_id') == $t->id ? 'selected' : '' }}>
                                    {{ $t->name }}
                                </option>
                                @endforeach
                            </optgroup>
                            @endif
                            @if ($eventThemes->isNotEmpty())
                            <optgroup label="📅 Event Themes">
                                @foreach ($eventThemes as $t)
                                <option value="{{ $t->id }}" {{ old('theme_id') == $t->id ? 'selected' : '' }}>
                                    {{ $t->name }}
                                </option>
                                @endforeach
                            </optgroup>
                            @endif
                        </select>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Tampilan default: system-status klasik</p>
                    </div>
                </div>

                {{-- Design Settings --}}
                <div class="p-6 space-y-5" x-data="{ open: false }">
                    <button type="button" @click="open = !open"
                            class="flex items-center justify-between w-full text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">
                        <span>Kustomisasi Tampilan</span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" x-transition class="space-y-4">
                        {{-- Logo Upload --}}
                        <div class="flex flex-col gap-1">
                            <label for="logo_file" class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                Logo <span class="text-gray-400 font-normal">(opsional — tampil di atas halaman)</span>
                            </label>
                            <input type="file" id="logo_file" name="logo_file"
                                   accept="image/jpeg,image/png,image/webp,image/svg+xml"
                                   class="text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition file:mr-3 file:py-2 file:px-3 file:rounded-l-lg file:border-0 file:text-xs file:font-medium file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-900/30 dark:file:text-indigo-400 file:cursor-pointer">
                            <p class="text-xs text-gray-400">JPG, PNG, WEBP, SVG · Maks 2MB · Otomatis dikompres ke WebP 480×160px</p>
                        </div>

                        {{-- Heading override --}}
                        <div class="flex flex-col gap-1">
                            <label for="ds_heading" class="text-sm font-medium text-gray-600 dark:text-gray-300">Heading Override <span class="text-gray-400 font-normal">(opsional, default: judul)</span></label>
                            <input type="text" id="ds_heading" name="design_settings[heading]"
                                   value="{{ old('design_settings.heading') }}"
                                   placeholder="Teks heading halaman status"
                                   class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>

                        {{-- Colors --}}
                        <div class="grid grid-cols-3 gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400">Warna Aksen</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" name="design_settings[primary_color]"
                                           value="{{ old('design_settings.primary_color', '#6366f1') }}"
                                           class="w-9 h-9 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer p-0.5 bg-transparent">
                                    <span class="text-xs text-gray-400 font-mono">primary</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400">Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" name="design_settings[background_color]"
                                           value="{{ old('design_settings.background_color', '#020617') }}"
                                           class="w-9 h-9 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer p-0.5 bg-transparent">
                                    <span class="text-xs text-gray-400 font-mono">bg</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400">Teks</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" name="design_settings[text_color]"
                                           value="{{ old('design_settings.text_color', '#f1f5f9') }}"
                                           class="w-9 h-9 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer p-0.5 bg-transparent">
                                    <span class="text-xs text-gray-400 font-mono">text</span>
                                </div>
                            </div>
                        </div>

                        {{-- End time override --}}
                        <div class="flex flex-col gap-1">
                            <label for="ds_end_time" class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                Waktu Selesai untuk Countdown <span class="text-gray-400 font-normal">(override estimasi selesai)</span>
                            </label>
                            <input type="datetime-local" id="ds_end_time" name="design_settings[end_time]"
                                   value="{{ old('design_settings.end_time') }}"
                                   class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>

                        {{-- Contact --}}
                        <div class="flex flex-col gap-1">
                            <label for="ds_contact" class="text-sm font-medium text-gray-600 dark:text-gray-300">Kontak Admin</label>
                            <input type="text" id="ds_contact" name="design_settings[contact]"
                                   value="{{ old('design_settings.contact') }}"
                                   placeholder="WhatsApp / Email / Telepon"
                                   class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>

                        {{-- Toggles --}}
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="hidden" name="design_settings[show_countdown]" value="0">
                                <input type="checkbox" name="design_settings[show_countdown]" value="1"
                                       {{ old('design_settings.show_countdown', '1') ? 'checked' : '' }}
                                       class="w-4 h-4 rounded accent-indigo-600">
                                <span class="text-sm text-gray-700 dark:text-gray-200">Tampilkan countdown</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="hidden" name="design_settings[show_timeline]" value="0">
                                <input type="checkbox" name="design_settings[show_timeline]" value="1"
                                       {{ old('design_settings.show_timeline', '1') ? 'checked' : '' }}
                                       class="w-4 h-4 rounded accent-indigo-600">
                                <span class="text-sm text-gray-700 dark:text-gray-200">Tampilkan timeline log</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Waktu --}}
                <div class="p-6 space-y-4">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Waktu (Opsional)</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="starts_at" class="text-sm font-medium text-gray-600 dark:text-gray-300">Mulai</label>
                            <input type="datetime-local" id="starts_at" name="starts_at" value="{{ old('starts_at') }}"
                                   class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="ends_at" class="text-sm font-medium text-gray-600 dark:text-gray-300">Estimasi Selesai</label>
                            <input type="datetime-local" id="ends_at" name="ends_at" value="{{ old('ends_at') }}"
                                   class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>
                    </div>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_global_banner" value="0">
                        <input type="checkbox" name="is_global_banner" value="1" {{ old('is_global_banner') ? 'checked' : '' }}
                               class="w-4 h-4 rounded accent-indigo-600">
                        <div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-200">Tampilkan sebagai banner global</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">Tampil di semua halaman saat status published</p>
                        </div>
                    </label>
                </div>

                <div class="p-6 flex items-center justify-between gap-4">
                    <a href="{{ route('admin.announcements.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition">
                        Simpan sebagai Draft
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

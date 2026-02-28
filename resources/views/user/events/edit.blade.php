<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('user.events.index') }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                &larr; Kembali
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Undangan
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-lg">
                    <p class="text-sm font-medium text-red-700 dark:text-red-400 mb-1">Terdapat kesalahan input:</p>
                    <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-300 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div
                x-data="editForm()"
                x-init="init()"
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden"
            >
                <form
                    action="{{ route('user.events.update', $event) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="p-6 space-y-7"
                    @submit="syncGalleryFiles()"
                >
                    @csrf
                    @method('PUT')

                    {{-- ── SECTION: Informasi Dasar ──────────────────── --}}
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700">
                            Informasi Dasar
                        </h3>
                        <div class="space-y-4">

                            {{-- Judul --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Judul Undangan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" value="{{ old('title', $event->title) }}"
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Paket & Tema --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Paket <span class="text-red-500">*</span>
                                    </label>
                                    <select name="package_id"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">-- Pilih Paket --</option>
                                        @foreach ($packages as $package)
                                            <option value="{{ $package->id }}"
                                                {{ old('package_id', $event->package_id) == $package->id ? 'selected' : '' }}>
                                                {{ $package->name }} — Rp{{ number_format($package->price, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('package_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Tema Tampilan
                                        <span class="text-gray-400 text-xs font-normal">(opsional)</span>
                                    </label>
                                    <select name="theme_id"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">-- Tampilan Default --</option>
                                        @foreach ($themes as $theme)
                                            <option value="{{ $theme->id }}"
                                                {{ old('theme_id', $event->theme_id) == $theme->id ? 'selected' : '' }}>
                                                {{ $theme->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('theme_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- ── SECTION: Detail Acara ─────────────────────── --}}
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700">
                            Detail Acara
                        </h3>
                        <div class="space-y-4">

                            {{-- Nama (bride / host / penyelenggara) --}}
                            @if ($event->event_type === 'pernikahan')
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Nama Mempelai Wanita <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="bride_name" value="{{ old('bride_name', $event->bride_name) }}"
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        @error('bride_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Nama Mempelai Pria <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="groom_name" value="{{ old('groom_name', $event->groom_name) }}"
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        @error('groom_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            @else
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ in_array($event->event_type, ['workshop','kegiatan_kantor','rapat','pelatihan']) ? 'Pembicara / Trainer' : 'Nama Penyelenggara' }}
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="bride_name" value="{{ old('bride_name', $event->bride_name) }}"
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('bride_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            @endif

                            {{-- Tanggal & Waktu --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Tanggal & Waktu Acara <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" name="event_date"
                                       value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}"
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('event_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Lokasi --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Lokasi Acara <span class="text-red-500">*</span>
                                </label>
                                <textarea name="location" rows="2"
                                          class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('location', $event->location) }}</textarea>
                                @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Link Maps --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Link Google Maps <span class="text-gray-400 text-xs">(opsional)</span>
                                </label>
                                <input type="url" name="maps_link" value="{{ old('maps_link', $event->maps_link) }}"
                                       placeholder="https://maps.google.com/..."
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('maps_link') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Event-type specific fields --}}
                            @if ($event->event_type === 'pernikahan')
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Keluarga Mempelai Wanita <span class="text-gray-400 text-xs">(opsional)</span>
                                        </label>
                                        <input type="text" name="event_data[bride_parents]"
                                               value="{{ old('event_data.bride_parents', $event->event_data['bride_parents'] ?? '') }}"
                                               placeholder="Bpk. Ahmad & Ibu Siti"
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Keluarga Mempelai Pria <span class="text-gray-400 text-xs">(opsional)</span>
                                        </label>
                                        <input type="text" name="event_data[groom_parents]"
                                               value="{{ old('event_data.groom_parents', $event->event_data['groom_parents'] ?? '') }}"
                                               placeholder="Bpk. Hasan & Ibu Fatimah"
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Tanggal Resepsi <span class="text-gray-400 text-xs">(opsional — format: 2026-06-15T13:00)</span>
                                    </label>
                                    <input type="text" name="event_data[reception_date]"
                                           value="{{ old('event_data.reception_date', $event->event_data['reception_date'] ?? '') }}"
                                           placeholder="2026-06-15T13:00"
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                </div>

                            @elseif ($event->event_type === 'buka_puasa')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Keterangan / Pesan Tambahan <span class="text-gray-400 text-xs">(opsional)</span>
                                    </label>
                                    <textarea name="event_data[description]" rows="3"
                                              placeholder="Disediakan takjil dan makan bersama..."
                                              class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old('event_data.description', $event->event_data['description'] ?? '') }}</textarea>
                                </div>

                                {{-- Foto Keluarga / Host --}}
                                <div class="border border-amber-200 dark:border-amber-800/50 rounded-xl overflow-hidden">
                                    <div class="px-4 py-3 bg-amber-50 dark:bg-amber-900/20 border-b border-amber-200 dark:border-amber-800/50">
                                        <p class="text-sm font-semibold text-amber-800 dark:text-amber-400">🌙 Foto Keluarga Penyelenggara</p>
                                        <p class="text-xs text-amber-600 dark:text-amber-500 mt-0.5">Foto yang ditampilkan di halaman undangan agar tamu mengenali penyelenggara</p>
                                    </div>
                                    <div class="p-4">
                                        <div class="flex flex-col sm:flex-row gap-4 items-start">
                                            <div class="w-full sm:w-48 flex-shrink-0">
                                                <div class="relative border-2 border-dashed border-amber-300 dark:border-amber-700 rounded-xl overflow-hidden cursor-pointer hover:border-amber-500 transition-colors bg-amber-50 dark:bg-amber-900/10"
                                                     style="aspect-ratio:4/3;"
                                                     @click="$refs.hostPhoto.click()">
                                                    {{-- Show current saved photo if no new preview --}}
                                                    <div x-show="!hostPhotoPreview">
                                                        @if (! empty($event->event_data['host_photo']))
                                                            <img src="{{ rtrim(config('app.url'), '/') }}/storage/{{ $event->event_data['host_photo'] }}"
                                                                 class="w-full h-full object-cover" alt="Foto host tersimpan">
                                                        @else
                                                            <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 p-3 text-center">
                                                                <svg class="w-10 h-10 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                </svg>
                                                                <span class="text-xs text-amber-500 dark:text-amber-400">Klik untuk upload<br>foto keluarga</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <img x-show="hostPhotoPreview"
                                                         :src="hostPhotoPreview"
                                                         class="w-full h-full object-cover" alt="Preview foto host">
                                                </div>
                                                <input type="file" name="host_photo"
                                                       accept="image/jpeg,image/png,image/webp"
                                                       x-ref="hostPhoto" class="hidden"
                                                       @change="handleHostPhoto($event)">
                                                <p class="mt-1.5 text-xs text-center text-amber-500 cursor-pointer hover:text-amber-700"
                                                   @click="$refs.hostPhoto.click()">
                                                    {{ ! empty($event->event_data['host_photo']) ? 'Ganti foto' : 'Upload foto' }}
                                                </p>
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 space-y-1 pt-1 text-xs">
                                                <p class="font-medium text-gray-600 dark:text-gray-300 text-sm">Tips foto yang baik:</p>
                                                <ul class="space-y-1 list-disc list-inside">
                                                    <li>Foto keluarga atau foto bersama</li>
                                                    <li>Format landscape (4:3) lebih ideal</li>
                                                    <li>Ukuran maksimal 2MB (JPG/PNG/WEBP)</li>
                                                </ul>
                                            </div>
                                        </div>
                                        @error('host_photo')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                            @elseif (in_array($event->event_type, ['workshop','kegiatan_kantor','rapat','pelatihan']))
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ match($event->event_type) {
                                            'rapat'     => 'Agenda Rapat',
                                            'pelatihan' => 'Deskripsi Pelatihan',
                                            'kegiatan_kantor' => 'Deskripsi Kegiatan',
                                            default     => 'Deskripsi Workshop',
                                        } }} <span class="text-gray-400 text-xs">(opsional)</span>
                                    </label>
                                    <textarea name="event_data[description]" rows="3"
                                              placeholder="Jelaskan topik, manfaat, dan apa yang akan dipelajari..."
                                              class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old('event_data.description', $event->event_data['description'] ?? '') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Tanggal & Waktu Selesai <span class="text-gray-400 text-xs">(opsional)</span>
                                    </label>
                                    <input type="text" name="event_data[end_date]"
                                           value="{{ old('event_data.end_date', $event->event_data['end_date'] ?? '') }}"
                                           placeholder="2026-06-15T17:00"
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Link Live Stream <span class="text-gray-400 text-xs">(opsional)</span>
                                    </label>
                                    <input type="url" name="event_data[livestream_link]"
                                           value="{{ old('event_data.livestream_link', $event->event_data['livestream_link'] ?? '') }}"
                                           placeholder="https://youtube.com/live/..."
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    @error('event_data.livestream_link') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div class="flex flex-wrap gap-4">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="hidden" name="event_data[sertifikat]" value="0">
                                        <input type="checkbox" name="event_data[sertifikat]" value="1"
                                               {{ old('event_data.sertifikat', $event->event_data['sertifikat'] ?? '0') === '1' ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Bersertifikat</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="hidden" name="event_data[biaya_sukarela]" value="0">
                                        <input type="checkbox" name="event_data[biaya_sukarela]" value="1"
                                               {{ old('event_data.biaya_sukarela', $event->event_data['biaya_sukarela'] ?? '0') === '1' ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Biaya Sukarela</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="hidden" name="event_data[peserta_publik]" value="0">
                                        <input type="checkbox" name="event_data[peserta_publik]" value="1"
                                               {{ old('event_data.peserta_publik', $event->event_data['peserta_publik'] ?? '0') === '1' ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan daftar peserta</span>
                                    </label>
                                </div>

                            @elseif ($event->event_type === 'official_notice')
                                {{-- Total Target ASN --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Total Target ASN <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="total_target_asn" min="0"
                                           value="{{ old('total_target_asn', $event->total_target_asn) }}"
                                           placeholder="Contoh: 120"
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <p class="mt-1 text-xs text-gray-400">Jumlah total ASN yang wajib melaporkan.</p>
                                    @error('total_target_asn')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                {{-- Nomor Surat --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Nomor Surat <span class="text-gray-400 text-xs">(opsional)</span>
                                    </label>
                                    <input type="text" name="event_data[notice_number]"
                                           value="{{ old('event_data.notice_number', $event->event_data['notice_number'] ?? '') }}"
                                           placeholder="Contoh: 001/UN.1/HM/2026"
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm font-mono">
                                </div>

                                {{-- Tingkat Urgensi --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tingkat Urgensi</label>
                                    <div class="flex flex-wrap gap-3">
                                        @foreach (['normal' => 'Normal', 'important' => 'Penting', 'urgent' => 'Mendesak'] as $val => $lbl)
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="event_data[notice_level]" value="{{ $val }}"
                                                   {{ old('event_data.notice_level', $event->event_data['notice_level'] ?? 'normal') === $val ? 'checked' : '' }}
                                                   class="text-indigo-600 focus:ring-indigo-500">
                                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $lbl }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Batas Waktu --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Batas Waktu / Deadline <span class="text-gray-400 text-xs">(opsional)</span>
                                    </label>
                                    <input type="text" name="event_data[deadline]"
                                           value="{{ old('event_data.deadline', $event->event_data['deadline'] ?? '') }}"
                                           placeholder="Contoh: 31 Maret 2026 pukul 16.00 WIB"
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                </div>

                                {{-- Unit Penerbit --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Unit / Bagian Penerbit <span class="text-gray-400 text-xs">(opsional)</span>
                                    </label>
                                    <input type="text" name="event_data[issuing_unit]"
                                           value="{{ old('event_data.issuing_unit', $event->event_data['issuing_unit'] ?? '') }}"
                                           placeholder="Biro Umum, Sekretariat, dsb."
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                </div>

                                {{-- Isi Pemberitahuan --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Isi Pemberitahuan <span class="text-gray-400 text-xs">(opsional)</span>
                                    </label>
                                    <textarea name="event_data[description]" rows="5"
                                              placeholder="Jelaskan isi pemberitahuan secara lengkap..."
                                              class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old('event_data.description', $event->event_data['description'] ?? '') }}</textarea>
                                </div>

                                {{-- Komitmen ZI/WBK/WBBM --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Komitmen ZI / WBK / WBBM <span class="text-gray-400 text-xs">(opsional)</span>
                                    </label>
                                    <textarea name="event_data[zi_commitment]" rows="3"
                                              placeholder="Tuliskan komitmen zona integritas instansi..."
                                              class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old('event_data.zi_commitment', $event->event_data['zi_commitment'] ?? '') }}</textarea>
                                </div>

                                {{-- Narahubung --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Narahubung / Kontak <span class="text-gray-400 text-xs">(opsional)</span>
                                    </label>
                                    <input type="text" name="event_data[contact_person]"
                                           value="{{ old('event_data.contact_person', $event->event_data['contact_person'] ?? '') }}"
                                           placeholder="Nama dan nomor HP narahubung"
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                </div>

                            @endif

                        </div>
                    </div>

                    {{-- ── SECTION: Media ────────────────────────────── --}}
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700">
                            Media
                        </h3>
                        <div class="space-y-5">

                            {{-- Banner Image --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Foto Banner / Cover
                                    <span class="text-gray-400 text-xs">(maks. 2MB — JPG, PNG, WEBP)</span>
                                </label>
                                {{-- Drop zone --}}
                                <div
                                    class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-5 text-center cursor-pointer hover:border-indigo-400 transition-colors"
                                    @click="$refs.bannerInput.click()"
                                    @dragover.prevent
                                    @drop.prevent="handleBannerDrop($event)"
                                >
                                    {{-- Empty state --}}
                                    <div x-show="!bannerPreview">
                                        @if ($event->banner_image)
                                            {{-- Show existing banner --}}
                                            <img src="{{ rtrim(config('app.url'), '/') }}/storage/{{ $event->banner_image }}"
                                                 class="mx-auto max-h-36 rounded-lg object-cover mb-2" alt="Banner saat ini">
                                            <p class="text-xs text-gray-400">Banner tersimpan · Klik untuk ganti</p>
                                        @else
                                            <svg class="mx-auto h-10 w-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <p class="text-sm text-gray-500">Klik atau drag foto ke sini</p>
                                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP</p>
                                        @endif
                                    </div>
                                    {{-- New preview --}}
                                    <div x-show="bannerPreview">
                                        <img :src="bannerPreview" class="mx-auto max-h-40 rounded-lg object-cover">
                                        <p class="text-xs text-gray-400 mt-2">Foto baru dipilih · Klik untuk ganti</p>
                                    </div>
                                </div>
                                <input type="file" name="banner_image" accept="image/jpeg,image/png,image/webp"
                                       x-ref="bannerInput" class="hidden"
                                       @change="handleBannerChange($event)">
                                @error('banner_image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Gallery Images --}}
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Galeri Foto
                                        <span class="text-gray-400 text-xs">(maks. 8 foto — upload baru akan mengganti semua)</span>
                                    </label>
                                    <span x-show="galleryPreviews.length > 0"
                                          class="text-xs font-semibold px-2 py-0.5 rounded-full"
                                          :class="galleryPreviews.length >= 8
                                            ? 'bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-400'
                                            : 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900/40 dark:text-indigo-400'"
                                          x-text="galleryPreviews.length + ' / 8'">
                                    </span>
                                </div>
                                <div
                                    class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-4 text-center cursor-pointer hover:border-indigo-400 transition-colors"
                                    @click="galleryPreviews.length < 8 && $refs.galleryInput.click()"
                                    @dragover.prevent
                                    @drop.prevent="handleGalleryDrop($event)"
                                    :class="galleryPreviews.length >= 8 ? 'opacity-60 cursor-not-allowed' : ''"
                                >
                                    <div x-show="galleryPreviews.length === 0" class="py-3">
                                        @if (! empty($event->gallery_images))
                                            {{-- Show existing gallery thumbnails --}}
                                            <div class="grid grid-cols-4 gap-2 mb-2">
                                                @foreach (array_slice($event->gallery_images, 0, 8) as $img)
                                                    <img src="{{ rtrim(config('app.url'), '/') }}/storage/{{ $img }}"
                                                         class="w-full h-20 object-cover rounded-lg" alt="Galeri">
                                                @endforeach
                                            </div>
                                            <p class="text-xs text-gray-400">{{ count($event->gallery_images) }} foto tersimpan · Klik untuk ganti semua</p>
                                        @else
                                            <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            <p class="text-sm text-gray-500">Tambah foto galeri</p>
                                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP · Maks. 8 foto</p>
                                        @endif
                                    </div>
                                    <div x-show="galleryPreviews.length > 0" class="grid grid-cols-4 gap-2">
                                        <template x-for="(src, idx) in galleryPreviews" :key="idx">
                                            <div class="relative group">
                                                <img :src="src" class="w-full h-20 object-cover rounded-lg">
                                                <button type="button"
                                                        @click.stop="removeGalleryImage(idx)"
                                                        class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full text-xs hidden group-hover:flex items-center justify-center leading-none">
                                                    &times;
                                                </button>
                                            </div>
                                        </template>
                                        <div x-show="galleryPreviews.length < 8"
                                             class="w-full h-20 border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center text-gray-400 gap-1">
                                            <span class="text-2xl leading-none">+</span>
                                            <span class="text-xs" x-text="'(' + (8 - galleryPreviews.length) + ' sisa)'"></span>
                                        </div>
                                    </div>
                                </div>
                                <input type="file" name="gallery_images[]" accept="image/jpeg,image/png,image/webp" multiple
                                       x-ref="galleryInput" class="hidden"
                                       @change="handleGalleryChange($event)">
                                @error('gallery_images') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                @error('gallery_images.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Upload Dokumen Resmi PDF — khusus official_notice --}}
                            @if ($event->event_type === 'official_notice')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Dokumen Resmi (PDF)
                                    <span class="text-gray-400 text-xs">(opsional — maks. 3MB)</span>
                                </label>

                                @if ($event->official_document)
                                <div class="flex items-center gap-3 p-3 mb-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg">
                                    <svg class="w-8 h-8 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5z"/>
                                    </svg>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-blue-700 dark:text-blue-300 truncate">
                                            {{ basename($event->official_document) }}
                                        </p>
                                        <a href="{{ rtrim(config('app.url'), '/') . '/storage/' . ltrim($event->official_document, '/') }}"
                                           target="_blank"
                                           class="text-xs text-blue-500 hover:underline">Lihat dokumen saat ini →</a>
                                    </div>
                                </div>
                                @endif

                                <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-5 text-center cursor-pointer hover:border-indigo-400 transition-colors"
                                     x-data="{ pdfName: null }"
                                     @click="$refs.pdfUpload.click()">
                                    <div x-show="!pdfName">
                                        <svg class="mx-auto h-10 w-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-sm text-gray-500">
                                            {{ $event->official_document ? 'Klik untuk ganti dokumen' : 'Klik untuk upload surat / nota dinas / SK' }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">PDF saja, maks. 3MB</p>
                                    </div>
                                    <div x-show="pdfName" class="flex items-center justify-center gap-2">
                                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5z"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300" x-text="pdfName"></span>
                                    </div>
                                    <input type="file" name="official_document" accept="application/pdf"
                                           x-ref="pdfUpload" class="hidden"
                                           @change="pdfName = $event.target.files[0]?.name ?? null">
                                </div>
                                @error('official_document')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                        </div>
                    </div>

                    {{-- ── SECTION: Pengaturan ───────────────────────── --}}
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700">
                            Pengaturan
                        </h3>

                        {{-- RSVP Toggle --}}
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <div>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Aktifkan RSVP Online</p>
                                <p class="text-xs text-gray-400 mt-0.5">Tamu dapat mengkonfirmasi kehadiran secara online</p>
                            </div>
                            <button type="button" @click="rsvpEnabled = !rsvpEnabled"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200"
                                    :class="rsvpEnabled ? 'bg-indigo-600' : 'bg-gray-300 dark:bg-gray-600'">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                                      :class="rsvpEnabled ? 'translate-x-6' : 'translate-x-1'"></span>
                            </button>
                            <input type="hidden" name="rsvp_enabled" :value="rsvpEnabled ? '1' : '0'">
                        </div>

                        {{-- Background Music Picker --}}
                        @php
                            $musicList      = \App\Models\MusicLibrary::where('is_active', true)->orderBy('title')->get();
                            $currentMusicId = old('music_id', $event->music_id);
                        @endphp
                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl"
                             x-data="{ selected: {{ $currentMusicId ? (int)$currentMusicId : 'null' }} }">
                            <input type="hidden" name="music_id" :value="selected !== null ? selected : ''">

                            <div class="flex items-start gap-3 mb-3">
                                <span class="text-xl mt-0.5">🎵</span>
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Background Musik</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Pilih dari daftar musik yang tersedia</p>
                                </div>
                            </div>

                            @if($musicList->isEmpty())
                                <p class="text-sm text-gray-400 dark:text-gray-500 italic text-center py-3">
                                    Belum ada musik tersedia. Hubungi admin.
                                </p>
                            @else
                                <div class="space-y-2">
                                    {{-- Opsi tanpa musik --}}
                                    <div @click="selected = null"
                                         :class="selected === null ? 'ring-2 ring-indigo-500 bg-indigo-50 dark:bg-indigo-900/30 border-indigo-300 dark:border-indigo-600' : 'bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600 hover:border-indigo-300 dark:hover:border-indigo-500'"
                                         class="flex items-center gap-3 px-3 py-2.5 border rounded-lg cursor-pointer transition">
                                        <span class="text-lg">🔇</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Tanpa Musik</span>
                                    </div>

                                    {{-- Daftar musik --}}
                                    @foreach($musicList as $m)
                                    <div @click="selected = {{ $m->id }}"
                                         :class="selected === {{ $m->id }} ? 'ring-2 ring-indigo-500 bg-indigo-50 dark:bg-indigo-900/30 border-indigo-300 dark:border-indigo-600' : 'bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600 hover:border-indigo-300 dark:hover:border-indigo-500'"
                                         class="flex items-center gap-3 px-3 py-2.5 border rounded-lg cursor-pointer transition">
                                        <span class="text-lg">🎵</span>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">{{ $m->title }}</p>
                                            @if($m->artist)
                                            <p class="text-xs text-gray-400 dark:text-gray-500 truncate">{{ $m->artist }}</p>
                                            @endif
                                        </div>
                                        @if($m->duration_formatted)
                                        <span class="text-xs text-gray-400 dark:text-gray-500 flex-shrink-0">{{ $m->duration_formatted }}</span>
                                        @endif
                                        <svg x-show="selected === {{ $m->id }}" class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    @endforeach
                                </div>
                            @endif

                            @error('music_id')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- ── Submit Buttons ────────────────────────────── --}}
                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('user.events.index') }}"
                           class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
    function editForm() {
        return {
            bannerPreview: null,
            galleryPreviews: [],
            galleryFiles: [],
            hostPhotoPreview: null,
            rsvpEnabled: {{ $event->rsvp_enabled ? 'true' : 'false' }},

            init() {
                // Nothing extra needed — existing images shown via Blade
            },

            handleBannerChange(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => { this.bannerPreview = e.target.result; };
                    reader.readAsDataURL(file);
                }
            },

            handleBannerDrop(event) {
                const file = event.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    this.$refs.bannerInput.files = dt.files;
                    const reader = new FileReader();
                    reader.onload = (e) => { this.bannerPreview = e.target.result; };
                    reader.readAsDataURL(file);
                }
            },

            handleGalleryChange(event) {
                const files = Array.from(event.target.files);
                const remaining = 8 - this.galleryPreviews.length;
                files.slice(0, remaining).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => { this.galleryPreviews.push(e.target.result); };
                    reader.readAsDataURL(file);
                    this.galleryFiles.push(file);
                });
            },

            handleGalleryDrop(event) {
                const files = Array.from(event.dataTransfer.files).filter(f => f.type.startsWith('image/'));
                const dt = new DataTransfer();
                files.forEach(f => dt.items.add(f));
                this.$refs.galleryInput.files = dt.files;
                this.handleGalleryChange({ target: { files: dt.files } });
            },

            removeGalleryImage(idx) {
                this.galleryPreviews.splice(idx, 1);
                this.galleryFiles.splice(idx, 1);
                this.syncGalleryFiles();
            },

            // Sync galleryFiles array back to the actual file input before submit
            syncGalleryFiles() {
                if (!this.$refs.galleryInput) return;
                const dt = new DataTransfer();
                this.galleryFiles.forEach(f => dt.items.add(f));
                this.$refs.galleryInput.files = dt.files;
            },

            handleHostPhoto(event) {
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => { this.hostPhotoPreview = e.target.result; };
                reader.readAsDataURL(file);
            },
        };
    }
    </script>
    @endpush
</x-app-layout>

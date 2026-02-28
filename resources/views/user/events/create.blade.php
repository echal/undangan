<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('user.events.index') }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                &larr; Kembali
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Buat Undangan Baru
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Validation errors summary (for non-JS fallback) --}}
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
                x-data="wizardForm()"
                x-init="init()"
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden"
            >
                {{-- Progress Bar --}}
                <div class="px-6 pt-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            Langkah <span x-text="currentStep"></span> dari 4
                        </span>
                        <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400"
                              x-text="stepLabels[currentStep - 1]"></span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div
                            class="bg-indigo-600 h-2 rounded-full transition-all duration-500 ease-out"
                            :style="`width: ${(currentStep / 4) * 100}%`"
                        ></div>
                    </div>
                    {{-- Step indicators --}}
                    <div class="flex justify-between mt-3">
                        <template x-for="step in 4" :key="step">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300"
                                    :class="{
                                        'bg-indigo-600 text-white': currentStep === step,
                                        'bg-green-500 text-white': currentStep > step,
                                        'bg-gray-200 dark:bg-gray-700 text-gray-500': currentStep < step
                                    }"
                                >
                                    <template x-if="currentStep > step">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </template>
                                    <template x-if="currentStep <= step">
                                        <span x-text="step"></span>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <form
                    action="{{ route('user.events.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="wizard-form"
                    @submit="syncGalleryFiles(); isSubmitting = true"
                >
                    @csrf

                    <div class="p-6">

                        {{-- ============================
                             STEP 1: Tipe & Info Dasar
                             ============================ --}}
                        <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-x-4"
                             x-transition:enter-end="opacity-100 translate-x-0">

                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Informasi Dasar</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Pilih jenis acara dan isi informasi utama undangan.</p>

                            {{-- Jenis Acara --}}
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jenis Acara <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-3 gap-3">
                                    <template x-for="type in eventTypes" :key="type.value">
                                        <label
                                            class="relative flex flex-col items-center justify-center p-4 rounded-xl border-2 cursor-pointer transition-all duration-200"
                                            :class="form.event_type === type.value
                                                ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/30'
                                                : 'border-gray-200 dark:border-gray-600 hover:border-indigo-300 dark:hover:border-indigo-700'"
                                        >
                                            <input type="radio" name="event_type" :value="type.value"
                                                   x-model="form.event_type"
                                                   @change="form.theme_id = ''"
                                                   class="sr-only">
                                            <span class="text-2xl mb-2" x-text="type.icon"></span>
                                            <span class="text-xs font-medium text-center text-gray-700 dark:text-gray-300"
                                                  x-text="type.label"></span>
                                            <div x-show="form.event_type === type.value"
                                                 class="absolute top-2 right-2 w-4 h-4 bg-indigo-600 rounded-full flex items-center justify-center">
                                                <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                                @error('event_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Judul Undangan --}}
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Judul Undangan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" x-model="form.title"
                                       @input="generateSlugPreview()"
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="Contoh: Pernikahan Budi & Sari"
                                       value="{{ old('title') }}">
                                <p class="mt-1 text-xs text-gray-400">
                                    URL: <span class="font-mono text-indigo-500" x-text="slugPreview || 'otomatis-dibuat'"></span>
                                </p>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Paket --}}
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Paket <span class="text-red-500">*</span>
                                </label>
                                <select name="package_id" x-model="form.package_id"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                            {{ $package->name }} — Rp{{ number_format($package->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('package_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tema Tampilan (opsional — sistem akan memilih tema sesuai jenis acara secara otomatis) --}}
                            @php
                                $themeEventMap = [
                                    'minimal'          => ['pernikahan'],
                                    'sakura'           => ['pernikahan'],
                                    'wedding-elegant'  => ['pernikahan'],
                                    'ramadan-glow'     => ['buka_puasa'],
                                    'workshop-ai'      => ['workshop'],
                                    'workshop-modern'  => ['workshop'],
                                    'government-clean' => ['kegiatan_kantor'],
                                    'corporate-modern' => ['rapat'],
                                    'executive-dark'   => ['pelatihan'],
                                    'official-blue'    => ['official_notice'],
                                    'event-elegant'    => ['pernikahan','buka_puasa','workshop','kegiatan_kantor','rapat','pelatihan','official_notice'],
                                    'event-classic'    => ['pernikahan','buka_puasa','workshop','kegiatan_kantor','rapat','pelatihan','official_notice'],
                                ];
                            @endphp
                            <div x-show="!!form.event_type">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Tema Tampilan
                                    <span class="text-gray-400 text-xs font-normal">(opsional — otomatis sesuai jenis acara)</span>
                                </label>
                                <select name="theme_id" x-model="form.theme_id"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- Gunakan Tema Otomatis --</option>
                                    @foreach ($themes->where('category', 'event') as $theme)
                                        @php $allowed = $themeEventMap[$theme->slug] ?? []; @endphp
                                        <option value="{{ $theme->id }}"
                                                data-event-types="{{ implode(',', $allowed) }}"
                                                x-show="!form.event_type || '{{ implode(',', $allowed) }}'.includes(form.event_type)"
                                                {{ old('theme_id') == $theme->id ? 'selected' : '' }}>
                                            {{ $theme->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('theme_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- ============================
                             STEP 2: Detail Acara (Dynamic)
                             Satu set field, label & placeholder
                             berubah sesuai event_type via Alpine.
                             Field duplikat dihilangkan agar tidak
                             ada name="" ganda yang dikirim ke server.
                             ============================ --}}
                        <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-x-4"
                             x-transition:enter-end="opacity-100 translate-x-0">

                            {{-- Header + event type badge --}}
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-0.5">Detail Acara</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400"
                                       x-text="currentTypeConfig().subtitle"></p>
                                </div>
                                <span class="text-2xl" x-text="getEventTypeIcon()"></span>
                            </div>

                            {{-- No event type selected guard --}}
                            <div x-show="!form.event_type" class="py-12 text-center">
                                <div class="text-4xl mb-3">🎯</div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">
                                    Kembali ke Langkah 1 dan pilih jenis acara terlebih dahulu.
                                </p>
                            </div>

                            {{-- ── UNIFIED FIELDS (only shown when event_type is set) ──
                                 Hanya satu set input dengan name yang unik.
                                 Label & placeholder berubah via Alpine x-text / :placeholder.
                                 Tidak ada duplikat name="event_date", name="location", dsb.
                            --}}
                            <div x-show="!!form.event_type" class="space-y-4">

                                {{-- [BARIS 1] Nama Utama (bride_name)
                                     · pernikahan  → Nama Mempelai Wanita
                                     · buka_puasa  → Nama Host / Penyelenggara
                                     · workshop    → Nama Pembicara / Trainer
                                     · future type → gunakan currentTypeConfig().hostLabel
                                --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            <span x-text="currentTypeConfig().hostLabel"></span>
                                            <span class="text-red-500"> *</span>
                                        </label>
                                        <input type="text" name="bride_name" x-model="form.bride_name"
                                               :placeholder="currentTypeConfig().hostPlaceholder"
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                               value="{{ old('bride_name') }}">
                                        @error('bride_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- [KONDISIONAL] Nama Mempelai Pria — hanya pernikahan.
                                         Untuk tipe lain kolom ini tidak dirender di DOM sama sekali
                                         (x-if bukan x-show) sehingga name="groom_name" tidak dikirim.
                                    --}}
                                    <template x-if="form.event_type === 'pernikahan'">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Nama Mempelai Pria <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="groom_name" x-model="form.groom_name"
                                                   placeholder="Nama lengkap mempelai pria"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                   value="{{ old('groom_name') }}">
                                            @error('groom_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </template>

                                    {{-- [KONDISIONAL] Jabatan / Keahlian — hanya workshop --}}
                                    <template x-if="['workshop','kegiatan_kantor','rapat','pelatihan'].includes(form.event_type)">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Jabatan / Keahlian
                                                <span class="text-gray-400 text-xs">(opsional)</span>
                                            </label>
                                            <input type="text" name="event_data[speaker_title]"
                                                   x-model="form.event_data.speaker_title"
                                                   placeholder="CEO, Digital Marketer, dsb."
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                   value="{{ old('event_data.speaker_title') }}">
                                        </div>
                                    </template>
                                </div>

                                {{-- [KONDISIONAL] Orang tua mempelai — hanya pernikahan --}}
                                <template x-if="form.event_type === 'pernikahan'">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Orang Tua Mempelai Wanita
                                                <span class="text-gray-400 text-xs">(opsional)</span>
                                            </label>
                                            <input type="text" name="event_data[bride_parents]"
                                                   x-model="form.event_data.bride_parents"
                                                   placeholder="Bpk. Ahmad & Ibu Siti"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                   value="{{ old('event_data.bride_parents') }}">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Orang Tua Mempelai Pria
                                                <span class="text-gray-400 text-xs">(opsional)</span>
                                            </label>
                                            <input type="text" name="event_data[groom_parents]"
                                                   x-model="form.event_data.groom_parents"
                                                   placeholder="Bpk. Budi & Ibu Dewi"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                   value="{{ old('event_data.groom_parents') }}">
                                        </div>
                                    </div>
                                </template>

                                {{-- [BARIS 2] Tanggal & Waktu
                                     Satu input event_date, label berubah:
                                     · pernikahan  → Tanggal & Waktu Akad
                                     · buka_puasa  → Tanggal & Waktu
                                     · workshop    → Tanggal & Waktu Mulai
                                --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            <span x-text="currentTypeConfig().dateLabel"></span>
                                            <span class="text-red-500"> *</span>
                                        </label>
                                        <input type="datetime-local" name="event_date" x-model="form.event_date"
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                               value="{{ old('event_date') }}">
                                        @error('event_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- [KONDISIONAL] Tanggal Resepsi — hanya pernikahan --}}
                                    <template x-if="form.event_type === 'pernikahan'">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Tanggal & Waktu Resepsi
                                                <span class="text-gray-400 text-xs">(opsional)</span>
                                            </label>
                                            <input type="datetime-local" name="event_data[reception_date]"
                                                   x-model="form.event_data.reception_date"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                   value="{{ old('event_data.reception_date') }}">
                                        </div>
                                    </template>

                                    {{-- [KONDISIONAL] Waktu Selesai — hanya workshop (multi-hari diizinkan) --}}
                                    <template x-if="['workshop','kegiatan_kantor','rapat','pelatihan'].includes(form.event_type)">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Tanggal & Waktu Selesai
                                                <span class="text-gray-400 text-xs">(multi-hari diizinkan — opsional)</span>
                                            </label>
                                            <input type="datetime-local" name="event_data[end_date]"
                                                   x-model="form.event_data.end_date"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                   value="{{ old('event_data.end_date') }}">
                                        </div>
                                    </template>
                                </div>

                                {{-- [BARIS 3] Lokasi — satu textarea, placeholder berubah per tipe --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        <span x-text="currentTypeConfig().locationLabel"></span>
                                        <span class="text-red-500"> *</span>
                                    </label>
                                    <textarea name="location" x-model="form.location" rows="2"
                                              :placeholder="currentTypeConfig().locationPlaceholder"
                                              class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('location') }}</textarea>
                                    @error('location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- [BARIS 4] Google Maps — semua tipe (opsional) --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Link Google Maps <span class="text-gray-400 text-xs">(opsional)</span>
                                    </label>
                                    <input type="url" name="maps_link" x-model="form.maps_link"
                                           placeholder="https://maps.google.com/..."
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                           value="{{ old('maps_link') }}">
                                    @error('maps_link')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- [KONDISIONAL] Keterangan / Deskripsi — buka_puasa & workshop
                                     Menggunakan x-show (bukan x-if) agar textarea tetap di DOM
                                     dan nilai tidak hilang saat switch tab antar tipe.
                                     Label berubah via currentTypeConfig().descLabel.
                                --}}
                                <div x-show="['buka_puasa','workshop','kegiatan_kantor','rapat','pelatihan'].includes(form.event_type)">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        <span x-text="currentTypeConfig().descLabel"></span>
                                        <span class="text-gray-400 text-xs"> (opsional)</span>
                                    </label>
                                    <textarea name="event_data[description]"
                                              x-model="form.event_data.description" rows="3"
                                              :placeholder="currentTypeConfig().descPlaceholder"
                                              class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('event_data.description') }}</textarea>
                                </div>

                                {{-- [KONDISIONAL] Foto Keluarga / Host — hanya buka_puasa --}}
                                <template x-if="form.event_type === 'buka_puasa'">
                                    <div class="border border-amber-200 dark:border-amber-800/50 rounded-xl overflow-hidden">
                                        <div class="px-4 py-3 bg-amber-50 dark:bg-amber-900/20 border-b border-amber-200 dark:border-amber-800/50">
                                            <p class="text-sm font-semibold text-amber-800 dark:text-amber-400">🌙 Foto Keluarga Penyelenggara</p>
                                            <p class="text-xs text-amber-600 dark:text-amber-500 mt-0.5">Foto yang akan ditampilkan di halaman undangan agar tamu mengenali penyelenggara</p>
                                        </div>
                                        <div class="p-4">
                                            <div class="flex flex-col sm:flex-row gap-4 items-start">
                                                {{-- Upload area --}}
                                                <div class="w-full sm:w-48 flex-shrink-0">
                                                    <div class="relative border-2 border-dashed border-amber-300 dark:border-amber-700 rounded-xl overflow-hidden cursor-pointer hover:border-amber-500 transition-colors bg-amber-50 dark:bg-amber-900/10"
                                                         style="aspect-ratio:4/3;"
                                                         @click="$refs.hostPhoto.click()">
                                                        <div x-show="!hostPhotoPreview"
                                                             class="absolute inset-0 flex flex-col items-center justify-center gap-2 p-3 text-center">
                                                            <svg class="w-10 h-10 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            </svg>
                                                            <span class="text-xs text-amber-500 dark:text-amber-400">Klik untuk upload<br>foto keluarga</span>
                                                        </div>
                                                        <img x-show="hostPhotoPreview"
                                                             :src="hostPhotoPreview"
                                                             class="w-full h-full object-cover" alt="Preview foto host">
                                                    </div>
                                                    <input type="file" name="host_photo"
                                                           accept="image/jpeg,image/png,image/webp"
                                                           x-ref="hostPhoto" class="hidden"
                                                           @change="handleHostPhoto($event)">
                                                    <p x-show="hostPhotoPreview"
                                                       class="mt-1.5 text-xs text-center text-amber-500 cursor-pointer hover:text-amber-700"
                                                       @click="$refs.hostPhoto.click()">
                                                        Ganti foto
                                                    </p>
                                                </div>

                                                {{-- Hint teks --}}
                                                <div class="text-sm text-gray-500 dark:text-gray-400 space-y-2 pt-1">
                                                    <p class="font-medium text-gray-600 dark:text-gray-300">Tips foto yang baik:</p>
                                                    <ul class="space-y-1 text-xs list-disc list-inside">
                                                        <li>Foto keluarga atau foto bersama</li>
                                                        <li>Format landscape (4:3) atau portrait</li>
                                                        <li>Resolusi minimal 600×400 px</li>
                                                        <li>Ukuran maksimal 2MB (JPG/PNG/WEBP)</li>
                                                    </ul>
                                                    <p class="text-xs text-amber-500 dark:text-amber-400 mt-2">
                                                        Foto ini akan muncul di undangan sebagai identitas keluarga penyelenggara.
                                                    </p>
                                                </div>
                                            </div>
                                            @error('host_photo')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </template>

                                {{-- [KONDISIONAL] Sertifikat — hanya workshop --}}
                                <template x-if="['workshop','kegiatan_kantor','rapat','pelatihan'].includes(form.event_type)">
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                        <div>
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Sertifikat</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Apakah peserta mendapat sertifikat?</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <input type="hidden" name="event_data[sertifikat]" :value="form.event_data.sertifikat">
                                            <button type="button"
                                                    @click="form.event_data.sertifikat = form.event_data.sertifikat === '1' ? '0' : '1'"
                                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200"
                                                    :class="form.event_data.sertifikat === '1' ? 'bg-indigo-600' : 'bg-gray-300 dark:bg-gray-600'">
                                                <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                                                      :class="form.event_data.sertifikat === '1' ? 'translate-x-6' : 'translate-x-1'"></span>
                                            </button>
                                            <span class="text-sm font-medium w-12"
                                                  :class="form.event_data.sertifikat === '1' ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400'"
                                                  x-text="form.event_data.sertifikat === '1' ? 'Ya' : 'Tidak'"></span>
                                        </div>
                                    </div>
                                </template>

                                {{-- [KONDISIONAL] Biaya Sukarela — hanya workshop --}}
                                <template x-if="['workshop','kegiatan_kantor','rapat','pelatihan'].includes(form.event_type)">
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                        <div>
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Biaya Sukarela</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Apakah ada biaya sukarela setelah kegiatan?</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <input type="hidden" name="event_data[biaya_sukarela]" :value="form.event_data.biaya_sukarela">
                                            <button type="button"
                                                    @click="form.event_data.biaya_sukarela = form.event_data.biaya_sukarela === '1' ? '0' : '1'"
                                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200"
                                                    :class="form.event_data.biaya_sukarela === '1' ? 'bg-indigo-600' : 'bg-gray-300 dark:bg-gray-600'">
                                                <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                                                      :class="form.event_data.biaya_sukarela === '1' ? 'translate-x-6' : 'translate-x-1'"></span>
                                            </button>
                                            <span class="text-sm font-medium w-12"
                                                  :class="form.event_data.biaya_sukarela === '1' ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400'"
                                                  x-text="form.event_data.biaya_sukarela === '1' ? 'Ya' : 'Tidak'"></span>
                                        </div>
                                    </div>
                                </template>

                                {{-- [KONDISIONAL] Link Live Stream — hanya workshop --}}
                                <template x-if="['workshop','kegiatan_kantor','rapat','pelatihan'].includes(form.event_type)">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Link Live Stream
                                            <span class="text-gray-400 text-xs">(opsional — YouTube, Zoom, dll.)</span>
                                        </label>
                                        <input type="url" name="event_data[livestream_link]"
                                               x-model="form.event_data.livestream_link"
                                               placeholder="https://youtube.com/live/... atau https://zoom.us/j/..."
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                               value="{{ old('event_data.livestream_link') }}">
                                    </div>
                                </template>

                                {{-- [KONDISIONAL] Tampilkan Daftar Peserta — hanya workshop --}}
                                <template x-if="['workshop','kegiatan_kantor','rapat','pelatihan'].includes(form.event_type)">
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                        <div>
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Tampilkan Daftar Peserta</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Peserta yang hadir akan terlihat di halaman undangan</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <input type="hidden" name="event_data[peserta_publik]" :value="form.event_data.peserta_publik">
                                            <button type="button"
                                                    @click="form.event_data.peserta_publik = form.event_data.peserta_publik === '1' ? '0' : '1'"
                                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200"
                                                    :class="form.event_data.peserta_publik === '1' ? 'bg-indigo-600' : 'bg-gray-300 dark:bg-gray-600'">
                                                <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                                                      :class="form.event_data.peserta_publik === '1' ? 'translate-x-6' : 'translate-x-1'"></span>
                                            </button>
                                            <span class="text-sm font-medium w-12"
                                                  :class="form.event_data.peserta_publik === '1' ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400'"
                                                  x-text="form.event_data.peserta_publik === '1' ? 'Ya' : 'Tidak'"></span>
                                        </div>
                                    </div>
                                </template>

                                {{-- [KONDISIONAL] Tim Pemateri & MC — hanya workshop --}}
                                <template x-if="['workshop','kegiatan_kantor','rapat','pelatihan'].includes(form.event_type)">
                                    <div class="border border-gray-200 dark:border-gray-600 rounded-xl overflow-hidden">
                                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-600">
                                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">🎤 Tim Pemateri & MC</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Tambah foto dan info pemateri untuk ditampilkan di halaman undangan</p>
                                        </div>
                                        <div class="p-4 space-y-5">

                                            {{-- Pemateri 1 (Pakar/Narasumber Utama) --}}
                                            <div>
                                                <p class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-3">Pemateri Utama</p>
                                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-start">
                                                    {{-- Foto --}}
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Foto <span class="font-normal">(opsional)</span></label>
                                                        <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl overflow-hidden cursor-pointer hover:border-indigo-400 transition-colors bg-gray-50 dark:bg-gray-700/30"
                                                             style="aspect-ratio:3/4;"
                                                             @click="$refs.speaker1Photo.click()">
                                                            <div x-show="!speaker1Preview" class="absolute inset-0 flex flex-col items-center justify-center gap-1">
                                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                                </svg>
                                                                <span class="text-xs text-gray-400">Upload foto</span>
                                                            </div>
                                                            <img x-show="speaker1Preview" :src="speaker1Preview"
                                                                 class="w-full h-full object-cover" alt="">
                                                        </div>
                                                        <input type="file" name="speaker1_photo" accept="image/*"
                                                               x-ref="speaker1Photo" class="hidden"
                                                               @change="handleSpeakerPhoto($event, 1)">
                                                    </div>
                                                    {{-- Info --}}
                                                    <div class="sm:col-span-2 space-y-2">
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Nama Lengkap + Gelar</label>
                                                            <input type="text" name="event_data[speaker1_name]"
                                                                   x-model="form.event_data.speaker1_name"
                                                                   placeholder="Dr. Budi Santoso, M.Si."
                                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                                   value="{{ old('event_data.speaker1_name') }}">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Jabatan / Keahlian</label>
                                                            <input type="text" name="event_data[speaker1_title]"
                                                                   x-model="form.event_data.speaker1_title"
                                                                   placeholder="CEO, Dosen, Digital Marketer, dsb."
                                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                                   value="{{ old('event_data.speaker1_title') }}">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Peran di Acara</label>
                                                            <input type="text" name="event_data[speaker1_role]"
                                                                   x-model="form.event_data.speaker1_role"
                                                                   placeholder="Pakar / Narasumber / Trainer"
                                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                                   value="{{ old('event_data.speaker1_role') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="border-gray-200 dark:border-gray-700">

                                            {{-- Pemateri 2 (Opsional) --}}
                                            <div>
                                                <p class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-3">Pemateri 2 <span class="text-gray-400 font-normal normal-case">(opsional)</span></p>
                                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-start">
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Foto</label>
                                                        <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl overflow-hidden cursor-pointer hover:border-indigo-400 transition-colors bg-gray-50 dark:bg-gray-700/30"
                                                             style="aspect-ratio:3/4;"
                                                             @click="$refs.speaker2Photo.click()">
                                                            <div x-show="!speaker2Preview" class="absolute inset-0 flex flex-col items-center justify-center gap-1">
                                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                                </svg>
                                                                <span class="text-xs text-gray-400">Upload foto</span>
                                                            </div>
                                                            <img x-show="speaker2Preview" :src="speaker2Preview"
                                                                 class="w-full h-full object-cover" alt="">
                                                        </div>
                                                        <input type="file" name="speaker2_photo" accept="image/*"
                                                               x-ref="speaker2Photo" class="hidden"
                                                               @change="handleSpeakerPhoto($event, 2)">
                                                    </div>
                                                    <div class="sm:col-span-2 space-y-2">
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Nama Lengkap + Gelar</label>
                                                            <input type="text" name="event_data[speaker2_name]"
                                                                   x-model="form.event_data.speaker2_name"
                                                                   placeholder="Nama pemateri kedua"
                                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                                   value="{{ old('event_data.speaker2_name') }}">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Jabatan / Keahlian</label>
                                                            <input type="text" name="event_data[speaker2_title]"
                                                                   x-model="form.event_data.speaker2_title"
                                                                   placeholder="Jabatan atau keahlian"
                                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                                   value="{{ old('event_data.speaker2_title') }}">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Peran di Acara</label>
                                                            <input type="text" name="event_data[speaker2_role]"
                                                                   x-model="form.event_data.speaker2_role"
                                                                   placeholder="Pemateri / Co-Trainer"
                                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                                   value="{{ old('event_data.speaker2_role') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="border-gray-200 dark:border-gray-700">

                                            {{-- MC / Pembawa Acara (Opsional) --}}
                                            <div>
                                                <p class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-3">MC / Pembawa Acara <span class="text-gray-400 font-normal normal-case">(opsional)</span></p>
                                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-start">
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Foto</label>
                                                        <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl overflow-hidden cursor-pointer hover:border-indigo-400 transition-colors bg-gray-50 dark:bg-gray-700/30"
                                                             style="aspect-ratio:3/4;"
                                                             @click="$refs.mcPhoto.click()">
                                                            <div x-show="!mcPreview" class="absolute inset-0 flex flex-col items-center justify-center gap-1">
                                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                                </svg>
                                                                <span class="text-xs text-gray-400">Upload foto</span>
                                                            </div>
                                                            <img x-show="mcPreview" :src="mcPreview"
                                                                 class="w-full h-full object-cover" alt="">
                                                        </div>
                                                        <input type="file" name="mc_photo" accept="image/*"
                                                               x-ref="mcPhoto" class="hidden"
                                                               @change="handleSpeakerPhoto($event, 'mc')">
                                                    </div>
                                                    <div class="sm:col-span-2 space-y-2">
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Nama Lengkap + Gelar</label>
                                                            <input type="text" name="event_data[mc_name]"
                                                                   x-model="form.event_data.mc_name"
                                                                   placeholder="Nama pembawa acara"
                                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                                   value="{{ old('event_data.mc_name') }}">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Jabatan / Instansi</label>
                                                            <input type="text" name="event_data[mc_title]"
                                                                   x-model="form.event_data.mc_title"
                                                                   placeholder="Jabatan atau instansi"
                                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                                   value="{{ old('event_data.mc_title') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </template>

                                {{-- [KONDISIONAL] Fields Pemberitahuan Kedinasan --}}
                                <template x-if="form.event_type === 'official_notice'">
                                    <div class="space-y-4">

                                        {{-- Total Target ASN --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Total Target ASN <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" name="total_target_asn" min="0"
                                                   x-model="form.event_data.total_target_asn"
                                                   placeholder="Contoh: 120"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                   value="{{ old('total_target_asn') }}">
                                            <p class="mt-1 text-xs text-gray-400">Jumlah total ASN yang wajib melaporkan.</p>
                                        </div>

                                        {{-- Nomor Surat --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Nomor Surat <span class="text-gray-400 text-xs">(opsional)</span>
                                            </label>
                                            <input type="text" name="event_data[notice_number]"
                                                   x-model="form.event_data.notice_number"
                                                   placeholder="Contoh: 001/UN.1/HM/2026"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm font-mono"
                                                   value="{{ old('event_data.notice_number') }}">
                                        </div>

                                        {{-- Tingkat Urgensi --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Tingkat Urgensi
                                            </label>
                                            <div class="grid grid-cols-3 gap-3">
                                                <template x-for="lvl in [{v:'normal',l:'Normal',c:'blue'},{v:'important',l:'Penting',c:'amber'},{v:'urgent',l:'Mendesak',c:'red'}]" :key="lvl.v">
                                                    <label class="relative flex flex-col items-center gap-1 p-3 rounded-xl border-2 cursor-pointer transition-all"
                                                           :class="form.event_data.notice_level === lvl.v
                                                               ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/30'
                                                               : 'border-gray-200 dark:border-gray-600 hover:border-indigo-300'">
                                                        <input type="radio" name="event_data[notice_level]"
                                                               :value="lvl.v" x-model="form.event_data.notice_level" class="sr-only">
                                                        <span x-text="lvl.l" class="text-sm font-semibold text-gray-700 dark:text-gray-300"></span>
                                                    </label>
                                                </template>
                                            </div>
                                        </div>

                                        {{-- Batas Waktu / Deadline --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Batas Waktu / Deadline <span class="text-gray-400 text-xs">(opsional)</span>
                                            </label>
                                            <input type="text" name="event_data[deadline]"
                                                   x-model="form.event_data.deadline"
                                                   placeholder="Contoh: 31 Maret 2026 pukul 16.00 WIB"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                   value="{{ old('event_data.deadline') }}">
                                        </div>

                                        {{-- Unit Penerbit --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Unit / Bagian Penerbit <span class="text-gray-400 text-xs">(opsional)</span>
                                            </label>
                                            <input type="text" name="event_data[issuing_unit]"
                                                   x-model="form.event_data.issuing_unit"
                                                   placeholder="Biro Umum, Sekretariat, dsb."
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                   value="{{ old('event_data.issuing_unit') }}">
                                        </div>

                                        {{-- Isi Pemberitahuan --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Isi Pemberitahuan <span class="text-gray-400 text-xs">(opsional)</span>
                                            </label>
                                            <textarea name="event_data[description]"
                                                      x-model="form.event_data.description"
                                                      rows="5"
                                                      placeholder="Jelaskan isi pemberitahuan secara lengkap..."
                                                      class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old('event_data.description') }}</textarea>
                                        </div>

                                        {{-- Komitmen ZI/WBK/WBBM --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Komitmen ZI / WBK / WBBM <span class="text-gray-400 text-xs">(opsional)</span>
                                            </label>
                                            <textarea name="event_data[zi_commitment]"
                                                      x-model="form.event_data.zi_commitment"
                                                      rows="3"
                                                      placeholder="Tuliskan komitmen zona integritas instansi..."
                                                      class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old('event_data.zi_commitment') }}</textarea>
                                        </div>

                                        {{-- Narahubung --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Narahubung / Kontak <span class="text-gray-400 text-xs">(opsional)</span>
                                            </label>
                                            <input type="text" name="event_data[contact_person]"
                                                   x-model="form.event_data.contact_person"
                                                   placeholder="Nama dan nomor HP narahubung"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                   value="{{ old('event_data.contact_person') }}">
                                        </div>

                                    </div>
                                </template>

                            </div>{{-- end unified fields --}}
                        </div>

                        {{-- ============================
                             STEP 3: Media & Pengaturan
                             ============================ --}}
                        <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-x-4"
                             x-transition:enter-end="opacity-100 translate-x-0">

                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Media & Pengaturan</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Upload foto dan atur fitur undangan (semua opsional).</p>

                            {{-- Banner Image --}}
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Foto Banner / Cover
                                    <span class="text-gray-400 text-xs">(opsional — maks. 2MB)</span>
                                </label>
                                <div
                                    class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center cursor-pointer hover:border-indigo-400 transition-colors"
                                    @click="$refs.bannerInput.click()"
                                    @dragover.prevent
                                    @drop.prevent="handleBannerDrop($event)"
                                >
                                    <div x-show="!bannerPreview">
                                        <svg class="mx-auto h-10 w-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-sm text-gray-500">Klik atau drag foto ke sini</p>
                                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP</p>
                                    </div>
                                    <div x-show="bannerPreview">
                                        <img :src="bannerPreview" class="mx-auto max-h-40 rounded-lg object-cover">
                                        <p class="text-xs text-gray-400 mt-2">Klik untuk ganti foto</p>
                                    </div>
                                </div>
                                <input type="file" name="banner_image" accept="image/jpeg,image/png,image/webp"
                                       x-ref="bannerInput" class="hidden"
                                       @change="handleBannerChange($event)">
                                @error('banner_image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Gallery Images --}}
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Galeri Foto
                                        <span class="text-gray-400 text-xs">(opsional — maks. 8 foto)</span>
                                    </label>
                                    {{-- Counter badge: e.g. "3 / 8" --}}
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
                                    <div x-show="galleryPreviews.length === 0" class="py-4">
                                        <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        <p class="text-sm text-gray-500">Klik atau drag foto ke sini</p>
                                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP · Maks. 8 foto</p>
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
                                            <span class="text-xs" x-text="'Tambah (' + (8 - galleryPreviews.length) + ' sisa)'"></span>
                                        </div>
                                    </div>
                                </div>
                                <input type="file" name="gallery_images[]" accept="image/jpeg,image/png,image/webp" multiple
                                       x-ref="galleryInput" class="hidden"
                                       @change="handleGalleryChange($event)">
                                @error('gallery_images')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @error('gallery_images.*')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- RSVP Toggle --}}
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl mb-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Aktifkan RSVP</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Tamu dapat mengkonfirmasi kehadiran secara online</p>
                                </div>
                                <button type="button" @click="form.rsvp_enabled = !form.rsvp_enabled"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200"
                                        :class="form.rsvp_enabled ? 'bg-indigo-600' : 'bg-gray-300 dark:bg-gray-600'">
                                    <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                                          :class="form.rsvp_enabled ? 'translate-x-6' : 'translate-x-1'"></span>
                                </button>
                                <input type="hidden" name="rsvp_enabled" :value="form.rsvp_enabled ? '1' : '0'">
                            </div>

                            {{-- Background Music Picker --}}
                            @php
                                $musicList = \App\Models\MusicLibrary::where('is_active', true)->orderBy('title')->get();
                            @endphp
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl"
                                 x-data="{ selected: {{ old('music_id') ? (int)old('music_id') : 'null' }} }">
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

                            {{-- Upload Dokumen Resmi (PDF) — khusus official_notice --}}
                            <div x-show="form.event_type === 'official_notice'" class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Dokumen Resmi (PDF)
                                    <span class="text-gray-400 text-xs">(opsional — maks. 3MB)</span>
                                </label>
                                <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-5 text-center cursor-pointer hover:border-indigo-400 transition-colors"
                                     @click="$refs.pdfInput.click()">
                                    <div x-show="!pdfFileName">
                                        <svg class="mx-auto h-10 w-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-sm text-gray-500">Klik untuk upload surat / nota dinas / SK</p>
                                        <p class="text-xs text-gray-400 mt-1">PDF saja, maks. 3MB</p>
                                    </div>
                                    <div x-show="pdfFileName" class="flex items-center justify-center gap-3">
                                        <svg class="w-8 h-8 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM11 14.5h2v1h-2v-1zm0-3h2v2.5h-2V11.5zm-3 3h1.5v1H8v-1zm0-3h1.5v2.5H8V11.5zm7 3h1.5v1H15v-1zm0-3h1.5v2.5H15V11.5z"/>
                                        </svg>
                                        <div class="text-left">
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300" x-text="pdfFileName"></p>
                                            <p class="text-xs text-gray-400 mt-0.5">Klik untuk ganti file</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="file" name="official_document" accept="application/pdf"
                                       x-ref="pdfInput" class="hidden"
                                       @change="handlePdfChange($event)">
                                @error('official_document')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- ============================
                             STEP 4: Review & Submit
                             ============================ --}}
                        <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-x-4"
                             x-transition:enter-end="opacity-100 translate-x-0">

                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Review & Konfirmasi</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Periksa kembali sebelum menyimpan undangan.</p>

                            <div class="space-y-3">
                                {{-- Jenis Acara --}}
                                <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <span class="text-xl mt-0.5" x-text="getEventTypeIcon()"></span>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wide">Jenis Acara</p>
                                        <p class="text-sm font-medium text-gray-800 dark:text-white"
                                           x-text="getEventTypeLabel() || '—'"></p>
                                    </div>
                                </div>

                                {{-- Judul --}}
                                <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <span class="text-xl mt-0.5">📋</span>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wide">Judul Undangan</p>
                                        <p class="text-sm font-medium text-gray-800 dark:text-white"
                                           x-text="form.title || '—'"></p>
                                    </div>
                                </div>

                                {{-- Nama (label & value berubah sesuai event_type via helper) --}}
                                <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <span class="text-xl mt-0.5">👤</span>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wide"
                                           x-text="previewNameLabel()"></p>
                                        <p class="text-sm font-medium text-gray-800 dark:text-white"
                                           x-text="previewNameValue()"></p>
                                    </div>
                                </div>

                                {{-- Tanggal --}}
                                <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <span class="text-xl mt-0.5">📅</span>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wide">Tanggal & Waktu</p>
                                        <p class="text-sm font-medium text-gray-800 dark:text-white"
                                           x-text="form.event_date ? new Date(form.event_date).toLocaleString('id-ID', {dateStyle:'long', timeStyle:'short'}) : '—'"></p>
                                    </div>
                                </div>

                                {{-- Lokasi --}}
                                <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <span class="text-xl mt-0.5">📍</span>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wide">Lokasi</p>
                                        <p class="text-sm font-medium text-gray-800 dark:text-white"
                                           x-text="form.location || '—'"></p>
                                    </div>
                                </div>

                                {{-- RSVP --}}
                                <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <span class="text-xl mt-0.5">✅</span>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wide">RSVP Online</p>
                                        <p class="text-sm font-medium"
                                           :class="form.rsvp_enabled ? 'text-green-600 dark:text-green-400' : 'text-gray-500'"
                                           x-text="form.rsvp_enabled ? 'Diaktifkan' : 'Nonaktif'"></p>
                                    </div>
                                </div>

                                {{-- Media --}}
                                <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <span class="text-xl mt-0.5">🖼️</span>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wide">Media</p>
                                        <p class="text-sm font-medium text-gray-800 dark:text-white">
                                            <span x-text="bannerPreview ? 'Banner ✓' : 'Tanpa banner'"></span>
                                            <span x-show="galleryPreviews.length > 0"
                                                  x-text="' · ' + galleryPreviews.length + ' foto galeri'"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 p-4 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-800 rounded-xl">
                                <p class="text-sm text-indigo-700 dark:text-indigo-300">
                                    💡 Undangan akan tersimpan sebagai <strong>Draft</strong>. Kamu bisa publikasikan kapan saja dari halaman detail undangan.
                                </p>
                            </div>
                        </div>

                    </div>{{-- end p-6 --}}

                    {{-- Navigation Buttons --}}
                    <div class="px-6 pb-6 flex items-center justify-between border-t border-gray-100 dark:border-gray-700 pt-5">
                        <button
                            type="button"
                            @click="prevStep()"
                            x-show="currentStep > 1"
                            class="px-5 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                        >
                            &larr; Sebelumnya
                        </button>
                        <div x-show="currentStep === 1" class="text-xs text-gray-400">Langkah 1/4</div>

                        <div class="flex gap-3 ml-auto">
                            <button
                                type="button"
                                @click="nextStep()"
                                x-show="currentStep < 4"
                                :disabled="!canProceed()"
                                class="px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                Lanjut &rarr;
                            </button>

                            <button
                                type="submit"
                                x-show="currentStep === 4"
                                :disabled="isSubmitting"
                                class="px-6 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition disabled:opacity-50"
                            >
                                <span x-show="!isSubmitting">💾 Simpan Undangan</span>
                                <span x-show="isSubmitting">Menyimpan...</span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
    function wizardForm() {
        return {
            currentStep: {{ $errors->any() ? 1 : 1 }},
            isSubmitting: false,
            bannerPreview: null,
            galleryPreviews: [],
            galleryFiles: [],
            slugPreview: '',
            speaker1Preview: null,
            speaker2Preview: null,
            mcPreview: null,
            hostPhotoPreview: null,
            pdfFileName: null,

            stepLabels: ['Informasi Dasar', 'Detail Acara', 'Media & Pengaturan', 'Review & Konfirmasi'],

            eventTypes: [
                { value: 'pernikahan',       label: 'Pernikahan',       icon: '💒' },
                { value: 'buka_puasa',       label: 'Buka Puasa',       icon: '🌙' },
                { value: 'workshop',         label: 'Workshop',         icon: '🎓' },
                { value: 'kegiatan_kantor',  label: 'Kegiatan Kantor',       icon: '🏛️' },
                { value: 'rapat',            label: 'Rapat',                 icon: '👔' },
                { value: 'pelatihan',        label: 'Pelatihan',             icon: '📋' },
                { value: 'official_notice',  label: 'Pemberitahuan Kedinasan', icon: '📢' },
            ],


            form: {
                event_type:   '{{ old('event_type', '') }}',
                title:        '{{ old('title', '') }}',
                package_id:   '{{ old('package_id', '') }}',
                theme_id:     '{{ old('theme_id', '') }}',
                bride_name:   '{{ old('bride_name', '') }}',
                groom_name:   '{{ old('groom_name', '') }}',
                event_date:   '{{ old('event_date', '') }}',
                location:     '{{ old('location', '') }}',
                maps_link:    '{{ old('maps_link', '') }}',
                rsvp_enabled: true,
                event_data: {
                    bride_parents:   '{{ old('event_data.bride_parents', '') }}',
                    groom_parents:   '{{ old('event_data.groom_parents', '') }}',
                    reception_date:  '{{ old('event_data.reception_date', '') }}',
                    description:     '{{ old('event_data.description', '') }}',
                    speaker_title:   '{{ old('event_data.speaker_title', '') }}',
                    end_date:        '{{ old('event_data.end_date', '') }}',
                    sertifikat:      '{{ old('event_data.sertifikat', '0') }}',
                    biaya_sukarela:  '{{ old('event_data.biaya_sukarela', '0') }}',
                    livestream_link: '{{ old('event_data.livestream_link', '') }}',
                    peserta_publik:  '{{ old('event_data.peserta_publik', '0') }}',
                    speaker1_name:   '{{ old('event_data.speaker1_name', '') }}',
                    speaker1_title:  '{{ old('event_data.speaker1_title', '') }}',
                    speaker1_role:   '{{ old('event_data.speaker1_role', '') }}',
                    speaker2_name:   '{{ old('event_data.speaker2_name', '') }}',
                    speaker2_title:  '{{ old('event_data.speaker2_title', '') }}',
                    speaker2_role:   '{{ old('event_data.speaker2_role', '') }}',
                    mc_name:         '{{ old('event_data.mc_name', '') }}',
                    mc_title:        '{{ old('event_data.mc_title', '') }}',
                    // official_notice fields
                    total_target_asn: '{{ old('total_target_asn', '') }}',
                    deadline:        '{{ old('event_data.deadline', '') }}',
                    notice_number:   '{{ old('event_data.notice_number', '') }}',
                    notice_level:    '{{ old('event_data.notice_level', 'normal') }}',
                    issuing_unit:    '{{ old('event_data.issuing_unit', '') }}',
                    zi_commitment:   '{{ old('event_data.zi_commitment', '') }}',
                    contact_person:  '{{ old('event_data.contact_person', '') }}',
                },
            },

            init() {
                // Always reset submitting state on page load (handles back-redirect after validation error)
                this.isSubmitting = false;
                @if ($errors->any())
                    this.currentStep = 1;
                @endif
                if (this.form.title) this.generateSlugPreview();
            },

            generateSlugPreview() {
                this.slugPreview = this.form.title
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .trim()
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            },

            getEventTypeLabel() {
                const found = this.eventTypes.find(t => t.value === this.form.event_type);
                return found ? found.label : '';
            },

            getEventTypeIcon() {
                const found = this.eventTypes.find(t => t.value === this.form.event_type);
                return found ? found.icon : '🎉';
            },

            // Returns label/placeholder config per event_type.
            // To add a new type: add entry to eventTypes[] AND add a case here.
            currentTypeConfig() {
                const configs = {
                    pernikahan: {
                        subtitle:           'Isi detail pernikahan — mempelai, tanggal akad & resepsi.',
                        hostLabel:          'Nama Mempelai Wanita',
                        hostPlaceholder:    'Nama lengkap mempelai wanita',
                        dateLabel:          'Tanggal & Waktu Akad',
                        locationLabel:      'Lokasi Akad / Resepsi',
                        locationPlaceholder:'Gedung Serbaguna, Jl. Mawar No. 10, Kota',
                        descLabel:          '',
                        descPlaceholder:    '',
                    },
                    buka_puasa: {
                        subtitle:           'Isi detail acara buka puasa bersama.',
                        hostLabel:          'Nama Host / Penyelenggara',
                        hostPlaceholder:    'Keluarga Bpk. Ahmad',
                        dateLabel:          'Tanggal & Waktu',
                        locationLabel:      'Lokasi Acara',
                        locationPlaceholder:'Jl. Merpati No. 5, RT 03/RW 02, Kelurahan, Kota',
                        descLabel:          'Keterangan / Pesan Tambahan',
                        descPlaceholder:    'Contoh: Disediakan takjil dan makan bersama, mohon hadir tepat waktu.',
                    },
                    workshop: {
                        subtitle:           'Isi detail workshop / seminar.',
                        hostLabel:          'Nama Pembicara / Trainer',
                        hostPlaceholder:    'Nama pembicara utama',
                        dateLabel:          'Tanggal & Waktu Mulai',
                        locationLabel:      'Lokasi / Link Zoom',
                        locationPlaceholder:'Offline: Nama Gedung, Alamat  |  Online: https://zoom.us/j/...',
                        descLabel:          'Deskripsi Workshop',
                        descPlaceholder:    'Jelaskan topik, manfaat, dan apa yang akan dipelajari peserta...',
                    },
                    kegiatan_kantor: {
                        subtitle:           'Isi detail kegiatan kantor.',
                        hostLabel:          'Nama Penyelenggara / Unit Kerja',
                        hostPlaceholder:    'Biro Umum, Divisi SDM, dsb.',
                        dateLabel:          'Tanggal & Waktu Mulai',
                        locationLabel:      'Lokasi Kegiatan',
                        locationPlaceholder:'Aula Kantor, Jl. Merdeka No. 1, Jakarta',
                        descLabel:          'Deskripsi Kegiatan',
                        descPlaceholder:    'Jelaskan tujuan dan agenda kegiatan...',
                    },
                    rapat: {
                        subtitle:           'Isi detail jadwal rapat.',
                        hostLabel:          'Nama Pemimpin Rapat / Instansi',
                        hostPlaceholder:    'Direktur Utama, Kepala Bagian, dsb.',
                        dateLabel:          'Tanggal & Waktu Mulai',
                        locationLabel:      'Ruang / Lokasi Rapat',
                        locationPlaceholder:'Ruang Rapat Lt. 3, Meeting Room A',
                        descLabel:          'Agenda Rapat',
                        descPlaceholder:    'Tuliskan agenda dan poin pembahasan...',
                    },
                    pelatihan: {
                        subtitle:           'Isi detail program pelatihan.',
                        hostLabel:          'Nama Fasilitator / Instruktur',
                        hostPlaceholder:    'Nama instruktur utama',
                        dateLabel:          'Tanggal & Waktu Mulai',
                        locationLabel:      'Lokasi / Platform Pelatihan',
                        locationPlaceholder:'Gedung Training Center  |  Online: https://zoom.us/j/...',
                        descLabel:          'Deskripsi Pelatihan',
                        descPlaceholder:    'Jelaskan materi, tujuan, dan manfaat pelatihan...',
                    },
                    official_notice: {
                        subtitle:           'Isi informasi pemberitahuan kedinasan.',
                        hostLabel:          'Unit / Instansi Penerbit',
                        hostPlaceholder:    'Biro Umum, Sekretariat Daerah, dsb.',
                        dateLabel:          'Tanggal Berlaku',
                        locationLabel:      'Kantor / Instansi',
                        locationPlaceholder:'Nama kantor atau instansi penerbit',
                        descLabel:          'Isi Pemberitahuan',
                        descPlaceholder:    'Jelaskan isi pemberitahuan secara lengkap...',
                    },
                };
                // Default fallback (jika tipe baru belum ada config-nya)
                return configs[this.form.event_type] ?? {
                    subtitle:           'Isi detail acara.',
                    hostLabel:          'Nama Penyelenggara',
                    hostPlaceholder:    'Nama penyelenggara',
                    dateLabel:          'Tanggal & Waktu',
                    locationLabel:      'Lokasi',
                    locationPlaceholder:'Alamat lengkap',
                    descLabel:          'Keterangan',
                    descPlaceholder:    'Informasi tambahan...',
                };
            },

            // Returns the correct preview label for the "name" row in Step 4
            previewNameLabel() {
                const map = {
                    pernikahan:      'Nama Mempelai',
                    buka_puasa:      'Penyelenggara',
                    workshop:        'Pembicara',
                    kegiatan_kantor: 'Penyelenggara',
                    rapat:           'Pemimpin Rapat',
                    pelatihan:       'Instruktur',
                    official_notice: 'Unit Penerbit',
                };
                return map[this.form.event_type] ?? 'Nama';
            },

            // Returns the formatted name value for Step 4 preview
            previewNameValue() {
                if (this.form.event_type === 'pernikahan') {
                    const bride = this.form.bride_name || '…';
                    const groom = this.form.groom_name || '…';
                    return bride + ' & ' + groom;
                }
                return this.form.bride_name || '—';
            },

            canProceed() {
                if (this.currentStep === 1) {
                    return this.form.event_type !== ''
                        && this.form.title.trim() !== ''
                        && this.form.package_id !== '';
                }
                if (this.currentStep === 2) {
                    const hasDate     = this.form.event_date.trim() !== '';
                    const hasLocation = this.form.location.trim() !== '';
                    const hasHost     = this.form.bride_name.trim() !== '';
                    if (this.form.event_type === 'pernikahan') {
                        return hasHost
                            && this.form.groom_name.trim() !== ''
                            && hasDate && hasLocation;
                    }
                    // buka_puasa dan workshop: host/pembicara + tanggal + lokasi
                    return hasHost && hasDate && hasLocation;
                }
                return true;
            },

            nextStep() {
                if (this.canProceed() && this.currentStep < 4) {
                    this.currentStep++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            },

            prevStep() {
                if (this.currentStep > 1) {
                    this.currentStep--;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
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
                // Re-sync input after removal
                this.syncGalleryFiles();
            },

            // Sync galleryFiles array back to the actual file input before submit
            // This ensures ALL accumulated files (added one by one) are sent together
            syncGalleryFiles() {
                if (!this.$refs.galleryInput) return;
                const dt = new DataTransfer();
                this.galleryFiles.forEach(f => dt.items.add(f));
                this.$refs.galleryInput.files = dt.files;
            },

            handleSpeakerPhoto(event, slot) {
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    if (slot === 1)    this.speaker1Preview = e.target.result;
                    else if (slot === 2) this.speaker2Preview = e.target.result;
                    else if (slot === 'mc') this.mcPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            handleHostPhoto(event) {
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => { this.hostPhotoPreview = e.target.result; };
                reader.readAsDataURL(file);
            },

            handlePdfChange(event) {
                const file = event.target.files[0];
                if (!file) return;
                this.pdfFileName = file.name;
            },
        };
    }
    </script>
    @endpush
</x-app-layout>

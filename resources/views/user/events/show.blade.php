<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('user.events.index') }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    &larr; Kembali
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Detail Undangan
                </h2>
            </div>
            <a href="{{ route('user.events.edit', $event) }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                Edit Undangan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg px-4 py-3 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Info Utama --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $event->title }}</h3>
                    @if (! $event->is_published)
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300">
                            Draft
                        </span>
                    @elseif ($event->isExpired())
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300">
                            Expired
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">
                            Aktif
                        </span>
                    @endif
                </div>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Mempelai Wanita</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $event->bride_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Mempelai Pria</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $event->groom_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Tanggal Acara</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                            {{ $event->event_date->translatedFormat('l, d F Y — H:i') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Paket</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                            {{ $event->package->name ?? '-' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Template</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                            {{ $event->template->name ?? '-' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Slug / URL</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100 mt-1 text-xs break-all">
                            {{ $event->slug }}
                        </dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-gray-500 dark:text-gray-400">Lokasi</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $event->location }}</dd>
                    </div>
                    @if ($event->maps_link)
                        <div class="sm:col-span-2">
                            <dt class="text-gray-500 dark:text-gray-400">Google Maps</dt>
                            <dd class="mt-1">
                                <a href="{{ $event->maps_link }}" target="_blank"
                                   class="text-indigo-600 hover:underline text-sm">Buka di Google Maps</a>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Tombol Publikasikan --}}
            @if (! $event->is_published)
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Publikasikan Undangan</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                        Setelah dipublikasikan, undangan akan aktif selama
                        <strong>{{ $event->package->duration_days }} hari</strong>
                        dan tidak dapat diubah kembali ke draft.
                    </p>
                    <form action="{{ route('user.events.publish', $event) }}" method="POST"
                          onsubmit="return confirm('Publikasikan undangan ini sekarang? Undangan akan aktif selama {{ $event->package->duration_days }} hari.')">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition">
                            Publikasikan Sekarang
                        </button>
                    </form>
                </div>
            @endif

            {{-- Link Undangan Publik --}}
            @if ($event->is_published)
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Link Undangan Publik</h4>
                    <div class="flex items-center gap-2">
                        <input type="text" readonly
                               value="{{ route('invitation.show', $event->slug) }}"
                               class="flex-1 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-300"
                               id="invitation-link">
                        <button onclick="navigator.clipboard.writeText(document.getElementById('invitation-link').value).then(() => alert('Link disalin!'))"
                                class="px-3 py-2 bg-indigo-600 text-white text-xs rounded-lg hover:bg-indigo-700">
                            Salin
                        </button>
                        <a href="{{ route('invitation.show', $event->slug) }}" target="_blank"
                           class="px-3 py-2 bg-gray-600 text-white text-xs rounded-lg hover:bg-gray-700">
                            Buka
                        </a>
                    </div>
                </div>
            @endif

            {{-- Statistik Tamu --}}
            @php
                $totalTamu      = $event->guests()->count();
                $totalHadir     = $event->guests()->where('rsvp_status', 'hadir')->count();
                $totalTidakHadir= $event->guests()->where('rsvp_status', 'tidak_hadir')->count();
                $totalPending   = $event->guests()->where('rsvp_status', 'pending')->count();
                $totalWishes    = $event->wishes()->count();
            @endphp
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
                        </svg>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Statistik Tamu</h4>
                    </div>
                    @if($totalHadir > 0)
                    <a href="{{ route('user.events.export-guests', $event) }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                        </svg>
                        Download Excel
                    </a>
                    @endif
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <p class="text-2xl font-bold text-gray-700 dark:text-gray-200">{{ $totalTamu }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total RSVP</p>
                    </div>
                    <div class="text-center p-3 bg-green-50 dark:bg-green-900/20 rounded-xl">
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $totalHadir }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Hadir</p>
                    </div>
                    <div class="text-center p-3 bg-red-50 dark:bg-red-900/20 rounded-xl">
                        <p class="text-2xl font-bold text-red-500 dark:text-red-400">{{ $totalTidakHadir }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tidak Hadir</p>
                    </div>
                    <div class="text-center p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl">
                        <p class="text-2xl font-bold text-amber-500 dark:text-amber-400">{{ $totalPending }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Belum Konfirmasi</p>
                    </div>
                </div>

                @if($totalHadir === 0 && $totalTamu > 0)
                <p class="mt-3 text-xs text-gray-400 dark:text-gray-500 text-center">
                    Belum ada tamu yang konfirmasi hadir. Tombol download akan muncul setelah ada konfirmasi.
                </p>
                @elseif($totalTamu === 0)
                <p class="mt-3 text-xs text-gray-400 dark:text-gray-500 text-center">
                    Belum ada RSVP masuk.
                </p>
                @endif

                {{-- Ucapan & Doa --}}
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Ucapan &amp; Doa</span>
                    <span class="text-sm font-semibold text-pink-500">{{ $totalWishes }}</span>
                </div>
            </div>

            {{-- Hapus --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h4 class="text-sm font-medium text-red-600 mb-2">Zona Berbahaya</h4>
                <form action="{{ route('user.events.destroy', $event) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus undangan ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition">
                        Hapus Undangan
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>

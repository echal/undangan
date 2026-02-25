<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.events.index') }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                &larr; Kembali
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Detail Undangan (Admin)
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Info Utama --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $event->title }}</h3>
                    @if (! $event->is_published)
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300">Draft</span>
                    @elseif ($event->isExpired())
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300">Expired</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">Aktif</span>
                    @endif
                </div>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Pemilik</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                            {{ $event->user->name ?? '-' }}
                            <span class="text-xs text-gray-400">({{ $event->user->email ?? '' }})</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Paket</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $event->package->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Template</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $event->template->name ?? '-' }}</dd>
                    </div>
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
                            {{ $event->event_date->translatedFormat('l, d F Y') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Expired Pada</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                            {{ $event->expired_at ? $event->expired_at->translatedFormat('d F Y, H:i') : 'Belum dipublikasi' }}
                        </dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-gray-500 dark:text-gray-400">Lokasi</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $event->location }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-gray-500 dark:text-gray-400">Slug</dt>
                        <dd class="font-mono text-xs text-gray-700 dark:text-gray-300 mt-1">{{ $event->slug }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-5 text-center">
                    <p class="text-3xl font-bold text-indigo-600">{{ $event->guests->count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Tamu (RSVP)</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-5 text-center">
                    <p class="text-3xl font-bold text-pink-500">{{ $event->wishes->count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Ucapan & Doa</p>
                </div>
            </div>

            {{-- Force Unpublish --}}
            @if ($event->is_published)
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h4 class="text-sm font-medium text-red-600 mb-2">Force Unpublish</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                        Undangan akan dikembalikan ke status <strong>Draft</strong> dan expired_at akan direset.
                        Tamu dan ucapan yang sudah masuk tidak akan dihapus.
                    </p>
                    <form action="{{ route('admin.events.unpublish', $event) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin unpublish undangan ini?')">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition">
                            Unpublish Sekarang
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

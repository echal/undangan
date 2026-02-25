<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Music Library
            </h2>
            <a href="{{ route('admin.music.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Upload Musik Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="flex items-center gap-3 px-4 py-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 rounded-lg text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="flex items-center gap-3 px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-lg text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif

            {{-- Stats --}}
            @php
                $totalCount  = $musics->total();
                $activeCount = \App\Models\MusicLibrary::where('is_active', true)->count();
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalCount }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Lagu</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $activeCount }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Aktif (terlihat user)</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                    <p class="text-2xl font-bold text-gray-400 dark:text-gray-500">{{ $totalCount - $activeCount }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Nonaktif</p>
                </div>
            </div>

            {{-- Music List --}}
            @if($musics->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 9 10.5-3m0 6.553v3.75a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a1.803 1.803 0 1 1-.99-3.467l2.31-.66a2.25 2.25 0 0 0 1.632-2.163Zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a1.803 1.803 0 0 1-.99-3.467l2.31-.66A2.25 2.25 0 0 0 9 15.553Z"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada musik di library</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Upload musik pertama untuk mulai.</p>
                <a href="{{ route('admin.music.create') }}"
                   class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">
                    Upload Musik
                </a>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($musics as $music)
                @php $usageCount = $music->events()->count(); @endphp
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 flex flex-col gap-3">
                    {{-- Header --}}
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $music->title }}</p>
                            @if($music->artist)
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $music->artist }}</p>
                            @endif
                        </div>
                        <span @class([
                            'flex-shrink-0 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold',
                            'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' => $music->is_active,
                            'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' => !$music->is_active,
                        ])>
                            {{ $music->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    {{-- Meta --}}
                    <div class="flex items-center gap-3 text-xs text-gray-400 dark:text-gray-500">
                        @if($music->file_size_formatted)
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                            </svg>
                            {{ $music->file_size_formatted }}
                        </span>
                        @endif
                        @if($music->duration_formatted)
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            {{ $music->duration_formatted }}
                        </span>
                        @endif
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2m14 0V9a2 2 0 0 0-2-2M5 11V9a2 2 0 0 1 2-2m0 0V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2M7 7h10"/>
                            </svg>
                            {{ $usageCount }} undangan
                        </span>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 pt-1 border-t border-gray-100 dark:border-gray-700">
                        {{-- Toggle --}}
                        <form method="POST" action="{{ route('admin.music.toggle', $music) }}" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="w-full text-center text-xs font-medium px-3 py-1.5 rounded-lg border transition
                                        {{ $music->is_active
                                            ? 'border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700'
                                            : 'border-green-300 dark:border-green-700 text-green-700 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20' }}">
                                {{ $music->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>

                        {{-- Delete --}}
                        <form method="POST" action="{{ route('admin.music.destroy', $music) }}"
                              onsubmit="return confirm('Hapus musik \'{{ addslashes($music->title) }}\'? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    @disabled($usageCount > 0)
                                    title="{{ $usageCount > 0 ? 'Tidak dapat dihapus — sedang digunakan ' . $usageCount . ' undangan' : 'Hapus musik' }}"
                                    class="flex items-center justify-center w-8 h-8 rounded-lg border transition
                                        {{ $usageCount > 0
                                            ? 'border-gray-200 dark:border-gray-700 text-gray-300 dark:text-gray-600 cursor-not-allowed'
                                            : 'border-red-200 dark:border-red-800 text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($musics->hasPages())
            <div class="flex justify-center">
                {{ $musics->links() }}
            </div>
            @endif
            @endif

        </div>
    </div>
</x-app-layout>

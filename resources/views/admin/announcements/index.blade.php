<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Pengumuman</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Kelola status page dan downtime announcement</p>
            </div>
            <a href="{{ route('admin.announcements.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Pengumuman
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-sm text-green-700 dark:text-green-400">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                @if ($announcements->isEmpty())
                    <div class="text-center py-16 text-gray-400 dark:text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                        <p class="text-sm">Belum ada pengumuman. <a href="{{ route('admin.announcements.create') }}" class="text-indigo-600 hover:underline">Buat sekarang</a></p>
                    </div>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-900/40 border-b border-gray-100 dark:border-gray-700">
                            <tr>
                                <th class="text-left px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Judul</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 hidden sm:table-cell">Severity</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Status</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 hidden lg:table-cell">Dibuat</th>
                                <th class="text-right px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($announcements as $item)
                            @php
                                $statusColor = match($item->computed_status) {
                                    'published' => 'green',
                                    'resolved'  => 'slate',
                                    'archived'  => 'gray',
                                    default     => 'yellow',
                                };
                                $severityColor = match($item->severity) {
                                    'warning'  => 'yellow',
                                    'critical' => 'red',
                                    default    => 'blue',
                                };
                                $statusLabel = match($item->computed_status) {
                                    'published' => 'Published',
                                    'resolved'  => 'Resolved',
                                    'archived'  => 'Archived',
                                    default     => 'Draft',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                <td class="px-5 py-3.5">
                                    <div class="font-medium text-gray-800 dark:text-gray-200 line-clamp-1">{{ $item->title }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 font-mono">/status/{{ $item->slug }}</div>
                                </td>
                                <td class="px-4 py-3.5 hidden sm:table-cell">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                        bg-{{ $severityColor }}-100 text-{{ $severityColor }}-700
                                        dark:bg-{{ $severityColor }}-900/40 dark:text-{{ $severityColor }}-400">
                                        {{ ucfirst($item->severity) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-semibold
                                        bg-{{ $statusColor }}-100 text-{{ $statusColor }}-700
                                        dark:bg-{{ $statusColor }}-900/40 dark:text-{{ $statusColor }}-400">
                                        @if ($item->computed_status === 'published')
                                            <span class="w-1.5 h-1.5 rounded-full bg-{{ $statusColor }}-500 animate-pulse"></span>
                                        @endif
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 hidden lg:table-cell text-gray-400 dark:text-gray-500 text-xs">
                                    {{ $item->created_at->isoFormat('D MMM YYYY') }}
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('status.show', $item->slug) }}" target="_blank"
                                           class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                                           title="Lihat halaman publik">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.announcements.edit', $item) }}"
                                           class="p-1.5 rounded-lg text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition"
                                           title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        @if ($item->status !== 'archived')
                                        <form action="{{ route('admin.announcements.archive', $item) }}" method="POST"
                                              onsubmit="return confirm('Arsipkan pengumuman ini?')">
                                            @csrf @method('PUT')
                                            <button type="submit"
                                                    class="p-1.5 rounded-lg text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-950/30 transition"
                                                    title="Arsipkan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('admin.announcements.destroy', $item) }}" method="POST"
                                              onsubmit="return confirm('Hapus pengumuman ini permanen?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 transition"
                                                    title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($announcements->hasPages())
                    <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $announcements->links() }}
                    </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

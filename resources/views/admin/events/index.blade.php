<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Monitoring Semua Undangan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter Status --}}
            <div class="mb-4 flex items-center gap-2 flex-wrap">
                @foreach (['', 'draft', 'aktif', 'expired'] as $s)
                    <a href="{{ route('admin.events.index', $s ? ['status' => $s] : []) }}"
                       class="px-3 py-1.5 rounded-md text-xs font-medium transition
                              {{ request('status', '') === $s
                                  ? 'bg-indigo-600 text-white'
                                  : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600' }}">
                        {{ $s === '' ? 'Semua' : ucfirst($s) }}
                    </a>
                @endforeach
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-xs uppercase text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="px-5 py-3">Judul</th>
                            <th class="px-5 py-3">Pemilik</th>
                            <th class="px-5 py-3">Mempelai</th>
                            <th class="px-5 py-3">Tanggal Acara</th>
                            <th class="px-5 py-3">Paket</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Expired</th>
                            <th class="px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($events as $event)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                <td class="px-5 py-3 font-medium max-w-[180px] truncate">{{ $event->title }}</td>
                                <td class="px-5 py-3 text-xs">{{ $event->user->name ?? '-' }}</td>
                                <td class="px-5 py-3 text-xs">{{ $event->bride_name }} & {{ $event->groom_name }}</td>
                                <td class="px-5 py-3 text-xs">{{ $event->event_date->format('d M Y') }}</td>
                                <td class="px-5 py-3 text-xs">{{ $event->package->name ?? '-' }}</td>
                                <td class="px-5 py-3">
                                    @if (! $event->is_published)
                                        <span class="px-2 py-0.5 rounded-full text-xs bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300">Draft</span>
                                    @elseif ($event->isExpired())
                                        <span class="px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300">Expired</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">Aktif</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $event->expired_at ? $event->expired_at->format('d M Y') : '-' }}
                                </td>
                                <td class="px-5 py-3">
                                    <a href="{{ route('admin.events.show', $event) }}"
                                       class="text-blue-600 hover:underline text-xs">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-10 text-center text-gray-400 dark:text-gray-500">
                                    Tidak ada undangan ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($events->hasPages())
                    <div class="px-5 py-4">
                        {{ $events->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Daftar Undangan Saya
            </h2>
            <a href="{{ route('user.events.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                + Buat Undangan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($events->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-12 text-center">
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Belum ada undangan. Mulai buat sekarang!</p>
                    <a href="{{ route('user.events.create') }}"
                       class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition">
                        Buat Undangan Pertama
                    </a>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                    <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-xs uppercase text-gray-500 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">Judul</th>
                                <th class="px-6 py-3">Mempelai</th>
                                <th class="px-6 py-3">Tanggal Acara</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($events as $event)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                    <td class="px-6 py-4 font-medium">{{ $event->title }}</td>
                                    <td class="px-6 py-4">{{ $event->bride_name }} & {{ $event->groom_name }}</td>
                                    <td class="px-6 py-4">{{ $event->event_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        @if (! $event->is_published)
                                            <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300">Draft</span>
                                        @elseif ($event->isExpired())
                                            <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300">Expired</span>
                                        @else
                                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">Aktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('user.events.show', $event) }}"
                                               class="text-blue-600 hover:underline text-xs">Lihat</a>
                                            <a href="{{ route('user.events.edit', $event) }}"
                                               class="text-indigo-600 hover:underline text-xs">Edit</a>
                                            <form action="{{ route('user.events.destroy', $event) }}" method="POST"
                                                  onsubmit="return confirm('Hapus undangan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline text-xs">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="px-6 py-4">
                        {{ $events->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

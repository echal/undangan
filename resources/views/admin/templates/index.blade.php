<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Manajemen Template
            </h2>
            <a href="{{ route('admin.templates.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                + Tambah Template
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($templates as $template)
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                        @if ($template->preview_image)
                            <img src="{{ asset('storage/' . $template->preview_image) }}"
                                 alt="{{ $template->name }}"
                                 class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                <span class="text-gray-400 dark:text-gray-500 text-sm">Tidak ada preview</span>
                            </div>
                        @endif

                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-medium text-gray-900 dark:text-gray-100 text-sm">{{ $template->name }}</h3>
                                @if ($template->status)
                                    <span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">Aktif</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400">Nonaktif</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mb-1 font-mono">{{ $template->slug }}</p>
                            @php $typeLabels = ['pernikahan' => '💒 Pernikahan', 'buka_puasa' => '🌙 Buka Puasa', 'workshop' => '🎓 Workshop']; @endphp
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-indigo-50 text-indigo-600 dark:bg-indigo-900/40 dark:text-indigo-300 mb-3">
                                {{ $typeLabels[$template->event_type] ?? $template->event_type }}
                            </span>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.templates.edit', $template) }}"
                                   class="text-indigo-600 hover:underline text-xs">Edit</a>
                                <form action="{{ route('admin.templates.destroy', $template) }}" method="POST"
                                      onsubmit="return confirm('Hapus template ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-12 text-center">
                        <p class="text-gray-400 dark:text-gray-500">Belum ada template.</p>
                    </div>
                @endforelse
            </div>

            @if ($templates->hasPages())
                <div class="mt-6">
                    {{ $templates->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Manajemen Paket
            </h2>
            <a href="{{ route('admin.packages.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                + Tambah Paket
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

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-xs uppercase text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Nama Paket</th>
                            <th class="px-6 py-3">Harga</th>
                            <th class="px-6 py-3">Durasi</th>
                            <th class="px-6 py-3">Fitur</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($packages as $package)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                <td class="px-6 py-4 font-medium">{{ $package->name }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">{{ $package->duration_days }} hari</td>
                                <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400">
                                    {{ count($package->features ?? []) }} fitur
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.packages.edit', $package) }}"
                                           class="text-indigo-600 hover:underline text-xs">Edit</a>
                                        <form action="{{ route('admin.packages.destroy', $package) }}" method="POST"
                                              onsubmit="return confirm('Hapus paket ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-xs">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400 dark:text-gray-500">
                                    Belum ada paket. Tambahkan paket pertama.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($packages->hasPages())
                    <div class="px-6 py-4">
                        {{ $packages->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

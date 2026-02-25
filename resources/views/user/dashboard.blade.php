<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Sambutan --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            User
                        </span>
                    </div>
                    <h3 class="text-lg font-semibold mb-1">Selamat datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600 dark:text-gray-400">Kelola undangan digital Anda dari sini.</p>
                </div>
            </div>

            {{-- Menu Aksi --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('user.events.create') }}"
                   class="flex items-center gap-4 p-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition">
                    <div class="text-3xl">+</div>
                    <div>
                        <p class="font-semibold text-lg">Buat Undangan</p>
                        <p class="text-indigo-200 text-sm">Buat undangan digital baru</p>
                    </div>
                </a>

                <a href="{{ route('user.events.index') }}"
                   class="flex items-center gap-4 p-6 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 text-gray-900 dark:text-gray-100 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 transition">
                    <div class="text-3xl">📋</div>
                    <div>
                        <p class="font-semibold text-lg">Daftar Undangan Saya</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Lihat & kelola semua undangan</p>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>

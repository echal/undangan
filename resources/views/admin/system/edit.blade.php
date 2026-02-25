<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Pengaturan Sistem</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Kelola maintenance mode dan informasi gangguan</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash --}}
            @if (session('success'))
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-sm text-green-700 dark:text-green-400">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if ($errors->any())
            <div class="flex items-start gap-3 px-4 py-3 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-sm text-red-700 dark:text-red-400">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <div>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Status Badge --}}
            <div class="flex items-center gap-3">
                @if ($settings->isInMaintenance())
                    <span class="inline-flex items-center gap-2 text-sm font-semibold px-3 py-1.5 rounded-full bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                        MAINTENANCE AKTIF
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 text-sm font-semibold px-3 py-1.5 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        SISTEM NORMAL
                    </span>
                @endif
                <span class="text-xs text-gray-400 dark:text-gray-500">
                    Terakhir diubah: {{ optional($settings->updated_at)->diffForHumans() ?? '-' }}
                </span>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.system.update') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm divide-y divide-gray-100 dark:divide-gray-700">
                @csrf
                @method('PUT')

                {{-- Mode --}}
                <div class="p-6 space-y-4">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Mode Maintenance</h3>

                    <div class="space-y-3">
                        @foreach ([
                            'disabled'  => ['label' => 'Nonaktif', 'desc' => 'Sistem berjalan normal, tidak ada redirect maintenance.', 'color' => 'emerald'],
                            'manual'    => ['label' => 'Manual (Aktif Sekarang)', 'desc' => 'Aktifkan maintenance segera sampai dimatikan manual.', 'color' => 'red'],
                            'scheduled' => ['label' => 'Terjadwal', 'desc' => 'Maintenance aktif hanya dalam rentang waktu yang ditentukan.', 'color' => 'amber'],
                        ] as $value => $opt)
                        <label class="flex items-start gap-3 p-3 rounded-xl border cursor-pointer transition
                            {{ old('maintenance_type', $settings->maintenance_type) === $value
                                ? 'border-indigo-400 bg-indigo-50 dark:bg-indigo-950/30 dark:border-indigo-600'
                                : 'border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                            <input type="radio" name="maintenance_type" value="{{ $value }}"
                                   {{ old('maintenance_type', $settings->maintenance_type) === $value ? 'checked' : '' }}
                                   class="mt-0.5 accent-indigo-600"
                                   x-model="mode" @change="mode = '{{ $value }}'">
                            <div>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $opt['label'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $opt['desc'] }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Schedule --}}
                <div class="p-6 space-y-4" x-data="{ mode: '{{ old('maintenance_type', $settings->maintenance_type) }}' }"
                     x-show="mode === 'scheduled'" x-transition>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Jadwal</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="maintenance_start_at" class="text-sm font-medium text-gray-600 dark:text-gray-300">Mulai</label>
                            <input type="datetime-local" id="maintenance_start_at" name="maintenance_start_at"
                                   value="{{ old('maintenance_start_at', $settings->maintenance_start_at?->format('Y-m-d\TH:i')) }}"
                                   class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="maintenance_end_at" class="text-sm font-medium text-gray-600 dark:text-gray-300">Selesai</label>
                            <input type="datetime-local" id="maintenance_end_at" name="maintenance_end_at"
                                   value="{{ old('maintenance_end_at', $settings->maintenance_end_at?->format('Y-m-d\TH:i')) }}"
                                   class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6 space-y-4">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Pesan Halaman Maintenance</h3>
                    <div class="flex flex-col gap-1">
                        <label for="maintenance_title" class="text-sm font-medium text-gray-600 dark:text-gray-300">Judul</label>
                        <input type="text" id="maintenance_title" name="maintenance_title"
                               value="{{ old('maintenance_title', $settings->maintenance_title) }}"
                               placeholder="Sistem Sedang Maintenance"
                               class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="maintenance_message" class="text-sm font-medium text-gray-600 dark:text-gray-300">Pesan</label>
                        <textarea id="maintenance_message" name="maintenance_message" rows="3"
                                  placeholder="Kami sedang melakukan peningkatan sistem..."
                                  class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition resize-none">{{ old('maintenance_message', $settings->maintenance_message) }}</textarea>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="contact_email" class="text-sm font-medium text-gray-600 dark:text-gray-300">Email Kontak <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="email" id="contact_email" name="contact_email"
                               value="{{ old('contact_email', $settings->contact_email) }}"
                               placeholder="support@contoh.com"
                               class="text-sm px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                </div>

                {{-- Actions --}}
                <div class="p-6 flex items-center justify-between gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">
                        ← Kembali ke Dashboard
                    </a>
                    <button type="submit"
                            class="px-6 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>

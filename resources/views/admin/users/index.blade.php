<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Manajemen Pengguna
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Setujui atau tolak pendaftaran pengguna baru
                </p>
            </div>
            <div class="flex items-center gap-2">
                @if($counts['pending'] > 0)
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400 text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    {{ $counts['pending'] }} menunggu
                </span>
                @endif
                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white text-sm font-semibold shadow-md shadow-indigo-200 dark:shadow-indigo-900 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Tambah User
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Message --}}
            @if(session('error'))
            <div class="flex items-center gap-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-xl px-5 py-3.5 text-sm font-medium shadow-sm">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif

            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="flex items-center gap-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 rounded-xl px-5 py-3.5 text-sm font-medium shadow-sm">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            {{-- Status Tabs --}}
            <div class="flex flex-wrap gap-2">
                @foreach(['pending' => ['label' => 'Menunggu', 'color' => 'amber'], 'approved' => ['label' => 'Disetujui', 'color' => 'green'], 'rejected' => ['label' => 'Ditolak', 'color' => 'red'], 'all' => ['label' => 'Semua', 'color' => 'gray']] as $tab => $cfg)
                <a href="{{ route('admin.users.index', ['status' => $tab]) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-150
                          {{ $status === $tab
                              ? 'bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white'
                              : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-white/50 dark:hover:bg-gray-800/50' }}">
                    @if($tab === 'pending')
                    <span class="w-2 h-2 rounded-full bg-amber-400 {{ $status === 'pending' ? 'animate-pulse' : '' }}"></span>
                    @elseif($tab === 'approved')
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    @elseif($tab === 'rejected')
                    <span class="w-2 h-2 rounded-full bg-red-400"></span>
                    @else
                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                    @endif
                    {{ $cfg['label'] }}
                    <span class="text-xs px-1.5 py-0.5 rounded-full
                                 {{ $status === $tab
                                     ? 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-400'
                                     : 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400' }}">
                        {{ $counts[$tab] }}
                    </span>
                </a>
                @endforeach
            </div>

            {{-- Table --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50">
                                <th class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider px-6 py-3.5">Pengguna</th>
                                <th class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider px-6 py-3.5 hidden sm:table-cell">Tema Dipilih</th>
                                <th class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider px-6 py-3.5">Status</th>
                                <th class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider px-6 py-3.5 hidden md:table-cell">Daftar</th>
                                <th class="text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider px-6 py-3.5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors" id="user-row-{{ $user->id }}">
                                {{-- User Info --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Selected Theme --}}
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    @if($user->selected_theme_slug)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 text-xs font-medium">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42"/>
                                        </svg>
                                        {{ $user->selected_theme_slug }}
                                    </span>
                                    @else
                                    <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </td>

                                {{-- Status Badge --}}
                                <td class="px-6 py-4">
                                    @if($user->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                        Menunggu
                                    </span>
                                    @elseif($user->status === 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Disetujui
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                        Ditolak
                                    </span>
                                    @endif
                                </td>

                                {{-- Registered Date --}}
                                <td class="px-6 py-4 hidden md:table-cell text-xs text-gray-400 whitespace-nowrap">
                                    <span title="{{ $user->created_at->format('d M Y H:i') }}">
                                        {{ $user->created_at->diffForHumans() }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($user->status !== 'approved')
                                        {{-- Approve button --}}
                                        <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-500 hover:bg-green-600 text-white text-xs font-semibold transition-colors shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>
                                                Setujui
                                            </button>
                                        </form>
                                        @endif

                                        @if($user->status !== 'rejected')
                                        {{-- Reject button — opens inline form --}}
                                        <button type="button"
                                                onclick="toggleRejectForm({{ $user->id }})"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-100 dark:bg-red-900/40 hover:bg-red-200 dark:hover:bg-red-900/60 text-red-700 dark:text-red-400 text-xs font-semibold transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                            </svg>
                                            Tolak
                                        </button>
                                        @endif

                                        @if($user->status === 'approved')
                                        <span class="text-xs text-gray-400 italic">Aktif</span>
                                        @endif

                                        {{-- Hapus --}}
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                              onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}? Tindakan ini tidak bisa dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 transition"
                                                    title="Hapus user">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Inline reject form (hidden by default) --}}
                                    @if($user->status !== 'rejected')
                                    <div id="reject-form-{{ $user->id }}" class="hidden mt-3">
                                        <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="flex gap-2">
                                                <input type="text"
                                                       name="rejection_reason"
                                                       placeholder="Alasan penolakan..."
                                                       maxlength="500"
                                                       required
                                                       class="flex-1 text-xs px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-300 dark:focus:ring-red-700">
                                                <button type="submit"
                                                        class="px-3 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white text-xs font-semibold transition-colors whitespace-nowrap">
                                                    Kirim
                                                </button>
                                                <button type="button"
                                                        onclick="toggleRejectForm({{ $user->id }})"
                                                        class="px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-500 dark:text-gray-400 text-xs font-semibold transition-colors">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    @endif

                                    {{-- Show rejection reason if rejected --}}
                                    @if($user->status === 'rejected' && $user->rejection_reason)
                                    <p class="mt-2 text-xs text-red-500 dark:text-red-400 text-right max-w-xs ml-auto leading-relaxed">
                                        <span class="font-semibold">Alasan:</span> {{ $user->rejection_reason }}
                                    </p>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Tidak ada pengguna</p>
                                        <p class="text-gray-400 dark:text-gray-500 text-xs">
                                            @if($status === 'pending') Belum ada pendaftaran baru yang menunggu persetujuan.
                                            @elseif($status === 'approved') Belum ada pengguna yang disetujui.
                                            @elseif($status === 'rejected') Tidak ada pengguna yang ditolak.
                                            @else Belum ada pengguna terdaftar.
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $users->appends(['status' => $status])->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
    function toggleRejectForm(userId) {
        const form = document.getElementById('reject-form-' + userId);
        if (!form) return;
        form.classList.toggle('hidden');
        if (!form.classList.contains('hidden')) {
            form.querySelector('input[name="rejection_reason"]').focus();
        }
    }
    </script>
    @endpush
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Tambah Pengguna
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Buat akun pengguna baru secara langsung
                </p>
            </div>
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

                {{-- Form Header --}}
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-md shadow-indigo-200 dark:shadow-indigo-900">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Data Pengguna Baru</p>
                        <p class="text-xs text-gray-400 mt-0.5">Isi semua field yang diperlukan</p>
                    </div>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('admin.users.store') }}" class="p-6 space-y-5">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               placeholder="cth. Budi Santoso"
                               class="w-full px-4 py-2.5 rounded-xl border text-sm transition
                                      {{ $errors->has('name') ? 'border-red-300 dark:border-red-600 bg-red-50 dark:bg-red-900/10 focus:ring-red-300' : 'border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-indigo-300 dark:focus:ring-indigo-600' }}
                                      text-gray-800 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500
                                      focus:outline-none focus:ring-2 focus:border-transparent">
                        @error('name')
                        <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               placeholder="cth. budi@email.com"
                               class="w-full px-4 py-2.5 rounded-xl border text-sm transition
                                      {{ $errors->has('email') ? 'border-red-300 dark:border-red-600 bg-red-50 dark:bg-red-900/10 focus:ring-red-300' : 'border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-indigo-300 dark:focus:ring-indigo-600' }}
                                      text-gray-800 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500
                                      focus:outline-none focus:ring-2 focus:border-transparent">
                        @error('email')
                        <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="password"
                                   name="password"
                                   required
                                   placeholder="Minimal 8 karakter"
                                   class="w-full px-4 py-2.5 pr-11 rounded-xl border text-sm transition
                                          {{ $errors->has('password') ? 'border-red-300 dark:border-red-600 bg-red-50 dark:bg-red-900/10 focus:ring-red-300' : 'border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-indigo-300 dark:focus:ring-indigo-600' }}
                                          text-gray-800 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500
                                          focus:outline-none focus:ring-2 focus:border-transparent">
                            <button type="button" onclick="togglePassword('password', this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                        <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   required
                                   placeholder="Ulangi password"
                                   class="w-full px-4 py-2.5 pr-11 rounded-xl border text-sm transition
                                          border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700
                                          text-gray-800 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500
                                          focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-600 focus:border-transparent">
                            <button type="button" onclick="togglePassword('password_confirmation', this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Role + Status row --}}
                    <div class="grid grid-cols-2 gap-4">
                        {{-- Role --}}
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select id="role" name="role" required
                                    class="w-full px-4 py-2.5 rounded-xl border text-sm transition
                                           {{ $errors->has('role') ? 'border-red-300 dark:border-red-600' : 'border-gray-200 dark:border-gray-600' }}
                                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                           focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-600 focus:border-transparent">
                                <option value="user" {{ old('role', 'user') === 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                            <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" name="status" required
                                    class="w-full px-4 py-2.5 rounded-xl border text-sm transition
                                           {{ $errors->has('status') ? 'border-red-300 dark:border-red-600' : 'border-gray-200 dark:border-gray-600' }}
                                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                           focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-600 focus:border-transparent">
                                <option value="approved" {{ old('status', 'approved') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="pending"  {{ old('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                                <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                            <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Info note --}}
                    <div class="rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 px-4 py-3 flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                        </svg>
                        <p class="text-xs text-blue-700 dark:text-blue-300 leading-relaxed">
                            User yang dibuat admin langsung berstatus <strong>Disetujui</strong> secara default — tidak perlu melalui proses review.
                            Ubah status jika diperlukan.
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('admin.users.index') }}"
                           class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white text-sm font-semibold shadow-md shadow-indigo-200 dark:shadow-indigo-900 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"/>
                            </svg>
                            Tambah Pengguna
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.querySelector('svg').innerHTML = isHidden
            ? '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/>'
            : '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>';
    }
    </script>
    @endpush
</x-app-layout>

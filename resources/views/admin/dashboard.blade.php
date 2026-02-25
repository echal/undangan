<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Dashboard Admin
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Selamat datang kembali, <span class="font-medium text-indigo-600 dark:text-indigo-400">{{ Auth::user()->name }}</span>
                </p>
            </div>
            <div class="text-sm text-gray-400 dark:text-gray-500 hidden sm:block">
                {{ now()->isoFormat('dddd, D MMMM YYYY') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ============================================================
                 SECTION 0: Status Sistem — Compact Summary Card
                 Variables: $maintenanceMode (bool), $systemSettings (SystemSetting)
                 ============================================================ --}}

            {{-- Flash Messages --}}
            @if (session('success'))
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-sm text-green-700 dark:text-green-400">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if ($errors->any())
            <div class="flex items-start gap-3 px-4 py-3 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-sm text-red-700 dark:text-red-400">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $errors->first() }}
            </div>
            @endif

            {{-- Compact System Status Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm px-5 py-4 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0
                        {{ $maintenanceMode
                            ? 'bg-red-100 dark:bg-red-900/40'
                            : 'bg-emerald-100 dark:bg-emerald-900/40'
                        }}">
                        <svg class="w-4.5 h-4.5 {{ $maintenanceMode ? 'text-red-600 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }}"
                             fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 font-medium uppercase tracking-wide">Status Sistem</p>
                        @if ($maintenanceMode)
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 dark:text-red-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                MAINTENANCE
                                @if ($systemSettings->maintenance_end_at)
                                    <span class="font-normal text-gray-400">s/d {{ $systemSettings->maintenance_end_at->isoFormat('D MMM, HH:mm') }}</span>
                                @endif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                SISTEM AKTIF
                            </span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('admin.system.edit') }}"
                   class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-lg
                          border border-gray-200 dark:border-gray-600
                          text-gray-700 dark:text-gray-300
                          hover:bg-gray-50 dark:hover:bg-gray-700
                          transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Kelola Sistem
                </a>
            </div>

            {{-- ============================================================
                 SECTION 1: Summary Stats Cards
                 Replace values with: $totalEvents, $totalUsers, etc.
                 ============================================================ --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">

                {{-- Card: Total Undangan --}}
                <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-transparent dark:from-indigo-950/30 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                    <div class="relative">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center shadow-md shadow-indigo-200 dark:shadow-indigo-900">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            {{-- Trend badge --}}
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400">
                                +{{ $activeEvents }}
                            </span>
                        </div>
                        {{-- Dynamic: {{ $totalEvents }} --}}
                        <p class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">{{ $totalEvents }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Undangan</p>
                        <div class="mt-3 flex items-center gap-3 text-xs">
                            <span class="flex items-center gap-1 text-green-600 dark:text-green-400">
                                <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                                {{ $activeEvents }} aktif
                            </span>
                            <span class="text-gray-400">·</span>
                            <span class="text-gray-400">{{ $draftEvents }} draft</span>
                        </div>
                    </div>
                </div>

                {{-- Card: Total Pengguna --}}
                <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-violet-50 to-transparent dark:from-violet-950/30 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                    <div class="relative">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-violet-500 to-violet-600 flex items-center justify-center shadow-md shadow-violet-200 dark:shadow-violet-900">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                        </div>
                        {{-- Dynamic: {{ $totalUsers }} --}}
                        <p class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">{{ $totalUsers }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Pengguna</p>
                        <div class="mt-3 text-xs text-gray-400">Pengguna terdaftar aktif</div>
                    </div>
                </div>

                {{-- Card: Total Template --}}
                <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-50 to-transparent dark:from-pink-950/30 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                    <div class="relative">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center shadow-md shadow-pink-200 dark:shadow-pink-900">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm0 8a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zm12 0a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                                </svg>
                            </div>
                        </div>
                        {{-- Dynamic: {{ $totalTemplates }} --}}
                        <p class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">{{ $totalTemplates }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Template</p>
                        <div class="mt-3 text-xs text-gray-400">Desain undangan tersedia</div>
                    </div>
                </div>

                {{-- Card: Total Revenue --}}
                <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent dark:from-emerald-950/30 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                    <div class="relative">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-md shadow-emerald-200 dark:shadow-emerald-900">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-400">
                                Revenue
                            </span>
                        </div>
                        {{-- Dynamic: {{ number_format($totalRevenue, 0, ',', '.') }} --}}
                        <p class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                            Rp{{ number_format($totalRevenue, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Pendapatan</p>
                        <div class="mt-3 text-xs text-gray-400">Dari {{ $totalEvents }} undangan</div>
                    </div>
                </div>

            </div>

            {{-- ============================================================
                 SECTION 2: Charts (2 side by side)
                 Dynamic data injected via inline JS from controller
                 ============================================================ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Chart 1: Undangan per 7 hari --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Undangan Dibuat</h3>
                            <p class="text-xs text-gray-400 mt-0.5">7 hari terakhir</p>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="relative h-48">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>

                {{-- Chart 2: Revenue per 6 bulan --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Pendapatan Bulanan</h3>
                            <p class="text-xs text-gray-400 mt-0.5">6 bulan terakhir</p>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="relative h-48">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

            </div>

            {{-- ============================================================
                 SECTION 3: Event Status Breakdown + Quick Actions
                 ============================================================ --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Event Status Breakdown --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-5">Status Undangan</h3>
                    <div class="space-y-4">
                        {{-- Aktif --}}
                        <div>
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1.5">
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                                    Aktif
                                </span>
                                {{-- Dynamic: {{ $activeEvents }} --}}
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $activeEvents }}</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                                @php $total = max($totalEvents, 1); @endphp
                                <div class="bg-green-500 h-2 rounded-full transition-all duration-700"
                                     style="width: {{ ($activeEvents / $total) * 100 }}%"></div>
                            </div>
                        </div>
                        {{-- Draft --}}
                        <div>
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1.5">
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>
                                    Draft
                                </span>
                                {{-- Dynamic: {{ $draftEvents }} --}}
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $draftEvents }}</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-amber-400 h-2 rounded-full transition-all duration-700"
                                     style="width: {{ ($draftEvents / $total) * 100 }}%"></div>
                            </div>
                        </div>
                        {{-- Expired --}}
                        <div>
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1.5">
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-red-400 inline-block"></span>
                                    Expired
                                </span>
                                {{-- Dynamic: {{ $expiredEvents }} --}}
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $expiredEvents }}</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-red-400 h-2 rounded-full transition-all duration-700"
                                     style="width: {{ ($expiredEvents / $total) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Donut visual summary --}}
                    <div class="mt-5 pt-5 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-center gap-4 text-xs text-gray-500">
                            <span>Total: <strong class="text-gray-800 dark:text-gray-200">{{ $totalEvents }}</strong></span>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-5">Aksi Cepat</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                        <a href="{{ route('admin.templates.create') }}"
                           class="group flex flex-col items-center justify-center gap-3 p-5 rounded-xl border-2 border-dashed border-pink-200 dark:border-pink-800 hover:border-pink-400 dark:hover:border-pink-600 hover:bg-pink-50 dark:hover:bg-pink-900/20 transition-all duration-200">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center shadow-lg shadow-pink-200 dark:shadow-pink-900 group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Tambah Template</p>
                                <p class="text-xs text-gray-400 mt-0.5">Desain baru</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.packages.create') }}"
                           class="group flex flex-col items-center justify-center gap-3 p-5 rounded-xl border-2 border-dashed border-indigo-200 dark:border-indigo-800 hover:border-indigo-400 dark:hover:border-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-200">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center shadow-lg shadow-indigo-200 dark:shadow-indigo-900 group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Buat Paket</p>
                                <p class="text-xs text-gray-400 mt-0.5">Harga & fitur</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.events.index') }}"
                           class="group flex flex-col items-center justify-center gap-3 p-5 rounded-xl border-2 border-dashed border-emerald-200 dark:border-emerald-800 hover:border-emerald-400 dark:hover:border-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all duration-200">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-200 dark:shadow-emerald-900 group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Semua Undangan</p>
                                <p class="text-xs text-gray-400 mt-0.5">Monitor & kelola</p>
                            </div>
                        </a>

                    </div>

                    {{-- Secondary quick links --}}
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('admin.templates.index') }}"
                           class="text-xs px-3 py-1.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 hover:text-indigo-700 dark:hover:text-indigo-400 transition-colors">
                            📋 Semua Template
                        </a>
                        <a href="{{ route('admin.packages.index') }}"
                           class="text-xs px-3 py-1.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 hover:text-indigo-700 dark:hover:text-indigo-400 transition-colors">
                            📦 Semua Paket
                        </a>
                        <a href="{{ route('admin.events.index') }}?status=expired"
                           class="text-xs px-3 py-1.5 rounded-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">
                            ⚠️ {{ $expiredEvents }} Expired
                        </a>
                    </div>
                </div>

            </div>

            {{-- ============================================================
                 SECTION 4: Recent Activity Table
                 Dynamic: $recentEvents collection
                 ============================================================ --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Aktivitas Terbaru</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Undangan terbaru dibuat pengguna</p>
                    </div>
                    <a href="{{ route('admin.events.index') }}"
                       class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50">
                                <th class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider px-6 py-3">Pengguna</th>
                                <th class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider px-6 py-3 hidden sm:table-cell">Aksi</th>
                                <th class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider px-6 py-3">Undangan</th>
                                <th class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider px-6 py-3 hidden md:table-cell">Status</th>
                                <th class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider px-6 py-3">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            {{-- Dynamic: @foreach ($recentEvents as $event) --}}
                            @forelse ($recentEvents as $event)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">
                                    {{-- User --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                                {{ strtoupper(substr($event->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800 dark:text-gray-200 text-sm truncate max-w-[120px]">
                                                    {{ $event->user->name ?? '—' }}
                                                </p>
                                                <p class="text-xs text-gray-400 truncate max-w-[120px]">
                                                    {{ $event->user->email ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Action --}}
                                    <td class="px-6 py-4 hidden sm:table-cell">
                                        @if ($event->is_published)
                                            <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2.5 py-1 rounded-full">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Dipublikasikan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-xs font-medium text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/30 px-2.5 py-1 rounded-full">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                Membuat Undangan
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Event Name --}}
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.events.show', $event) }}"
                                           class="font-medium text-gray-800 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors text-sm truncate max-w-[180px] block">
                                            {{ $event->title }}
                                        </a>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $event->package->name ?? '—' }}</p>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        @if (! $event->is_published)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                                Draft
                                            </span>
                                        @elseif ($event->isExpired())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">
                                                Expired
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">
                                                Aktif
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Date --}}
                                    <td class="px-6 py-4 text-xs text-gray-400 whitespace-nowrap">
                                        <span title="{{ $event->created_at->format('d M Y H:i') }}">
                                            {{ $event->created_at->diffForHumans() }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-400">
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="text-3xl">📭</span>
                                            Belum ada undangan yang dibuat.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const isDark = document.documentElement.classList.contains('dark');
        const gridColor  = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
        const labelColor = isDark ? '#9ca3af' : '#6b7280';

        // ── Chart 1: Weekly Invitations (Line) ──────────────────────────
        // Dynamic data from $weeklyData
        const weeklyLabels = @json($weeklyData->pluck('label'));
        const weeklyCounts = @json($weeklyData->pluck('count'));

        new Chart(document.getElementById('weeklyChart'), {
            type: 'line',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Undangan',
                    data: weeklyCounts,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.1)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#6366f1',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: isDark ? '#1f2937' : '#fff',
                        titleColor: isDark ? '#e5e7eb' : '#111827',
                        bodyColor: isDark ? '#9ca3af' : '#6b7280',
                        borderColor: isDark ? '#374151' : '#e5e7eb',
                        borderWidth: 1,
                        padding: 10,
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y} undangan`,
                        }
                    },
                },
                scales: {
                    x: {
                        grid: { color: gridColor, drawBorder: false },
                        ticks: { color: labelColor, font: { size: 11 } },
                    },
                    y: {
                        grid: { color: gridColor, drawBorder: false },
                        ticks: {
                            color: labelColor,
                            font: { size: 11 },
                            stepSize: 1,
                            precision: 0,
                        },
                        beginAtZero: true,
                    },
                },
            }
        });

        // ── Chart 2: Monthly Revenue (Bar) ───────────────────────────────
        // Dynamic data from $monthlyRevenue
        const revenueLabels  = @json($monthlyRevenue->pluck('label'));
        const revenueAmounts = @json($monthlyRevenue->pluck('revenue'));

        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Pendapatan',
                    data: revenueAmounts,
                    backgroundColor: revenueAmounts.map((_, i) =>
                        i === revenueAmounts.length - 1
                            ? 'rgba(16,185,129,0.9)'
                            : 'rgba(16,185,129,0.3)'
                    ),
                    borderColor: 'rgba(16,185,129,0.8)',
                    borderWidth: 1.5,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: isDark ? '#1f2937' : '#fff',
                        titleColor: isDark ? '#e5e7eb' : '#111827',
                        bodyColor: isDark ? '#9ca3af' : '#6b7280',
                        borderColor: isDark ? '#374151' : '#e5e7eb',
                        borderWidth: 1,
                        padding: 10,
                        callbacks: {
                            label: ctx => ` Rp${ctx.parsed.y.toLocaleString('id-ID')}`,
                        }
                    },
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: labelColor, font: { size: 11 } },
                    },
                    y: {
                        grid: { color: gridColor, drawBorder: false },
                        ticks: {
                            color: labelColor,
                            font: { size: 11 },
                            callback: v => 'Rp' + (v >= 1000000
                                ? (v/1000000).toFixed(0) + 'jt'
                                : v >= 1000 ? (v/1000).toFixed(0) + 'rb' : v),
                        },
                        beginAtZero: true,
                    },
                },
            }
        });
    });
    </script>
    @endpush
</x-app-layout>

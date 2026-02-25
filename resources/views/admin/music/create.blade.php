<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.music.index') }}"
               class="flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Upload Musik Baru
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            {{-- Info Notice --}}
            <div class="mb-6 flex items-start gap-3 px-4 py-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-300 rounded-xl text-sm">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                </svg>
                <div>
                    <p class="font-semibold mb-1">Panduan Upload Musik</p>
                    <ul class="space-y-0.5 text-blue-700 dark:text-blue-400">
                        <li>• Format yang didukung: <strong>MP3</strong> dan <strong>M4A</strong></li>
                        <li>• Ukuran file maksimal: <strong>15 MB</strong></li>
                        <li>• Musik yang diupload akan tersedia untuk semua user</li>
                        <li>• Gunakan nama dan artis yang deskriptif agar mudah ditemukan</li>
                    </ul>
                </div>
            </div>

            {{-- Form --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <form method="POST" action="{{ route('admin.music.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-5">
                        {{-- Title --}}
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Judul Lagu <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="title"
                                   name="title"
                                   value="{{ old('title') }}"
                                   placeholder="contoh: Canon in D"
                                   required
                                   class="w-full rounded-lg border px-3 py-2.5 text-sm
                                       @error('title') border-red-300 dark:border-red-700 bg-red-50 dark:bg-red-900/10
                                       @else border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 @enderror
                                       text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 transition">
                            @error('title')
                            <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Artist --}}
                        <div>
                            <label for="artist" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Artis / Komposer
                                <span class="text-gray-400 dark:text-gray-500 font-normal">(opsional)</span>
                            </label>
                            <input type="text"
                                   id="artist"
                                   name="artist"
                                   value="{{ old('artist') }}"
                                   placeholder="contoh: Johann Pachelbel"
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2.5 text-sm
                                       bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                       placeholder-gray-400 dark:placeholder-gray-500
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 transition">
                            @error('artist')
                            <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- File Upload --}}
                        <div x-data="{ fileName: '', isDragging: false }">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                File Musik <span class="text-red-500">*</span>
                            </label>
                            <label
                                for="file"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="isDragging = false; if($event.dataTransfer.files[0]) { fileName = $event.dataTransfer.files[0].name; $refs.fileInput.files = $event.dataTransfer.files; }"
                                :class="isDragging ? 'border-indigo-400 bg-indigo-50 dark:bg-indigo-900/20' : 'border-gray-300 dark:border-gray-600 hover:border-indigo-400 dark:hover:border-indigo-500'"
                                class="flex flex-col items-center justify-center gap-3 px-6 py-8 border-2 border-dashed rounded-xl cursor-pointer transition">

                                <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 9 10.5-3m0 6.553v3.75a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a1.803 1.803 0 1 1-.99-3.467l2.31-.66a2.25 2.25 0 0 0 1.632-2.163Zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a1.803 1.803 0 0 1-.99-3.467l2.31-.66A2.25 2.25 0 0 0 9 15.553Z"/>
                                </svg>

                                <div class="text-center">
                                    <p x-show="!fileName" class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                        Klik atau seret file ke sini
                                    </p>
                                    <p x-show="fileName" x-text="fileName" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 break-all"></p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">MP3, M4A — maks 15MB</p>
                                </div>

                                <input x-ref="fileInput"
                                       type="file"
                                       id="file"
                                       name="file"
                                       accept=".mp3,.m4a,audio/mpeg,audio/mp4"
                                       required
                                       @change="fileName = $event.target.files[0]?.name ?? ''"
                                       class="hidden">
                            </label>
                            @error('file')
                            <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3 mt-8 pt-5 border-t border-gray-100 dark:border-gray-700">
                        <button type="submit"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                            </svg>
                            Upload Musik
                        </button>
                        <a href="{{ route('admin.music.index') }}"
                           class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>

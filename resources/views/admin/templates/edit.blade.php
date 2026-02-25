<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.templates.index') }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                &larr; Kembali
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Template: {{ $template->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">

                <form action="{{ route('admin.templates.update', $template) }}" method="POST"
                      enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Template</label>
                        <input type="text" name="name" value="{{ old('name', $template->name) }}"
                               class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Jenis Acara <span class="text-red-500">*</span>
                        </label>
                        <select name="event_type"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="pernikahan" {{ old('event_type', $template->event_type) === 'pernikahan' ? 'selected' : '' }}>💒 Pernikahan</option>
                            <option value="buka_puasa" {{ old('event_type', $template->event_type) === 'buka_puasa' ? 'selected' : '' }}>🌙 Buka Puasa</option>
                            <option value="workshop"   {{ old('event_type', $template->event_type) === 'workshop'   ? 'selected' : '' }}>🎓 Workshop</option>
                        </select>
                        @error('event_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Preview Image Baru
                            <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin mengganti)</span>
                        </label>

                        @if ($template->preview_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $template->preview_image) }}"
                                     alt="Preview saat ini"
                                     class="h-24 rounded-md object-cover border border-gray-200 dark:border-gray-600">
                                <p class="text-xs text-gray-400 mt-1">Preview saat ini</p>
                            </div>
                        @endif

                        <input type="file" name="preview_image" accept="image/*"
                               class="w-full text-sm text-gray-700 dark:text-gray-300
                                      file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0
                                      file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700
                                      dark:file:bg-indigo-900 dark:file:text-indigo-300
                                      hover:file:bg-indigo-100">
                        @error('preview_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" id="status" value="1"
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                               {{ old('status', $template->status) ? 'checked' : '' }}>
                        <label for="status" class="text-sm text-gray-700 dark:text-gray-300">
                            Template Aktif (tampil di pilihan user)
                        </label>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                            Perbarui Template
                        </button>
                        <a href="{{ route('admin.templates.index') }}"
                           class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

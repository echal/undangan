<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MusicLibrary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MusicLibraryController extends Controller
{
    public function index(): View
    {
        $musics      = MusicLibrary::withCount('events')->latest()->paginate(15);
        $activeCount = MusicLibrary::where('is_active', true)->count();

        return view('admin.music.index', compact('musics', 'activeCount'));
    }

    public function create(): View
    {
        return view('admin.music.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'  => ['required', 'string', 'max:255'],
            'artist' => ['nullable', 'string', 'max:255'],
            'file'   => ['required', 'file', 'mimes:mp3,m4a', 'max:15360'], // 15MB
        ], [
            'file.required' => 'File musik wajib diupload.',
            'file.mimes'    => 'File harus berformat MP3 atau M4A.',
            'file.max'      => 'Ukuran file musik maksimal 15MB.',
        ]);

        $file     = $request->file('file');
        $path     = $file->store('music', 'public');
        $fileSize = $file->getSize();

        MusicLibrary::create([
            'title'     => $request->title,
            'artist'    => $request->artist,
            'file_path' => $path,
            'file_size' => $fileSize,
            'is_active' => true,
        ]);

        return redirect()->route('admin.music.index')
                         ->with('success', 'Musik "' . $request->title . '" berhasil diupload.');
    }

    public function toggleActive(MusicLibrary $music): RedirectResponse
    {
        $music->update(['is_active' => ! $music->is_active]);
        $status = $music->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Musik \"{$music->title}\" berhasil {$status}.");
    }

    public function destroy(MusicLibrary $music): RedirectResponse
    {
        $usageCount = $music->events()->count();

        if ($usageCount > 0) {
            return back()->with('error', "Musik \"{$music->title}\" sedang digunakan oleh {$usageCount} undangan. Nonaktifkan saja jika tidak ingin ditampilkan ke user.");
        }

        Storage::disk('public')->delete($music->file_path);
        $title = $music->title;
        $music->delete();

        return back()->with('success', "Musik \"{$title}\" berhasil dihapus.");
    }
}
